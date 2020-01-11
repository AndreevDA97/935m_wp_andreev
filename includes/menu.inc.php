<?php
	$menu = array(
		"Главная"=>"/index.php?page=home", 
		"Каталог"=>"/index.php?page=catalog",
		"Работа №1"=>"/index.php?page=lab_rab1",
		"Работа №2"=>"/index.php?page=lab_rab2",
		"Работа №3"=>"/index.php?page=lab_rab3",
		"Работа №4"=>"/index.php?page=lab_rab4",
		"Работа №5"=>"/index.php?page=lab_rab5"
	);
?>	

<div class="sidebar">
	<?php if (!IS_AUTH) { ?>
	<div class="auth">
		<p>Вход в систему</p>
		<form method="POST" action="index.php?action=login">
			<input type="text" name="login"><br>
			<input type="password" name="password"><br>
			<label class="error"><?=$auth_error?></label>
			<input type="submit" value="Войти"><br>
		</form>
		<button onclick="location.href='index.php?page=register';" style="width:100%">Регистрация</button>
	</div>
	<?php }
		unset($_SESSION['auth_error']);
		getMenu($menu);
	?>
</div> <!-- sidebar -->