<?              //________________________________________________FUNCTION for ADMINKA___________________________________________________________
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
//--------------------------------------------------------------------------------------------------------------------------------------------------

// ДОБАВИТЬ В БД НОВЫЙ ТОВАР(книга)- for ADMINKA
function f_addCatalog($title, $author, $pubyear, $price) { // 4 param.: что хотим положить в табл.(catalog)
	global $link;  // обьявляем $link(лежит соединение с БД) глобальной,чтобы была доступна ф-ии извне
	
	$sql= "INSERT INTO catalog (title, author, pubyear, price) VALUES (?,?,?,?)"; // формируем запрос к таблице БД,но для подготовленного запроса
	if(!$stmt= mysqli_prepare($link,$sql)): return FALSE; // Подготовка SQL-запроса к выполнению. В $stmt вернется TRUE(object) или FALSE(если такой запрос не пройдет).И говорим, если $stmt FALSE, то и вернуть FALSE
	else:
		mysqli_stmt_bind_param($stmt, "ssid", $title, $author, $pubyear, $price); // К подготовленн.запросу привязываем параметры,кот.хотим ложить в БД
		mysqli_stmt_execute($stmt); // Исполни подготовленный запрос,лежащий в $stmt
		mysqli_stmt_close($stmt); // Закрываем передачу подготовленн.запроса(не обязательно,но лучше закрывать)
			return TRUE; //вернуть TRUE,когда подготовленный запрос прошел и успех.
	endif;
}
//-----------------------------------------------------------------------------------------------------------------------------------------------
// ПОЛУЧЕНИЕ ИНФОРМАЦИИ О ЗАКАЗЕ(данные Юзера лежат в файле orders.txt(это конст.ORDERS_LOG) а перечень товаров- в табл.otders БД) - for ADMINKA
			/*Текстов.файл(orders.txt)-идентификатор заказа,по нему ориентируемся,т.е.привязываемся к идентификатору Юзера($orderid). Каждая строка
			в текст.файле-это отдельный идентификатор($orderid), поэтому сколько в текст.файле строк- столько заказов. Это все складываем в массив,
			сначала в ПРОМЕЖУТОЧНЫЙ($orderinfo) куда будет сливаться вся инфо как из текст.файла так и их табл.(catalog) БД в виде:
			$orderinfo[key]=> value. Затем этот ПРОМЕЖУТОЧНЫЙ($orderinfo) массив закидываем,в свою очередь,как элемент,в ОСНОВНОЙ($allorders) массив.
			В итоге получаем 3-х мерн.МАССИВ($allorders): $allorders[0]=> $orderinfo[key]=> value
														                  $orderinfo["goods"]=> [key]=> value...
			т.е.каждый элемент $allorders[] - заказ !  */
