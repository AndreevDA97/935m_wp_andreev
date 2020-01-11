<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		include 'includes/lib.inc.php';
		if (!empty($_POST['password_main']) && !empty($_POST['password_confirm']) && !empty($_POST['user_name'])) 
		{
			if ($_POST['password_main'] == $_POST['password_confirm'])
			{
				$email = safestr($_POST['email']);
				$emailRegex = "/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z\-\.]+$/";
				if (preg_match($emailRegex, $email))
				{
					$password = md5(safestr($_POST['password_main']).SITE_SALT);
					$name = safestr($_POST['user_name']);
					if (isset($_POST['address'])) $address = safestr($_POST['address']);
					if (isset($_POST['phone'])) $phone = safestr($_POST['phone']);
					addUser($name, $password, $phone, $email, $address);
					session_start(); $_SESSION['reg_success'] = $name;
					header("Location: index.php?page=register");
					exit;
				}
				else $error = 'Адрес эл. почты не корректен!';
			}
			else $error = 'Пароли не совпадают!';
		}
		else $error = 'Заполните все обязательные поля!';
		session_start(); $_SESSION['reg_error'] = $error;
		header("Location: index.php?page=register");
		exit;
	}
?>
<div class="content">
	<h2>Регистрация</h2>
	<div class="line"></div>
	<div style="width: auto">
	<?php 
		if (!isset($_SESSION['reg_success'])) {
	?>
		<form method="POST" action="register.php">
			<p>
				<label>Имя пользователя</label><br>
				<input type="text" name="user_name" required>
			</p>
			<p>
				<label>Пароль</label><br>
				<input type="password" name="password_main" required>
			</p>
			<p>
				<label>Повторите пароль</label><br>
				<input type="password" name="password_confirm" required>
			</p>
			<p>
				<label>Адрес</label><br>
				<input type="text" name="address">
			</p>
			<p>
				<label>Email</label><br>
				<input type="text" name="email">
			</p>
			<p>
				<label>Телефон</label><br>
				<input type="text" name="phone">
			</p>
			<br>
			<?php 
				if (isset($_SESSION['reg_error'])) {
					echo "<label class='error'>".safestr($_SESSION['reg_error'])."</label>";
					unset($_SESSION['reg_error']);
				}
			?>
			<p>
				<input type="reset" value="Сброс">
				<input type="submit" value="Зарегистрироваться">
			</p>
		</form>
	<?php
		} else {
			echo '<p>Пользователь зарегистрирован. <br>'
				.'Войдите с помощью логина <b>'
				.safestr($_SESSION['reg_success']).'</b></p>';
			unset($_SESSION['reg_success']);
		}
	?>
	</div>
	<div style="height: 0px;"></div>
</div> <!-- content -->