<?php
// Author: Himanshu Kandpal
error_reporting(E_ALL ^ E_DEPRECATED);
// we log to the database
$database_name = 'forum';
mysql_connect('localhost','root','');
mysql_select_db($database_name);
	
// 	username of the administrator
$admin = 'himanshu';

$design = 'images';

// optional configuration

$url_home = 'index.php';

// initialization

include('init.php');
?>