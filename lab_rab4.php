<div class="content">
	<h2>Лабораторная работа №4</h2>
	<div class="line"></div>
	<div class="center" style="width: auto">
<?php
	// подключение и пересоздание бд
	global $user, $pass;
	$dbname = "test.fdb";
	$dbpath = $_SERVER['DOCUMENT_ROOT']."\database\\$dbname";
	$host = $_SERVER['SERVER_NAME'].":".$dbpath; 
	if (file_exists($dbpath)) unlink($dbpath);
	createDatabase($host, $user, $pass);
	echo '</br>База данных успешно создана!</br></br>';
	echo '<b>Структура базы данных:</b></br>';
	// вывод информации о таблицах
	getTableInfo($host, $user, $pass);
	
	modifyDatabase($host, $user, $pass);
	echo '</br><b>Изменённая структура базы данных:</b></br>';
	// вывод информации о таблицах
	getTableInfo($host, $user, $pass);
	
	// восстановить структуру бд
	ibase_drop_db(ibase_connect($host, $user, $pass));
	createDatabase($host, $user, $pass);
	echo '</br>Структура базы данных восстановлена!</br>';
	// заполнение таблиц данными
	insertToDatabase($host, $user, $pass);

	// вывод содержимого таблиц
	// ARTICLE
	echo "</br><b>Таблица ARTICLE:</b></br>";
	$dbh = ibase_connect($host, $user, $pass);
	$result = ibase_query($dbh, "SELECT * FROM ARTICLE") or die ("Сбой при доступе к БД: " . ibase_errmsg());
	$articles = array();
	while ($row = ibase_fetch_assoc($result)) array_push($articles, $row);
	showArticleTable($articles);
	ibase_close($dbh);
	
	// SITE_USER
	echo "</br><b>Таблица USER:</b></br>";
	$dbh = ibase_connect($host, $user, $pass);
	$result = ibase_query($dbh, "SELECT * FROM SITE_USER") or die ("Сбой при доступе к БД: " . ibase_errmsg());
	$users = array();
	while ($row = ibase_fetch_assoc($result)) array_push($users, $row);
	showUserTable($users);
	ibase_close($dbh);
	
	// вывод результатов первого запроса
	echo "</br><b>Запрос №1:</b></br>";
	$dbh = ibase_connect($host, $user, $pass);
	$result = ibase_query($dbh, "SELECT * FROM ARTICLE WHERE CHAR_LENGTH(ANOTATION) < 200") or die ("Сбой при доступе к БД: " . ibase_errmsg());
	$articles = array();
	while ($row = ibase_fetch_assoc($result)) array_push($articles, $row);
	showArticleTable($articles);
	ibase_close($dbh);

	// вывод результатов второго запроса
	echo "</br><b>Запрос №2:</b></br>";
	$dbh = ibase_connect($host, $user, $pass);
	$result = ibase_query($dbh, "SELECT * FROM ARTICLE WHERE CHAR_LENGTH(NAME) > 20") or die ("Сбой при доступе к БД: " . ibase_errmsg());
	$articles = array();
	while ($row = ibase_fetch_assoc($result)) array_push($articles, $row);
	showArticleTable($articles);
	ibase_close($dbh);
	
	// удаление бд
	$dbh = ibase_connect($host, $user, $pass);
	ibase_drop_db($dbh);
	echo '</br>База данных успешно удалена!</br>';
?>
	</div>
	<div style="height: 0px;"></div>
</div> <!-- content -->