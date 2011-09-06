<?php

class FrontController extends DooController {

    public function index() {

        if (Doo::session()->isStarted()) {

            $usr = Doo::session()->get('usr');

            if (is_object($usr) && ($usr instanceof M00Usuarios)) {

                $cte = Doo::session()->get('cte');

                if (is_object($cte) && $cte instanceof M02Clientes) {
                    $data['nit_cedula'] = substr($cte->nit_cedula, 0, 9);
                    $data['id_interno'] = $cte->id_interno;
                }
                $data['usrtype'] = Doo::session()->get('usrtype');
                $data['baseurl'] = Doo::conf()->APP_URL;

                //echo '<pre>'.json_encode(Doo::session()->getAll()).'</pre>';

                $this->view()->render('ppal', $data);

            } else {
                return array(Doo::conf()->APP_URL . 'login', 303);
            }
        } else {
            return array(Doo::conf()->APP_URL . 'login/wrong/201', 303);
        }
    }

    public function keepalive() {
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
