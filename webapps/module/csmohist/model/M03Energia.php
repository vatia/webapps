<?php

class M03Energia extends DooSmartModel {

    public $m02cli_id_cliente;
    public $fecha;
    public $h01a;
    public $h02a;
    public $h03a;
    public $h04a;
    public $h05a;
    public $h06a;
    public $h07a;
    public $h08a;
    public $h09a;
    public $h10a;
    public $h11a;
    public $h12a;
    public $h13a;
    public $h14a;
    public $h15a;
    public $h16a;
    public $h17a;
    public $h18a;
    public $h19a;
    public $h20a;
    public $h21a;
    public $h22a;
    public $h23a;
    public $h24a;
    public $h01r;
    public $h02r;
    public $h03r;
    public $h04r;
    public $h05r;
    public $h06r;
    public $h07r;
    public $h08r;
    public $h09r;
    public $h10r;
    public $h11r;
    public $h12r;
    public $h13r;
    public $h14r;
    public $h15r;
    public $h16r;
    public $h17r;
    public $h18r;
    public $h19r;
    public $h20r;
    public $h21r;
    public $h22r;
    public $h23r;
    public $h24r;

    public $_table = 'm03_energia';
    public $_primarykey = '';

    public $_fields = array('m02cli_id_cliente', 'fecha',
    	'h01a', 'h02a', 'h03a', 'h04a', 'h05a', 'h06a', 'h07a', 'h08a',
    	'h09a', 'h10a', 'h11a', 'h12a', 'h13a', 'h14a', 'h15a', 'h16a',
    	'h17a', 'h18a', 'h19a', 'h20a', 'h21a', 'h22a', 'h23a', 'h24a',
    	'h01r', 'h02r', 'h03r', 'h04r', 'h05r', 'h06r', 'h07r', 'h08r',
    	'h09r', 'h10r', 'h11r', 'h12r', 'h13r', 'h14r', 'h15r', 'h16r',
    	'h17r', 'h18r', 'h19r', 'h20r', 'h21r', 'h22r', 'h23r', 'h24r');

    public function  __construct() {
        parent::setupModel(__CLASS__);
    }
}
