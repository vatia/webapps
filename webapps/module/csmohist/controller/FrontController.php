<?php

class FrontController extends DooController {

    public function index() {

    	Doo::loadModel('M00Usuarios');
    	Doo::loadModel('M02Clientes');
    	Doo::loadModel('M02GruposCliente');

        if (Doo::session()->isStarted()) {
            Doo::session()->module = 'csmo-hist';
            $usr = Doo::session()->get('usr');
            if (is_object($usr) && ($usr instanceof M00Usuarios)) {

                $data['sess_id'] = Doo::session()->getId();
                $data['baseurl'] = Doo::conf()->APP_URL;

                // TODO: rango ciclos inicial
                $data['ciclo_ini'] = '201107';
                $data['ciclo_fin'] = '201108';

                // TODO: rango ciclos min/max
                $data['ciclo_ini_min'] = '201101';
                $data['ciclo_fin_max'] = '201108';

                $data['graph'] = 'global/img/graph-line.png';

                $data['usrtype'] = Doo::session()->get('usrtype');

                $cte = Doo::session()->get('cte');
                if (is_object($cte) && ($cte instanceof M02Clientes)) {
                	$data['id_cliente'] = $cte->id_cliente;
                } else {
                	$data['id_cliente'] = null;
                }

                $data['clientes'] = array();
            	if ($data['usrtype'] == 'corp') {
            		$grp = Doo::session()->get('grp');
            		if (is_object($grp) && ($grp instanceof M02GruposCliente)) {
            			$data['id_grupo'] = $grp->id;
            		} else {
            			$data['id_grupo'] = null;
            		}
            		$clientes = Doo::session()->get('clientes');
            		if (is_array($clientes) && count($clientes) > 0) {
                    	$data['clientes'] = $clientes;
            		}
                }
                self::view()->render('csmohist', $data);

            } else {
                return array(Doo::conf()->APP_URL . 'login', 303);
            }
        } else {
            return array(Doo::conf()->APP_URL . 'login/wrong/201', 303);
        }
    }
}
