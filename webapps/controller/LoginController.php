<?php

class LoginController extends DooController {

    public function index() {

    	Doo::loadModel('M00Usuarios');

        if (Doo::session()->isStarted()) {
            $objUsr = Doo::session()->get('usr');
            if (is_object($objUsr) && ($objUsr instanceof M00Usuarios)) {
                return array(Doo::conf()->APP_URL, 303);
            } else {
                $data['msg'] = null;
                $data['baseurl'] = Doo::conf()->APP_URL;
                self::view()->render('login', $data);
            }
        } else {
            return array(Doo::conf()->APP_URL . 'login/wrong/201', 303);
        }
    }

    public function login() {

    	Doo::loadModel('M00Usuarios');
    	Doo::loadModel('M02Clientes');
    	Doo::loadModel('M02GruposCliente');

    	Doo::logger()->beginDbProfile('find_usr', 'login');
        $objUsr = self::db()->find('M00Usuarios', array(
        	'where' => '(login = ? OR email = ?) AND passwd = md5(?)',
            'param' => array(
        				$_REQUEST['username'],
        				$_REQUEST['username'],
        				$_REQUEST['passwd']),
        	'limit' => 1));
        Doo::logger()->endDbProfile('find_usr');

        if (is_object($objUsr) && ($objUsr instanceof M00Usuarios)) {

            Doo::session()->usr = $objUsr;
            Doo::session()->usrtype = $_REQUEST['usertype'];

            $isValid = false;

            switch ($_REQUEST['usertype']) {

                case 'asoc':
                case 'front':

                	Doo::logger()->beginDbProfile('find_cte', 'login_asoc_front');
                    $objCte = self::db()->find('M02Clientes', array(
                    	'where' => 'id_cliente = ?',
                    	'param' => array($_REQUEST['id']),
                    	'limit' => 1));
                    Doo::logger()->endDbProfile('find_cte');

                    if (is_object($objCte) && ($objCte instanceof M02Clientes)) {

                        Doo::session()->cte = $objCte;

                    	Doo::logger()->beginDbProfile(
                    		'find_cte_x_usr', 'login_asoc_front');

                        $clientes = self::db()->relate('M02Clientes', 'M00Usuarios',
                            array('where' => 'm00_cte_x_usr.id_usuario = ?',
                                'param' => array($objUsr->id_usuario),
                            		'match' => true));

                        Doo::logger()->endDbProfile('find_cte_x_usr');

                        if (is_array($clientes) && count($clientes) > 0) {

                            foreach ($clientes as $cte) {

                                if ($cte->id_cliente === $objCte->id_cliente) {

                                	$isValid = true;

                                    switch ($objCte->m02tcl_id_tipo_cliente) {
                                        case 1:
                                            if ($_REQUEST['usertype'] != 'front') {
                                                return array(Doo::conf()->APP_URL .
                                                	'login/wrong/106', 303);
                                            }
                                        break;
                                        case 2:
                                            if ($_REQUEST['usertype'] != 'asoc') {
                                                return array(Doo::conf()->APP_URL .
                                                	'login/wrong/106', 303);
                                            }
                                        break;
                                        default:
                                            throw new LoginUserTypeException(
                                            	'Tipo de usuario no valido');
                                    }
                                    break;
                                }
                            }
                        }
                        if (!$isValid) {
                            return array(Doo::conf()->APP_URL .
                            	'login/wrong/104', 303);
                        }
                    } else {
                        return array(Doo::conf()->APP_URL .
                        	'login/wrong/102', 303);
                    }
                    break;

                case 'corp':

                	Doo::logger()->beginDbProfile('find_grp', 'login_corp');
                    $objGrp = self::db()->find('M02GruposCliente', array(
                    	'where' => 'id = ?',
                    	'param' => array($_REQUEST['id']),
                    	'limit' => 1));
                    Doo::logger()->endDbProfile('find_grp');

                    if (is_object($objGrp) && ($objGrp instanceof M02GruposCliente)) {

                    	Doo::session()->grp = $objGrp;

                    	Doo::logger()->beginDbProfile('find_grp_x_usr', 'login_corp');
                        $grupos = self::db()->relate('M02GruposCliente', 'M00Usuarios',
                            array('where' => 'm00_usuarios.id_usuario = ?',
                                'param' => array($objUsr->id_usuario),
                            		'match' => true));
                        Doo::logger()->endDbProfile('find_grp_x_usr');

                        if (is_array($grupos) && (count($grupos) > 0)) {

                            foreach ($grupos as $grp) {

                                if ($grp->id === $objGrp->id) {

                                	$isValid = true;

                                    Doo::logger()->beginDbProfile(
                                    	'find_cte_x_grp', 'login_corp');
                                    $clientes = self::db()->
                                    	relate('M02Clientes', 'M02GruposCliente',
                                    	array('where' => 'm02_clientes.m02gcli_id = ?',
                                            'param' => array($objGrp->id),
                                    			'asc' => 'id_cliente'));
                                    Doo::logger()->endDbProfile('find_cte_x_grp');

                                    if (is_array($clientes) && (count($clientes) > 0)) {
                                        Doo::session()->clientes = $clientes;
                                        Doo::session()->cte = $clientes[0];
                                    }
                                    break;
                                }
                            }
                        }
                        if (!$isValid) {
                            return array(Doo::conf()->APP_URL .
                            	'login/wrong/105', 303);
                        }
                    } else {
                        return array(Doo::conf()->APP_URL .
                        	'login/wrong/103', 303);
                    }
                    break;

                case 'cial':

                	Doo::logger()->beginDbProfile('find_cte_vtia', 'login_cial');
                    $objCte = self::db()->find('M02Clientes',
                    	array('where' => 'id_cliente = ?',
                    		'param' => array('1003699'), 'limit' => 1));
                   	Doo::logger()->endDbProfile('find_cte_vtia');

                    if (is_object($objCte) && ($objCte instanceof M02Clientes)) {

                    	Doo::session()->cte = $objCte;

                    	Doo::logger()->beginDbProfile(
                    		'find_cte_x_usr', 'login_cial');

                        $clientes = self::db()->relate('M02Clientes', 'M00Usuarios',
                            array('where' => 'm00_cte_x_usr.id_usuario = ?',
                                'param' => array($objUsr->id_usuario),
                            		'match' => true));

                        Doo::logger()->endDbProfile('find_cte_x_usr');

                        $isValid = false;
                        if (is_array($clientes) && count($clientes) > 0) {
                            foreach ($clientes as $cte) {
                                if ($cte->id_cliente === $objCte->id_cliente) {
                                	$isValid = true;
                                }
                            }
                        }
                        if (!$isValid) {
                            return array(Doo::conf()->APP_URL .
                            	'login/wrong/104', 303);
                        }

                    } else {
                        return array(Doo::conf()->APP_URL .
                        	'login/wrong/102', 303);
                    }
                    break;

                default:
                    throw new LoginUserTypeException('Tipo de usuario no valido');
            }
            return array(Doo::conf()->APP_URL, 303);

        } else {
            return array(Doo::conf()->APP_URL . 'login/wrong/101', 303);
        }
    }

