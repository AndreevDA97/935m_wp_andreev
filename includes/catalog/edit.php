<?php
	if (isset($_SESSION['image'])) {
		$loaded_image = $_SESSION['image'];
		unset($_SESSION['image']);
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		include '../lib.inc.php';
		session_start();
		$id = safestr($_POST['id']);
		if (isset($_POST['loadimg'])) 
		{
			$item = array();
			$item['name'] = safestr($_POST['name']);
			$item['anotation'] = safestr($_POST['anotation']);
			$item['description'] = safestr($_POST['description']);
			$_SESSION['TempItem'] = $item;

			if (!empty($_FILES['image']['name']))
			{
				$name = resize($_FILES['image']);
				$newfile = '/uploads/item_'.uniqid().'.tmp';
				$temp_path = $_SERVER['DOCUMENT_ROOT'].$newfile;
				if (copy($name, $temp_path))
					unlink($name);
				$_FILES['image']['tmp_name'] = $temp_path;
				$_FILES['image']['netpath'] = $newfile;
				$_SESSION['image'] = $_FILES['image'];
				header("Location: /index.php?page=edit&id={$id}");
				exit;
			}
			else {
				$_SESSION['image'] = 'empty';
				header("Location: /index.php?page=edit&id={$id}");
				exit;
			}
		}
		else if (isset($_POST['save']))
		{
			if (!empty($_POST['name']) && !empty($_POST['anotation']) 
				&& !empty($_POST['description']) && !empty($_POST['image']))
			{
				$item = $_SESSION['Items'][$id];
				$item['name'] = safestr($_POST['name']);
				$item['anotation'] = safestr($_POST['anotation']);
				$item['description'] = safestr($_POST['description']);
				
				$loaded_image = safestr($_POST['image']);
				if (isset($loaded_image)) {
					if ($loaded_image == 'empty') {
						$path = $_SERVER['DOCUMENT_ROOT'].$item['image'];
						if (file_exists($path))
							unlink($path);
						unset($item['image']);
					} else {
						$uploadfile = $_SERVER['DOCUMENT_ROOT'].'/images/catalog/'.$id.'.jpg';
						if (copy($loaded_image, $uploadfile))
							unlink($loaded_image);
						$item['image'] = '/images/catalog/'.$id.'.jpg';
					}
				}

				$_SESSION['Items'][$id] = $item;
				header("Location: /index.php?page=item&id={$id}");
				exit;
			}
			else {
				$_SESSION['error'] = 'Полностью заполните форму';
				header("Location: /index.php?page=edit&id={$id}");
				exit;
			}
		}
	}
	
	if (!isset($_GET['id'])) {
		header("Location: /index.php?page=catalog");
		exit;
	}
	$id = safestr($_GET['id']);

	if (isset($_SESSION['TempItem']))
	{
		$item = $_SESSION['TempItem'];
		unset($_SESSION['TempItem']);
	}
	else
		$item = $_SESSION['Items'][$id];

	$error = safestr(@$_SESSION['error']);
	unset($_SESSION['error']);
?>
<div class="content">
	<h2>Редактирование статьи №<?=$id+1?></h2>
	<div class="line"></div>
	<br>
	<form action="includes/catalog/edit.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" value="<?=$id?>" name="id">
		<p>Название статьи:<input type="text" name="name" value="<?=$item['name']?>"></p>
		<p>Краткое описание:<input type="text" name="anotation" value="<?=$item['anotation']?>"></p>
		<p>Полное описание:<textarea name="description"><?=$item['description']?></textarea></p>
		<p>Изображение:<input name="loadimg" type='submit' value='Загрузить'> <input type="file" name="image"></p>
		<?php
			if (isset($loaded_image)) {
				if ($loaded_image == 'empty') {
					echo '<input type="hidden" name="image" value="empty">';
				} else {
					echo "Изображение загружено!</br>
					Имя файла: ".$loaded_image['name']."</br>
					Тип файла: ".$loaded_image['type']."</br>
					Размер файла: ".$loaded_image['size']."</br>";
					echo '<img src="'.$loaded_image['netpath'].'">';
					echo '<input type="hidden" name="image" value="'.$loaded_image['tmp_name'].'">';
				}
			}
			else if (isset($item['image'])) {
				echo '<img src="'.$item['image'].'">';
			}
		?>

		<label class="error"><?=@$error?></label>
		<p><input name="save" type='submit' value='Сохранить изменения'></p>
	</form>
</div> <!-- content -->