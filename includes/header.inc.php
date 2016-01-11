<?
 $day=date('d'); $mon=date('m'); $year=date('Y'); //как пример, что дату можно вызывать по частям и для удобства распих.по переменным
?>

<? //определение времени суток для отображ.пользователю в блоке header START
$hour=(integer)date("H"); //функцией date вытягиваем текущее значение часов и кладем в $hour. Страхуемся и приводим данные к целому числу.
$welcome=""; // инициализируем переменную под вывод значения. Хотя это можно и не делать, но для визуализации удобнее

if($hour>0 && $hour<6 ): $welcome="Доброй ночи";
	elseif($hour>=6 && $hour<11 ): $welcome="Доброе утро";
	elseif($hour>=11 && $hour<18 ): $welcome="Добрый день";
	elseif($hour>=18 && $hour<23 ): $welcome="Добрый вечер";
else:$welcome="Добрoй ночи";
endif;	
 //определение времени суток для отображ.пользователю в блоке header END
?>

<!-- HEADER START-->

<sub><p><? echo strftime('Сегодня %d-%m-%Y'); ?></p></sub>  <!-- вывод время-даты через strftime -->
<sub><p><? echo date('Сегодня d-m-Y'); ?></p></sub> <!-- вывод время-даты через date.Для сравнен.2-х Ф-ий -->
<sub><p><?= "Сегодня: $day число  $mon месяц $year год" ?></p></sub>  <!-- см.начало этого действия в начале докум. -->
<h5 style='text-align:right;' > <?=$welcome; ?>, Гость!</h5>

<sub><!-- Форма выбора "Кудп отправимся?" START-->
<form action="<?= $_SERVER["PHP_SELF"] ?>">
	Куда отправимся?:
	<select name="url" size="1">
		<option value="http://www.google.ru">Гугл</option>
		<option value="http://www.yandex.ru">Яндекс</option>
		<option value="http://www.rambler.ru">Рамблер</option>
	</select>
	<input type="submit" value="GO!">
</form>
</sub> <!-- Форма выбора "Кудп отправимся?" START -->


<h3 style='text-align:center;'> HEADER</h3>

	<!-- print Menu for  top_sidebar START -->
<div style='text-align:center;'><? if (!f_getMenu($top_menu,false,true)) echo MY_ERR_F_GET_MENU;?></div> <!--проверка:если ф-я НЕ отработала и вернула false,-выводить надпись об ошибке--> 
	<!-- print Menu for top_sidebar END -->
		
<!-- HEADER END-->
