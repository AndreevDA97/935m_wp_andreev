<?php
	if ($_GET['action'] == 'login' && isset($_POST['login']) && isset($_POST['password']))
	{
		$login = safestr($_POST['login']);
		$password = md5(safestr($_POST['password']).SITE_SALT);
		$user = getUser($login, $password);
		session_start();
		if ($user) {
			$_SESSION['user_login'] = $user['NAME'];
			$_SESSION['user_id'] = $user['ID'];
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
			unset($_COOKIE['LastLogin']);
			setcookie('LastLogin', time(), 2147483647); // постоянные cookies
		}
		else {
			$_SESSION['auth_error'] = 'Неправильный логин или пароль.';
		}
		header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		exit;
	}
	if ($_GET['action'] == 'logout')
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