<?
/* Скрипт для восстановления файла(.htpasswd),который должен лежать в корне папки[admin] и в которм лежат данные для SuperUser(Админа) для 
	Авторизации(входа) в Админ-панель управления сайтом. Если файл с данными (.htpasswd) исчезнет или будет пуст или не окажется в корне папки[admin],
	то войти в Админ-панель управления сайтом будет невозможно. Тогда нужно просто запустить в браузере этот файл(recovery_admin.php) со скриптом и он
	сгенерирует временные Лошин и Пароль для Авторизации и входа в Админ-панель.
*/
header("Content-type:text/html; charset=utf-8"); // передаем заголовок с нужной кодировкой 
define("FILE_SUPERUSERS",".htpasswd"); // конст.для хранения имени файла c данными Aдмина(ов):логин,соль, число итераций полученные из Формы вода при создании нового СуперЮзера

$user= "start_root2015"; // временный Логин
$res_hash= ""; // инициализтруем Хеш Пароля, пока пустой
$salt= "aa11"; // соль для Пароля
$iteration_count= 3; //число итераций "солений" пароля в цикле, при работе ф-ии f_getHash. (См. lib.inc.php)
$string= "852258"; // временный Пароль

function f_getHash($string,$salt,$iteration_count) { // 3 param.:(string)-пароль, (salt)-соль для пароля, (iteration_count)-число итераций,-сколько раз "солить" массив в цикле
	for($i=0; $i<$iteration_count; $i++) { $string=sha1($string.$salt); return $string; } // вернет последний результат(строку) из такого "посоленного"массива
}
f_getHash($string,$salt,$iteration_count); // вызов ф-и

$res_hash = f_getHash($string,$salt,$iteration_count); // получаем Хеш Пароля

function f_addSuperUser($user, $res_hash, $salt, $iteration_count) { // 4 param.:
	$path="$user|$res_hash|$salt|$iteration_count\r\n"; //формир.строку из получен.данных для записи в файл .htpasswd
		if( !file_put_contents(FILE_SUPERUSERS, $path, FILE_APPEND) ): return FALSE;  // открываем соед.с файлом и записываем в него сформированную строку с данными
		else: return TRUE;
		endif;
}
// вызов функции
if(!f_addSuperUser($user, $res_hash, $salt, $iteration_count)) { echo "При добавлении временного SuperUser произошла ошибка!"; }
else { echo "Временный SuperUser добавлен! Логин: $user <br> Пароль: $string <br><br> 
		Обязательно добавьте с панели Администратора (Закладка \"Добавить SuperUser\") нового SuperUser с новым ЛОГИНОМ и новым надежным ПАРОЛЕМ!"; }	
?>