<?php

class LoginController extends DooController {

    public function index() {

        if (Doo::session()->isStarted()) {
            $objUsr = Doo::session()->get('usr');
            if (is_object($objUsr) && ($objUsr instanceof M00Usuarios)) {
                return array(Doo::conf()->APP_URL, 303);
            } else {
                $data['msg'] = '';
                $data['baseurl'] = Doo::conf()->APP_URL;
                $this->view()->render('login', $data);
            }
        } else {
            return array(Doo::conf()->APP_URL . 'login/wrong/201', 303);
        }
    }

    public function login() {

        $params = array(
            'where' => '(login = ? OR email = ?) AND passwd = md5(?)',
            'param' => array($_REQUEST['username'], $_REQUEST['username'],
                $_REQUEST['passwd']),
            'limit' => 1);

        $objUsr = $this->db()->find('M00Usuarios', $params);

        if (is_object($objUsr) && ($objUsr instanceof M00Usuarios)) {

            Doo::session()->usr = $objUsr;
            Doo::session()->usrtype = $_REQUEST['usertype'];

            switch ($_REQUEST['usertype']) {

                case 'asoc':
                case 'front':

                    $objCte = $this->db()->find('M02Clientes',
                        array(
                            'where' => 'id_cliente = ?',
                            'param' => array($_REQUEST['id']),
                        	'limit' => 1));

                    if (is_object($objCte) && ($objCte instanceof M02Clientes)) {

                        $clientes = $objCte->relateM00Usuarios(
                            array(
                                'where' => 'm00_cte_x_usr.id_usuario = ?',
                                'param' => array($objUsr->id_usuario)
                            ));

                        if (is_array($clientes) && count($clientes) > 0) {

                            foreach ($clientes as $cte) {

                                if ($cte->id_cliente == $objCte->id_cliente) {

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

                                    Doo::session()->cte = $objCte;

                                    break;
                                }
                            }
                        } else {
                            return array(Doo::conf()->APP_URL .
                            	'login/wrong/104', 303);
                        }
                    } else {
                        return array(Doo::conf()->APP_URL .
                        	'login/wrong/102', 303);
                    }

                    break;

                case 'corp':

                    $exists = false;
                    $objGrp = new M02GruposCliente();
                    $objGrp->id = $_REQUEST['id'];
                    $objGrp = $this->db()->find($objGrp, array('limit' => 1));

                    if (is_object($objGrp) && ($objGrp instanceof M02GruposCliente)) {

                        $grupos = $objGrp->relateM00Usuarios(
                            array(
                                'where' => 'm00_grp_x_usr.id_usuario = ?',
                                'param' => array($objUsr->id_usuario)
                            ));

                        if (is_array($grupos) && (count($grupos) > 0)) {

                            foreach ($grupos as $grp) {

                                if ($grp->id === $objGrp->id) {

                                    Doo::session()->grp = $objGrp;
                                    Doo::session()->id_grupo = $objGrp->id;

                                    $objCte = new M02Clientes();
                                    $clientes = $objCte->relateM02GruposCliente(
                                        array(
                                            'where' => 'm02gcli_id = ?',
                                            'param' => array($objGrp->id)
                                        ));

                                    if (is_array($clientes) && (count($clientes) > 0)) {
                                        Doo::session()->cte = $clientes[0];
                                    }
                                    $exists = true;
                                    break;
                                }
                            }
                        }
                        if (!$exists) {
                            return array(Doo::conf()->APP_URL .
                            	'login/wrong/105', 303);
                        }
                    } else {
                        return array(Doo::conf()->APP_URL .
                        	'login/wrong/103', 303);
                    }

                    break;

                case 'cial':

                    $cte = new M02Clientes();
                    $cte->id_cliente = 1003699;
                    $cte = $this->db()->find($cte, array('limit' => 1));

                    if (is_object($cte) && ($cte instanceof M02Clientes)) {
                        Doo::session()->cte = $cte;
                        Doo::session()->id_cliente = $cte->id_cliente;
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
                $data['msg'] = 'ERROR-106 - Id cliente no corresponde al tipo de usuario elegido';
                break;
            case 201:
                $data['msg'] = 'WARNING-201 - Sesion expirada por inactividad';
                break;
            default:
                throw new LoginErrorCodeException('Codigo de error desconocido');
        }

        $data['baseurl'] = Doo::conf()->APP_URL;
        $this->view()->render('login', $data);
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

