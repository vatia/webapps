<?php

$config['START_TIME'] = microtime(true);

$config['SITE_PATH'] = realpath('.') . '/';

$config['BASE_PATH'] = 'doophp/';

$config['PROTECTED_FOLDER'] = 'webapps/';

$config['SUBFOLDER'] = '/';

$config['APP_MODE'] = 'prod';

$config['APP_URL'] = 'http://' . $_SERVER['HTTP_HOST'] . $config['SUBFOLDER'];

$config['APP_URL_NO_WWW'] = str_replace('www.', '', $config['APP_URL']);

$config['AUTOROUTE'] = true;

$config['DEBUG_ENABLED'] = true;

$config['LOG_PATH'] = 'logs/';

$config['CACHE_PATH'] = $config['PROTECTED_FOLDER'] . 'cache/';

$config['ERROR_404_ROUTE'] = '/error';

//$config['ERROR_404_DOCUMENT'] = 'error.php';

/* $config['MEMCACHE'] = array(
    array('192.168.0.39', '11211', true, 40),
    array('192.168.0.40', '11211', true, 80)
); */

//$config['APP_NAMESPACE_ID'] = 'webapps';

$config['MODULES'] =
    array('matrixcsmo', 'csmohist', 'curates',
          'calckvar', 'loadcensus', 'factweb', 'updinfo');

$config['AUTOLOAD'] = array('class', 'libraries', 'model',
    'module/calckvar/controller', 'module/calckvar/model',
    'module/csmohist/controller', 'module/csmohist/model',
    'module/curates/controller', 'module/curates/model',
    'module/factweb/controller', 'module/factweb/model',
    'module/loadcensus/controller', 'module/loadcensus/model',
    'module/matrixcsmo/controller', 'module/matrixcsmo/model',
    'module/updinfo/controller', 'module/updinfo/model');

$config['TEMPLATE_ENGINE'] = 'DooView';

$config['TEMPLATE_ALLOW_PHP'] = true;

$config['TEMPLATE_COMPILE_ALWAYS'] = true;

$config['TEMPLATE_SHOW_COMMENT'] = false;

$config['SESSION_CACHE_TYPE'] = 'APC';
