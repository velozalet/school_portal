<?
ob_start(); // Стартуем буфферизацию контента
header("Content-type:text/html; charset=utf-8"); // передаем заголовок с нужной кодировкой 
header("Cache-Control:no-store"); //запрет на кеширование страницы(т.е. НЕ КЭШИРОВАТЬ); если нужно вообще
//---------------------------------------------------------------------------------------------------------------------	
define("FILE_SUPERUSERS",".htpasswd"); // конст.для хранения имени файла c данными Aдмина(ов):логин,соль, число итераций полученные из Формы вода при создании нового СуперЮзера
define("ORDERS_LOG","orders.txt"); // конст.для хранения имени файла с личн.данными пользователей(это обычный txt-файл)
//---------------------------------------------------------------------------------------------------------------------	

if (!isset($_SERVER['PHP_AUTH_USER']) && !isset($_SERVER['PHP_AUTH_PW'])) { // если поля Аутоитентификации пусты
	header('WWW-Authenticate: Basic realm="AUTORIZATION FOR SUPER_USER"');
    header('HTTP/1.0 401 Unauthorized');
    exit ('Доступ закрыт! Вам необходимо авторизироваться как Администратору сайта!'); 
} 

if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) { //1_if 
		$login= $_SERVER['PHP_AUTH_USER']; // если поля Аутоитентификации НЕ пусты, ложим содержимое в переменную для дальнейшей ее проверки
		$password= $_SERVER['PHP_AUTH_PW']; // если поля Аутоитентификации НЕ пусты, ложим содержимое в переменную для дальнейшей ее проверки

	if($result= f_superUserExists($login)) { //2_if - передаем $login в ф-ю проверки login на имеющиеся данные ф файле(.htpasswd) с SuperUser'ами
		list($user,$res_hash,$salt,$iteration_count)= explode("|", $result); // разбиваем строку, login которой совпал с $login введенным при Аутентификации и раскидываем эту строку по переменным

		if(f_getHash($password,$salt,$iteration_count)== $res_hash) { echo "Вы вошли как Super User: $login"; } // вызываем ф-ю,которая Хеширует пароль и передаем в нее $password(то,что веели при Аутоитентификации),чтобы ф-я это Захешировала, а затем результат сравниваем с Хешом пароля,в строке из файла(.htpasswd),который мы вытянули,как совпавший по $login
		else { header('WWW-Authenticate: Basic realm="AUTORIZATION FOR SUPER_USER"'); header('HTTP/1.0 401 Unauthorized'); exit; } // иначе в окно Авторизации

   	} //2_if
	else { header('WWW-Authenticate: Basic realm="AUTORIZATION FOR SUPER_USER"'); header('HTTP/1.0 401 Unauthorized'); exit; } // иначе в окно Авторизации
} //1_if 
//---------------------------------------------------------------------------------------------------------------------
// Config. paramameters for connecting and CONNECT to BD 'e_shop':
define('DB_HOST', 'localhost'); // наш хост localhost
define('DB_LOGIN', 'littus'); // Логин к БД
define('DB_PASSWORD', '3851'); // Пароль к БД 
define('DB_NAME', 'e_shop'); // Имя БД
	
$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME); // connect to BD 'e_shop' (in the mySQL)
if (mysqli_connect_errno()) { printf("Нет соединения с БД '".DB_NAME."': %s\n", mysqli_connect_error()); exit(); }
//-----------------------------------------------------------------------------------------------------------------------
// Иннициализ.значения переменных по-умолчанию (для PHP-script в create_user),когда форма ввода не заполнена
$user = 'root'; // логин для SuperUser
$string = '12345'; // пароль для SuperUser
$salt = ''; // соль_(она пристыковывается к паролю(к $string) единой строкой, чтобы повысить надежность пароля. Делается это через ф-ю f_getHash. (См. lib.inc.php)
$iteration_count = 10; // число итераций "солений" пароля в цикле, при работе ф-ии f_getHash. (См. lib.inc.php)
$eny_code = '1FD37EAA5ED9425683326EA68DCD0E59'; // просто любая придуманная строка из набора символов для получения "соли" ($salt)
$result='';
//-----------------------------------------------------------------------------------------------------------------------