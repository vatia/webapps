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
	        require_once $jpgraph_path . 'jpgraph_line.php';

	        $ciclos = $activa = $reactiva = array();

	        if (is_array($facturas) && count($facturas) > 0) {
	        	foreach ($facturas as $fact) {
	        		array_push($ciclos, $fact->ciclo);
	                array_push($activa, $fact->csm_act);
	                array_push($reactiva, $fact->csm_rea);
		        }
	        }
	        if ((count($activa) == 0) && (count($reactiva) == 0)) {
	            $activa = $reactiva = array(0);
	        }

	        $graph = new Graph(650, 220, 'auto');

	        $graph->SetScale('textlin');
	        $graph->SetMargin(48, 10, 0, 40);
	        $graph->SetTheme(new UniversalTheme());
	        $graph->SetBox(false);

	        $graph->ygrid->SetFill(false);

	        $bar_act = new BarPlot($activa);
	        $bar_act->SetLegend('Activa');
			$bar_act->SetCSIMTargets(null, $activa);
	        $bar_act->value->Show(true);
	        $bar_act->SetShadow(true);

	        $bar_rea = new BarPlot($reactiva);
	        $bar_rea->SetLegend('Reactiva');

	        $line_act = new LinePlot($activa);
	        $line_act->SetWeight(1);
	        $line_act->SetBarCenter(true);

	        $graph->Add(new GroupBarPlot(array($bar_act, $bar_rea)));
	        $graph->Add($line_act);

	        $graph->title->Set($cte->id_cliente.' - '.$cte->nombre_facturacion);

	        //$graph->legend->SetFrameWeight(1);

	        $graph->xaxis->title->Set('Ciclos Facturacion');
	        $graph->xaxis->SetTickLabels($ciclos);
	        $graph->xaxis->HideLine(false);
	        $graph->xaxis->HideTicks(false, false);

	        $graph->yaxis->title->Set('Consumos KWh');
	        $graph->yaxis->HideLine(false);
	        $graph->yaxis->HideTicks(false, false);

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

