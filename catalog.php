<?php 
	if (isset($_GET['delete']))
	{
		include 'includes/lib.inc.php';
		session_start();
		// Удаление загруженного изображения
		$path = $_SERVER['DOCUMENT_ROOT'].$_SESSION['Items'][$_GET['delete']]['image'];
		if (file_exists($path))
			unlink($path);
		// Удаление сессионной записи
		unset($_SESSION['Items'][$_GET['delete']]);
		header("Location: /index.php?page=catalog");
		exit;
	}
?>
<div class="content">
	<h2>Каталог статей</h2>
	<div class="line"></div>
	<br>
<?php
	if (!empty($_SESSION['Items']))
	{
		foreach ($_SESSION['Items'] as $id => $item)
		{
?>
			<p>№<?=$id+1?></p>
			<table style="width:100%">
			<tr>
				<th>Изображение</th>
				<td>
				<?php 
					if (isset($item['image']) && file_exists($_SERVER['DOCUMENT_ROOT'].$item['image']))
						echo '<br><img src="'.$item['image'].'">'; 
					else
						echo 'Отсутствует';
				?>
				</td>
			</tr>
			<tr>
				<th>Название</th>
				<td><?=$item['name']?></td>
			</tr>
			<tr>
				<th>Краткое описание</th>
				<td><?=$item['anotation']?></td>
			</tr>
			<tr>
				<th>Действия</th>
				<td>
					<button onclick="location.href='index.php?page=item&id=<?=$id?>'">
						Перейти к просмотру
					</button>
					<button onclick="location.href='catalog.php?delete=<?=$id?>'">
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