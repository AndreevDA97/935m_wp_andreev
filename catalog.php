<?php
	if (isset($_GET['search']))
	{
		$twoSymbolsRegex = '/.{2,}/';
		$whiteSpaceRegex = '/[\s]+/';
		$notDigitRegex = '/[\D]{1,}/';

		$searchvalue = safestr($_GET['query']);
		$searchfield = safestr($_GET['search']);

		if ($searchvalue != '' && $searchfield != '' 
			&& preg_match($notDigitRegex, $searchvalue)
			&& preg_match($twoSymbolsRegex, $searchvalue))
		{
			$keywords = preg_split($whiteSpaceRegex, $searchvalue);
			$keywords = preg_grep($notDigitRegex, $keywords);
			$results = array();
			foreach($keywords as $word) {
				$results = array_merge($results, searchArticleByField($searchfield, $word));
			}
			if (count($results) == 0) {
				$searchFail = 'Записи не найдены.';
				$articles = getArticles($sortfield, $first, $skip);
			} else {
				$articles = $results; 
			}	
		} else {
			$searchFail = 'Введите корректную строку поиска!';
			$articles = getArticles($sortfield, $first, $skip);
		}
	}
	if (isset($_GET['delete']))
	{
		include 'includes/lib.inc.php';
		session_start();
		// Получение удаляемой записи
		$article = getArticleById($_GET['delete']);
		// Удаление загруженного изображения
		$path = $_SERVER['DOCUMENT_ROOT'].$article['IMAGE'];
		if (!empty($article['IMAGE']) && file_exists($path))
			unlink($path);
		// Удаление записи
		deleteArticle($_GET['delete']);
		header("Location: /index.php?page=catalog");
		exit;
	}
	
	$skip = 0;
	$first = 2;
	$sortfield = 'NAME';
	
	if (isset($_GET['sort'])) $sortfield = safestr($_GET['sort']); 
	if (isset($_GET['skip'])) $skip = safestr($_GET['skip']);
	if (isset($_GET['first'])) $first = safestr($_GET['first']);
	if (!isset($articles)) 
		$articles = getArticles($sortfield, $first, $skip);
?>
<div class="content">
	<h2>Каталог статей</h2>
	<div class="line"></div>
	<br>
	<a href="index.php?page=catalog&sort=NAME">Сортировка по названию</a>
	<a href="index.php?page=catalog&sort=ANOTATION">Сортировка по краткому описанию</a>
	<br>
	<form method="GET" action="index.php?page=catalog">
		<input name="page" type="hidden" value="catalog" />
		Условия отбора:
		<select name="search">
			<option value="NAME">Название статьи содержит</option>
			<option value="ANOTATION">Описание содержит</option>
		</select>
		<input name="query" type="text" />
		<input type="submit" value="Применить" />
	</form>
	<?php 
		if(!empty($searchFail)) 
			echo '<label class="error">'.$searchFail.'</label><br>';
		echo getPageMenu(2);
	?>
	<br>
	<br>
<?php
	if (!empty($articles))
	{
		foreach ($articles as $id => $item)
		{
?>
			<p>№<?=$item['ID']?></p>
			<table style="width:100%">
			<tr>
				<th>Изображение</th>
				<td>
				<?php 
					if (isset($item['IMAGE']) && file_exists($_SERVER['DOCUMENT_ROOT'].$item['IMAGE']))
						echo '<br><img src="'.$item['IMAGE'].'">'; 
					else
						echo 'Отсутствует';
				?>
				</td>
			</tr>
			<tr>
				<th>Название</th>
				<td><?=$item['NAME']?></td>
			</tr>
			<tr>
				<th>Краткое описание</th>
				<td><?=$item['ANOTATION']?></td>
			</tr>
			<tr>
				<th>Действия</th>
				<td>
					<button onclick="location.href='index.php?page=item&id=<?=$item['ID']?>'">
						Перейти к просмотру
					</button>
					<button onclick="location.href='catalog.php?delete=<?=$item['ID']?>'">
						Удалить
					</button>
				</td>
			</tr>
			</table>
			<br>
<?php
		}
	}
?>
	<button onclick="location.href='index.php?page=add'">Добавить</button>
</div> <!-- content -->