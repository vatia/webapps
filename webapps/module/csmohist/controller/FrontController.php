<?php

class FrontController extends DooController {

    public function index() {

        if (Doo::session()->isStarted()) {

            Doo::session()->module = 'csmo-hist';

            $usr = Doo::session()->get('usr');

            if (is_object($usr) && ($usr instanceof M00Usuarios)) {

                $data['sess_id'] = Doo::session()->getId();
                $data['baseurl'] = Doo::conf()->APP_URL;

                // TODO: rango ciclos inicial
                $data['ciclo_ini'] = '201101';
                $data['ciclo_fin'] = '201108';

                $data['graph'] = 'global/img/graph-line.png';

                $data['usrtype'] = Doo::session()->get('usrtype');

            	if ($data['usrtype'] == 'corp') {
                    $data['clientes'] = Doo::session()->get('clientes');
                    //Doo::session()->cte = $data['clientes'][0];
                } else {
                	$data['clientes'] = null;
                }
                $data['id_cliente'] = Doo::session()->get('cte')->id_cliente;

                //echo '<pre>'.json_encode(Doo::session()->getAll()).'</pre>';

                $this->view()->render('csmohist', $data);

            } else {
                return array(Doo::conf()->APP_URL . 'login', 303);
            }
        } else {
            return array(Doo::conf()->APP_URL . 'login/wrong/201', 303);
        }
    }
}
