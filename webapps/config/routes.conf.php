<?php

$route['force_lowercase'] = true;

$route['*']['/'] =  array('FrontController', 'index');
$route['*']['/error'] = array('ErrorController', 'index');
$route['*']['/error/:exception'] = array('ErrorController', 'exception');

$route['*']['/keepalive'] =  array('FrontController', 'keepalive');

$route['get']['/login'] = array('LoginController', 'index');
$route['post']['/login'] = array('LoginController', 'login');

$route['*']['/session/expired'] =  array('LoginController', 'index');
$route['*']['/login/wrong/:code'] = array('LoginController', 'wrong');

$route['*']['/login/change-passwd'] = array('PasswdController', 'change');
$route['*']['/login/lost-passwd'] = array('PasswdController', 'lost');

$route['*']['/signup'] = array('LoginController', 'signup');

$route['*']['/logout'] = array('LoginController', 'logout');



/* Matrix Csmo */

$route['*']['/matrix-csmo'] = array('[matrixcsmo]FrontController', 'index');

$route['*']['/matrix-csmo/:id_cliente'] =
    array('[matrixcsmo]FrontController', 'client',
        'match' => array('id_cliente' => '/[0-9]+/'));

$route['*']['/matrix-csmo/corp/:id_grupo'] =
    array('[matrixcsmo]FrontController', 'corp',
        'match' => array('id_grupo' => '/[0-9]+/'));

$route['*']['/matrix-csmo/act'] = $route['*']['/matrix-csmo/rea'] =
    $route['*']['/matrix-csmo/pen'] = $route['*']['/matrix-csmo/fpo'] =
        $route['*']['/error'];

$route['*']['/matrix-csmo/act/:id_cliente/:fecha_ini/:fecha_fin'] =
    array('[matrixcsmo]MatrixCsmoController', 'act',
        'match' => array('id_cliente' => '/[0-9]+/'));

$route['*']['/matrix-csmo/rea/:id_cliente/:fecha_ini/:fecha_fin'] =
    array('[matrixcsmo]MatrixCsmoController', 'rea',
        'match' => array('id_cliente' => '/[0-9]+/'));

$route['*']['/matrix-csmo/pen/:id_cliente/:fecha_ini/:fecha_fin'] =
    array('[matrixcsmo]MatrixCsmoController', 'pen',
        'match' => array('id_cliente' => '/[0-9]+/'));

$route['*']['/matrix-csmo/fpo/:id_cliente/:fecha_ini/:fecha_fin'] =
    array('[matrixcsmo]MatrixCsmoController', 'fpo',
        'match' => array('id_cliente' => '/[0-9]+/'));

$route['*']['/matrix-csmo/graph/:tipo_csmo/:id_cliente/:fecha_ini/:fecha_fin'] =
    array('[matrixcsmo]ChartController', 'graph',
        'match' => array('id_cliente' => '/[0-9]+/'));

$route['*']['/matrix-csmo/excel/:id/:fecha_ini/:fecha_fin/:csmotypes'] =
    array('[matrixcsmo]ReportController', 'excel');


/* Csmo Hist */

$route['*']['/csmo-hist'] = array('[csmohist]FrontController', 'index');

$route['*']['/csmo-hist/:id_cliente'] =
    array('[csmohist]FrontController', 'client',
        'match' => array('id_cliente' => '/[0-9]+/'));

$route['*']['/csmo-hist/corp/:id_grupo'] =
    array('[csmohist]FrontController', 'corp',
        'match' => array('id_grupo' => '/[0-9]+/'));

$route['*']['/csmo-hist/last/:id_cliente/:ciclo_ini/:ciclo_fin'] =
    array('[csmohist]CsmoHistController', 'last',
        'match' => array('id_cliente' => '/[0-9]+/'));

$route['*']['/csmo-hist/curr/:id_cliente'] =
    array('[csmohist]CsmoHistController', 'curr',
        'match' => array('id_cliente' => '/[0-9]+/'));

$route['*']['/csmo-hist/avg/:id_cliente'] =
    array('[csmohist]CsmoHistController', 'avg',
        'match' => array('id_cliente' => '/[0-9]+/'));

$route['*']['/csmo-hist/graph/:id_cliente/:ciclo_ini/:ciclo_fin'] =
    array('[csmohist]ChartController', 'graph',
        'match' => array('id_cliente' => '/[0-9]+/'));

$route['*']['/csmo-hist/excel/:id/:fecha_ini/:fecha_fin'] =
    array('[matrixcsmo]ReportController', 'excel');

