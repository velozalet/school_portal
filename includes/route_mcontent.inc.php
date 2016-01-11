<?  // Динамика ОСНОВНОГО КОНТЕНТА при запросе страницы от параметра id

switch($id):  
// from array $l_menu (file:includes/data_menus_inc.php) for l_sidebar                          
	case 'contact': include 'includes/contact.inc.php'; break;
	case 'about': include 'includes/about.inc.php'; break;
	case 'info': include 'includes/info.inc.php'; break;
	case 'gowhere': include 'includes/gowhere.inc.php'; break;
	case 'gbook': include 'includes/gbook.inc.php'; break;
	case 'log': include 'includes/view-log.inc.php'; break;
	

// from array $top_menu (file:includes/data_menus_inc.php)  for top_sidebar 
	case 'page1': include 'includes/page1.inc.php'; break;
	case 'calc': include 'includes/calc.inc.php'; break;
	case 'table': include 'includes/table.inc.php'; break;
	
	default: include 'includes/index.inc.php';
endswitch;