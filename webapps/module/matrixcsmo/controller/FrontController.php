<?php

class FrontController extends DooController {

    public function index() {

        if (Doo::session()->isStarted()) {

            Doo::session()->module = 'matrix-csmo';

            $usr = Doo::session()->get('usr');

            if (is_object($usr) && ($usr instanceof M00Usuarios)) {

                $data['sess_id'] = Doo::session()->getId();
                $data['baseurl'] = Doo::conf()->APP_URL;

                // TODO: rango fechas inicial
                $data['fecha_ini'] = '2011-08-02';
                $data['fecha_fin'] = '2011-09-01';

                $data['graph'] = 'global/img/graph-bar.png';

                $data['usrtype'] = Doo::session()->get('usrtype');

                if ($data['usrtype'] == 'corp') {
                    $data['clientes'] = Doo::session()->get('clientes');
                    //Doo::session()->cte = $data['clientes'][0];
                } else {
                	$data['clientes'] = null;
                }
                $data['id_cliente'] = Doo::session()->get('cte')->id_cliente;

                //echo '<pre>'.json_encode(Doo::session()->getAll()).'</pre>';

                $this->view()->render('mtxcsmo', $data);

            } else {
                return array(Doo::conf()->APP_URL . 'login', 303);
            }
        } else {
            return array(Doo::conf()->APP_URL . 'login/wrong/201', 303);
        }
    }
}
