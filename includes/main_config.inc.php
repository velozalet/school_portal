<? 
header("Content-type:text/html; charset=utf-8"); // передаем заголовок с нужной кодировкой 
header("Cache-Control:no-store"); //запрет на кеширование страницы(т.е. НЕ КЭШИРОВАТЬ); если нужно вообще

// посыл заголовка для формы-выбора "Куда отправимся?" в header.inc.php
$url = strip_tags($_GET["url"]);
	if ($url): header("Location: $url"); exit; endif;
////////////////////////////////////////////////////////////////////////
$id=f_clearData($_GET['id'],'string_to_lower'); // инициализируем $id из данных пришедших методом GET из меню выбора страниц сaйта(l_sidebar.inc.php <- data_menus.inc.php)
//////////////////////////////////////////////////////////////////////////////////////////////////////////
// Config. paramameters for connecting and CONNECT to BD 'gbook':
define('DB_HOST', 'localhost'); // наш хост localhost
define('DB_LOGIN', 'root'); // Логин к БД
define('DB_PASSWORD', ''); // Пароль к БД (тут у нас его нет,отсутствует)
define('DB_NAME', 'gbook'); // Имя нашей БД
	$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error()); // connect to BD 'gbook' (in the mySQL)
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////