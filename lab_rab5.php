<div class="content">
	<h2>Лабораторная работа №5</h2>
	<div class="line"></div>
	<div class="center" style="width: auto">
<?php
	$tasks = array();
	
	$task = array();
	$task['ask'] = 'Восстановить файл prog1.pas, находящийся в каталоге C:\PROGRAMS (recover c:\programs\prog1.pas, RECOVER c:\PROGRAMS\prog1.PAS).';
	$task['answer_reg'] = '/^(recover|RECOVER)[\s]+c:\\\\(programs|PROGRAMS)\\\\prog1.(pas|PAS)$/i';
	$task['answer'] = '';
	array_push($tasks, $task);

	$task = array();
	$task['ask'] = 'Перейти из текущего каталога в каталог C:\DATA\TEXT (cd c:\data\text, chdir c:\data\text).';
	$task['answer_reg'] = '/^(cd|chdir)[\s]+c:\\\\data\\\\text$/i';
	$task['answer'] = '';
	array_push($tasks, $task);

	$task = array();
	$task['ask'] = 'Проверить носитель данных в дисководе А: на наличие ошибок с выводом на экран дисплея информации по каждому из проверенных файлов и информации по каждому из проверенных файлов и информации об обнаруженных дефектах диска. Ошибки должны исправляться после соответствующего запроса (chkdsk a:/f/v, chkdsk A: /v /f).';
	$task['answer_reg'] = '/^chkdsk[\s]+[aA]:[\s]*(\/f|\/v)[\s]*(\/v|\/f)$/i';
	$task['answer'] = '';
	array_push($tasks, $task);

	$task = array();
	$task['ask'] = 'Сравнить файл prog1.pas в каталоге D:\PASCAL с файлом prog2.pas, находящимся в текущем каталоге. Воспользоваться командой, не отображающей различия между файлами (comp d:\pascal\prog1.pas prog2.pas, comp prog2.pas d:\pascal\prog1.pas).';
	$task['answer_reg'] = '/^comp[\s]+((d:\\\\pascal\\\\prog1\.pas)|(prog2\.pas))[\s]+((prog2\.pas)|(d:\\\\pascal\\\\prog1.pas))$/i';
	$task['answer'] = '';
	array_push($tasks, $task);

	$task = array();
	$task['ask'] = 'Сравнить два диска при наличии одного дисковода А:. Сравниваться должны только первые стороны дисков (diskcomp a: a:/1, diskcomp a: b:/1, diskcomp b: a:/1).';
	$task['answer_reg'] = '/^diskcomp[\s]+((a:[\s]+[ab]{1}:\/1)|(b:[\s]+a:\/1))$/';
	$task['answer'] = '';
	array_push($tasks, $task);

	function getUsersAnswers(){
		$i = 0;
		$answers[] = array();
		while(isset($_POST["answer".$i])){
			$answers[$i] = $_POST["answer".$i];
			$i++;
		}
		return $answers;
	}

	function getRightAnswersCount($tasks, $answers){
		$count = 0;
		for($i = 0; $i < count($tasks); $i++){
			$count += preg_match($tasks[$i]['answer_reg'], $answers[$i]) ? 1 : 0;
		}
		return $count;
	}

	function getMark($count, $totalCount){
		if ($count != 0){
			$proc = $totalCount * 100 / $count;
			if ($proc >= 90) return 5;
			if ($proc >= 75) return 4;
			if ($proc >= 60) return 3;
		}
		return 2;
	}

	function showAsks($tasks){
		for($i = 0; $i < count($tasks); $i++){
			echo "<b>Вопрос №$i.</b><br/>".$tasks[$i]['ask']."<br/><br/>
			Ответ: <input name='answer$i' class='answer' type='text' maxlength='255'><br/><br/>";
		}
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$answers = getUsersAnswers();
		$count = getRightAnswersCount($tasks, $answers);
		$mark = getMark($count, count($tasks));
		echo "<table border='1'><tr>
		<th>Правильных ответов </th>
		<td>$count</td></tr>
		<tr><th>Оценка </th>
		<td>$mark</td>
		</tr></table><br/>";
	}
?>
		<form method="POST">
			<?php showAsks($tasks)?>
			<input type="submit" value="Ответить">
		</form>
	</div>
	<div style="height: 0px;"></div>
</div> <!-- content -->