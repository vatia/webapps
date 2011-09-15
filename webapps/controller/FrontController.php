<?php

class FrontController extends DooController {

    public function index() {
        Doo::loadModel('M00Usuarios');
        Doo::loadModel('M02Clientes');
        Doo::loadModel('M02GruposCliente');
        if (Doo::session()->isStarted()) {
            $usr = Doo::session()->get('usr');
            if (is_object($usr) && ($usr instanceof M00Usuarios)) {
                $cte = Doo::session()->get('cte');
                if (is_object($cte) && ($cte instanceof M02Clientes)) {
                    $data['nit_cedula'] = substr($cte->nit_cedula, 0, 9);
                    $data['id_grupo'] = $cte->m02gcli_id;
                    $data['id_interno'] = $cte->id_interno;
                    $data['usrname'] = $cte->nombre_facturacion;
                } else {
                	$data['nit_cedula'] = $data['id_grupo'] =
                		$data['id_interno'] = $data['usrname'] = null;
                }
                $usrtype = Doo::session()->get('usrtype');
                if ($usrtype === 'corp') {
              		$grp = Doo::session()->get('grp');
               		if (is_object($grp) && ($grp instanceof M02GruposCliente)) {
               			$data['id_grupo'] = $grp->id;
               			$data['usrname'] = $grp->grupo_cliente;
               		}
                }
                $data['usrtype'] = Doo::session()->get('usrtype');
                $data['baseurl'] = Doo::conf()->APP_URL;
                self::view()->render('ppal', $data, true, true);
            } else {
                return array(Doo::conf()->APP_URL . 'login', 303);
            }
        } else {
            return array(Doo::conf()->APP_URL . 'login/wrong/201', 303);
        }
    }

    public function keepalive() {
    	Doo::loadModel('M00Usuarios');
        if (Doo::session()->isStarted()) {
            $usr = Doo::session()->get('usr');
            if (is_object($usr) && ($usr instanceof M00Usuarios)) {
                $this->toJSON(array('signin' => true), true);
            } else {
                $this->toJSON(array('signin' => false), true);
            }
        }
    }
}
