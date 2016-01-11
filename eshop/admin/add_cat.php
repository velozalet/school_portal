<?
//include "..secure/login.php";
include_once "lib.inc.php"; // + библиотека функций
include_once "config.inc.php"; //+ основной файл с конфигурационн.настройками
ob_start(); // Стартуем буфферизацию контента
?>
<?
// filters param. from form ввода данных Юзера и его сообщения: START
if ( ($_SERVER['REQUEST_METHOD']=="POST")     // если была отправлена форма c данными от Юзера методом POST
	&& isset($_POST['title']) && !empty($_POST['title'])
	&& isset($_POST['author']) && !empty($_POST['author'])
	&& isset($_POST['pubyear']) && !empty($_POST['pubyear'])
	&& isset($_POST['price']) && !empty($_POST['price'])
	&& isset($_POST['price1']) && !empty($_POST['price1'])  // проверка существуют ли поля и не пустые ли они
	){ 
		$title= f_clearData($_POST['title'],'string_to_db_prepare'); 
		$author= f_clearData($_POST['author'],'string_to_db_prepare'); 
		$pubyear= f_clearData($_POST['pubyear'],'integer');
		$price= f_clearData($_POST['price'],'integer'); // если цена будет вбиваться в одно поле,то сдесь 2-м параметром передать float_notsign и в БД не забыть поставить параметр в соответст.поле "DOUBLE" и в mysqli_stmt_bind_param "d"
		$price1= f_clearData($_POST['price1'],'integer');
		$price= $price.'.'.$price1; 

		f_addCatalog($title, $author, $pubyear, $price);
		$alert= "Товар успешно добавлен в БД"; header("Refresh:2; {$_SERVER['REQUEST_URI']}");
	}
	elseif ($_SERVER['REQUEST_METHOD']!=="POST") {    // если была отправлена форма c данными от Юзера методом POST
		$alert= " "; 
	}
	elseif (($_SERVER['REQUEST_METHOD']=="POST") && empty($title) or empty($author) or empty($pubyear) or empty($price)) {  // если была отправлена форма c данными от Юзера методом POST
		$alert= "Вы заполнили не все имеющиеся поля Формы!"; 
	}
	elseif ( !f_addCatalog($title, $author, $pubyear, $price) ) {
		$alert= "ERROR: добавления товара в БД!"; 
	}
?>
<html>
	<div align='center'> <a href='index.php'>АДМИНКА-ГЛАВНАЯ</a> </div>
	<br>
	
<head> <title>Форма добавления товара в каталог</title> </head>
<body>
	<form action="<?= $_SERVER['REQUEST_URI']?>" method="POST">
		<p>Название: <input type="text" name="title" size="100">
		<p>Автор: <input type="text" name="author" size="50">
		<p>Год издания: <input type="text" name="pubyear" size="4">
		<p>Цена: <input type="text" name="price" size="6"> руб. <input type="text" name="price1" size="2"> коп.
		<p><input type="submit" value="ADD to CATALOG">
	</form>
</body>
</html>
<?=$alert; ?>
<hr>