<?php
	session_start();
	ob_start();
	$host="localhost:60";
	$user="root";
	$pass="";
	$db="uyeler";

	$baglan= mysql_connect($host,$user,$pass) or die (mysql_error());
	mysql_select_db($db,$baglan) or die (mysql_error());
	mysql_query("SET CHARACTER SET 'utf8'");
	mysql_query("SET NAMES 'utf8'");
?>