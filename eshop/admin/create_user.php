<?
require_once "lib.inc.php";
require_once "config.inc.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Хеш.SHA-1</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>
<body>
	<div align='center'> <a href='index.php'>АДМИНКА-ГЛАВНАЯ</a> </div>
	<br>

	<h1>Создание СуперЮзера(администратора)</h1>
<?
// BLOCK: создание нового SuperUser(Админа) с хешированием пароля или проверка существующего SuperUser(Админа),если такой уже имеется: START
if (!$salt) { // если не задана соль, то генерируем ее сами, автоматически
	$salt = str_replace('=', '', base64_encode(md5(microtime().$eny_code))); // после(base64_encode) в конце всегда появляется символы "=".Используем ф-ю(str_replace),чтобы убрать их и заменить на пустоту 
}          

if ($_SERVER['REQUEST_METHOD']=='POST') { //если была отправлена Форма методом 'POST'   
	$user = $_POST['user'] ?: $user; //если есть $_POST['user'],то в $user ложим $_POST['user'], ИНАЧЕ в $user ложим значение($user) то,что по-умолчанию инициализированно выше
	
	if(!f_superUserExists($user)) {  // ПРОВЕРКА. если в файле(.htpasswd) с СуперЮзерами нет такого СуперЮзера как в ($user) из Формы ввода,то...
		$string = $_POST['string'] ?: $string; // аналогично строке: $user = $_POST['user'] ?: $user;
		$salt = $_POST['salt'] ?: $salt; // аналогично строке: $user = $_POST['user'] ?: $user;
		$iteration_count = (int) $_POST['iteration_count'] ?: $iteration_count; // аналогично строке: $user = $_POST['user'] ?: $user;

		$res_hash = f_getHash($string,$salt,$iteration_count);  // генерирование Хеш пароля
		$alarm = 'Хеш пароля для SuperUser '.$user. ' успешно сгенерирован!'; // $alarm -для вывода Юзеру сообщения результата 
		if(f_addSuperUser($user, $res_hash, $salt, $iteration_count)) // если f_addSuperUser отработала-(добавила новую запись для СуперЮзера в файл(.htpasswd))
			 $alarm = 'SuperUser '.$user. ' с указанными данными успешно добавлен!';
		else $alarm = 'При добавлении SuperUser '.$user. ' произошла ошибка';
	}
	else { $alarm = "SuperUser $user уже существует. Выберите другое имя."; } // если же есть такой СуперЮзер в файле(.htpasswd)
}
// BLOCK: создание нового SuperUser(Админа) с хешированием пароля или проверка существующего SuperUser(Админа),если такой уже имеется: END
?>
<h3><?= $alarm?></h3> <!-- вывод сообщения результата добавления SuperUser -->
<form action="<?= $_SERVER['PHP_SELF']?>" method="post">
	<div>
		<label for="txtUser">Логин</label>
		<input id="txtUser" type="text" name="user" value="<?= $user?>" style="width:40em"/> 
	</div>
	<br>
	<div> 
		<label for="txtString">Пароль</label>
		<input id="txtString" type="text" name="string" value="<?= $string?>" style="width:40em"/> 
	</div> 
	<br>
	<div>
		<label for="txtSalt">Соль</label>
		<input id="txtSalt" type="text" name="salt" value="<?= $salt?>"  style="width:40em"/> 
	</div> 
	<br>	
	<div>
		<label for="txtIterationCount">Число иттераций</label>
		<input id="txtIterationCount" type="text" name="iteration_count" value="<?= $iteration_count?>"  style="width:4em"/> 
	</div> 
	<br>		
	<div>
		<button type="submit">Создать</button>
	</div>	
</form>
</body>
</html>