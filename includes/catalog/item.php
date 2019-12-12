<?php
	if (!isset($_GET['id'])) {
		header("Location: /index.php?page=catalog");
		exit;
	}
	$id = safestr($_GET['id']);
	$item = $_SESSION['Items'][$id];
?>
<div class="content">
	<h2>Просмотр статьи №<?=$id+1?></h2>
	<div class="line"></div>
	<br>
	<form method='POST'>
		<p>Изображение: 
		<?php 
			if (isset($item['image']) && file_exists($_SERVER['DOCUMENT_ROOT'].$item['image']))
				echo '<br><img src="'.$item['image'].'">'; 
			else
				echo 'Отсутствует';
		?>
		</p>
		<p>Название статьи: <?=$item['name']?></p>
		<p>Краткое описание: <?=$item['anotation']?></p>
		<p>Полное описание: <?=$item['description']?></p>
	</form>
	<button onclick="location.href='index.php?page=edit&id=<?=$id?>'">
		Редактировать статью
	</button>
</div> <!-- content -->