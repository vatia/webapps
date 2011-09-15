<?php

class ReportController extends DooController {

    public function excel() {

    	set_time_limit(0);

        /*define('_PHPEXCEL_LIB',
            Doo::conf()->SITE_PATH . 'webapps/libraries/');

        require_once _PHPEXCEL_LIB . 'PHPExcel.php';*/

        $excel = new PHPExcel();

        /*$excel->getProperties()->setCreator('Vatia S.A. E.S.P.')
            ->setLastModifiedBy('Vatia S.A. E.S.P.')
            ->setTitle('Matriz')
            ->setSubject('Consumos')
            ->setDescription('Matrices de Energia')
            ->setKeywords('vatia reporte matriz consumo energia')
            ->setCategory('matrixcsmo');*/

        $usrtype = $this->params['usrtype'];

        $cols = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L',
        	'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y');

        $csmos = preg_split('/[,\-]/',
            $this->params['csmotypes'], -1, PREG_SPLIT_NO_EMPTY);

		$f = 2;

        if ($usrtype === 'corp') {

        	$clientes = Doo::session()->get('clientes');
        	if (is_array($clientes) && count($clientes) > 0) {
        		$idx = 0;
        		foreach ($clientes as $cte) {
        			if (is_object($cte) && ($cte instanceof M02Clientes)) {
        				if ($cte->id_cliente === $this->params['id']) {

				            //$sheet = $excel->createSheet($idx++);
				            $sheet = $excel->getActiveSheet();

				            $sheet->setTitle($cte->id_cliente);
				            $sheet->setCellValue('A'.$f, $cte->nombre_facturacion);

				            foreach ($csmos as $csmo) {
				                switch ($csmo) {

				                	////////////////////////////////////////////////

				                    case 'act':
				                        $sheet->setCellValue('A'.($f+=2),
				                        	'MATRIZ DE ENERGIA ACTIVA');

				                        $sheet->setCellValue('A'.($f+=2), 'FECHA');
				                        for ($i = 1; $i<=24; $i++) {
				                            $sheet->setCellValue($cols[$i].$f, 'H'.$i);
				                        }
				                        $sheet->setCellValue('Z'.$f++, 'CSMO_TOTAL_DIA');

				                        $mtx_act = Doo::session()->get('matrix_act');

				                        if (is_array($mtx_act) && count($mtx_act) > 0) {
				                            foreach ($mtx_act as $mtx) {
				                                $sheet->setCellValue('A'.$f, $mtx->fecha)
				                                    ->setCellValue('B'.$f, $mtx->h01a)
				                                    ->setCellValue('C'.$f, $mtx->h02a)
				                                    ->setCellValue('D'.$f, $mtx->h03a)
				                                    ->setCellValue('E'.$f, $mtx->h04a)
				                                    ->setCellValue('F'.$f, $mtx->h05a)
				                                    ->setCellValue('G'.$f, $mtx->h06a)
				                                    ->setCellValue('H'.$f, $mtx->h07a)
				                                    ->setCellValue('I'.$f, $mtx->h08a)
				                                    ->setCellValue('J'.$f, $mtx->h09a)
				                                    ->setCellValue('K'.$f, $mtx->h10a)
				                                    ->setCellValue('L'.$f, $mtx->h11a)
				                                    ->setCellValue('M'.$f, $mtx->h12a)
				                                    ->setCellValue('N'.$f, $mtx->h13a)
				                                    ->setCellValue('O'.$f, $mtx->h14a)
				                                    ->setCellValue('P'.$f, $mtx->h15a)
				                                    ->setCellValue('Q'.$f, $mtx->h16a)
				                                    ->setCellValue('R'.$f, $mtx->h17a)
				                                    ->setCellValue('S'.$f, $mtx->h18a)
				                                    ->setCellValue('T'.$f, $mtx->h19a)
				                                    ->setCellValue('U'.$f, $mtx->h20a)
				                                    ->setCellValue('V'.$f, $mtx->h21a)
				                                    ->setCellValue('W'.$f, $mtx->h22a)
				                                    ->setCellValue('X'.$f, $mtx->h23a)
				                                    ->setCellValue('Y'.$f, $mtx->h24a)
				                                    ->setCellValue('Z'.$f,
				                                    	'=SUM(B'.$f.':Y'.$f++.')');
				                            }
				                            $sheet->setCellValue('A'.$f, 'CSMO_TOTAL_HORA');

				                            for ($i = 1; $i<=24; $i++) {
				                                $sheet->setCellValue($cols[$i].$f,
			                                		'=SUM('.$cols[$i].($f-count($mtx_act)).
			                                			':'.$cols[$i].($f-1).')');
				                            }
				                            $sheet->setCellValue('Y'.$f, 'CSMO_TOTAL');

				                            $sheet->setCellValue('Z'.$f, '=SUM(Z'.
				                            	($f-count($mtx_act)).':Z'.($f-1).')');
				                        }
				                        break;

				                	////////////////////////////////////////////////

				                    case 'rea':
				                        $sheet->setCellValue('A'.($f+=2),
				                        	'MATRIZ DE ENERGIA REACTIVA');

				                        $sheet->setCellValue('A'.($f+=2), 'FECHA');
				                        for ($i = 1; $i<=24; $i++) {
				                            $sheet->setCellValue($cols[$i].$f, 'H'.$i);
				                        }
				                        $sheet->setCellValue('Z'.$f++, 'CSMO_TOTAL_DIA');

				                        $mtx_rea = Doo::session()->get('matrix_rea');

				                        if (is_array($mtx_rea) && count($mtx_rea) > 0) {
				                            foreach ($mtx_rea as $mtx) {
				                                $sheet->setCellValue('A'.$f, $mtx->fecha)
				                                    ->setCellValue('B'.$f, $mtx->h01r)
				                                    ->setCellValue('C'.$f, $mtx->h02r)
				                                    ->setCellValue('D'.$f, $mtx->h03r)
				                                    ->setCellValue('E'.$f, $mtx->h04r)
				                                    ->setCellValue('F'.$f, $mtx->h05r)
				                                    ->setCellValue('G'.$f, $mtx->h06r)
				                                    ->setCellValue('H'.$f, $mtx->h07r)
				                                    ->setCellValue('I'.$f, $mtx->h08r)
				                                    ->setCellValue('J'.$f, $mtx->h09r)
				                                    ->setCellValue('K'.$f, $mtx->h10r)
				                                    ->setCellValue('L'.$f, $mtx->h11r)
				                                    ->setCellValue('M'.$f, $mtx->h12r)
				                                    ->setCellValue('N'.$f, $mtx->h13r)
				                                    ->setCellValue('O'.$f, $mtx->h14r)
				                                    ->setCellValue('P'.$f, $mtx->h15r)
				                                    ->setCellValue('Q'.$f, $mtx->h16r)
				                                    ->setCellValue('R'.$f, $mtx->h17r)
				                                    ->setCellValue('S'.$f, $mtx->h18r)
				                                    ->setCellValue('T'.$f, $mtx->h19r)
				                                    ->setCellValue('U'.$f, $mtx->h20r)
				                                    ->setCellValue('V'.$f, $mtx->h21r)
				                                    ->setCellValue('W'.$f, $mtx->h22r)
				                                    ->setCellValue('X'.$f, $mtx->h23r)
				                                    ->setCellValue('Y'.$f, $mtx->h24r)
				                                    ->setCellValue('Z'.$f,
				                                    	'=SUM(B'.$f.':Y'.$f++.')');
				                            }
				                            $sheet->setCellValue('A'.$f, 'CSMO_TOTAL_HORA');

				                            for ($i = 1; $i<=24; $i++) {
				                                $sheet->setCellValue($cols[$i].$f,
			                                		'=SUM('.$cols[$i].($f-count($mtx_rea)).
			                                			':'.$cols[$i].($f-1).')');
				                            }
				                            $sheet->setCellValue('Y'.$f, 'CSMO_TOTAL');

				                            $sheet->setCellValue('Z'.$f, '=SUM(Z'.
				                            	($f-count($mtx_rea)).':Z'.($f-1).')');
				                        }
				                        break;

				                	////////////////////////////////////////////////

				                    case 'pen':
				                        $sheet->setCellValue('A'.($f+=2),
				                        	'MATRIZ DE ENERGIA PENALIZADA');

				                        $sheet->setCellValue('A'.($f+=2), 'FECHA');
				                        for ($i = 1; $i<=24; $i++) {
				                            $sheet->setCellValue($cols[$i].$f, 'H'.$i);
				                        }
				                        $sheet->setCellValue('Z'.$f++, 'CSMO_TOTAL_DIA');

				                        $mtx_pen = Doo::session()->get('matrix_pen');

				                        if (is_array($mtx_pen) && count($mtx_pen) > 0) {
				                            foreach ($mtx_pen as $mtx) {
				                                $sheet->setCellValue('A'.$f, $mtx->fecha)
				                                    ->setCellValue('B'.$f, $mtx->h01a)
				                                    ->setCellValue('C'.$f, $mtx->h02a)
				                                    ->setCellValue('D'.$f, $mtx->h03a)
				                                    ->setCellValue('E'.$f, $mtx->h04a)
				                                    ->setCellValue('F'.$f, $mtx->h05a)
				                                    ->setCellValue('G'.$f, $mtx->h06a)
				                                    ->setCellValue('H'.$f, $mtx->h07a)
				                                    ->setCellValue('I'.$f, $mtx->h08a)
				                                    ->setCellValue('J'.$f, $mtx->h09a)
				                                    ->setCellValue('K'.$f, $mtx->h10a)
				                                    ->setCellValue('L'.$f, $mtx->h11a)
				                                    ->setCellValue('M'.$f, $mtx->h12a)
				                                    ->setCellValue('N'.$f, $mtx->h13a)
				                                    ->setCellValue('O'.$f, $mtx->h14a)
				                                    ->setCellValue('P'.$f, $mtx->h15a)
				                                    ->setCellValue('Q'.$f, $mtx->h16a)
				                                    ->setCellValue('R'.$f, $mtx->h17a)
				                                    ->setCellValue('S'.$f, $mtx->h18a)
				                                    ->setCellValue('T'.$f, $mtx->h19a)
				                                    ->setCellValue('U'.$f, $mtx->h20a)
				                                    ->setCellValue('V'.$f, $mtx->h21a)
				                                    ->setCellValue('W'.$f, $mtx->h22a)
				                                    ->setCellValue('X'.$f, $mtx->h23a)
				                                    ->setCellValue('Y'.$f, $mtx->h24a)
				                                    ->setCellValue('Z'.$f,
				                                    	'=SUM(B'.$f.':Y'.$f++.')');
				                            }
				                            $sheet->setCellValue('A'.$f, 'CSMO_TOTAL_HORA');

				                            for ($i = 1; $i<=24; $i++) {
				                                $sheet->setCellValue($cols[$i].$f,
			                                		'=SUM('.$cols[$i].($f-count($mtx_pen)).
			                                			':'.$cols[$i].($f-1).')');
				                            }
				                            $sheet->setCellValue('Y'.$f, 'CSMO_TOTAL');

				                            $sheet->setCellValue('Z'.$f, '=SUM(Z'.
				                            	($f-count($mtx_pen)).':Z'.($f-1).')');
				                        }
				                        break;

				                	////////////////////////////////////////////////

				                    case 'fpo':
				                        $sheet->setCellValue('A'.($f+=2),
				                        	'MATRIZ FACTOR DE POTENCIA');

				                        $sheet->setCellValue('A'.($f+=2), 'FECHA');
				                        for ($i = 1; $i<=24; $i++) {
				                            $sheet->setCellValue($cols[$i].$f, 'H'.$i);
				                        }
				                        $sheet->setCellValue('Z'.$f++, 'CSMO_TOTAL_DIA');

				                        $mtx_fpo = Doo::session()->get('matrix_fpo');

				                        if (is_array($mtx_fpo) && count($mtx_fpo) > 0) {
				                            foreach ($mtx_fpo as $mtx) {
				                                $sheet->setCellValue('A'.$f, $mtx->fecha)
				                                    ->setCellValue('B'.$f, $mtx->h01a)
				                                    ->setCellValue('C'.$f, $mtx->h02a)
				                                    ->setCellValue('D'.$f, $mtx->h03a)
				                                    ->setCellValue('E'.$f, $mtx->h04a)
				                                    ->setCellValue('F'.$f, $mtx->h05a)
				                                    ->setCellValue('G'.$f, $mtx->h06a)
				                                    ->setCellValue('H'.$f, $mtx->h07a)
				                                    ->setCellValue('I'.$f, $mtx->h08a)
				                                    ->setCellValue('J'.$f, $mtx->h09a)
				                                    ->setCellValue('K'.$f, $mtx->h10a)
				                                    ->setCellValue('L'.$f, $mtx->h11a)
				                                    ->setCellValue('M'.$f, $mtx->h12a)
				                                    ->setCellValue('N'.$f, $mtx->h13a)
				                                    ->setCellValue('O'.$f, $mtx->h14a)
				                                    ->setCellValue('P'.$f, $mtx->h15a)
				                                    ->setCellValue('Q'.$f, $mtx->h16a)
				                                    ->setCellValue('R'.$f, $mtx->h17a)
				                                    ->setCellValue('S'.$f, $mtx->h18a)
				                                    ->setCellValue('T'.$f, $mtx->h19a)
				                                    ->setCellValue('U'.$f, $mtx->h20a)
				                                    ->setCellValue('V'.$f, $mtx->h21a)
				                                    ->setCellValue('W'.$f, $mtx->h22a)
				                                    ->setCellValue('X'.$f, $mtx->h23a)
				                                    ->setCellValue('Y'.$f, $mtx->h24a)
				                                    ->setCellValue('Z'.$f,
				                                    	'=SUM(B'.$f.':Y'.$f++.')');
				                            }
				                            $sheet->setCellValue('A'.$f, 'CSMO_TOTAL_HORA');

				                            for ($i = 1; $i<=24; $i++) {
				                                $sheet->setCellValue($cols[$i].$f,
			                                		'=SUM('.$cols[$i].($f-count($mtx_fpo)).
			                                			':'.$cols[$i].($f-1).')');
				                            }
				                            $sheet->setCellValue('Y'.$f, 'CSMO_TOTAL');

				                            $sheet->setCellValue('Z'.$f, '=SUM(Z'.
				                            	($f-count($mtx_fpo)).':Z'.($f-1).')');
				                        }
				                        break;
				                }
				            }
        					break;
        				}
	        			$excel->setActiveSheetIndex(0);
        			}
        		}
        	}

/*******************************************************************************/

        } else {

            $cte = Doo::session()->get('cte');

            if (is_object($cte) && ($cte instanceof M02Clientes)) {

            	$sheet = $excel->getActiveSheet();

	            $sheet->setTitle($cte->id_cliente);
	            $sheet->setCellValue('A'.$f, $cte->nombre_facturacion);

	            foreach ($csmos as $csmo) {
	                switch ($csmo) {

				        ////////////////////////////////////////////////////////////

	                    case 'act':
	                        $sheet->setCellValue('A'.($f+=2),
	                        	'MATRIZ DE ENERGIA ACTIVA');

	                        $sheet->setCellValue('A'.($f+=2), 'FECHA');
	                        for ($i = 1; $i<=24; $i++) {
	                            $sheet->setCellValue($cols[$i].$f, 'H'.$i);
	                        }
	                        $sheet->setCellValue('Z'.$f++, 'CSMO_TOTAL_DIA');

	                        $mtx_act = Doo::session()->get('matrix_act');

	                        if (is_array($mtx_act) && count($mtx_act) > 0) {
	                            foreach ($mtx_act as $mtx) {
	                                $sheet->setCellValue('A'.$f, $mtx->fecha)
	                                    ->setCellValue('B'.$f, $mtx->h01a)
	                                    ->setCellValue('C'.$f, $mtx->h02a)
	                                    ->setCellValue('D'.$f, $mtx->h03a)
	                                    ->setCellValue('E'.$f, $mtx->h04a)
	                                    ->setCellValue('F'.$f, $mtx->h05a)
	                                    ->setCellValue('G'.$f, $mtx->h06a)
	                                    ->setCellValue('H'.$f, $mtx->h07a)
	                                    ->setCellValue('I'.$f, $mtx->h08a)
	                                    ->setCellValue('J'.$f, $mtx->h09a)
	                                    ->setCellValue('K'.$f, $mtx->h10a)
	                                    ->setCellValue('L'.$f, $mtx->h11a)
	                                    ->setCellValue('M'.$f, $mtx->h12a)
	                                    ->setCellValue('N'.$f, $mtx->h13a)
	                                    ->setCellValue('O'.$f, $mtx->h14a)
	                                    ->setCellValue('P'.$f, $mtx->h15a)
	                                    ->setCellValue('Q'.$f, $mtx->h16a)
	                                    ->setCellValue('R'.$f, $mtx->h17a)
	                                    ->setCellValue('S'.$f, $mtx->h18a)
	                                    ->setCellValue('T'.$f, $mtx->h19a)
	                                    ->setCellValue('U'.$f, $mtx->h20a)
	                                    ->setCellValue('V'.$f, $mtx->h21a)
	                                    ->setCellValue('W'.$f, $mtx->h22a)
	                                    ->setCellValue('X'.$f, $mtx->h23a)
	                                    ->setCellValue('Y'.$f, $mtx->h24a)
	                                    ->setCellValue('Z'.$f,
	                                    	'=SUM(B'.$f.':Y'.$f++.')');
	                            }
	                            $sheet->setCellValue('A'.$f, 'CSMO_TOTAL_HORA');

	                            for ($i = 1; $i<=24; $i++) {
	                                $sheet->setCellValue($cols[$i].$f,
                                		'=SUM('.$cols[$i].($f-count($mtx_act)).
                                			':'.$cols[$i].($f-1).')');
	                            }
	                            $sheet->setCellValue('Y'.$f, 'CSMO_TOTAL');
	                            $sheet->setCellValue('Z'.$f, '=SUM(Z'.
	                            	($f-count($mtx_act)).':Z'.($f-1).')');
	                        }
	                        break;

				        ////////////////////////////////////////////////////////////

	                    case 'rea':
	                        $sheet->setCellValue('A'.($f+=2),
	                        	'MATRIZ DE ENERGIA REACTIVA');

	                        $sheet->setCellValue('A'.($f+=2), 'FECHA');
	                        for ($i = 1; $i<=24; $i++) {
	                            $sheet->setCellValue($cols[$i].$f, 'H'.$i);
	                        }
	                        $sheet->setCellValue('Z'.$f++, 'CSMO_TOTAL_DIA');

	                        $mtx_rea = Doo::session()->get('matrix_rea');

	                        if (is_array($mtx_rea) && count($mtx_rea) > 0) {
	                            foreach ($mtx_rea as $mtx) {
	                                $sheet->setCellValue('A'.$f, $mtx->fecha)
	                                    ->setCellValue('B'.$f, $mtx->h01r)
	                                    ->setCellValue('C'.$f, $mtx->h02r)
	                                    ->setCellValue('D'.$f, $mtx->h03r)
	                                    ->setCellValue('E'.$f, $mtx->h04r)
	                                    ->setCellValue('F'.$f, $mtx->h05r)
	                                    ->setCellValue('G'.$f, $mtx->h06r)
	                                    ->setCellValue('H'.$f, $mtx->h07r)
	                                    ->setCellValue('I'.$f, $mtx->h08r)
	                                    ->setCellValue('J'.$f, $mtx->h09r)
	                                    ->setCellValue('K'.$f, $mtx->h10r)
	                                    ->setCellValue('L'.$f, $mtx->h11r)
	                                    ->setCellValue('M'.$f, $mtx->h12r)
	                                    ->setCellValue('N'.$f, $mtx->h13r)
	                                    ->setCellValue('O'.$f, $mtx->h14r)
	                                    ->setCellValue('P'.$f, $mtx->h15r)
	                                    ->setCellValue('Q'.$f, $mtx->h16r)
	                                    ->setCellValue('R'.$f, $mtx->h17r)
	                                    ->setCellValue('S'.$f, $mtx->h18r)
	                                    ->setCellValue('T'.$f, $mtx->h19r)
	                                    ->setCellValue('U'.$f, $mtx->h20r)
	                                    ->setCellValue('V'.$f, $mtx->h21r)
	                                    ->setCellValue('W'.$f, $mtx->h22r)
	                                    ->setCellValue('X'.$f, $mtx->h23r)
	                                    ->setCellValue('Y'.$f, $mtx->h24r)
	                                    ->setCellValue('Z'.$f,
	                                    	'=SUM(B'.$f.':Y'.$f++.')');
	                            }
	                            $sheet->setCellValue('A'.$f, 'CSMO_TOTAL_HORA');

	                            for ($i = 1; $i<=24; $i++) {
	                                $sheet->setCellValue($cols[$i].$f,
                                		'=SUM('.$cols[$i].($f-count($mtx_rea)).
                                			':'.$cols[$i].($f-1).')');
	                            }
	                            $sheet->setCellValue('Y'.$f, 'CSMO_TOTAL');

	                            $sheet->setCellValue('Z'.$f, '=SUM(Z'.
	                            	($f-count($mtx_rea)).':Z'.($f-1).')');
	                        }
	                        break;

				        ////////////////////////////////////////////////////////////

	                    case 'pen':
	                        $sheet->setCellValue('A'.($f+=2),
	                        	'MATRIZ DE ENERGIA PENALIZADA');

	                        $sheet->setCellValue('A'.($f+=2), 'FECHA');
	                        for ($i = 1; $i<=24; $i++) {
	                            $sheet->setCellValue($cols[$i].$f, 'H'.$i);
	                        }
	                        $sheet->setCellValue('Z'.$f, 'CSMO_TOTAL_DIA');

	                        $mtx_pen = Doo::session()->get('matrix_pen');

	                        if (is_array($mtx_pen) && count($mtx_pen) > 0) {
	                            foreach ($mtx_pen as $mtx) {
	                                $sheet->setCellValue('A'.$f, $mtx->fecha)
	                                    ->setCellValue('B'.$f, $mtx->h01a)
	                                    ->setCellValue('C'.$f, $mtx->h02a)
	                                    ->setCellValue('D'.$f, $mtx->h03a)
	                                    ->setCellValue('E'.$f, $mtx->h04a)
	                                    ->setCellValue('F'.$f, $mtx->h05a)
	                                    ->setCellValue('G'.$f, $mtx->h06a)
	                                    ->setCellValue('H'.$f, $mtx->h07a)
	                                    ->setCellValue('I'.$f, $mtx->h08a)
	                                    ->setCellValue('J'.$f, $mtx->h09a)
	                                    ->setCellValue('K'.$f, $mtx->h10a)
	                                    ->setCellValue('L'.$f, $mtx->h11a)
	                                    ->setCellValue('M'.$f, $mtx->h12a)
	                                    ->setCellValue('N'.$f, $mtx->h13a)
	                                    ->setCellValue('O'.$f, $mtx->h14a)
	                                    ->setCellValue('P'.$f, $mtx->h15a)
	                                    ->setCellValue('Q'.$f, $mtx->h16a)
	                                    ->setCellValue('R'.$f, $mtx->h17a)
	                                    ->setCellValue('S'.$f, $mtx->h18a)
	                                    ->setCellValue('T'.$f, $mtx->h19a)
	                                    ->setCellValue('U'.$f, $mtx->h20a)
	                                    ->setCellValue('V'.$f, $mtx->h21a)
	                                    ->setCellValue('W'.$f, $mtx->h22a)
	                                    ->setCellValue('X'.$f, $mtx->h23a)
	                                    ->setCellValue('Y'.$f, $mtx->h24a)
	                                    ->setCellValue('Z'.$f,
	                                    	'=SUM(B'.$f.':Y'.$f++.')');
	                            }
	                            $sheet->setCellValue('A'.$f, 'CSMO_TOTAL_HORA');

	                            for ($i = 1; $i<=24; $i++) {
	                                $sheet->setCellValue($cols[$i].$f,
                                		'=SUM('.$cols[$i].($f-count($mtx_pen)).
                                			':'.$cols[$i].($f-1).')');
	                            }
	                            $sheet->setCellValue('Y'.$f, 'CSMO_TOTAL');

	                            $sheet->setCellValue('Z'.$f, '=SUM(Z'.
	                            	($f-count($mtx_pen)).':Z'.($f-1).')');
	                        }
	                        break;

				        ////////////////////////////////////////////////////////////

	                    case 'fpo':
	                        $sheet->setCellValue('A'.($f+=2),
	                        	'MATRIZ FACTOR DE POTENCIA');

	                        $sheet->setCellValue('A'.($f+=2), 'FECHA');
	                        for ($i = 1; $i<=24; $i++) {
	                            $sheet->setCellValue($cols[$i].$f, 'H'.$i);
	                        }
	                        $sheet->setCellValue('Z'.$f, 'CSMO_TOTAL_DIA');

	                        $mtx_fpo = Doo::session()->get('matrix_fpo');

	                        if (is_array($mtx_fpo) && count($mtx_fpo) > 0) {
	                            foreach ($mtx_fpo as $mtx) {
	                                $sheet->setCellValue('A'.$f, $mtx->fecha)
	                                    ->setCellValue('B'.$f, $mtx->h01a)
	                                    ->setCellValue('C'.$f, $mtx->h02a)
	                                    ->setCellValue('D'.$f, $mtx->h03a)
	                                    ->setCellValue('E'.$f, $mtx->h04a)
	                                    ->setCellValue('F'.$f, $mtx->h05a)
	                                    ->setCellValue('G'.$f, $mtx->h06a)
	                                    ->setCellValue('H'.$f, $mtx->h07a)
	                                    ->setCellValue('I'.$f, $mtx->h08a)
	                                    ->setCellValue('J'.$f, $mtx->h09a)
	                                    ->setCellValue('K'.$f, $mtx->h10a)
	                                    ->setCellValue('L'.$f, $mtx->h11a)
	                                    ->setCellValue('M'.$f, $mtx->h12a)
	                                    ->setCellValue('N'.$f, $mtx->h13a)
	                                    ->setCellValue('O'.$f, $mtx->h14a)
	                                    ->setCellValue('P'.$f, $mtx->h15a)
	                                    ->setCellValue('Q'.$f, $mtx->h16a)
	                                    ->setCellValue('R'.$f, $mtx->h17a)
	                                    ->setCellValue('S'.$f, $mtx->h18a)
	                                    ->setCellValue('T'.$f, $mtx->h19a)
	                                    ->setCellValue('U'.$f, $mtx->h20a)
	                                    ->setCellValue('V'.$f, $mtx->h21a)
	                                    ->setCellValue('W'.$f, $mtx->h22a)
	                                    ->setCellValue('X'.$f, $mtx->h23a)
	                                    ->setCellValue('Y'.$f, $mtx->h24a)
	                                    ->setCellValue('Z'.$f,
	                                    	'=SUM(B'.$f.':Y'.$f++.')');
	                            }
	                            $sheet->setCellValue('A'.$f, 'CSMO_TOTAL_HORA');

	                            for ($i = 1; $i<=24; $i++) {
	                                $sheet->setCellValue($cols[$i].$f,
                                		'=SUM('.$cols[$i].($f-count($mtx_fpo)).
                                			':'.$cols[$i].($f-1).')');
	                            }
	                            $sheet->setCellValue('Y'.$f, 'CSMO_TOTAL');

	                            $sheet->setCellValue('Z'.$f, '=SUM(Z'.
	                            	($f-count($mtx_fpo)).':Z'.($f-1).')');
	                        }
	                        break;
	                }
	            }
            }
            $excel->setActiveSheetIndex(0);
        }

