<?php

class ChartController extends DooController {

    public function graph() {

    	Doo::loadModel('M02Clientes');
    	Doo::loadModel('M03Energia');

        Doo::logger()->beginDbProfile('find_cte', 'csmo_rpt');
        $cte = self::db()->find('M02Clientes', array(
        	'where' => 'id_cliente = ?',
        	'param' => array($this->params['id_cliente']),
        	'limit' => 1));
        Doo::logger()->endDbProfile('find_cte');

        if (is_object($cte) && ($cte instanceof M02Clientes)) {

        	$matrix = self::db()->find('M03Energia', array(
        		'where' => 'm02cli_id_cliente = ? AND fecha BETWEEN ? AND ?',
	            'param' => array($this->params['id_cliente'],
        			$this->params['fecha_ini'], $this->params['fecha_fin']),
        		'asc' => 'fecha'));

	        define('_JPGRAPH_LIB', Doo::conf()->SITE_PATH .
	        	'webapps/libraries/jpgraph/');

	        require_once _JPGRAPH_LIB . 'jpgraph.php';
	        require_once _JPGRAPH_LIB . 'jpgraph_bar.php';
	        require_once _JPGRAPH_LIB . 'jpgraph_line.php';

	        $fechas = $csmos = array(0);

	        if (is_array($matrix) && count($matrix) > 0) {
	        	array_pop($fechas);
	        	array_pop($csmos);
	        	foreach ($matrix as $mtx) {
	        		array_push($fechas, $mtx->fecha);
	        		$csmo = 0;
	        		for($h = 1; $h <= 24; $h++) {
		        		if ($h < 10) {
		        			switch ($this->params['tipo_csmo']) {
		        				case 'act':
	        						$csmo += $mtx->{'h0'.$h.'a'};
	        						break;
	        					case 'rea':
	        						$csmo += $mtx->{'h0'.$h.'r'};
	        						break;
	        					case 'pen':
	        						$csmo += self::excedente($mtx->{'h0'.$h.'a'},
	        							$mtx->{'h0'.$h.'r'});
	        						break;
	        					case 'fpo':
	        						$csmo += self::aparente($mtx->{'h0'.$h.'a'},
	        							$mtx->{'h0'.$h.'r'});
	        						break;
		        			}
		        		} else {
		        			switch ($this->params['tipo_csmo']) {
		        				case 'act':
	        						$csmo += $mtx->{'h'.$h.'a'};
	        						break;
	        					case 'rea':
	        						$csmo += $mtx->{'h'.$h.'r'};
	        						break;
	        					case 'pen':
	        						$csmo += self::excedente($mtx->{'h'.$h.'a'},
	        							$mtx->{'h'.$h.'r'});
	        						break;
	        					case 'fpo':
	        						$csmo += self::aparente($mtx->{'h'.$h.'a'},
	        							$mtx->{'h'.$h.'r'});
	        						break;
		        			}
		        		}
	        		}
	        		array_push($csmos, $csmo);
		        }
	        }
	        $graph = new Graph(800, 260, 'auto');

	        $graph->SetScale('textlin');
	        $graph->SetMargin(48, 10, 0, 40);
	        $graph->SetTheme(new UniversalTheme());
	        $graph->SetBox(false);

	        $graph->ygrid->SetFill(false);

	        $plot = new LinePlot($csmos);
	        $plot->SetWeight(2);

	        $graph->Add($plot);

	        $graph->title->Set($cte->id_cliente.' - '.$cte->nombre_facturacion);

	        //$graph->legend->SetFrameWeight(1);

	        $graph->xaxis->title->Set('Fecha');
	        $graph->xaxis->SetTickLabels($fechas);
	        $graph->xaxis->HideLine(false);
	        $graph->xaxis->HideTicks(false, false);

	        $graph->yaxis->title->Set('Consumo KWh');
	        $graph->yaxis->HideLine(false);
	        $graph->yaxis->HideTicks(false, false);

	        $filename = $this->params['tipo_csmo'] .
	        	Doo::session()->getId() . '.png';

            $img = Doo::conf()->SITE_PATH . 'temp/' . $filename;

            if (is_file($img)) {
	            unlink($img);
	    	}
	        $graph->Stroke(_IMG_HANDLER);
            $graph->img->Stream($img);

	        $data['graph'] = Doo::conf()->APP_URL . 'temp/' . $filename;
	        $data['time'] = Doo::conf()->START_TIME;

	        self::view()->render('graph', $data);
        }
    }

	private function excedente($activa, $reactiva) {
    	$penalizada = $reactiva - ($activa / 2);
    	return ($penalizada > 0) ? $penalizada: 0;
    }

	private function aparente($activa, $reactiva) {
    	$aparente = sqrt(pow($activa, 2) + pow($reactiva, 2));
    	return ($aparente > 0) ? round($activa / $aparente, 2): 0;
    }
}
