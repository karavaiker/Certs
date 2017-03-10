<?php
/**
 * The template for displaying 404 pages (Not Found).
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
<meta name="robots" content="index, follow" />

<link rel="shortcut icon" href="/pics/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/pics/favicon.ico" type="image/x-icon" /> 

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" media="all" type="text/css" />

<link rel="stylesheet" media="print" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/print.css" />

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/common.js"></script>
<title>
Ошибка 404 — Страница не найдена
</title>
</head>
<body class="e404">
	<div class="container404">
		<div class="error content-block" id="content">
			<a href="/"><img src="/pics/bg/logo.gif" alt="Вектор" class="logo png"/></a>
			<h2>Страница не найдена</h2> 
			<p>Страницы, на которую Вы хотите попасть, у нас нет.</p> 
			<p>Возможно, Вы ошиблись, набирая адрес, либо данная страница была удалена.</p>
			<p>Предлагаем Вам:</p>
			<ul>
			<li>Перейти на <a href="/">главную страницу</a></li>
			<li>Вернуться к <a href="javascript:history.go(-1)">предыдущей странице</a></li>
			</ul>
		</div>
	</div>
</body>
</html>