        $filename = 'mtxcsmo_' . $this->params['id'];

        /*$usrtype = Doo::session()->get('usrtype');
        if ($usrtype == 'corp') {
        	$grp = Doo::session()->get('grp');
        	if (is_object($grp) && ($grp instanceof M02GruposCliente)) {
        		$filename .= 'corp_' . $grp->id;
        	}
        } else {
        	$cte = Doo::session()->get('cte');
        	if (is_object($cte) && ($cte instanceof M02Clientes)) {
        		$filename .= 'cte_' . $cte->id_cliente;
        	}
        }*/

        $filename .=  '_' . Doo::session()->getId() . '.xls';

    	$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $objWriter->save(Doo::conf()->SITE_PATH . 'temp/' . $filename);

        self::toJSON(array('file' => Doo::conf()->APP_URL . 'temp/' . $filename), true);
        //self::load()->download(Doo::conf()->SITE_PATH . 'temp/' . $filename);
    }

    public function pdf() {

        define('_TCPDF_LIB',
            Doo::conf()->SITE_PATH . 'webapps/libraries/tcpdf/');

        require_once _TCPDF_LIB . 'config/lang/eng.php';
        require_once _TCPDF_LIB . 'tcpdf.php';

        $pdf = new TCPDF();

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Vatia S.A. E.S.P.');
        $pdf->SetTitle('Reporte');
        $pdf->SetSubject('Matriz de Consumo');
        $pdf->SetKeywords('vatia, reporte, matriz, consumo, energia');

        $pdf->setJPEGQuality(90);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->getAliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('times', 'B', 20);
        $pdf->Cell(0, 12, 'Reporte Matriz de Consumo', 1, 1, 'C');

        $filename = Doo::session()->getId() . '_' . $this->params['id'] .
             'matrixcsmo' . $this->params['fecha_ini'] .
            	$this->params['fecha_fin'] . '.pdf';

    	$data['filename'] = Doo::conf()->SITE_PATH . 'temp/' . $filename;

    	$pdf->Output(Doo::conf()->SITE_PATH . 'temp/' . $filename, 'F');

        self::view()->render('pdf', $data);
    }
}
