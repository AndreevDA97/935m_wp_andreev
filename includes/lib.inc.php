<?php
	// настройки подключения к бд
	include_once "base_reg.cfg.php";

	// формирование меню сайта
	function getMenu($menu)
	{
		global $page;
		echo '<div class="nav">';
			foreach ($menu as $link => $href)
			{
				$class = strpos($href, $page) !== false ? 
					' class="active"' : '';
				echo '<div class="vertical-menu">';
				echo "<h4><a href=\"{$href}\"{$class}>{$link}</a></h4>";
				echo '</div>';
			}
		
		echo '</div>';
	}
	
	// возведение $y в степень $x
	function power($y, $x) {
		$result = exp($x*log(abs($y)));
		return $x & 1 && $y < 0 ? -$result : $result;
	}
	
	// функция изменения размера изображения
	function resize($file)
	{
		//Ограничение по ширине в пикселях
		$max_size = 250;
		//Cоздание исходного изображения на основе исходного файла
		$src = imagecreatefromjpeg($file['tmp_name']);
		//Определение ширины и высоты изображения
		$w_src = imagesx($src);
		$h_src = imagesy($src);
		If ($w_src > $max_size)
		{
			//Вычисление пропорций
			$ratio = $w_src/$max_size;
			$w_dest = round($w_src/$ratio);
			$h_dest = round($h_src/$ratio);
			//Создание пустого изображения
			$dest = imagecreatetruecolor($w_dest, $h_dest);
			//Копирование старого изображения в новое с изменением параметров
			imagecopyresampled($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
			//Вывод изображения и очистка памяти
			imagejpeg($dest, $file['tmp_name']);
			imagedestroy($dest);
			imagedestroy($src);
			
			return $file['tmp_name'];
		}
		else
		{
			//Вывод изображения без изменения и очистка памяти
			imagejpeg($src, $file['tmp_name']);
			imagedestroy($src);
			
			return $file['tmp_name'];
		}
	}
	
	// удаление HTML, PHP тегов и лишних пробелов
	function safestr($str) {
		return trim(strip_tags($str));
	}
	
	/*
	 * Функции работы с базой данных
	 */
	
	// создание базы данных и ее структуры
	function createDatabase($host, $user, $pass) {
		// создание бд
		ibase_query(IBASE_CREATE, "CREATE DATABASE '$host' USER '$user' PASSWORD '$pass' DEFAULT CHARACTER SET utf8");
		ibase_close();

		$dbh = ibase_connect($host, $user, $pass);
		// начало транзакции
		ibase_trans();
		// создание таблиц
		ibase_query($dbh, "CREATE TABLE SITE_USER (
			ID INTEGER NOT NULL PRIMARY KEY,
			NAME VARCHAR(50) NOT NULL,
			PASSWORD VARCHAR(50) NOT NULL,
			PHONE VARCHAR(20),
			EMAIL VARCHAR(50),
			ADDRESS VARCHAR(100))") or die ("Ошибка доступа к БД: " . ibase_errcode());

		ibase_query($dbh, " CREATE TABLE ARTICLE (
			ID INTEGER NOT NULL PRIMARY KEY,
			NAME VARCHAR(75) NOT NULL,
			ANOTATION VARCHAR(500) NOT NULL,
			DESCRIPTION VARCHAR(3000),
			INCOMING_DATE TIMESTAMP NOT NULL,
			IMAGE VARCHAR(100),
			USER_ID INTEGER NOT NULL);") or die ("Ошибка доступа к БД: " . ibase_errmsg());

		ibase_query($dbh, "CREATE SEQUENCE USER_ID_SEQ");
		ibase_query($dbh, "CREATE SEQUENCE ARTICLE_ID_SEQ");
		ibase_commit();

		// обновление структуры бд
		$dbh = ibase_connect($host, $user, $pass);
		ibase_trans();
		ibase_query($dbh, "ALTER TABLE ARTICLE ADD FOREIGN KEY (USER_ID)
			 REFERENCES SITE_USER(ID) ON DELETE SET NULL ON UPDATE CASCADE;") or die ("Ошибка доступа к БД: " . ibase_errmsg());
		ibase_query($dbh, "ALTER SEQUENCE USER_ID_SEQ RESTART WITH 0");
		ibase_query($dbh, "ALTER SEQUENCE ARTICLE_ID_SEQ RESTART WITH 0");
		ibase_commit();
		
		// создание триггеров для авто-заполнения
		$dbh = ibase_connect($host, $user, $pass);
		ibase_trans();
		ibase_query($dbh, "CREATE TRIGGER USER_INSERT_HANDLER FOR SITE_USER
			ACTIVE BEFORE INSERT
			AS
			BEGIN
				new.ID = GEN_ID(USER_ID_SEQ, 1);
			END;") or die ("Ошибка доступа к БД: " . ibase_errmsg());

		ibase_query($dbh, "CREATE TRIGGER ARTICLE_INSERT_HANDLER FOR ARTICLE
			ACTIVE BEFORE INSERT
			AS
			BEGIN
				new.ID = GEN_ID(ARTICLE_ID_SEQ, 1);
				new.INCOMING_DATE = current_timestamp;
			END;") or die ("Ошибка доступа к БД: " . ibase_errmsg());
		ibase_commit();
	}

	function modifyDatabase($host, $user, $pass) {
		$dbh = ibase_connect($host, $user, $pass);
		// начало транзакции
		ibase_trans();
		// изменение структуры таблицы
		ibase_query($dbh, "ALTER TABLE ARTICLE DROP ANOTATION");
		ibase_query($dbh, "ALTER TABLE SITE_USER DROP ADDRESS");
		ibase_commit();
	}

	function insertToDatabase($host, $user, $pass) {
		$dbh = ibase_connect($host, $user, $pass);
		// начало транзакции
		ibase_trans();
		// вставка в таблицу SITE_USER
		$password = md5('Pass1'.SITE_SALT);
		ibase_query($dbh, "INSERT INTO SITE_USER(NAME, PASSWORD, PHONE, EMAIL, ADDRESS) 
			values ('User1', '$password', '8985345344', 'sdfk3@mail.ru', 'Полетаева, 30');");
		$password = md5('Pass2'.SITE_SALT);
		ibase_query($dbh, "INSERT INTO SITE_USER(NAME, PASSWORD, PHONE, EMAIL, ADDRESS) 
			values ('User2', '$password', '8923423438', 'asdfa3@yandex.ru', 'Гагарина, 59/1');");
		$password = md5('Pass3'.SITE_SALT);
		ibase_query($dbh, "INSERT INTO SITE_USER(NAME, PASSWORD, PHONE, EMAIL, ADDRESS) 
			values ('User3', '$password', '8974234231', 'sdxa2@mail.ru', 'Большакова, 40');");
		$password = md5('Pass4'.SITE_SALT);
		ibase_query($dbh, "INSERT INTO SITE_USER(NAME, PASSWORD, PHONE, EMAIL, ADDRESS) 
			values ('User4', '$password', '8965748323', 'pli41@yandex.ru', 'Есенина, 19');");
		ibase_commit();
		
		// вставка в таблицу ARTICLE с проверкой авто-заполнения
		$dbh = ibase_connect($host, $user, $pass);
		ibase_trans();
		ibase_query($dbh, "INSERT INTO ARTICLE(NAME, ANOTATION, DESCRIPTION, IMAGE, USER_ID) 
			values ('История', 'Касимов стоит на перепутье. Отсюда идут дороги в Москву и Рязань, Владимир и Нижний. Может, этим объясняются перипетии его судьбы и роль в истории.', 'Основан город в 1152 году Юрием Долгоруким при впадении реки Бабенки в Оку под именем Городец Мещерский. Позже он был разрушен татарскими набегами и пожарами, а город перенесен чуть выше по Оке уже под названием Новый Низовой Городец. Помним, что был и поныне есть Городец на другой реке — Волге. Издавна здесь, среди болот, озер, лесов, жили племена мещера, меря, мордва и русские. А чуть позже поселились и татары. Василий Темный в 1452 году пожаловал город сыну казанского Улу-Мухаммед хана Касиму за то, что Касим поддержал князя в междоусобной борьбе. Долгое время Касимов выполнял роль форпоста на рязанской земле, будучи пограничьем между Казанским ханством и Москвою. Более двухсот лет посуществовало Касимовское ханство (Касимов тогда звался Ханкерман). Здесь, после взятия Казани Иваном Грозным, жила в несвободе последняя казанская царица — Сююмбике. Из Касимова родом был Сеид-Булат, провозглашенный Иваном Грозным царем всея Руси под именем Симеона Бекбулатовича, «правивший» 11 месяцев. После смерти в 1681 году последней правительницы Касимова Фатимы-Султан это ханство перестало существовать.Хотя, в Казанском кремле вам покажут башню ее имени и расскажут красивую легенду о героической гибели царицы.', '/images/catalog/1.jpg', 1);");
		ibase_query($dbh, "INSERT INTO ARTICLE(NAME, ANOTATION, DESCRIPTION, IMAGE, USER_ID)
			values ('Город старины и близкой нови…', 'Не думайте, что Касимов откроется сразу во всей красе. Он будет играть в прятки, обещать, манить. Свернешь направо — там тупик. Виной тому касимовские овраги. Они делят город на несколько частей. Преодолеешь препятствие — награда. На возвышении церковь, ампирный особняк, площадь с торговыми рядами или минарет!', 'Современный Касимов — русский город, сохранивший татарские черты не только в имени. В городе две мечети: новая, как ее все называют, построена в начале XX века, и старая, выстроенная в XV столетии. От XV века дошел, правда, лишь минарет (мечеть царь Петр приказал разобрать), остальная часть пристроена через три века. В старой мечети сейчас музей, посвященный быту местных татар. Поднимитесь на минарет — сверху город и окрестности как на ладони. Предание гласит: Петр I, подъезжая к городу, перекрестился на белый высокий минарет, приняв его за православный храм. Когда же заметил, что это не церковь, а мечеть, то в сердцах приказал судовому артиллеристу снести верхушку минарета, что артиллерист и сделал. Мечеть так и стояла без «головы», только при Екатерине II татары выхлопотали разрешение достроить ее. Метрах в ста от мечети располагается ханская усыпальница — текие Шах-Али хана. Второе текие — Авган-Султана — ниже по Оке. Из достопримечательностей города — набережная Оки с особняками, площадь Соборная, с торговами рядами и храмами.', '/images/catalog/2.jpg', 2);");
		ibase_query($dbh, "INSERT INTO ARTICLE(NAME, ANOTATION, DESCRIPTION, IMAGE, USER_ID)
			values ('Над рекою, над Окою', 'В Касимов стоит приехать уже только ради того, чтобы полюбоваться набережной и Окой. Ока здесь особенная. В прежние века река играла важную роль в жизни города, по ней ходили пароходы не только до Нижнего и Рязани. Из Самары, Казани, Астрахани по воде переправляли товар купцы. Теперь тут спокойно рыбачат местные любители рыбной ловли (наверное, все мужское население города бывает тут), по реке, бывает, ходят сухогрузы, для пассажирских судов судоходна река лишь до июля.', 'Итак, с одной стороны — Ока, с другой — лицом к ней стоят в одну линию особняки. И дальше — парадный въезд в город — Петровская застава. На Набережной улице раньше размещались и кожевенные производства, склады, пароходные конторы. Но губернский город еще надо постараться увидеть, ведь свернешь не туда — попадешь то ли в город, то ль в деревню. Касимов до сих пор ввысь не стремится. Частная застройка и двух-трехэтажные дома составляют большую часть зданий. С Набережной наверх — и вот главная площадь — Соборная или Советская, кто как ее называет. Тут торговые ряды, храмы и особняки. Вообще Касимов — город церквей и особняков. Правда, денег на поддержку былого великолепия, видимо выделяется мало. Торговые ряды в стиле ампир, построенные местным архитектором-самоучкой Иваном Гагиным, того и гляди рухнут. Так что успейте видеть! Успенская церковь, расположенная невдалеке, вроде как на ремонте, закрыта и тиха даже в престольный праздник, но пока результатов не видно. И вообще, все время, пока были в Касимове, не покидала мысль, что надо торопиться, материальная история ускользает, рушится. Центр Касимова во многом — плод творчества Ивана Гагина. Дом Алянчиковых, дом Кастровых, Баркова и другие усадьбы выстроены по его проекту. О доме Алянчиковых ходит легенда. Якобы первоначально предполагалось: здание будет иметь множество архитектурных украшений — портики, галереи, нарядный балкон. Но от всего этого хозяин решил отказаться после общения с гадалкой. Та предсказала ему смерть после завершения строительства дома. Так купец решил не заканчивать проект. Хотя от гибели это его не уберегло — в эпидемию холеры он умер. Единственный из всей семьи. Архитектор Гагин сорок лет вынашивал план строительства храма Воскресения Христова на главной площади города. Вокруг главного купола должна была двигаться фигура Спасителя, вслед за солнцем. Но проект не был осуществлен. Главный храм города — Вознесенский собор — был построен тут же, на Соборной, уже проекту другого, рязанского, архитектора Воронихина.', '/images/catalog/3.jpg', 3);");
		ibase_query($dbh, "INSERT INTO ARTICLE(NAME, ANOTATION, DESCRIPTION, IMAGE, USER_ID)
			values ('Что привезти?', 'На Соборной площади и на улице Советской сохранились и общественные здания — дом городской управы, казначейства, мирового суда. Квартал занимает здание механико-технического училища (1896 год). Сегодня улица Советская занята магазинами, парикмахерскими, различными «фирмами», так что в глазах пестрит от вывесок. Единого стиля и плана, к которому стремился архитектор девятнадцатого столетия', 'Что еще? Есть в Касимове музей самоваров (ул.Советская, д.4), и, не поверите, — музей космонавтики! Говорят, четверг и воскресенье в Касимове — базарные дни, много народа, шумит ярмарка. Мы были в среду, достаточно тихо и немноголюдно. Поесть в местных кафе не удалось, их тут немного, из них часть закрыта. Обошлись сухим пайком — сетевые и прочие магазины в городе имеются. В Касимове находится старейшая сетевязальная фабрика. Рыбаки, вам сюда! А вот знаменитых касимовских поддужных колокольчиков мы не нашли, взяли фарфоровые. Есть поделки местных мастеров в музее, что в доме Алянчикова, открытки и путеводители. Как доехать: из Москвы автомобилем по Егорьевскому шоссе, время в пути — примерно 5 часов (если без пробок!). Автобусом с Щелковского автовокзала — 5 с половиной, а то и больше. Ходит рейсовый автобус из Рязани (Касимов — Рязанская область).', '/images/catalog/4.jpg', 4);");
		ibase_commit();
	}

	function db_initialize() {
		global $host, $user, $pass, $dbpath;
		if(!file_exists($dbpath)) {
			createDatabase($host, $user, $pass);
			modifyDatabase($host, $user, $pass);
			insertToDatabase($host, $user, $pass);
		}
	}

	function getTableInfo($host, $user, $pass)
	{
		$dbh = ibase_connect($host, $user, $pass);
		$query = "SELECT R.RDB\$RELATION_NAME AS RELATION_NAME, R.RDB\$FIELD_NAME AS FIELD_NAME, F.RDB\$FIELD_LENGTH AS FIELD_LENGTH, T.RDB\$TYPE_NAME AS TYPE_NAME, CASE R.RDB\$NULL_FLAG WHEN 1 THEN 'TRUE' ELSE 'FALSE' END AS NULL_FLAG, R.RDB\$FIELD_POSITION AS FIELD_POSITION
		FROM RDB\$FIELDS F, RDB\$RELATION_FIELDS R, RDB\$TYPES T 
		WHERE (F.RDB\$FIELD_NAME = R.RDB\$FIELD_SOURCE) AND (R.RDB\$SYSTEM_FLAG = 0) AND (F.RDB\$FIELD_TYPE = T.RDB\$TYPE) AND (T.RDB\$FIELD_NAME = 'RDB\$FIELD_TYPE')
		ORDER BY RELATION_NAME, FIELD_POSITION;";
		$result = ibase_query($dbh, $query);
		echo "<table border='1' width='60%'><tr>
			  <th width='20%'>Таблица</th>
			  <th width='20%'>Поле</th>
			  <th width='10%'>Тип</th>
			  <th width='10%'>Длина</th>
			  <th width='30%'>Ограничение на NULL</th>
			  <th width='10%'>Позиция</th></tr>";
		while ($rows = ibase_fetch_object($result)) 
		{ 
			echo "<tr><td>$rows->RELATION_NAME</td><td>$rows->FIELD_NAME</td><td>$rows->TYPE_NAME</td><td>$rows->FIELD_LENGTH</td><td>$rows->NULL_FLAG</td><td>$rows->FIELD_POSITION</td></tr>";
		}
		echo "</table>";
	}

	/*
	 * Логика модели для таблицы SITE_USER
	 */
	function showUserTable($users, $withDeleteOption = false){
		echo '<table border="1">
		<tr>
			<th width="25%">Имя пользователя</th>
			<th width="25%">Телефон</th>
			<th width="25%">E-mail</th>
			<th width="25%">Адрес</th>
		</tr>';
		foreach($users as $user) {
			$id = $user['ID'];
			$name = $user['NAME'];
			$phone = $user['PHONE'];
			$email = $user['EMAIL'];
			$address = $user['ADDRESS'];
			echo "<tr>
				<td>$name</td>
				<td>$phone</td>
				<td>$email</td>
				<td>$address</td>";
			if($withDeleteOption) {
				echo"<td>
						<input type='checkbox' name='checkbox$id' value=$id/>
					</td>";
			}
			echo"</tr>";
		}
		echo '</table>';
	}

	function getUser($login, $password){
		global $host, $user, $pass;
		$dbh = ibase_connect($host, $user, $pass);
		$result = ibase_query($dbh, "SELECT * FROM SITE_USER WHERE NAME = '$login' AND PASSWORD = '$password'") or die ("Ошибка доступа к БД: " . ibase_errmsg());
		return ibase_fetch_assoc($result);  
	}

	function getUserById($id){
		global $host, $user, $pass;
		$dbh = ibase_connect($host, $user, $pass);
		$result = ibase_query($dbh, "SELECT * FROM SITE_USER WHERE ID = $id") or die ("Ошибка доступа к БД: " . ibase_errmsg());
		return ibase_fetch_assoc($result);
	}

	function addUser($name, $password, $phone, $email, $address) {
		global $host, $user, $pass;
		$dbh = ibase_connect($host, $user, $pass);
		$query = "INSERT INTO SITE_USER (NAME, PASSWORD, PHONE, EMAIL, ADDRESS) 
			VALUES ('$name', '$password', '$phone', '$email', '$address')";
		ibase_query($dbh, $query) or die ("Ошибка доступа к БД: " . ibase_errmsg());
	}

	/*
	 * Логика модели для таблицы ARTICLE
	 */
	function showArticleTable($articles, $withDeleteOption = false){
		echo '<table border="1">
		<tr>	
			<th width="10%">Название:</th>
			<th width="70%">Краткое описание:</th>
			<th width="10%">Дата размещения:</th>
			<th width="10%">Пользователь:</th> 
		</tr>';
		foreach($articles as $article) {
			$id = $article['ID'];  
			$name = $article['NAME'];
			$anotation = $article['ANOTATION'];
			$date = $article['INCOMING_DATE'];
			$user_name = getUserById($article['USER_ID'])['NAME'];
			echo "<tr>
				<td>
					<a href='index.php?page=item&id=$id';'>$name</a>
				</td>
				<td>$anotation</td>
				<td>$date</td>
				<td>$user_name</td>";
			if($withDeleteOption){
				echo "<td>
						<input type='checkbox' name='checkbox$id' value=$id/>
					</td>";
			}
			echo "</tr>";
		}
		echo '</table>';
	}

	function checkArticleFromPost() {
		return (!empty($_POST['name']) && !empty($_POST['description']) &&
			!empty($_POST['anotation']));
	}

	function getArticleById($id) {
		global $host, $user, $pass;
		$dbh = ibase_connect($host, $user, $pass);
		$result = ibase_query($dbh, "SELECT * FROM ARTICLE WHERE ID = $id") or die ("Ошибка доступа к БД: " . ibase_errmsg());
		return ibase_fetch_assoc($result);
	}

	function getArticleNextId() {
		global $host, $user, $pass;
		$dbh = ibase_connect($host, $user, $pass);
		$result = ibase_query($dbh, "SELECT GEN_ID(ARTICLE_ID_SEQ, 0) + 1 FROM RDB\$DATABASE") or die ("Ошибка доступа к БД: " . ibase_errmsg());
		return ibase_fetch_assoc($result);
	}

	function addArticle($article) {
		global $host, $user, $pass;

		$name = $article['NAME'];
		$anotation = $article['ANOTATION'];
		$description = isset($article['DESCRIPTION']) ? $article['DESCRIPTION'] : '';
		$image = isset($article['IMAGE']) ? "'".$article['IMAGE']."'" : 'null';
		$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '1';
		$dbh = ibase_connect($host, $user, $pass);
		$query = "INSERT INTO ARTICLE (NAME, ANOTATION, DESCRIPTION, IMAGE, USER_ID) 
			VALUES ('$name', '$anotation', '$description', $image, $user_id)"; 
		ibase_query($dbh, $query) or die ("Ошибка доступа к БД: " . ibase_errmsg());
	}

	function getArticles() {
		global $host, $user, $pass;
		$dbh = ibase_connect($host, $user, $pass);
		$query = "SELECT * FROM ARTICLE"; 
		$result = ibase_query($dbh, $query) or die ("Ошибка доступа к БД: " . ibase_errmsg());
		$articles = array();
		while ($row = ibase_fetch_assoc($result)) array_push($articles, $row);
		return $articles;
	}

	function updateArticle($id, $article) {
		global $host, $user, $pass;

		$name = $article['NAME'];
		$anotation = $article['ANOTATION'];
		$user_id = $article['USER_ID'];
		$description = isset($article['DESCRIPTION']) ? $article['DESCRIPTION'] : '';
		$image =  isset($article['IMAGE']) ? "'".$article['IMAGE']."'" : 'null';

		$dbh = ibase_connect($host, $user, $pass);
		$query = "UPDATE ARTICLE SET NAME = '$name', ANOTATION = '$anotation',
			DESCRIPTION = '$description', USER_ID = $user_id, IMAGE = $image WHERE ID = $id;";
		ibase_query($dbh, $query) or die ("Ошибка доступа к БД: " . ibase_errmsg());
	}

	function deleteArticle($id) {
		global $host, $user, $pass;
		$dbh = ibase_connect($host, $user, $pass);
		$query = "DELETE FROM ARTICLE WHERE ID = '$id'";
		ibase_query($dbh, $query)  or die ("Ошибка доступа к БД: " . ibase_errmsg());
	}
?>