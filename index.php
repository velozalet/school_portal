<?
include_once dirname(__FILE__)."/includes/library.inc.php"; // + библиотека функций
include_once "includes/main_config.inc.php"; //+ основной файл с конфигурационн.настройками

include_once "includes/cookie.inc.php"; //+ COOKIE'S User 
include_once "includes/data_menus.inc.php"; // + массивы всех меню
include_once "includes/error_rep.inc.php"; // + константы выводимых ошибок
include_once "includes/log_config.inc.php"; // + конфигурационные данные для журнала посещений страниц сайта Юзером:
include_once "includes/route_headers.inc.php"; // block print $title and $header START
ob_start(); // Стартуем буфферизацию контента
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= $title ?></title> <!-- в зависимости от того, как отработает block print $title сверху файла -->
        <meta http-equiv="content-type"
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="includes/style.css" />
    </head>
    <body>

<!-- HEADER START-->    	
		<div id="header">
			<img src="img/logo1.jpg" width="187" height="29" alt="Наш логотип" class="logo" />
			<span class="slogan">обо всём сразу <br>
				<? include "includes/route_cookie.inc.php"; ?> <!-- + управление отображениями cookie Юзера-->
			</span>

			<? include "includes/header.inc.php"; ?> <!-- + header-->
		</div>
<!-- HEADER END-->

<!-- MAIN CONTENT START-->
		<div id="content">
			<h1><?= $header?></h1> <!-- динамически изменяющийся заголовк оласти ОСНОВНОГО КОНТЕНТА--> 
			<? include 'includes/route_mcontent.inc.php'; ?>	 <!-- + Динамика подсоединения контента в завис.от нажатой вкладки l_sidebar -->
		</div>
<!-- MAIN CONTENT END-->	

<!-- l_sidebar START -->	
		<div id="nav">
			<h2>Навигация по сайту</h2>

			<ul>
				<? include_once "includes/l_sidebar.inc.php"; ?> <!--  + l_sidebar (HTML-код с ф-ей отрисовки меню) -->	
			</ul>
		</div>
<!-- l_sidebar END -->	

<!-- FOOTER START-->		
		<div id="footer">
			<? include "includes/footer.inc.php"; ?> <!-- + footer-->
		</div>
<!-- FOOTER END-->		
    </body>
</html>