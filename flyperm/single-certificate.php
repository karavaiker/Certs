<?php
/*
Template Name: Single Certificate
*/
?>

<?php get_header(); ?>
    </div>
    </div>
    <div class="clear"></div>

    <div class="wr">
    <div id="content">
    <div id="wrap">
        <div class="cLeft">

            <?php
            if (isset($_GET['success'])) { ?>
                <div class="payment_mess">Спасибо! Оплата прошла успешно. Сертификат отправлен на Вашу почту.</div>
            <?php } elseif (isset($_GET['fail'])) { ?>
                <div class="payment_mess">Оплата сертификата закончилась с ошибкой. Попробуйте еще раз.</div>
                <?php
            }
            ?>

            <div class="bg-immg-full-cert" style="background-image: url('<?= the_post_thumbnail_url() ?>')"></div>
            <?php while (have_posts()) : the_post(); ?>
            <? $price = get_post_meta(get_the_ID(), 'cert_price', true);?>
                <form class="cert-buy-form" action="/buy" method="POST">
                    <input type="hidden" name="cert_name" value="<? echo get_the_title();?>">
                    <input type="hidden" name="cert_price" value="<? echo $price;?>">
                    <input type="hidden" name="post_id" value="<? echo get_the_ID()?>">
                    
                    <div>
                        <input type="email" name="email" class="cert-email-input" placeholder="Введите ваш email" required>
                    </div>
                    <div>
                        <input type="submit" class="cert-buy-btn" value="Купить">
                    </div>
                </form>

                <div class="cert-post-header"><? echo get_the_title(); ?></div>
                <? if (!empty($price)) { $price .= ' руб.'; } ?>
                <div class="cert-post-price">Цена: <b><?= $price ?></b></div>
                <?php the_content(); ?>
            <?php endwhile; ?>


        </div>
        <div class="clear"></div>
    </div>


    <?php get_sidebar(); ?>
    <div class="clear"></div>
<?php get_footer(); ?>