    public function wrong() {

        if (!Doo::session()->isDestroyed()) {
            Doo::session()->destroy();
            Doo::session()->stop();
        }

        switch ($this->params['code']) {
            case 101:
                $data['msg'] = 'ERROR-101 - Nombre de usuario, email o clave incorrecto';
                break;
            case 102:
                $data['msg'] = 'ERROR-102 - Id cliente incorrecto o no existe';
                break;
            case 103:
                $data['msg'] = 'ERROR-103 - Codigo corporativo incorrecto o no existe';
                break;
            case 104:
                $data['msg'] = 'ERROR-104 - Usuario no pertenece a este cliente';
                break;
            case 105:
                $data['msg'] = 'ERROR-105 - Usuario no pertenece a este corporativo';
                break;
            case 106:
                $data['msg'] = 'ERROR-106 - Id cliente no corresponde al tipo de usuario';
                break;
            case 201:
                $data['msg'] = 'WARNING-201 - Sesion expirada por inactividad';
                break;
            default:
                throw new LoginErrorCodeException('Codigo de error desconocido');
        }

        $data['baseurl'] = Doo::conf()->APP_URL;
        self::view()->render('login', $data);
    }

    public function expired() {
        if (!Doo::session()->isDestroyed()) {
            Doo::session()->destroy();
            Doo::session()->stop();
        }
        $data['msg'] = 'WARNING-201 - Sesion expirada por inactividad';
    	$data['baseurl'] = Doo::conf()->APP_URL;
        self::view()->render('login', $data);
    }

    public function logout() {

        foreach (glob(Doo::conf()->SITE_PATH . 'temp/' .
            Doo::session()->getId() . '*', GLOB_ONLYDIR) as $filename) {
            if (is_file($filename)) {
                unlink($filename);
            }
        }

        if (!Doo::session()->isDestroyed()) {
            Doo::session()->destroy();
            Doo::session()->stop();
        }

        return array(Doo::conf()->APP_URL . 'login', 303);
    }
}

class LoginErrorCodeException extends Exception { }

class LoginUserTypeException extends Exception { }
