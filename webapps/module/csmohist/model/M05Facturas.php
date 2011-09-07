<?php

class M05Facturas extends DooSmartModel {

    public $cliente_id;
    public $factura;
    public $ciclo;
    public $csm_act;
    public $csm_rea;
    public $csm_act_promedio;
    public $csm_rea_promedio;

    public $_table = 'm05_facturas';
    public $_primarykey = 'factura';

    public $_fields = array('cliente_id', 'factura', 'ciclo',
    	'csm_act', 'csm_rea', 'csm_act_promedio', 'csm_rea_promedio');

    public function  __construct() {
        parent::setupModel(__CLASS__);
    }
}
