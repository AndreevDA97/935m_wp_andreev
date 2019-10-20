<?php
	include "includes/lib.inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>г. Касимов, 867 лет | Лабораторная работа №2</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="style.css" />
</head>

<body>
	<div class="sheet">
		<div class="container">
			<?php include "includes/top.inc.php" ?>
			<div class="content">
				<h2>Лабораторная работа №2</h2>
				<div class="line"></div>
				<div class="center" style="width: auto">
					<h4>Задание 1.</h4><br />
					<?php 
						echo '<table>';
						echo '<tr><th>Переменная</th><th>Значение</th></tr>';
						foreach ($_SERVER as $key => $value) {
							echo "<tr><td>{$key}</td><td>{$value}</td></tr>";
						}
						echo '</table>';
					?>
					<h4>Задание 2.</h4><br />
					<p>
						<?php 
							$y = rand(0, 10); 
							$x = rand(0, 10);
							$result = power($y, $x);
							echo "Результат возведения числа {$y} в степень {$x} = {$result}" 
						?>
					</p>
				</div>
				<div style="height: 0px;"></div>
			</div> <!-- content -->
			<?php include "includes/menu.inc.php" ?>
			<div class="clear"></div> <!-- Отмена обтекания -->
			<?php include "includes/bottom.inc.php" ?>
		</div> <!-- container -->
	</div> <!-- sheet -->
</body>

</html>