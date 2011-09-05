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
                $data['fecha_ini'] = '2011-07-02';
                $data['fecha_fin'] = '2011-08-01';

                $data['graph'] = 'global/img/graph-bar.png';

                $data['usrtype'] = Doo::session()->get('usrtype');

                if ($data['usrtype'] == 'corp') {

                    $data['id_grupo'] = Doo::session()->get('id_grupo');

                    $cte = new M02Clientes();
                    $cte->m02gcli_id = $data['id_grupo'];

                    $data['clientes'] = $this->db()->find($cte,
                        array('asc' => 'id_cliente'));

                    /*foreach ($clientes as $cte) {
                        if ($cte->m02gcli_id === $data['id_grupo']) {
                            array_push($data['clientes'], $cte);
                        }
                    }*/
                    if (is_array($data['clientes'])) {

                        Doo::session()->cte = $data['clientes'][0];

                        Doo::session()->id_cliente =
                            $data['clientes'][0]->id_cliente;
                    }
                }
                $data['id_cliente'] = Doo::session()->get('id_cliente');

                $this->view()->render('mtxcsmo', $data);

            } else {
                return array(Doo::conf()->APP_URL . 'login', 303);
            }
        } else {
            return array(Doo::conf()->APP_URL . 'login/wrong/201', 303);
        }
    }
}
