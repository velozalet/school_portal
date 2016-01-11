<?php
//надо вообще сделать будет отдельную функцию для отслеживания и возврата ошибок и применять для этих целей, совместно с константами именно функцию
define('MY_ERR_F_GET_MENU',
		'<i style=color:red><sub>ERROR function f_getMenu</sub></i>'); //конст.ошибки передачи данных через функцию function GetMenu() в файле library_inc.php. ф-я отрисовывает меню из массива,передаваемого ей

		//define('MY_ERR_F_GET_MENU', 'any text...'); //
?>