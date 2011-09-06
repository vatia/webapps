<?php

$dbconfig['dev'] = array('192.168.200.54', 'mithra', 'jalvarez', 'v4t14dba',
	'mysql', true, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8');

$dbconfig['prod'] = array('192.168.0.158', 'mithra', 'mithra', 'atenas',
	'mysql', true, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8');

// belongs_to, should_belong_to, has_many, can_have_many, should_have_many

$dbmap['M02Clientes']['has_many']['M00Usuarios'] = array(
	'foreign_key' => 'id_cliente',
		'through' => 'm00_cte_x_usr');

$dbmap['M00Usuarios']['has_many']['M02Clientes'] = array(
	'foreign_key' => 'id_usuario',
		'through' => 'm00_cte_x_usr');

$dbmap['M02GruposCliente']['has_many']['M00Usuarios'] = array(
	'foreign_key' => 'id_grupo',
		'through' => 'm00_grp_x_usr');

$dbmap['M00Usuarios']['has_many']['M02GruposCliente'] = array(
	'foreign_key' => 'id_usuario',
		'through' => 'm00_grp_x_usr');

$dbmap['M02Clientes']['belongs_to']['M02GruposCliente'] = array('foreign_key' => 'id');

$dbmap['M02GruposCliente']['has_many']['M02Clientes'] = array('foreign_key' => 'm02gcli_id');

$dbmap['M02Clientes']['has_many']['M03Energia'] = array('foreign_key' => 'm02cli_id_cliente');
$dbmap['M03Energia']['belongs_to']['M02Clientes'] = array('foreign_key'=> 'id_cliente');

$dbmap['M02Clientes']['has_many']['M05Facturas'] = array('foreign_key' => 'cliente_id');
$dbmap['M05Facturas']['belongs_to']['M02Clientes'] = array('foreign_key'=> 'id_cliente');
