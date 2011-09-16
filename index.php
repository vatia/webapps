<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('html_errors', 1);
error_reporting(E_ALL | E_STRICT);

ini_set('max_execution_time', 0);
ini_set('max_input_time', 0);
ini_set('memory_limit', '512M');

ini_set('error_log', dirname(__FILE__).'/logs/php.log');

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

header('Expires: Fri, 26 Nov 1982 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

function app_url_base() {

	$isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on");

	$port = (isset($_SERVER["SERVER_PORT"]) &&
		((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") ||
			($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));

	$port = ($port) ? ':' . $_SERVER["SERVER_PORT"] : '';

	$url = ($isHTTPS ? 'https://' : 'http://') . $_SERVER["SERVER_NAME"] . $port;

	return $url;
}

require 'bootstrap.php';
