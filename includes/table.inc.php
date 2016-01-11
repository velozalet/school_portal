<?
if($_SERVER['REQUEST_METHOD']=="POST"):  // была ли отправлена Форма или нет, если да,-то принимаем переданные переменные и фильтруем их 
	$rows=f_clearData($_POST['rows'],'integer');
	$cols=f_clearData($_POST['cols'],'integer');
	$color=f_clearData($_POST['color'],'string');
endif;
?>

<!-- Input form START-->
<form method="POST" name='form' action="<?=$_SERVER['REQUEST_URI'];?> ">
	Задать кол-во строк: <input type="text" name="rows" value="<?= $rows ?>"><br><br> <!-- value="....."- чтобы значения введенных данных пользователем не удалялись. Удалить,если не надо, чтобы так было -->
	Задать кол-во столбцов: <input type="text" name="cols" value="<?= $cols ?>"><br><br>
	Задать цвет: <input type="text" name="color" value="<?= $color ?>"><br><br>
<input type="submit" value="CREATE !">
</form> <!-- Input form END-->



<?
if(!empty($rows) and !empty($cols) and !empty($color)):  // если значения переданных переменных НЕ пустые,то отрисовываем табл.умножения с этими переданными значениями от этих переменных
	f_getTable($rows,$cols,$color);

else: f_getTable(); // иначе вызываем функцию по отрисовке табл.умнож. без параметров вообще, что означает- отрисовку с параметрами по умолчанию(см.function f_getTable/ file: library_inc.php)
endif;

?>




<?
 /*
if($_SERVER['REQUEST_METHOD']=="POST"):  // была ли отправлена Форма или нет
	$rows=f_clearData($_POST['rows'],'integer');
	$cols=f_clearData($_POST['cols'],'integer');
	$color=f_clearData($_POST['color'],'string');

	f_getTable($rows,$cols,$color);
	
else: f_getTable();
endif;

*/
?>