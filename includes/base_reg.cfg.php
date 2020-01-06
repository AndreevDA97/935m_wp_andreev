<?php
	define('SITE_SALT', '528');
	$dbname = "base.fdb";
	$dbpath = $_SERVER['DOCUMENT_ROOT']."\database\\$dbname";
	$host = $_SERVER['SERVER_NAME'].":".$dbpath; 
	$user = "SYSDBA"; 
	$pass = "masterkey";
?>