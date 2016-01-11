<?
include_once "inc/lib.inc.php"; // + библиотека функций
include_once "inc/config.inc.php"; //+ основной файл с конфигурационн.настройками
ob_start(); // Стартуем буфферизацию контента
?>
<html>
<head>
	<title>Форма оформления заказа</title>
</head>
<body>
	<h1>Оформление заказа</h1>
	<?="<p align='center'> Вернуться в <a href='catalog.php'> Каталог товаров </a> </p>"; ?>
	<form action="<?= $_SERVER['REQUEST_URI']?>" method="POST"> <!-- форма ввода данных Юзера -->
		<p>Ваше ФИО: <input type="text" name="name" size="45" value="<?=$name ?>">
		<p>Ваш E-mail: <input type="text" name="email" size="20" value="<?=$email ?>">
		<p>Ваш телефон: <input type="text" name="phone" size="15"value="<?=$phone ?>">
		<p>Адрес доставки: <input type="text" name="address" size="50" value="<?=$address ?>">
			<p><input type="submit" value="Оформить заказ"> 
				<input type="reset" value="Очистить данные">
	</form>
</body>
</html>
<?
// filters param. from form ввода данных Юзера: START
if ( ($_SERVER['REQUEST_METHOD']=="POST")     // если была отправлена форма c данными от Юзера методом POST
	&& isset($_POST['name']) && !empty($_POST['name'])      // проверка существуют ли поля и не пустые ли они
	&& isset($_POST['email']) && !empty($_POST['email']) // проверка существуют ли поля и не пустые ли они
	&& isset($_POST['phone']) && !empty($_POST['phone'])    // проверка существуют ли поля и не пустые ли они
	&& isset($_POST['address']) && !empty($_POST['address'])    // проверка существуют ли поля и не пустые ли они
	){ 
		$name=f_clearData($_POST['name'],'string_forfile'); 
		$email=f_clearData($_POST['email'],'string_forfile'); 
		$phone=f_clearData($_POST['phone'],'string_forfile');
		$address=f_clearData($_POST['address'],'string_forfile');
		$orderid= $basket['orderid']; // вынимаем из Массива-Корзины-Куки именно уникал.идентификатор Юзера
		$datetime= time(); // ставим в момент POST'а current TIMESTAMP. (Также можно с помощью $_SERVER['REQUEST_TIME'])
		$ip_user= $_SERVER['REMOTE_ADDR']; // считываем IP-adress Юзера

		$path="$name|$email|$phone|$address|$orderid|$datetime|$ip_user\r\n"; //формир.строку из получен.данных для записи в файл orders.txt
		file_put_contents('orders_log/'.ORDERS_LOG, $path, FILE_APPEND);  // открываем соед.с файлом и записываем в него сформированную строку с данными
		
		if(!f_resaveOrder($orderid, $datetime)) { echo "Ошибка приложения оформлениЯ заказа";} // Пересохранеие товаров с Корзины юзера(КУКА-МАССИВ $basket + МАССИВ($items)-это выборка товаров из catalog БД,в зависимости от того,что в $basket) в Заказы(табл.orders) БД.
		else {
			echo $alert= "Ваш Заказ принят!";
echo <<<END
<div> <input type='button' value='OK!' onClick="location.href='catalog.php'"> </div> 
END;
		}
} 
	elseif ($_SERVER['REQUEST_METHOD']!=="POST") {    // если НЕ была отправлена форма c данными от Юзера методом POST
		echo " "; 
	}
	elseif (($_SERVER['REQUEST_METHOD']=="POST") && empty($name) or empty($email) or empty($phone) or empty($address)) {  // если была отправлена форма c данными от Юзера методом POST но такие-то поля пустые
		echo $alert= "Вы заполнили не все имеющиеся поля Формы!"; 
	}
// filters param. from form ввода данных Юзера: END
		// если нужно после оформления заказа остаться на этой же странице, то в строке 46 можно так: onClick="location.href='{$_SERVER['REQUEST_URI']}'">
?>