<?php
	if (isset($_POST['login']) && isset($_POST['password']))
	{
		$login = safestr($_POST['login']);
		$password =  safestr($_POST['password']);
		session_start();
		if ($login == 'admin' && $password == 'admin') {
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
			$_SESSION['login'] = $login;
			unset($_COOKIE['LastLogin']);
			setcookie('LastLogin', time(), 2147483647); // постоянные cookies
		}
		else {
			$_SESSION['auth_error'] = 'Неправильный логин или пароль.';
		}
		header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		exit;
	}
	if (isset($_GET['logout']))
	{
		session_start();
		session_destroy();
		header("Location: index.php");
		exit;
	}
	session_start();
	define('IS_AUTH', @$_SESSION['ip'] == $_SERVER['REMOTE_ADDR']);
	$auth_error = @$_SESSION['auth_error'];
?>