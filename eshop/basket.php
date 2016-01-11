<?
include_once "inc/lib.inc.php"; // + библиотека функций
include_once "inc/config.inc.php"; //+ основной файл с конфигурационн.настройками
ob_start(); // Стартуем буфферизацию контента
?>
<html>
<head>
	<title>Корзина пользователя</title>
</head>
<body>
	<h1>Ваша корзина</h1>
<?="<p align='right'> Вернуться в <a href='catalog.php'> Каталог товаров </a> </p>"; ?>

<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>N п/п</th>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>Количество</th>
	<th>Удалить</th>
</tr>
<?
// Block: вывод Списка всех товаров КОРЗИНЫ Юзера: START 
$my_basket= f_myBasket(); // результат отработки ф-и(асс.массив выборки из БД) ложим в $all_catalog. Может прийти:FALSE/ массив с данными ( пустой массив будет расценен тут как FALSE)
if(!is_array($my_basket)) {   // если пришел не массив(т.е.тут если FALSE) то выводим сообщение. (Кстати,если тут проверять на FALSE, то тройным равно!!)
	echo "Извлечение запроса из БД НЕ прошло! Код ошибки № n/n: "; 
}
if(!empty($my_basket)) { // если мы тут,то в($my_basket) не пустой массив,значит выводим все в заданном формате
	$i=0; // инициализ.счетчик для нумерации товара в таблице

	foreach ($my_basket as $item) {
		$i++; 
		echo"<tr>
				<td> $i </td>
				<td> {$item['title']} </td>
				<td> {$item['author']} </td>
				<td> {$item['pubyear']} </td>
				<td> {$item['price']} </td>
				<td> {$item['quantity']} </td>
				<td> <a href='$_SERVER[REQUEST_URI]?del={$item['id']}'> Delete </a> </td>
			</tr>";
		$summ= $summ +( $item['price'] * $item['quantity'] ); // подсчитываем сумму всех товаров в корзине пользователя 	
	}
}
else { echo "В Корзине нет товаров!"; }
// Block: вывод Списка всех товаров КОРЗИНЫ Юзера: END
?>
</table>

<p> Всего товаров в корзине (шт.): <?=$count ;?> <br> На сумму: <?=$summ;?> руб. </p>

<?
// помещаем в $order_butt кнопку(Оформить заказ!)
$order_butt=<<<END
<div align='center'>
	<input type='button' value='Оформить заказ!'
                      onClick="location.href='orderform.php'">
</div>
END;

// вывод кнопки (Оформить заказ!)
echo ($summ===0) ? " " : $order_butt; //если $count=0 (т.е.НЕТ товаров в корзине), то не выводим кнопку,иначе(значит есть хоть один товар),- выводим кнопку

//Block: Delete товар из Корзины Юзера: START
if(isset($_GET['del'])): // если глоб.переменная такая послалась именно методом GET
	$del=f_clearData($_GET['del'],'integer'); // то принимаем, отфильтровываем как число,целое,положительное.Тут будет либо число(целое,положит.) либо 0(NULL)
	f_deleteFromBasket($del); // передаем ($del) ф-и на удаление товара по такому ключу как и значение в($del)
	header("Location: " .$_SERVER['SCRIPT_NAME']); // перезапрашиваем обратно эту же страницу
endif;
//Block: Delete товар из Корзины Юзера: END
//-----------------------------------------
print_r($basket); // для проверки,отладки кода что приходит здесь в наш МАССИВ-КОРЗИНУ-КУКУ ($basket). ПОТОМ УБРАТЬ!!
echo "<br>";
print_r($items); // для проверки,отладки кода что приходит здесь в наш МАССИВ-КОРЗИНУ-КУКУ ($items). ПОТОМ УБРАТЬ!!
?>
</body>
</html>