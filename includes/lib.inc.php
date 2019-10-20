<?php
	// формирование меню сайта
	function getMenu($menu)
	{
		echo '<div class="nav">';
			foreach ($menu as $link => $href)
			{
				echo '<div class="vertical-menu">';
				echo "<h4><a href=\"{$href}\">{$link}</a></h4>";
				echo '</div>';
			}
		
		echo '</div>';
	}
	
	// возведение $y в степень $x
	function power($y, $x) {
		$result = exp($x*log(abs($y)));
		return $x & 1 && $y < 0 ? -$result : $result;
	}
?>