<?php 
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
?>
<div class="content">
	<h2>Каталог статей</h2>
	<div class="line"></div>
	<br>
<?php
	$articles = getArticles();
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