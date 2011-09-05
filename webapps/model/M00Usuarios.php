<?php

class M00Usuarios extends DooSmartModel {

    public $id_usuario;
    public $email;
    public $login;
    public $passwd;

    public $_table = 'm00_usuarios';
    public $_primarykey = 'id_usuario';

    public $_fields = array('id_usuario', 'email', 'login', 'passwd');

    public function  __construct() {
        parent::setupModel(__CLASS__);
    }
}
