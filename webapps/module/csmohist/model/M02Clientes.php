<?php

class M02Clientes extends DooSmartModel {

    public $id_cliente;
    public $nit_cedula;
    public $codigo_sic;
    public $nombre_facturacion;
    public $m02tcl_id_tipo_cliente;
    public $m02gcli_id;
    public $id_interno;

    public $_table = 'm02_clientes';
    public $_primarykey = 'id_cliente';

    public $_fields = array(
    	'id_cliente', 'nit_cedula', 'codigo_sic', 'nombre_facturacion',
    		'm02tcl_id_tipo_cliente', 'm02gcli_id', 'id_interno');

    public function  __construct() {
        parent::setupModel(__CLASS__);
    }
}
