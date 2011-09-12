<?php

class M00CteXUsr extends DooSmartModel {

    public $id_cliente;
    public $id_usuario;

    public $_table = 'm00_cte_x_usr';
    public $_primarykey = '';

    public $_fields = array('id_cliente','id_usuario');

    public function  __construct() {
        parent::setupModel(__CLASS__);
    }
}
