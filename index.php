<?php
	ini_set('error_reporting', E_ALL & ~E_NOTICE);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	$page = empty($_GET['page']) ?
		'home' : $_GET['page']; // одностраничный интерфейс
	header('Cache-control: no-store'); // запрет кэширования
	header('Content-Type: text/html; charset=utf-8'); // указать кодировку
	
	include 'includes/lib.inc.php';
	require 'includes/auth.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>г. Касимов, 867 лет | Главная</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="style.css" />
</head>

<body>
	<div class="sheet">
		<div class="container">
			<?php include "includes/top.inc.php" ?>
			<?php 
				switch ($page) {
					case 'catalog': include $page.'.php'; break;
					case 'add': include 'includes/catalog/'.$page.'.php'; break;
					case 'edit': include 'includes/catalog/'.$page.'.php'; break;
					case 'item': include 'includes/catalog/'.$page.'.php'; break;
					case 'lab_rab1': 
						ob_start();
						include $page.'.php';
						$lab_rab1 = ob_get_contents();
						file_put_contents($page.'.html', $lab_rab1);
						ob_end_clean();
						echo $lab_rab1;
						break;
					case 'lab_rab2': include $page.'.php'; break;
					case 'lab_rab3': include $page.'.php'; break;
					default: 
			?>
			<div class="content">
				<h2>Главная</h2>
				<div class="line"></div>
				<div class="center">
					<h4>Добро пожаловать на сайт об истории города Касимова!</h4><br />
					<p>
						История отдельных городов и областей важна для истории целого государства, поэтому будет нелишним
						ознакомить читающую публику с историей города Касимова, в связи с историей Касимовского ханства и отечесвенною
						историей вообще. История города Касимова потому важна для истории России, что касимовские цари со своими
						подданными татарами воевали за русскую землю и участвовали почти во всех войнах и походах против врагов ее,
						начиная с самого основания Касимовского царства и до его уничтожения, т.е. с эпохи Василия Темного и до времен
						Петра Великого. Поэтому история города Касимова может иметь интерес для всякого русского, кого интересуют
						исторические сочинения о нашей родной старине...<br />
						<br />
						<img src="images/kasimov.jpg" alt="kasimov" style="width: 400px" />
					</p>
				</div>
				<div style="height: 0px;"></div>
			</div> <!-- content -->
			<?php
						break;
				}
			?>
			<?php include "includes/menu.inc.php" ?>
			<div class="clear"></div> <!-- Отмена обтекания -->
			<?php include "includes/bottom.inc.php" ?>
		</div> <!-- container -->
	</div> <!-- sheet -->
</body>

</html>