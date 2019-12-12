<div class="content">
	<h2>Лабораторная работа №2</h2>
	<div class="line"></div>
	<div class="center" style="width: auto">
		<h4>Задание 1.</h4><br />
		<?php 
			echo '<table>';
			echo '<tr><th>Переменная</th><th>Значение</th></tr>';
			foreach ($_SERVER as $key => $value) {
				echo "<tr><td>{$key}</td><td>{$value}</td></tr>";
			}
			echo '</table>';
		?>
		<h4>Задание 2.</h4><br />
		<p>
			<?php 
				$y = rand(0, 10); 
				$x = rand(0, 10);
				$result = power($y, $x);
				echo "Результат возведения числа {$y} в степень {$x} = {$result}" 
			?>
		</p>
	</div>
	<div style="height: 0px;"></div>
</div> <!-- content -->