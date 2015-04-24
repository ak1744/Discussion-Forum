<?php
// Author: Himanshu Kandpal 

session_start();

header('Content-type: text/html;charset=UTF-8');

if(!isset($_SESSION['username']) and isset($_COOKIE['username'], $_COOKIE['password'])){
	$query='select password,id from users where username="'.mysql_real_escape_string($_COOKIE['username']).'"';
	$cnn = mysql_query($query);
	$dn_cnn = mysql_fetch_array($cnn);
	if(sha1($dn_cnn['password'])==$_COOKIE['password'] and mysql_num_rows($cnn)>0){
		$_SESSION['username'] = $_COOKIE['username'];
		$_SESSION['userid'] = $dn_cnn['id'];
	}
}

?>