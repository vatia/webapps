<?php

class M02GruposCliente extends DooSmartModel {

    public $id;
    public $grupo_cliente;

    public $_table = 'm02_grupos_cliente';
    public $_primarykey = 'id';

    public $_fields = array('id', 'grupo_cliente');

    public function  __construct() {
        parent::setupModel(__CLASS__);
    }
}
