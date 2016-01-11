<?
session_start();  //открываем сессию
header("Content-type:text/html; charset=utf-8"); // передаем заголовок с нужной кодировкой 

// Если 1-й запуск "Теста"
if(!isset($_SESSION['test']) && !isset($_POST['question'])) {  //если нет Сессии с именем 'test'(т.е.нет переменной Глоб.Масс. $_SESSION с именем 'test') и нет перем.Глоб.массива $_POST['question'] (которая отвечает за порядковый номер вопроса в тесте)
	$question ='0'; // тогда инициал.переменную для номера текущего вопроса Теста
	$title='Пройдите тест'; // тогда инициал.переменную для динамического заголовка в верхней части страницы 
}
else { if($_POST['question'] !== '1')  // если $_POST['question'] НЕ равна 1, т.е. 2,3...(потому что question будет уже =1 всего только после нажатия кнопки "START TEST",а данных еще не будет,- писать в массив нечего еще,поэтому начнем записывать данные со следующего шага,когда $question будет равна 2 и более) 
			$_SESSION['test'][] = $_POST['answer']; // создаем сессионную пер.$_SESSION['test'] как массив,куда ложим массив ответов с формы

			$question = $_POST['question']; // инициализируем $question из данных пришедших методом POST (передается скрыто (hidden)
			$title = $_POST['title']; // инициализируем $title из данных пришедших методом POST (передается скрыто (hidden)
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<title>ТECT</title>
</head>
<body>

<table width="50%" border="1" align='center'>

<tr>
	<td align="center">
		<!-- HEADER START-->   
		<table width="100%">
			<tr>
				<td align="center">
					<h1> <?= $title ?> </h1> <!-- выводим динамический заголовок для этой страницы  -->
					<p><a href='/school_portal/index.php'> Прервать тест и вернуться на сайт</a></p>
				</td>
			</tr>
		</table>
		<!-- HEADER END    http://localhost/school_porta-->
	</td>
</tr>

<tr>
	<td> <!-- MAIN CONTENT START-->	
<? 
switch($question):  // в зависсимости от № вопроса подключ.соответствующий файл с контентом(форма с вопросами)                         
	case '0': include 'start.php'; break;
	case '1': include 'q1.php'; break;
	case '2': include 'q2.php'; break;
	case '3': include 'q3.php'; break;
		default: include 'result.php'; // если не 0,1,2,3,- то значит все вопросы теста Юзер отправил( вообще тут $question будет =4), а значит инклюдим файл с выводом результата Теста
endswitch;
?>	
	</td><!-- MAIN CONTENT END-->
</tr>
</table>

</body>
</html>