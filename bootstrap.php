<?php

require_once './webapps/config/common.conf.php';
require_once './webapps/config/routes.conf.php';
require_once './webapps/config/acl.conf.php';
require_once './webapps/config/db.conf.php';

require_once $config['BASE_PATH'] . 'Doo.php';
require_once $config['BASE_PATH'] . 'app/DooConfig.php';
//require_once $config['BASE_PATH'] . 'diagnostic/debug.php';

function __autoload($classname){
	Doo::autoload($classname);
}

spl_autoload_register('Doo::autoload');

Doo::conf()->set($config);

try {
    Doo::db()->setMap($dbmap);
    Doo::db()->setDb($dbconfig, Doo::conf()->APP_MODE);
    Doo::db()->sql_tracking = true;
} catch(SqlMagicException $e) {
    Doo::logger()->err($e->getMessage());
}

Doo::acl()->rules = $acl;
Doo::acl()->defaultFailedRoute = Doo::conf()->APP_URL . '/error';

Doo::app()->route = $route;

try {
    Doo::app()->run();
} catch (Exception $e) {
    Doo::logger()->err($e->getMessage());
    echo $e->getMessage();
}

Doo::logger()->writeDbProfiles();
Doo::logger()->writeProfiles();
Doo::logger()->writeLogs();
Doo::logger()->writeTraces();
