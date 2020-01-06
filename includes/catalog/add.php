<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		include '../lib.inc.php';
		session_start();
		if (checkArticleFromPost())
		{
			$item = array();
			$item['NAME'] = safestr($_POST['name']);
			$item['ANOTATION'] = safestr($_POST['anotation']);
			$item['DESCRIPTION'] = safestr($_POST['description']);
			if (!empty($_FILES['image']['name']))
			{
				$name = resize($_FILES['image']);
				$newid = getArticleNextId();
				$newfile = '/images/catalog/'.$newid.'.jpg';
				$newpath = $_SERVER['DOCUMENT_ROOT'].$newfile;
				if (copy($name, $newpath))
					unlink($name);
				$item['IMAGE'] = $newfile;
			}
			
			addArticle($item);
			header("Location: /index.php?page=catalog");
			exit;
		}
		else {
			$_SESSION['error'] = 'Полностью заполните форму';
			header("Location: /index.php?page=add");
			exit;
		}
	}
	
	$error = safestr(@$_SESSION['error']);
	unset($_SESSION['error']);
?>
<div class="content">
	<h2>Добавление статьи</h2>
	<div class="line"></div>
	<br>
	<form action="includes/catalog/add.php" method="POST" enctype="multipart/form-data">
		<p>Название статьи:<input type="text" name="name"></p>
		<p>Краткое описание:<input type="text" name="anotation"></p>
		<p>Полное описание:<textarea name="description"></textarea></p>
		<p>Изображение:<input type="file" name="image"></p>

		<label class="error"><?=@$error?></label>
		<p><input type='submit' value='Добавить'></p>
	</form>
</div> <!-- content -->
