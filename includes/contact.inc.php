<h3>Адрес</h3>
<p>123456 Москва, Малый Американский переулок 21</p>
<h3>Задайте вопрос</h3>

<form action='<?= $_SERVER['REQUEST_URI'] ?>' method='POST' name="form_question">

	<label for='name'>Ваше Имя: </label> <br>
		<input type='text' name='name' id="name" value="<?= $name ?>" size="50" maxlength="10" title="Максимально 10 символов"> <br>	

	<label for='age'>Ваш возраст (полных лет): </label> <br>
		<input type='text' name='age' id="age" value="<?= $age ?>" size="50" maxlength="2" title="Максимально 2 символа"> <br>	

	<label for='theme'>Тема письма: </label> <br>
		<input type='text' name='theme' id="theme" value="<?= $theme ?>" size="50" maxlength="20" title="Максимально 20 символов"> <br>

	<label for='msg'>Текст письма: </label> <br>
		<textarea name='msg' id="msg" cols="51" rows="10" maxlength="100" title="Максимально 100 символов"></textarea> <br><br>
	
		<input type='submit' value='SEND'>
		<input type="reset" value="Clear">
</form>	

<br><hr>
<?
// filters param. from form_question  START
if($_SERVER['REQUEST_METHOD']=="POST") {
	$name=f_clearData($_POST['name'],'string_forfile'); // если отправлять будем в БД, то указать string_to_db
	$age=f_clearData($_POST['age'],'integer');
	$theme=f_clearData($_POST['theme'],'string_forfile'); // если отправлять будем в БД, то указать string_to_db
	$msg=f_clearData($_POST['msg'],'string_forfile'); // если отправлять будем в БД, то указать string_to_db
} // filters param. from form_question  END	

// print param. from form_question START
$res_mail=''; // инициализируем переменную для индикации успешности правильного заполнения формы и результата отправки письма (пока пустая)

if($_SERVER['REQUEST_METHOD']!=="POST") {  // если форма с данными не была отправлена, т.е.Юзер только зашел на новую страницу,-то ничего не выводить
	echo " "; 
	$res_mail=false;
} 

	elseif(!$name or !$theme or !$msg) {  // если эти переменные НЕ существуют, т.е.что-то не ввели в одно из этих полей, то выводим текст об этом
		echo "Вы НЕ заполнили одно или несколько текстовых полей формы !";
		$res_mail=false; 
	}
	
	elseif(!empty($name) && !empty($theme) && !empty($msg) && $age==false) {  // если $name,$theme,$msg существуют и не пустые и при этом $age==false(т.е. нам ввели не число),- тогда  
		unset($name); unset($theme); unset($msg); // данные аннулируем (удаляем переменные)
		echo "Please, input integer in \"Ваш возраст(полных лет)\"!"; // и выводим текст о введении в поле именно числа
		$res_mail=false;
	}

else {    //при иных условиях,значит форма заполнена корректно,- выдаем все данные как есть в нужном контексте и перезапрос страницы!
	  echo "Your name is: $name <br>"; 
	  echo "Your age is: $age <br>";
	  echo "Theme your post: $theme <br>";
	  echo "Text your post: $msg <br>";	
	  $res_mail=true;

	  header("Location: " .$_SERVER['REQUEST_URI']); // перезапрос страницы методом GET
}
// print param. from form_question END


// block send E-mail: START
if($res_mail===true) {  //если $res_mail-наш индикатор = true,значит форма заполнена как надо и можно формировать и отсылать письмо
	if(mail("\r\nlittus@i.ua \r\n ","\r\n$theme \r\n ",
			"\r\nДанные Юзера: \r\nИмя: $name \r\nВозраст(лет): $age \r\nТекст письма: $msg \r\n ",
			"\r\nContent-type: text/plain; charset=utf-8 \r\n ")) { echo "<hr><br>You mail send!"; }
	else { echo "<hr><br>Your mail DON`T send!"; }
}
// block send E-mail: END
?>