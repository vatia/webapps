<?php

class M00GrpXUsr extends DooSmartModel {

    public $id_usuario;
    public $id_grupo;

    public $_table = 'm00_grp_x_usr';
    public $_primarykey = '';

    public $_fields = array('id_usuario','id_grupo');

    public function  __construct() {
        parent::setupModel(__CLASS__);
    }
}
