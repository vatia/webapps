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
                $data['ciclo_ini'] = '201104';
                $data['ciclo_fin'] = '201106';

                $data['graph'] = 'global/img/graph-line.png';

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

                $this->view()->render('csmohist', $data);

            } else {
                return array(Doo::conf()->APP_URL . 'login', 303);
            }
        } else {
            return array(Doo::conf()->APP_URL . 'login/wrong/201', 303);
        }
    }
}
