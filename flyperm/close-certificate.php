<?php
/*
Template Name: Close Certificate
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="height: 500px;">
  <head>
    <meta name="" http-equiv="content-type" content="text/html;charset=<?php bloginfo('charset'); ?>"/>

    <link rel="shortcut icon" href="/pics/favicon.ico" type="image/x-icon"/>
    <link rel="icon" href="/pics/favicon.ico" type="image/x-icon"> 

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" type="text/css" media="all"/>
    

    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/common.js"></script>

    <link rel="stylesheet" media="print" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/print.css" />

    <title>Закрытие сертификата</title>
  </head>
  <body>
    <img src="/pics/bg/logo.gif" alt="" id="print_logo"/>
    <div id="main" class="print_certificate">
      <div class="top png24"></div>
      <div id="wrapper" class="png24">
        <div id="header">
          <div id="wrap">
            <div class="cLeft">
                <a href="/">
                  <img src="/pics/bg/logo.gif" id="logo">
                </a>
                <div class="head">
                  
		</div>
            </div>
          </div>
        </div>
        <div class="visualMain">
          <div class="pad"></div>
		</div>
		<div class="clear"></div>

		<div class="wr">
			<div id="content">
				<div id="wrap">	
					<?php
            					if(isset($_GET['paid'])) { ?>
               						<div class="payment_mess">Сертификат использован и закрыт!</div>
            					<?php } elseif (isset($_GET['closed'])) { ?>
               						<div class="payment_mess">Сертификат уже был использован!</div>
            					<?php } elseif (isset($_GET['other'])) { ?>
               						<div class="payment_mess">Сертификат либо не оплачен, либо находится в оплате!</div>
            					<?php } else { ?>
							<?php while ( have_posts() ) : the_post(); ?>
            							<?php get_template_part( 'content', 'page' ); ?>
	 						<?php endwhile; // end of the loop. ?>
						<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
        </div>
      </div>

      <div class="bWrap">
        <div id="footer">
          <div class="pad">
            <div class="infoBottom">По вопросам организации полетов звоните Алексею Иванову  <span>(342) 277-57-74</span></div>
          </div>
        </div>
        <div class="bottom png24"></div>
	  </div>
    </div>
  </body>
</html>