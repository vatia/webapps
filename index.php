<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

ini_set('memory_limit', '256M');

//ini_set('session.gc_maxlifetime', 3600);
//ini_set('session.gc_probability', 1);
//ini_set('session.gc_divisor', 1);
//ini_set('session.use_trans_sid', true);
//ini_set('session.use_only_cookies', 1);
//ini_set('session.cookie_lifetime', 300);
ini_set('session.save_path', dirname(__FILE__).'/temp/sessions');
//ini_set('session.referer_check', 'www.vatia.com.co');
//ini_set('session.cookie_domain', (strpos($_SERVER['HTTP_HOST'], '.') !== false) ? $_SERVER['HTTP_HOST'] : '');

date_default_timezone_set('America/Bogota');

require 'bootstrap.php';
