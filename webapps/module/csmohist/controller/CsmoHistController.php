<?php

class CsmoHistController extends DooController {

    public function last() {

        $fact = new M05Facturas();
        $fact->cliente_id = $this->params['id_cliente'];

        $facturas = $this->db()->find($fact, array('asc' => 'ciclo'));

        $data['facturas'] = array();

        if (is_array($facturas) && (count($facturas) > 0)) {

            foreach ($facturas as $fact) {

                if ((intval($fact->ciclo) >= intval($this->params['ciclo_ini'])) &&
                    (intval($fact->ciclo) <= intval($this->params['ciclo_fin']))) {

                    array_push($data['facturas'], $fact);
                }
            }
        }
        $this->view()->render('lastcsmo', $data);
    }

    public function curr() {

        $data['factura'] = self::bill($this->params['id_cliente']);

        $this->view()->render('currcsmo', $data);
    }

    public function avg() {

        $data['factura'] = self::bill($this->params['id_cliente']);

        $this->view()->render('csmoavg', $data);
    }

    private function bill($id_cliente) {

        $fact = new M05Facturas();
        $fact->cliente_id = $id_cliente;

        $facturas = $this->db()->find($fact);

        $max_ciclo = 0;

        $factura = new M05Facturas();

        if (is_array($facturas) && (count($facturas) > 0)) {

            foreach ($facturas as $fact) {

                if ($fact->ciclo > $max_ciclo) {

                    $max_ciclo = $fact->ciclo;
                    $factura = $fact;
                }
            }
        }
        return $factura;
    }
}
