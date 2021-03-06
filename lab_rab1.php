<div class="content">
	<style type="text/css">
		.content label { display: block; }
		.content table { border-collapse: collapse; }
		.content tr { height: 50px; }
		.content td, th {
			border: 1px solid #000;
			width: 50px;
		}
		.content .widthfix {
			visibility: hidden;
			height: 0;
		}
		.content .blue { background-color: blue; }
		.content .green { background-color: green; }
		.content .red { background-color: red; }
		.content .yellow { background-color: yellow; }
	</style>
	
	<h2>Лабораторная работа №1</h2>
	<div class="line"></div>
	<h4>Задание 1.</h4><br />
	<table>
		<tr>
			<td rowspan="2" colspan="2" class="blue"></td>
			<td rowspan="2" colspan="3"></td>
			<td rowspan="2" colspan="5"></td>
			<td rowspan="2" colspan="3"></td>
		</tr>
		<tr></tr>
		<tr>
			<td rowspan="4" colspan="1"></td>
			<td rowspan="4" colspan="1"></td>
			<td rowspan="2" colspan="8" class="green"></td>
			<td colspan="3" class="red"></td>
		</tr>
		<tr>
			<td colspan="3"></td>
		</tr>
		<tr>
			<td rowspan="2" colspan="6"></td>
			<td rowspan="2"></td>
			<td rowspan="2" class="yellow"></td>
			<td rowspan="2" colspan="3"></td>
		</tr>
		<tr></tr>
		<tr class="widthfix">
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</table>

	<h4>Задание 2.</h4><br />
	<form action="">
		<p>
			<label>Фамилия Имя Отчество</label>
			<input type="text" />
		</p>
		<p>
			<label>Дата рождения</label>
			<input type="text" />
		</p>
		<p>
			<label>Телефон</label>
			<input type="text" />
		</p>
		<p>
			<label>E-mail</label>
			<input type="text" />
		</p>
		<p>
			<label>Должность</label>
			<input type="text" />
		</p>
		<p>
			<label>Желаемая зарплата</label>
			<input type="text" />
		</p>
		<p>
			<label>График работы</label>
			<select>
				<option value="0" selected="selected">Полный день</option>
				<option value="1">Сменный график</option>
				<option value="2">Гибкий график</option>
				<option value="3">Удаленная работа</option>
				<option value="4">Вахтовый метод</option>
			</select>
		</p>
		<p>
			<label>Готовность к командировкам <input type="checkbox" /></label>
		</p>
		<p>
			<label>Дополнительная информация</label>
			<textarea rows="3" cols="24"></textarea>
		</p>
		<p><input type="submit" value="Отправить форму" /></p>
	</form>
</div> <!-- content -->