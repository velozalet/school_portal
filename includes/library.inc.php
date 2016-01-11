<?php 
	
function f_getMenu($menu,$vertical=true,$text=true) {

 if(!is_array($menu)): return false; //если в ф-ю пришел НЕ массив,то возвращаем false 
 else:   //если же в функцию пришел массив, то выполняем тело ф-ии и возвращаем в конце true:
	$horisont=' ';  // $horisont по умолчанию будет равна пустой строке,т.е. ничего не будет подставляться
	$text_dec=' '; // $text_dec по умолчанию будет равна пустой строке,т.е. ничего не будет подставляться
	if(!$vertical) {$horisont='display:inline;margin-right:10px';} //если $vertical НЕ существ(т.е.она false),то в $horisont загоняем нужный стиль CSS
	if(!$text) {$text_dec ='text-decoration:none';}  //если $text_dec НЕ существ(т.е.она false),то в $text_dec загоняем нужный стиль CSS
 
	foreach ($menu as $key=>$href) {echo "<li style=list-style-type:none;$horisont;><a style=$text_dec; href='$href'> $key</a></li>";} //цикл выводящий все з-я данного массива
 return true; 
 endif;
}		
//----------------------------------------------------------------------------------------------------------			
//$rows=10; // Кол-во tr
//$cols=10; // Кол-во td

function f_getTable($rows=5, $cols=5, $color='yellow') {// Задаем сразу в теле ф-и параметры(значения) по умолчанию

echo "<table width='0' border='1'>"; // Начало шапки табл.(это можно вынести из php-кода)
	
	for($tr=1; $tr<=$rows; $tr++) // main level CYCLE START
	{ echo "<tr>";
	
		for($td=1; $td<=$cols; $td++) { // sub(1) level CYCLE START
			if($tr==1 or $td==1) echo "<td align=center bgcolor=$color <strong>".$tr*$td."</strong></td>"; 
			else echo "<td>".$tr*$td."</td>"; 
			                          } // sub(1) level CYCLE END
	 echo "</tr>"; } // main level CYCLE END

echo "</table>";}  // ОБЪЯВЛЕНИЕ всей Ф-И getTable КОНЕЦ
//----------------------------------------------------------------------------------------------------------					
/* ФИЛЬТР-ОЧИСТКА ПРИНИМАЕМЫХ ДАННЫХ С метода GET/POST  (!)_для расширения PHP(php_mysqli.dill). Started ih PHP ver.5.0_(!): */
function f_clearData($data,$type){  // param.:2/ $data-from METHOD GET/POST; $type-по какому шаблону ее фильтровать(см.по case)
	global $link; //объявляем глобальной,чтобы была видна ф-и извне.Тут соединение с БД (в виде object)
	switch($type){
		case 'integer': return trim(htmlspecialchars(strip_tags(abs((integer)$data)))); break; //для числа: 1)не дробное число 2)положительн. 3)без знаков "+/-"
		case 'float_notsign': return trim(htmlspecialchars(strip_tags(abs($data)))); break; //для числа дробного десятичного формата(т.е.для 4.5242).: 1)без знакa "-" ; если число будет 4,5242(т.е.запятая вместо точки) или 2/3,-будет возвращено только целое число(т.е. 4 и 2 соответственно)
		case 'float_withsign': return trim(htmlspecialchars(strip_tags($data)))*1; break; ////для числа дробного десятичного формата(т.е.для 4.5242), HO знак "-" сохраняется ; если число будет 4,5242(т.е.запятая вместо точки) или 2/3,-будет возвращено только целое число(т.е. 4 и 2 соответственно)
		case 'string': return trim(addslashes(htmlspecialchars(strip_tags($data)))); break; //для строки,которой тут же пользоваться,т.е.когда не надо результат вносить в БД 	
		case 'string_to_db': return mysqli_real_escape_string($link, trim(htmlspecialchars(strip_tags($data)))); break; // для строки,идущей в БД (но не методом Подготовл.Запроса)
		case 'string_to_db_prepare': return trim(htmlspecialchars(strip_tags($data))); break; // для строки,идущей в БД, методом Подготовл.Запроса
		case 'string_forfile': return trim(htmlspecialchars(strip_tags($data))); break;   // для строки,идущей в файл
		case 'string_to_lower': return strtolower(trim(addslashes(htmlspecialchars(strip_tags($data))))); break;  // как для (case'string')+ преобразует строку в НИЖНИЙ регистр
	}  // в случае ненадобности экранировать апостроф в строке(O'Brian),- убрать addslashes,где он стоит!
}
//----------------------------------------------------------------------------------------------------------
/* ПЕРЕМЕЩЕНИЕ ЗАГРУЖЕННОГО НА СЕРВЕР ФАЙЛА В УКАЗВННУЮ ПАПКУ В КОРНЕ проекта сайта */
function f_fileMoveUploaded($uploaddir) {   // param.:1- $uploaddir - содержит строку абсолютного пути к файлу,который перемещаем (см.gowhere.inc.php)
	if($_SERVER['REQUEST_METHOD']=='POST') {  // если была отправлена форма с загрузкой определенного файла на сервер, то:
    	foreach ($_FILES['user_file']['error'] as $key => $error) {
      		if ($error == UPLOAD_ERR_OK) { // если при загрузке файла(ов) ошибок нет, то:
        							$tmp_name = $_FILES['user_file']['tmp_name'][$key];
        		global $name; 		$name= $_FILES['user_file']['name'][$key]; //чтобы $name потом была доступна после отработки ф-ии
        		global $size_file;  $size_file= $_FILES['user_file']['size'][$key]; //чтобы $size_file потом была доступна после отработки ф-ии
				move_uploaded_file($tmp_name, $uploaddir.$name); // перемещаем файл в указанную папку по указанному пути
        		return true; // ф-я отработала, возвращаем true
        	} 
      	}
    }
} 
/*______________________________________________________________________IMPOTANT!! :
$uploaddir = __DIR__ .'/../upload/';//ложит файл в папку [upload],которая расположена на один уровень выше папки с файлом,в кот.выполняется скрипт PHP
$uploaddir = __DIR__ .'./upload/'; //ложит файл в папку [upload],которая расположена в этой же папке с файлом,в кот.выполняется скрипт PHP

$uploaddir = __DIR__.'./'; //ложит прямо в эту же папку,где лежит сам файл,в кот.выполняется скрипт PHP
$uploaddir = __DIR__.'../'; // аналогично предыдущему почему-то
$uploaddir = __DIR__.'/'; // аналогично предыдущему почему-то

$uploaddir = __DIR__.'/../'; //ложит просто в папку,которая расположена на один уровень выше папки с файлом,где лежит сам файл,в кот.выполняется скрипт PHP
$uploaddir = __DIR__.'/../../'; //ложит просто в папку, которая расположена на 2 уровня выше папки с файлом,где лежит сам файл,в кот.выполняется скрипт PHP
*/
//----------------------------------------------------------------------------------------------------------

?>