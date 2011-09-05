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

        $data['matrix'] = Doo::db()->find($enrgy,
                    array(
                    'select' => 'fecha, h01a, h02a, h03a, h04a, h05a, h06a, h07a,
                    			h08a, h09a, h10a, h11a, h12a, h13a, h14a, h15a,
                				h16a, h17a, h18a, h19a, h20a, h21a, h22a, h23a,
                				h24a, version',
                    'where' => 'fecha BETWEEN ? AND ?',
                    'param' => array(
                                $this->fecha_ini,
                                $this->fecha_fin),
                    'asc' => 'fecha'));

        Doo::session()->matrix_act = $data['matrix'];

        $this->view()->render('act', $data);
    }

    public function rea() {

        self::params();

        $data['id_cliente'] = $this->id_cliente;
        $data['fecha_ini'] = $this->fecha_ini;
        $data['fecha_fin'] = $this->fecha_fin;

        $enrgy = new M03Energia();
        $enrgy->m02cli_id_cliente = $this->id_cliente;

        $data['matrix'] = Doo::db()->find($enrgy,
                    array(
                    'select' => 'fecha, h01r, h02r, h03r, h04r, h05r, h06r, h07r,
                    			h08r, h09r, h10r, h11r, h12r, h13r, h14r, h15r,
                				h16r, h17r, h18r, h19r, h20r, h21r, h22r, h23r,
                				h24r, version',
                    'where' => 'fecha BETWEEN ? AND ?',
                    'param' => array(
                                $this->fecha_ini,
                                $this->fecha_fin),
                    'asc' => 'fecha'));

        Doo::session()->matrix_rea = $data['matrix'];

        $this->view()->render('rea', $data);
    }

    public function pen() {

        // TODO: excedente reactiva function

        self::params();

        $data['id_cliente'] = $this->id_cliente;
        $data['fecha_ini'] = $this->fecha_ini;
        $data['fecha_fin'] = $this->fecha_fin;

        $enrgy = new M03Energia();
        $enrgy->m02cli_id_cliente = $this->id_cliente;

        $data['matrix'] = Doo::db()->find($enrgy,
                    array(
                    'select' => 'fecha, h01a, h02a, h03a, h04a, h05a, h06a, h07a,
                    			h08a, h09a, h10a, h11a, h12a, h13a, h14a, h15a,
                				h16a, h17a, h18a, h19a, h20a, h21a, h22a, h23a,
                				h24a, version',
                    'where' => 'fecha BETWEEN ? AND ?',
                    'param' => array(
                                $this->fecha_ini,
                                $this->fecha_fin),
                    'asc' => 'fecha'));

        Doo::session()->matrix_pen = $data['matrix'];

        $this->view()->render('pen', $data);
    }

    public function fpo() {

        // TODO: factor potencia function

        self::params();

        $data['id_cliente'] = $this->id_cliente;
        $data['fecha_ini'] = $this->fecha_ini;
        $data['fecha_fin'] = $this->fecha_fin;

        $enrgy = new M03Energia();
        $enrgy->m02cli_id_cliente = $this->id_cliente;

        $data['matrix'] = Doo::db()->find($enrgy,
                    array(
                    'select' => 'fecha, h01a, h02a, h03a, h04a, h05a, h06a, h07a,
                    			h08a, h09a, h10a, h11a, h12a, h13a, h14a, h15a,
                				h16a, h17a, h18a, h19a, h20a, h21a, h22a, h23a,
                				h24a, version',
                    'where' => 'fecha BETWEEN ? AND ?',
                    'param' => array(
                                $this->fecha_ini,
                                $this->fecha_fin),
                    'asc' => 'fecha'));

        Doo::session()->matrix_fpo = $data['matrix'];

        $this->view()->render('fpo', $data);
    }
}