function f_getOrders() { 
	global $link;  // обьявляем $link(лежит соединение с БД) глобальной,чтобы была доступна ф-ии извне
	if(!is_file('../orders_log/'.ORDERS_LOG)) { return FALSE; } // если файла orders.txt с данными пользователя НЕТ - FALSE
	
// Получение инфо о заказчиках из файла orders.txt: START
	$orders_txt = file('../orders_log/'.ORDERS_LOG); // зачитываем файл(orders.txt) в($orders_txt) и делая данные в нем массивом

	$allorders = array(); //инициализируем ОСНОВНОЙ МАССИВ(3-х мерн.),в кот.будет идти вся инфо о заказах, как с файла orders.txt, так и с БД (табл.orders)

	foreach ($orders_txt as $key) { //OPEN foreach
		list($name,$email,$phone,$address,$orderid,$datetime,$ip_user)=explode("|", $key); //разбиваем ф-ей list массив из ф-ла(orders.txt) на переменные по границе симв."|"
	    
	    $orderinfo = array(); //инициал.ПРОМЕЖУТОЧНЫЙ массив,в кот.будет идти инфо о заказчиках из ф-ла orders.txt и из табл.(catalog) БД
	    	$orderinfo["name"] = $name; // заполняем этот инициализированный ПРОМЕЖУТОЧНЫЙ массив(orderinfo) ассоциативными ключами и значениями полученных переменных из файла(orders.txt)
			$orderinfo["email"] = $email;  //--//--
			$orderinfo["phone"] = $phone;   //--//--
			$orderinfo["address"] = $address;  //--//--
			$orderinfo["orderid"] = $orderid;   //--//--
			$orderinfo["datetime"] = $datetime;   //--//--
			$orderinfo["ip_user"] = $ip_user;  //--//-- 
// Получение инфо о заказчиках из файла orders.txt: END 		
// Получение инфо о товарах из табл.(orders) БД: START 		
 		$sql= "SELECT title,author,pubyear,price,quantity,orderid,datetime  FROM orders WHERE orderid= '$orderid' AND datetime= '$datetime'"; 
 		if (!$result= mysqli_query($link, $sql)): return FALSE; // если нет результата выборки из БД, ветруть FALSE
		else: $orderinfo["goods"]= mysqli_fetch_all($result, MYSQLI_ASSOC); //из результата выборки из БД($result) делаем асс.массив и делаем его элементом ПРОМЕЖУТОЧНОГО массива $orderinfo с ключом["goods"] в котором уже в такомже виде хранится инфо Юзера
			 mysqli_free_result($result); // освобождаем $result(память,занятую результптом запроса)
// Получение инфо о товарах из табл.(orders) БД: END 
			$allorders[]= $orderinfo; // ПРОМЕЖУТОЧНЫЙ массив($orderinfo),где лежат все данные как из текст.файла,так и из табл.(orders)БД,ложим в свою очередь в ячейку ОСНОВНОГО МАССИВА(3-х мерн.).Теперь данные ПРОМЕЖУТ.массива есть элементами ОСНОВНОГО(3-х мерн.) массива
		endif;
	} //CLOSE foreach
	return $allorders; // возвращаем ОСНОВНОЙ МАССИВ(3-х мерн.),в кот.вся инфо о заказах, как с файла orders.txt, так и с БД (табл.orders)
}
//-----------------------------------------------------------------------------------------------------------------------------------------------
//ГЕНЕРИРОВАНИЕ ХЕШ ПАРОЛЯ - for ADMINKA
function f_getHash($string,$salt,$iteration_count) { // 3 param.:(string)-пароль, (salt)-соль для пароля, (iteration_count)-число итераций,-сколько раз "солить" массив в цикле
	for($i=0; $i<$iteration_count; $i++) { $string=sha1($string.$salt); return $string; } // вернет последний результат(строку) из такого "посоленного"массива
}
//-----------------------------------------------------------------------------------------------------------------------------------------------
// ДОБАВЛЕНИЕ НОВОЙ ЗАПИСИ В ФАЙЛ С ПОЛЬЗОВАТЕЛЕМ(лями)-т.е.добавление Админа(ов) - for ADMINKA
function f_addSuperUser($user, $res_hash, $salt, $iteration_count) { // 4 param.:
	$path="$user|$res_hash|$salt|$iteration_count\r\n"; //формир.строку из получен.данных для записи в файл .htpasswd
		if( !file_put_contents(FILE_SUPERUSERS, $path, FILE_APPEND) ): return FALSE;  // открываем соед.с файлом и записываем в него сформированную строку с данными
		else: return TRUE;
		endif;
}
//-----------------------------------------------------------------------------------------------------------------------------------------------
// ПРОВЕРКА НАЛИЧИЯ СУЩЕСТВУЮЩЕГО Админа(ов) в СПИСКЕ В ФАЙЛЕ Админом(ми) - for ADMINKA
	//если такого пользователя нет
function f_superUserExists($user) { //1 param.:($user)- введенный через форму авторизации Админа логин
	if(!is_file(FILE_SUPERUSERS)): return FALSE; // если файла со списком СуперЮзеров не существует,- вернуть FALSE
	else: $users= file(FILE_SUPERUSERS); // зачитываем файл(.htpasswd) в($users) и делая данные в нем массивом
		foreach ($users as $key) { //перебираем наш массив($users),куда мы положили все даннве с файла(.htpasswd)
			if(@strpos($key, $user) !== FALSE ) { return $key; } // в цикле проверяем каждый эл.массива($key)-т.е.строку,где каждая строка это отдельный СуперЮзер,на совпадение в строках с параметром переменной($user).Если есть,-возвращаем эту самую строку
		}
	return FALSE; //если совпадений не найдено,- тоже возвращаем FALSE
	endif;
}
//-----------------------------------------------------------------------------------------------------------------------------------------------
function f_logOut() { // ВЫХОД из АДМИН-ПАНЕЛИ - for ADMINKA
	header("Refresh:1; {$_SERVER['SCRIPT_NAME']}");
    header('HTTP/1.0 401 Unauthorized'); 
}
?>