<?
include_once "inc/lib.inc.php"; // + библиотека функций
include_once "inc/config.inc.php"; //+ основной файл с конфигурационн.настройками
ob_start(); // Стартуем буфферизацию контента
?>
<html>
<head>
	<title>Каталог товаров</title>
</head>
<body>
<p align="center"> <a href='/school_portal/index.php'>  На Главную </a> </p>
<p>Товаров в <a href="basket.php">корзине</a>: <?= $count?> </p>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, (руб.)</th>
	<th>В корзину</th>
</tr>

<?
// Block: вывод Списка всех товаров из Каталога: START
		$all_catalog=f_showAllCatalog(); // результат отработки ф-и(асс.массив выборки из БД) ложим в $all_catalog
if(!is_array($all_catalog)) {   // если пришел не массив(т.е.тут если FALSE), то выводим сообщение. (Кстати,если тут проверять на FALSE, то тройным равно!!)
	echo "Извлечение запроса из БД НЕ прошло! Код ошибки № n/n: "; 
}
if(!empty($all_catalog)) { // если мы тут, значит в $all_catalog массив, если он Не пустой, то выводим все в заданном формате
	echo "Всего товаров (шт.) - ".mysqli_affected_rows($link)."<br>"; // корректно ли работает эта ф-я ??? 

	foreach ($all_catalog as $catalog) { // мет.GET будет уходить идентифик.(id) товара
		echo"<tr>
				<td> {$catalog['title']} </td>
				<td> {$catalog['author']} </td>
				<td> {$catalog['pubyear']} </td>
				<td> {$catalog['price']} </td>
				<td> <a href='{$_SERVER['SCRIPT_NAME']}?id={$catalog['id']}'> В корзину </a> </td>
			</tr>";
	}
}
else { echo "В Каталоге БД нет товаров!"; }
// Block: вывод Списка всех товаров из Каталога: END

// Block: добавление товара из Каталога в КОРЗИНУ Юзеру(по $id): START
if(isset($_GET['id'])) { $id= f_clearData($_GET['id'],'integer'); } // принимаем,инициализ.,фильтруем пар.(id) - идентификатор товара из Каталога БД 

if($id==='0'): header("Location: " .$_SERVER['SCRIPT_NAME']); exit;
elseif($id): $quantity = 1; // кол-во товара в КОРЗИНЕ Юзера со значением по умолчанию =1 
			 f_addBasket($id, $quantity); // ДОБАВЛЕНИЕ ТОВАРА в КОРЗИНУ Юзера
	  		header("Location: " .$_SERVER['SCRIPT_NAME']); // перезапрашиваем обратно страницу catalog.php 			
endif;
// Block: добавление товара из Каталога в КОРЗИНУ Юзеру(по $id): END
?>
</table>
</body>
</html>