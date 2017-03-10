<?php
/**
 * Header template
 *
 * open tags body, main, wrapper, wr, content
 */

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta name="" http-equiv="content-type" content="text/html;charset=<?php bloginfo('charset'); ?>"/>
    <meta name="description" content="Вектор — полеты на парапланах в Перми" />
    <meta name="keywords" content="Парапланерная школа, Вектор, полеты на парапланах в Перми, полеты в тандеме, обучение пилотов" />

    <link rel="shortcut icon" href="/pics/favicon.ico" type="image/x-icon"/>
    <link rel="icon" href="/pics/favicon.ico" type="image/x-icon"> 

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" type="text/css" media="all"/>

    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/common.js"></script>

    <link rel="stylesheet" media="print" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/print.css" />

    <title><?php wp_title(' ', true, 'left'); ?></title>
  </head>
  <body>
    <img src="/pics/bg/logo.gif" alt="" id="print_logo"/>
    <div id="bg">
      <img src="/pics/bg/bg.jpg" width="100%" alt="">
    </div>
    <div id="main">
      <div class="top png24"></div>
      <div id="wrapper" class="png24">
        <div id="header">
          <div id="wrap">
            <div class="cLeft">
                <a href="/">
                  <img src="/pics/bg/logo.gif" id="logo">
                </a>
                <div class="head">
                  <h1><?php $header = get_post_meta($post->ID, 'h1', true) ? get_post_meta($post->ID, 'h1', true) : 'Полёты на парапланах в Перми' ; echo $header; ?></h1>
              </div>
            </div>
          </div>

          <?php get_wp_block('head_contacts'); ?>

        </div>
        <div class="visualMain">
          <div class="pad">
            <div class="menu png24">
              <?php
              $menu = wp_get_nav_menu_object('main'); // получаем  главное меню
              $current_url = home_url($wp->request).'/'; // url страницы

            $menu_list = ''; 
              $menu_items = wp_get_nav_menu_items($menu->term_id); // получаем элементы по ID 
$menu_count = count($menu_items); 
              foreach ((array) $menu_items as $key => $item) { 

                $active_class = ($current_url == $item->url) ? 'png24 active' : ''; 
$last_class = ($menu_count == $item->menu_order) ? 'last' : ''; 
                $menu_list .= '<a href="' . $item->url . '" id="m' . ($key + 1) . '" class="' . $active_class . ' ' .$last_class . '">' . $item->title . '</a>'; 
              } 

              echo $menu_list;
              ?> 
              <div class="clear"></div>
            </div>