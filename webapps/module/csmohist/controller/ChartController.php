<?php

class ChartController extends DooController {

    public function graph() {

    	Doo::loadModel('M02Clientes');
    	Doo::loadModel('M05Facturas');

        Doo::logger()->beginDbProfile('find_cte', 'csmo_rpt');
        $cte = self::db()->find('M02Clientes', array(
        	'where' => 'id_cliente = ?',
        	'param' => array($this->params['id_cliente']),
        	'limit' => 1));
        Doo::logger()->endDbProfile('find_cte');

        //echo json_encode($cte);

        if (is_object($cte) && ($cte instanceof M02Clientes)) {

	        Doo::logger()->beginDbProfile('find_fact', 'csmo_rpt');
	        $facturas = self::db()->relate('M05Facturas', 'M02Clientes',
	        	array(
	        	'where' => 'm02_clientes.id_cliente = ? ' .
	        	           'AND m05_facturas.factura_tipo_id <> ? '.
	        	           'AND (m05_facturas.ciclo BETWEEN ? AND ?)',
	        	'param' => array($cte->id_cliente, 303,
	        		$this->params['ciclo_ini'], $this->params['ciclo_fin']),
        		'asc' => 'm05_facturas.ciclo'));
	        Doo::logger()->endDbProfile('find_fact');

	        $jpgraph_path = Doo::conf()->SITE_PATH . 'webapps/libraries/jpgraph/';

	        require_once $jpgraph_path . 'jpgraph.php';
	        require_once $jpgraph_path . 'jpgraph_bar.php';

	        $data1y = $data2y = array();

	        if (is_array($facturas) && count($facturas) > 0) {
	        	//echo json_encode($facts);
	        	foreach ($facturas as $fact) {
	                array_push($data1y, $fact->csm_act);
	                array_push($data2y, $fact->csm_rea);
		        }
	        }
	        if ((count($data1y) == 0) && (count($data2y) == 0)) {
	            $data1y = $data2y = array(0);
	        }

	        $graph = new Graph(640, 220);
	        $graph->SetScale('textlin');

	        $b1plot = new BarPlot($data1y);
	        $b2plot = new BarPlot($data2y);

	        $gbplot = new GroupBarPlot(array($b1plot, $b2plot));

	        $graph->Add($gbplot);

	        $graph->xaxis->title->Set('ciclos');
	        $graph->yaxis->title->Set('consumos');

	        $graph->title->Set($cte->nombre_facturacion);

	        $filename = Doo::session()->getId() . '_' . $cte->id_cliente .
	             'csmohist' . $this->params['ciclo_ini'] .
	            	$this->params['ciclo_fin'] . '.png';

            $img = Doo::conf()->SITE_PATH . 'temp/' . $filename;

            if (is_file($img)) {
	            unlink($img);
	    	}
	        $graph->Stroke(_IMG_HANDLER);
            $graph->img->Stream($img);

	        $data['graph'] = Doo::conf()->APP_URL . 'temp/' . $filename;
	        $data['time'] = Doo::conf()->START_TIME;

	        $this->view()->render('graph', $data);
        }
    }
}
