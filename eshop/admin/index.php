<?
ob_start(); // Стартуем буфферизацию контента
include_once "lib.inc.php"; // + библиотека функций  
include_once "config.inc.php"; //+ основной файл с конфигурационн.настройками
?>
<?
if(isset($_GET['logout'])): // если передан мет.GET ($logout)- т.е.если нажали ссылку "Завершить сеанс"
	$logout= f_clearData($_GET['logout'],'string_to_lower'); // принимаем ($logout), фильтруем
	f_logOut(); // вызываем ф-ю,которая перебросит снова на авторизаци. страницы
	endif;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>АДМИНКА</title> <!-- в зависимости от того, как отработает block print $title сверху файла -->
        <meta http-equiv="content-type"
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="includes/style.css" />
    </head>
    <body>
	<h1>Администрирование магазина</h1>
	<h3>Доступные действия:</h3>
	<ul>
		<li><a href='add_cat.php'>Добавление товара в каталог</a></li>
		<li><a href='orders_view.php'>Просмотр готовых заказов</a></li>
		<li><a href='create_user.php'>Добавить SuperUser</a></li>
		<li><a href='index.php?logout'>Завершить сеанс</a></li>
	</ul>
</body>
</html>