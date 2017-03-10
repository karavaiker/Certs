<?php
/*
Template Name: Print Certificate
*/
?>

<?php
$inv_key = $_GET['key'];
global $wpdb;
$table_name = $wpdb->prefix . "invoices";

$cert_info = $wpdb->get_results("SELECT * FROM $table_name WHERE invoice_key = '$inv_key'");
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

    <link rel="stylesheet" media="print" type="text/css"
          href="<?php echo get_template_directory_uri(); ?>/css/print.css"/>

    <title>Печать сертификата</title>
</head>
<body>
<img src="/pics/bg/logo.gif" alt="" id="print_logo"/>
<div id="main" class="print_certificate">
    <div id="wrapper_cert" class="png24 cert_body">
        <div class="wr">
            <div id="content">
                <div id="wrap">
                    <div class="cLeft">
                        <div class="cert_info">
                            <div id="sertificate">Сертификат<?php //echo $cert_info[0]->cert_name; ?></div>
                            <? $bt_cert_name = str_replace("Сертификат", "", $cert_info[0]->cert_name );?>
                            <p><span class="red"><?php echo $bt_cert_name?></span></p>
                            <p>Стоимость сертификата - <span
                                    class="red"><?php echo $cert_info[0]->cert_price; ?></span> руб.</p>
                        </div>
                        <div class="cert_content">
                            <h2>Будущий парапланерист!</h2>
                            <p> Каждый владелец нашего сертификата имеет замечательную возможность осуществить древнюю
                                мечту Человечества — парить как птица! Для этого у нас есть оборудование мирового
                                уровня и команда профессиональных пилотов, в совершенстве владеющих своими
                                «крыльями».</p>
                            <p>Позвоните по телефону — 2-775-774 или загляните в группу «Школа пилотов
                                «ВЕКТОР-Пермь» (vk.ru\ﬂyperm), либо на сайт школы (ﬂy.perm.ru), узнайте, когда в
                                ближайшее время производятся полеты и приезжайте к нам в гости! Мы работаем в 5 км
                                от города, на аэродроме «Фролово» (т-кт Нестюковский, д.1Б), зимой — по выходным
                                дням с 11.00, летом — каждый день, в будни с 18.00, в выходные с 11.00. Не летаем в
                                дождь и сильный ветер. Просим Вас отнестись с пониманием, если полеты в тот день,
                                когда Вы запланировали, отменятся по погодным условиям. Мы заботимся в первую
                                очередь о безопасности.</p>
                            <p>Форма одежды на полетах: летом — длинный рукав и штанина, спортивная обувь, зимой —
                                лучшая одежда для полетов горнолыжно-бордическая, но если у Вас ее нет, мы
                                предоставим летный комбинезон, а также шлем, маску, балаклаву и перчатки. Да! И
                                огромные теплые валенки!</p>
                            <p>Каждому пассажиру мы предлагаем взять в полет нашу видеокамеру и снять репортаж о
                                своём приключении. Забрать видео Вы сможете на видеоканале
                                (www.youtube.com/user/89028015774) нашего клуба. Его легко найти, введя в поиске наш
                                номер телефона.</p>
                            <p>До встречи в полете, друзья!</p>
                        </div>
                    </div>
                </div>

                <div class="cert_bottom">
                    <div class="map"><img src="/pics/map.jpg"/></div>
                    <div class="qr_content">
                        <span>Действителен до:</span><br>
                        <?php $cert_actual_date = date('d.m.Y', strtotime('+1 year', strtotime($cert_info[0]->invoice_date))); ?>
                            <span class="red"><?php echo $cert_actual_date; ?></span>
                        <?php
                            $url = 'http://fly.perm.ru/close-certificate?key=' . $inv_key . '&action=close';
                            echo do_shortcode("[qrcode content=$url size='120' alt='QR Code']");
                        ?>
                    </div>
                    <p id="cert_code">Код сертификата: <?php echo $inv_key; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>