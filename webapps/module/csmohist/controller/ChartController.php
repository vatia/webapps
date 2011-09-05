<?php

class ChartController extends DooController {

    public function graph() {

        $jpgraph_dir = Doo::conf()->SITE_PATH . 'webapps/libraries/jpgraph/';

        require_once $jpgraph_dir . 'jpgraph.php';
        require_once $jpgraph_dir . 'jpgraph_bar.php';

        $data1y = $data2y = array();

        $fact = new M05Facturas();
        $fact->cliente_id = $this->params['id_cliente'];
        $facts = $this->db()->find($fact);

        foreach ($facts as $fact) {
            if ((intval($fact->ciclo) >= intval($this->params['ciclo_ini'])) &&
                (intval($fact->ciclo) <= intval($this->params['ciclo_fin']))) {
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

        $graph->title->Set($this->params['id_cliente']);

        $graph->Stroke(_IMG_HANDLER);

        $filename = Doo::session()->getId() . '_' . $this->params['id_cliente'] .
             'csmohist' . $this->params['ciclo_ini'] .
            	$this->params['ciclo_fin'] . '.png';

    	/* if (is_file($filename)) {
            unlink($filename);
    	} */

        $graph->img->Stream(Doo::conf()->SITE_PATH . 'temp/' . $filename);

        $data['graph'] = Doo::conf()->APP_URL . 'temp/' . $filename;

        $this->view()->render('graph', $data);
    }
}
