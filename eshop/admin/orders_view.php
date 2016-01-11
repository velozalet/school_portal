<?
include_once "lib.inc.php"; // + библиотека функций
include_once "config.inc.php"; //+ основной файл с конфигурационн.настройками
ob_start(); // Стартуем буфферизацию контента
?>
<html>
<head>
	<div align='center'> <a href='index.php'>АДМИНКА-ГЛАВНАЯ</a> </div>
	<br>

	<title>Список всех ЗАКАЗОВ</title>
</head>
<body>
<h1>Список всех ЗАКАЗОВ:</h1>
<?
$allorders=f_getOrders(); // полученный наш 3-х мерный МАССИВ передаем $allorders
						 //print_r($allorders); // при тестировании(еще до вывода данных),если нужно расскоментировать,- покажет что пришло из ф-и f_getOrders() и в ккаком виде
if(!is_array($allorders)): return FALSE;
	
else: $i=0; // инициализ.счетчик для нумерации заказов по порядку при выводе
	foreach ($allorders as $order_1) {  //open foreach  LEVEL-1
		$i++;
		$dt=date("d.m.Y H:i", $order_1['datetime']); // форматируем TIMESTAMP в дату-время
		echo "<hr>
			<h2> Заказ № $i </h2>
			<p><b> Заказчик</b>: {$order_1['name']} </p>
			<p><b> Email</b>: {$order_1['email']} </p>
			<p><b> Телефон</b>: {$order_1['phone']} </p>
			<p><b> Адрес доставки</b>: {$order_1['address']} </p>
			<p><b> Адрес ID</b>: {$order_1['ip_user']} </p>
			<p><b> Дата размещения заказа</b>: $dt </p>
		
			<h3 align='center'>Купленные товары:</h3>
			<table border='1' cellpadding='5' cellspacing='0' width='90%''>
				<tr>
					<th>N п/п</th>
					<th>Название</th>
					<th>Автор</th>
					<th>Год издания</th>
					<th>Цена, руб.</th>
					<th>Количество</th>
				</tr>";
			 
			$ii=0; // инициализ.счетчик для нумерации товаров в таблице к Заказу
			$summ=0; // инициализ. для хранения общей суммы товаров в таблице для определенного заказа
		foreach ($order_1['goods'] as $order) { //open foreach  LEVEL-2
			$ii++; 
			echo"<tr>
					<td> $ii </td>
					<td> {$order['title']} </td>
					<td> {$order['author']} </td>
					<td> {$order['pubyear']} </td>
					<td> {$order['price']} </td>
					<td> {$order['quantity']} </td>
				</tr>";
			$summ= $summ +( $order['price'] * $order['quantity'] ); // подсчитываем сумму всех товаров в корзине пользователя
		} //close foreach  LEVEL-2

		echo "</table>
			<p> Всего товаров в заказе на сумму: $summ руб.</p>";
	} //close foreach  LEVEL-1	
endif;
?>

</body>
</html>