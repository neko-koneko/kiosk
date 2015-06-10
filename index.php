<?php
session_start();
error_reporting(E_NONE);
error_reporting(E_ALL);
header("Content-type: text/html; charset=UTF-8");
header("Expires: Mon, 23 May 1995 02:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must_revalidate");
header("Pragma: no-cache;");
header("Strict-Transport-Security: max-age=15768000");
//header("Content-Security-Policy: default-src 'self'; script-src 'unsafe-inline'; style-src 'unsafe-inline';"); // FF 23+ Chrome 25+ Safari 7+ Opera 19+
//header("X-Content-Security-Policy: default-src 'self'; script-src 'unsafe-inline'; style-src 'unsafe-inline' "); // IE 10+
header("X-Frame-Options: SAMEORIGIN");

// load config
require_once("config/db_config.php");
require_once("config/auth_config.php");
require_once("config/local_config.php");

//init
require_once("inc/libraries/init.php");
require_once("inc/libraries/utils.php");


if(!$db || $db->conn_id == false){
		include("503.php"); die;
}


if (!empty( $_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
{$server_protocol='https://';}
else
{$server_protocol='http://';}
$server_name = rtrim($_SERVER['SERVER_NAME'], '/');
$base = $server_protocol.$server_name;

$server_port = $_SERVER['SERVER_PORT'];
if ($server_port!='80' and $server_port!='443'){$base .= ":".$server_port;}

$base .= (dirname($_SERVER['PHP_SELF']) != "\\") ? dirname($_SERVER['PHP_SELF']) : "";
if (mb_substr($base, -1)!=='/'){$base.='/';}

$base_url_components=parse_url($base);
$base_url_path = mb_substr( $base_url_components['path'],1);

$main_request  = mb_substr( $_SERVER['REQUEST_URI'],1);

//echo 'mr='.$main_request.' base_url='.$base_url_path.' base ='.$base; print_r($_SERVER); die;

if (mb_strpos($main_request,$base_url_path)===0)
{
  $main_request = mb_substr($main_request,mb_strlen($base_url_path) );
  $main_request = reset(explode('?',$main_request));
}

$main_request = reset(explode('?',$main_request));
$main_request_array = array_filter(explode('/',$main_request,10));

//print_r($main_request_array);die;

$controller_path = $main_request_array[0];

if ($controller_path == '')
 {
  $controller_path = 'inc/controllers/main.php';
 }
else
 {
  if (file_exists('inc/controllers/'.$controller_path.'.php'))
   {
	$controller_path = 'inc/controllers/'.$controller_path.'.php';
   }
   else
   {
    $controller_path = 'inc/controllers/main.php';
   }
 }
 include($controller_path);

?>