<?php
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
?>