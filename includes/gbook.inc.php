<?
if (mysqli_connect_errno()) {   //проверка успешности соединения с сервером БД mySQL__(параметры сединения с БД в main_config.inc.php)
		printf("Не удалось подключиться к DB '".DB_NAME."': %s\n", mysqli_connect_error()); exit();
	}

// filters param. from form ввода данных Юзера и его сообщения: START
if ( ($_SERVER['REQUEST_METHOD']=="POST")     // если была отправлена форма c данными от Юзера методом POST
	&& isset($_POST['name']) && !empty($_POST['name'])      // проверка существуют ли поля и не пустые ли они
	&& isset($_POST['email']) && !empty($_POST['email']) // проверка существуют ли поля и не пустые ли они
	&& isset($_POST['msg']) && !empty($_POST['msg'])    // проверка существуют ли поля и не пустые ли они
	){ 
		$name=f_clearData($_POST['name'],'string_to_db'); 
		$email=f_clearData($_POST['email'],'string_to_db'); 
		$msg=f_clearData($_POST['msg'],'string_to_db'); 
			$datetime= time(); // ставим в момент POST'а current TIMESTAMP
		$sql= "INSERT INTO msgs (name, email, msg, datetime) VALUES ('$name','$email','$msg','$datetime')"; // формируем запрос к таблице БД 
		mysqli_query($link, $sql) or die(mysqli_error($link)); // исполняем запрос(действие) к таблице БД

		header("Location: " .$_SERVER['REQUEST_URI']); exit; // перезапрос страницы методом GET
} 
	elseif ($_SERVER['REQUEST_METHOD']!=="POST") {    // если НЕ была отправлена форма c данными от Юзера методом POST
		echo " "; 
	}
	elseif (($_SERVER['REQUEST_METHOD']=="POST") && empty($name) or empty($email) or empty($msg)) {  // если была отправлена форма c данными от Юзера методом POST но такие-то поля пустые
		$alert= "Вы заполнили не все имеющиеся поля Формы!"; 
	}
// filters param. from form ввода данных Юзера и его сообщения: END
?>

<h3>Оставьте запись в нашей Гостевой книге</h3>

<form action="<?= $_SERVER['REQUEST_URI']?>" method="POST"> <!-- форма ввода данных Юзера и его сообщения -->
	Login: <br><input type="text" name='name' size="30" maxlength="30" title="Максимально 30 символов"><br>
	Email: <br><input type="text" name='email' size="30" maxlength="30" title="Максимально 30 символов"><br>
	Post: <br><textarea name='msg' cols="51" rows="10" maxlength="250" title="Максимально 250 символов"></textarea><br><br>
			<input type="submit" value="SEND POST">
			<input type="reset" value="Clear">
</form>

<?
echo $alert;  //вывод текста ошибки если в форме отправки заполнены не все поля и произошла отправка данных

// Block: вывод Гостевой книги: START
$sql= "SELECT id, name, email, msg, datetime FROM msgs ORDER BY id DESC LIMIT 10"; // формируем запрос к таблице БД 
$result= mysqli_query($link, $sql) or die(mysqli_error($link)); // исполняем запрос(действие) к таблице БД и ложим результат в $result
		
if(!$result) { // проверка успешности извлечения данных из БД. 1-е условие, когда $result попала ложь
	echo "Извлечение запроса из БД НЕ прошло! Код ошибки № n/n: "; 
}
if(mysqli_num_rows($result)>0) { // 2-е условие, когда кол-во строк $result >0, значит успех- загоняем результат в ассоциат.массив
	echo "<br><br>";
	echo "Всего записей в Гостевой Книге (шт.) - ".mysqli_num_rows($result)."<br><hr>";  //подсчет кол-ва всех имеющихся записей в Гоставой книге
	while($my_row= mysqli_fetch_assoc($result)) { //ЦИКЛ: Загоняем($result) в ассоц.массив и инициализируем нужные переменные для работы с ними
		$id = $my_row['id'];
		$name = $my_row['name'];
		$email = $my_row['email'];
		$msg = nl2br($my_row['msg']);
		$datetime = date('d-m-Y H:i:s',$my_row['datetime']);

		echo "<hr><a href='mailto:$email'>$name</a> От: $datetime"; //вывод поля name ссылкой, где направление ссылки есть e_mail этого пользователя
  		echo "<p>".$msg."</p>"; // вывод поля msg,пропущенное через ф-ю nl2br - делает вывод из таб.БД именно так, как было введено в БД
  		echo "<p align='right'><a href='$_SERVER[REQUEST_URI]&del=$id'> Delete </a></p>";   //делаем ссылку удалить инфо выведенное до этого по id
	} 
} 
else { echo "Извлечение запроса из БД НЕ может быть осуществлено,- в таблице БД нет записей!"; }//иначе,когда и 1и2 условие Не прошли- вывести текст ошибки
// Block: вывод Гостевой книги: END

//Block: Delete User's Рost: START
if(isset($_GET['del'])) { // если глоб.переменная такая послалась именно методом GET
	$del=f_clearData($_GET['del'],'integer'); // то принимаем, отфильтровываем как число,целое,положительное

	if($del) { 		// допол.проверка (если есть такой, но уже отфильтрованный параметр)
		$sql= "DELETE FROM msgs WHERE id=$del";  // формируем запрос к таблице БД
		mysqli_query($link, $sql) or die(mysqli_error($link)); // исполняем запрос(действие) к таблице БД и ложим результат в $result
		
		mysqli_close($link); // закрываем соединение с БД 
		
		header("Location: " .$_SERVER['SCRIPT_NAME'].'?id=gbook'); // перезапрос страницы методом GET - НЕ ПРОДУМАН,через:'?id=gbook' - БРЕДДД-ПЕРЕДЕЛАТЬ!!!!!
	}
}
//Block: Delete User's Рost: END

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Если поле(datetime)- в настройке в БД поставить тип "TIMESTAMP" и в настройке по-умолчанию "CURRENT_TIMESTAMP",то дата сама автоматом проставляется, 
  //но не как timestamp,а как дата-время на америк.манер.Тогда в запросах будут следующие изменения:
// 1) $datetime= time(); - ставить не нужно
// 2) $sql= "INSERT INTO msgs (name, email, msg) VALUES ('$name','$email','$msg')";
// 3) $sql= "SELECT id, name, email, msg, UNIX_TIMESTAMP(datetime) AS dt FROM msgs ORDER BY id DESC LIMIT 10"; // выбрать поля из таблицы(поле(datetime) мы прогоняем черех внутреннюю ф-ю БД UNIX_TIMESTAMP(),которое вернет обычную timestamp) и просим присвоить этому полю псевдоним 'dt' ИЗ табл.(msgs), отсортировать по(id) в обрат.порядке(т.е. с конца) и взять только 5 записей
// 4)	while($my_row= mysqli_fetch_assoc($result)) { 
	// ..................
	//	$dt = date('d-m-Y H:i:s',$my_row['dt']);
	// ..................
	//	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
