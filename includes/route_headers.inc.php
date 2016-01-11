<?  // Динамика: надписи на открытой вкладке($title) и заголовка страницы($header) при запросе страницы от параметра id
$title=" "; //инициализируем $title для динамического изменения надписи открытой вкладки
$header = " "; //инициализируем $header для динамического изменения заголовка страницы

switch($id):    // изменение <title> в HTML-code,в зависимости от запрашиваемой страницы и $header,отвечающей за заголовок в подставляемой странице
// for l_sidebar    	
	case 'contact': 
		$title="КОНТАКТЫ"; 
		$header="КОНТАКТЫ <hr>"; break;  
	case 'about': 
		$title="О НАС";
		$header="О НАС <hr>"; break; 
	case 'info': 
		$title="ИНФОРМАЦИЯ";
		$header="ИНФОРМАЦИЯ <hr>"; break;  
	case 'gbook': 
		$title="ГОСТЕВАЯ КНИГА";
		$header="ГОСТЕВАЯ КНИГА <hr>"; break;  
	case 'log': 
		$title="ЖУРНАЛ.ПОС.";
		$header="ЖУРНАЛ ПОСЕЩЕНИЙ <hr>"; break;
	case 'gowhere': 
		$title="ЧТО ЗАГРУЗИМ ? ))";
		$header="ЧТО ЗАГРУЗИМ ? ))"; break;    

// for top_sidebar    
	case 'page1': 
		$title="PAGE_1";
		$header="PAGE_1 <hr>"; break;
	case 'calc': 
		$title="CALCULATOR";
		$header="КАЛЬКУЛЯТОР <hr>"; break; 
	case 'table': 
		$title="TABLE";
		$header="ТАБЛИЦА УМНОЖЕНИЯ <hr>"; break;  

	default: 
		$title="SCHOOL_PORTAL"; 
		$header="Добро пожаловать на SCHOOL_PORTAL ! <hr>";
endswitch;