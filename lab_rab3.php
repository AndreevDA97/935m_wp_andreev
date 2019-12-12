<div class="content">
	<h2>Лабораторная работа №3</h2>
	<div class="line"></div>
	<div class="center" style="width: auto">
		<h4>Задание 1.</h4><br />
		<form action="index.php?page=lab_rab3" method="post">
			<p>
				<label>Система счисления</label>
				<select name="values_base">
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10" selected="selected">10</option>
				</select>
			</p>
			<p>
				<label>Число 1</label>
				<input type="text" name="value1" />
			</p>
			<p>
				<label>Операция</label>
				<select name="operation">
					<option value="+" selected="selected">+</option>
					<option value="-">-</option>
					<option value="*">*</option>
					<option value="/">/</option>
				</select>
			</p>
			<p>
				<label>Число 2</label>
				<input type="text" name="value2" />
			</p>
			<p><input type="submit" value="Вычислить" /></p>
		</form>
		<?php 
			if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
				$operation = $_POST['operation'];
				$values_base = $_POST['values_base'];
				$value1 = $_POST['value1']; $value2 = $_POST['value2'];
				if (empty($values_base) || empty($value1) 
					|| empty($operation) || empty($value2))
						$error = 'Ошибка: форма заполнена не полностью.';
				if (!isset($error)) {
					$available_chars = substr('0123456789ABCDEF', 0, $values_base);
					for ($i = 0; $i < strlen($value1); $i++) {
						if (strpos($available_chars, $value1[$i]) === false) {
							$error = 'Ошибка: некорректный ввод 1 числа.';
							break;
						}
					}
					for ($i = 0; $i < strlen($value2); $i++) {
						if (strpos($available_chars, $value2[$i]) === false) {
							$error = 'Ошибка: некорректный ввод 2 числа.';
							break;
						}
					}
				}
				if (!isset($error)) {
					$value1 = base_convert($value1, $values_base, 10);
					$value2 = base_convert($value2, $values_base, 10);
					switch($operation) {
						case '+': 
							$result = $value1 + $value2;
							break;
						case '-': 
							$result = $value1 - $value2;
							break;
						case '*': 
							$result = $value1 * $value2;
							break;
						case '/': 
							$result = $value1 / $value2;
							break;
					}
					$result = base_convert($result, 10, $values_base);
		?>
					<br>
					<table>
						<tr>
							<td><b>Система счисления:</b></td>
							<td><?=@$_POST['values_base']?></td>
						</tr>
						<tr>
							<td><b>Число 1:</b></td>
							<td><?=@$_POST['value1']?></td>
						</tr>
						<tr>
							<td><b>Операция:</b></td>
							<td><?=@$_POST['operation']?></td>
						</tr>
						<tr>
							<td><b>Число 2:</b></td>
							<td><?=@$_POST['value2']?></td>
						</tr>
						<tr>
							<td><b>Результат:</b></td>
							<td><?=$result?></td>
						</tr>
					</table>
			<?php 
				} else {
					echo '<label class="error">'.$error.'</label>';
				}
			} ?>
	</div>
	<div style="height: 0px;"></div>
</div> <!-- content -->