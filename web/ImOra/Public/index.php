<?php

error_reporting(E_ALL);
define('ORADT_WEB', 1);
/**
  这个是什么意思？
 */

define('APP_NAME', 'apps');
define('APP_PATH', '../Apps/');
define('TMPL_PATH','../Apps/Tpl/');
define('CONF_PATH', '../Config/');
define('RUNTIME_PATH','../Runtime/');
define('APP_DEBUG', true);
define('WEB_ROOT_DIR', realpath(dirname(__FILE__)) . '/');
define('LIB_ROOT_PATH', WEB_ROOT_DIR . '../Libs/');

//解决firefox用flash时候session丢失问题
if (isset($_POST['__PHP_SESSID'])){
    session_id($_POST['__PHP_SESSID']);
}

//define('TMPL_PATH', '/Tpl/');
header('Content-Type:text/html; charset=utf-8');
header('X-Powered-By:OraWeb');
include('../Libs/ThinkPHP/ThinkPHP.php');
/* EOF */
