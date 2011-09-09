<?php

class CsmoHistController extends DooController {

    public function last() {

    	Doo::loadModel('M02Clientes');
    	Doo::loadModel('M05Facturas');

        Doo::logger()->beginDbProfile('find_cte', 'csmo_rpt');
        $cte = self::db()->find('M02Clientes', array(
        	'where' => 'id_cliente = ?',
        	'param' => array($this->params['id_cliente']),
        	'limit' => 1));
        Doo::logger()->endDbProfile('find_cte');

        if (is_object($cte) && ($cte instanceof M02Clientes)) {

        	Doo::logger()->beginDbProfile('find_fact', 'csmo_hist');
	        $facturas = self::db()->relate('M05Facturas', 'M02Clientes',
	        	array(
	        	'where' => 'm02_clientes.id_cliente = ? ' .
	        	           'AND m05_facturas.factura_tipo_id <> ? '.
	        	           'AND (m05_facturas.ciclo BETWEEN ? AND ?)',
	        	'param' => array($cte->id_cliente, 303,
	        		$this->params['ciclo_ini'], $this->params['ciclo_fin']),
        		'asc' => 'm05_facturas.ciclo'));
	        Doo::logger()->endDbProfile('find_fact');
        }

        if (is_array($facturas) && (count($facturas) > 0)) {
            $data['facturas'] = $facturas;
        } else {
        	$data['facturas'] = array();
        }
        self::view()->render('lastcsmo', $data);
    }

    public function curr() {
        $data['factura'] = self::bill($this->params['id_cliente']);
        self::view()->render('currcsmo', $data);
    }

    public function avg() {
        $data['factura'] = self::bill($this->params['id_cliente']);
        self::view()->render('csmoavg', $data);
    }

    private function bill($id_cliente) {

    	Doo::loadModel('M02Clientes');
    	Doo::loadModel('M05Facturas');

        Doo::logger()->beginDbProfile('find_cte', 'csmo_rpt');
        $cte = self::db()->find('M02Clientes', array(
        	'where' => 'id_cliente = ?',
        	'param' => array($this->params['id_cliente']),
        	'limit' => 1));
        Doo::logger()->endDbProfile('find_cte');

        $factura = new M05Facturas();
        if (is_object($cte) && ($cte instanceof M02Clientes)) {

        	Doo::logger()->beginDbProfile('find_fact', 'csmo_hist');
	        $facturas = self::db()->relate('M05Facturas', 'M02Clientes',
	        	array(
	        	'where' => 'm02_clientes.id_cliente = ? ' .
	        	           'AND m05_facturas.factura_tipo_id <> ?',
	        	'param' => array($cte->id_cliente, 303),
        		'asc' => 'm05_facturas.ciclo'));
	        Doo::logger()->endDbProfile('find_fact');

	        if (is_array($facturas) && (count($facturas) > 0)) {
	        	return $facturas[count($facturas)-1];
	        }
        }
        return $factura;
    }
}
