<?php

class ChartController extends DooController {

    public function graph() {

        $jpgraph_dir = Doo::conf()->SITE_PATH . 'webapps/libraries/jpgraph/';

        require_once $jpgraph_dir . 'jpgraph.php';
        require_once $jpgraph_dir . 'jpgraph_bar.php';

        $title = $this->params['id_cliente'] . ' - ';

        switch ($this->params['tipo_csmo']) {

            case 'act':
                $title .= 'Energia Activa';
                break;

            case 'rea':
                $title .= 'Energia Reactiva';
                break;

            case 'pen':
                $title .= 'Energia Penalizada';
                break;

            case 'fpo':
                $title .= 'Factor Potencia';
                break;

            default:
                return array('/error', 404);
        }

        $datay1 = array(20, 15, 23, 15);
        $datay2 = array(12, 9, 42, 8);
        $datay3 = array(5, 17, 32, 24);

        $graph = new Graph(640, 240);
        $graph->SetScale('textlin');

        $graph->SetTheme(new UniversalTheme());
        $graph->img->SetAntiAliasing(false);
        $graph->title->Set($title);
        $graph->SetBox(false);

        $graph->img->SetAntiAliasing();

        $graph->yaxis->HideZeroLabel();
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false,false);

        $graph->xgrid->Show();
        $graph->xgrid->SetLineStyle('solid');
        $graph->xaxis->SetTickLabels(array('A','B','C','D'));
        $graph->xgrid->SetColor('#e3e3e3');

        $p1 = new LinePlot($datay1);
        $graph->Add($p1);
        $p1->SetColor('#6495ed');
        $p1->SetLegend('Line 1');

        $p2 = new LinePlot($datay2);
        $graph->Add($p2);
        $p2->SetColor('#b22222');
        $p2->SetLegend('Line 2');

        $p3 = new LinePlot($datay3);
        $graph->Add($p3);
        $p3->SetColor('#ff1493');
        $p3->SetLegend('Line 3');

        $graph->legend->SetFrameWeight(1);
        $graph->Stroke(_IMG_HANDLER);

        $imgfile = 'temp/matrix_csmo_' . $this->params['id_cliente'] . '_' .
            Doo::session()->getId() . '.png';

        $graph->img->Stream(Doo::conf()->SITE_PATH . $imgfile);

        $data['graph'] = Doo::conf()->APP_URL . $imgfile;

        $this->view()->render('graph', $data);
    }
}
