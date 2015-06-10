<?php

// CI standalone DB init
define('BASEPATH', realpath(dirname(__FILE__)).'/CI/');
define('APPPATH', realpath(dirname(__FILE__)).'/CI/');
include_once('CI/core/Common.php');
include_once('CI/database/DB.php');
function get_config(){}

function &load_database($params = '', $active_record_override = false)
{
	$database =& DB($params, $active_record_override);
	return $database;
}
/* Load database via Database source name, eg. "mysql://root:password@localhost/mydatabase" */

//$mysqli_connection = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['password'],$config['db']['database']);

$db =& load_database($config['db']['driver']."://".$config['db']['user'].":".$config['db']['password']."@".$config['db']['host']."/".$config['db']['database'], true);

mb_internal_encoding("UTF-8");
mb_regex_encoding("UTF-8");
date_default_timezone_set($config['local']['timezone']);
setlocale(LC_ALL,$config['local']['locale']);
?>