<form action='<?=$_SERVER['REQUEST_URI'];?>' method='POST' name='form'> <!-- форма калькулятора START-->
	Число 1: <input type='text' name='num1'><br /><br />
	Оператор: <input type='text' name='operator'><br /><br />
	Число 2: <input type='text' name ='num2'><br /><br />
			 <input type='submit' name='submit' value='DONE'>
</form> <!-- форма калькулятора END-->
<?
if($_SERVER['REQUEST_METHOD']=="POST") { // была ли отправлена Форма или нет, если да,-то принимаем переданные переменные и пропускаем через фильтра 
	$num1=f_clearData($_POST['num1'],'float_notsign');
	$num2=f_clearData($_POST['num2'],'float_notsign');
	$operator=f_clearData($_POST['operator'],'string');
}        

$result="$num1 $operator $num2= "; // инициализируем в $result строку вывода, кторую будем приклеивать к результату вычисления 

switch($operator)
{	case '':  $result=''; break;
	case '+': $result.=$num1+$num2; break;
	case '-': $result.=$num1-$num2; break;
	case '*': $result.=$num1*$num2; break;
	case '/': 	if($num2==0): $result="На 0 делить нельзя!";
				else: $result.=$num1/$num2; endif; break;
	default: $result="Неизвестный оператор :&nbsp; '$operator'";  
}	

if($num1===0 && $num2===0 && $operator!=='/'): $result='0'; endif;  // если в поле ввода-1 или поле ввода-2 будут нули и матем.оператор не деление,- то ничего не выводить
?>

<!--Вывод результатов калькулятора START-->
<p>Результат : 
<?php 
echo ($result) ? $result : "0"; //если есть(существует) $result, то ее значение и выводим, если ее нету, то выводим 0. Равнозначно записи: if($result): echo " $result"; else: echo "0"; endif; 
?>
</p>
<!--Вывод результатов калькулятора END-->   