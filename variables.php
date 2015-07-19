<?php
	session_start();
	
	if(!isset($_SESSION['server']))
	{
		$_SESSION['server'] = '127.0.0.1';
		$_SESSION['user'] = 'root';
		$_SESSION['password'] = '';
		$_SESSION['database'] = 'supriyacart';
		$_SESSION['userid'] = 0;
		$_SESSION['login'] = 0;
	}
	
?>