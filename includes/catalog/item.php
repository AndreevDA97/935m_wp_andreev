<?php
	if (!isset($_GET['id'])) {
		header("Location: /index.php?page=catalog");
		exit;
	}
	$id = safestr($_GET['id']);
	$item = getArticleById($id);
?>
<div class="content">
	<h2>Просмотр статьи №<?=$id?></h2>
	<div class="line"></div>
	<br>
	<form method='POST'>
		<p><b>Изображение:</b> 
		<?php 
			if (isset($item['IMAGE']) && file_exists($_SERVER['DOCUMENT_ROOT'].$item['IMAGE']))
				echo '<br><img src="'.$item['IMAGE'].'">'; 
			else
				echo 'Отсутствует';
		?>
		</p>
		<p><b>Название статьи:</b> <?=$item['NAME']?></p>
		<p><b>Краткое описание:</b> <?=$item['ANOTATION']?></p>
		<p><b>Полное описание:</b> <?=$item['DESCRIPTION']?></p>
	</form>
	<button onclick="location.href='index.php?page=edit&id=<?=$id?>'">
		Редактировать статью
	</button>
</div> <!-- content -->