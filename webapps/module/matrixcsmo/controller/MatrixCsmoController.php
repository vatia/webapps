<?php

class MatrixCsmoController extends DooController {

    private $id_cliente;
    private $fecha_ini;
    private $fecha_fin;

    private function params() {

        $this->id_cliente = (isset($this->params['id_cliente'])) ?
            $this->params['id_cliente']: Doo::session()->get('id_cliente');

        $this->fecha_ini = (isset($this->params['fecha_ini'])) ?
            $this->params['fecha_ini']: Doo::session()->get('fecha_ini');

        $this->fecha_fin = (isset($this->params['fecha_fin'])) ?
            $this->params['fecha_fin']: Doo::session()->get('fecha_fin');
    }

    public function act() {

        self::params();

        $data['id_cliente'] = $this->id_cliente;
        $data['fecha_ini'] = $this->fecha_ini;
        $data['fecha_fin'] = $this->fecha_fin;

        $enrgy = new M03Energia();
        $enrgy->m02cli_id_cliente = $this->id_cliente;

        $data['matrix'] = self::db()->find($enrgy, array(
            'where' => 'fecha BETWEEN ? AND ?',
            'param' => array($this->fecha_ini, $this->fecha_fin),
            'asc' => 'fecha'));

        Doo::session()->matrix_act = $data['matrix'];

        if (is_array($data['matrix']) && count($data['matrix']) > 0) {
        	for ($i=0; $i<count($data['matrix']); $i++) {
	        	for($h = 1; $h <= 24; $h++) {
	        		if ($h < 10) {
	        			$data['matrix'][$i]->{'h0'.$h.'a'} = number_format(
	        				$data['matrix'][$i]->{'h0'.$h.'a'}, 2, ',', '.');
	        		} else {
	        			$data['matrix'][$i]->{'h'.$h.'a'} = number_format(
	        				$data['matrix'][$i]->{'h'.$h.'a'}, 2, ',', '.');
	        		}
	        	}
	        }
        }
        $this->view()->render('act', $data);
    }

    public function rea() {

        self::params();

        $data['id_cliente'] = $this->id_cliente;
        $data['fecha_ini'] = $this->fecha_ini;
        $data['fecha_fin'] = $this->fecha_fin;

        $enrgy = new M03Energia();
        $enrgy->m02cli_id_cliente = $this->id_cliente;

        $data['matrix'] = self::db()->find($enrgy, array(
        	'where' => 'fecha BETWEEN ? AND ?',
             'param' => array($this->fecha_ini, $this->fecha_fin),
             'asc' => 'fecha'));

        Doo::session()->matrix_rea = $data['matrix'];

        if (is_array($data['matrix']) && count($data['matrix']) > 0) {
        	for ($i=0; $i<count($data['matrix']); $i++) {
	        	for($h = 1; $h <= 24; $h++) {
	        		if ($h < 10) {
	        			$data['matrix'][$i]->{'h0'.$h.'r'} = number_format(
	        				$data['matrix'][$i]->{'h0'.$h.'r'}, 2, ',', '.');
	        		} else {
	        			$data['matrix'][$i]->{'h'.$h.'r'} = number_format(
	        				$data['matrix'][$i]->{'h'.$h.'r'}, 2, ',', '.');
	        		}
	        	}
	        }
        }
        self::view()->render('rea', $data);
    }

    private function excedente($activa, $reactiva) {
    	$penalizada = $reactiva - ($activa / 2);
    	return ($penalizada > 0) ? $penalizada: 0;
    }

    public function pen() {

        self::params();

        $data['id_cliente'] = $this->id_cliente;
        $data['fecha_ini'] = $this->fecha_ini;
        $data['fecha_fin'] = $this->fecha_fin;

        $enrgy = new M03Energia();
        $enrgy->m02cli_id_cliente = $this->id_cliente;

        $data['matrix'] = self::db()->find($enrgy, array(
        	'where' => 'fecha BETWEEN ? AND ?',
            'param' => array($this->fecha_ini, $this->fecha_fin),
            'asc' => 'fecha'));

        Doo::session()->matrix_pen = $data['matrix'];

        if (is_array($data['matrix']) && count($data['matrix']) > 0) {
	        foreach ($data['matrix'] as $mtx) {
	        	for($h = 1; $h <= 24; $h++) {
	        		if ($h < 10) {
	        			$mtx->{'h0'.$h.'a'} = number_format(self::excedente(
	        				$mtx->{'h0'.$h.'a'}, $mtx->{'h0'.$h.'r'}), 2, ',', '.');
	        		} else {
	        			$mtx->{'h'.$h.'a'} = number_format(self::excedente(
	        				$mtx->{'h'.$h.'a'}, $mtx->{'h'.$h.'r'}), 2, ',', '.');
	        		}
	        	}
	        }
        }
        self::view()->render('pen', $data);
    }

    private function aparente($activa, $reactiva) {
    	$aparente = sqrt(pow($activa, 2) + pow($reactiva, 2));
    	return ($aparente > 0) ? round($activa / $aparente, 2): 0;
    }

    public function fpo() {

        self::params();

        $data['id_cliente'] = $this->id_cliente;
        $data['fecha_ini'] = $this->fecha_ini;
        $data['fecha_fin'] = $this->fecha_fin;

        $enrgy = new M03Energia();
        $enrgy->m02cli_id_cliente = $this->id_cliente;

        $data['matrix'] = self::db()->find($enrgy, array(
        	'where' => 'fecha BETWEEN ? AND ?',
            'param' => array($this->fecha_ini, $this->fecha_fin),
            'asc' => 'fecha'));

        Doo::session()->matrix_fpo = $data['matrix'];

        if (is_array($data['matrix']) && count($data['matrix']) > 0) {
	        foreach ($data['matrix'] as $mtx) {
	        	for($h = 1; $h <= 24; $h++) {
        		    if ($h < 10) {
	        			$mtx->{'h0'.$h.'a'} = number_format(self::aparente(
	        				$mtx->{'h0'.$h.'a'}, $mtx->{'h0'.$h.'r'}), 2, ',', '.');
	        		} else {
	        			$mtx->{'h'.$h.'a'} = number_format(self::aparente(
	        				$mtx->{'h'.$h.'a'}, $mtx->{'h'.$h.'r'}), 2, ',', '.');
	        		}
	        	}
	        }
        }
        self::view()->render('fpo', $data);
    }
}
