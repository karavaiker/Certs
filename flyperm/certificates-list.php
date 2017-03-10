<?php
/*
Archive Template: Certificates List
*/

get_header(); ?>

    </div>
    </div>
    <div class="clear"></div>

    <div class="wr">
    <div id="content">
    <div id="wrap">
        <div class="cLeft">
            <header class="archive-header">
                <h2 class="archive-title"><?php echo single_cat_title('', false); ?></h2>
                <?$cat_description = category_description();?>
            </header><!-- .archive-header -->
            <div class="hr"></div>


                <?
                global $post;
                //Собираем посты по времени
                $posts = get_posts(array(
                    'posts_per_page'   => 90,
                    'offset'           => 0,
                    'category' => 4,
                    'meta_key'			=> 'cert_price',
                    'orderby'			=> 'meta_value_num',
                    'order'				=> 'ASC',
                    'meta_query' => array(
                        array(
                            'key' => 'is_cert_time',
                            'value' => '"time"',
                            'compare' => 'LIKE'
                        )
                    )
                ));
                ?>

                <?php if( $posts ):?>
                    <h3>По времени</h3>
                    <div class="block-cert-wp">
                    <? foreach ( $posts as $post ):
                        setup_postdata( $post );?>

                    <a href="<?echo get_permalink();?>" class="card-cert">
                        <div class="card-cert-image" style="background-image: url('<?echo the_post_thumbnail_url();?>')"></div>
                        <div class="card-cert-header"><?echo get_the_title();?></div>
                        <?$price = get_post_meta(get_the_ID(), 'cert_price', true);
                        if (!empty($price)){
                            $price.=' руб.';
                        }
                        ?>
                        <div class="card-cert-price"><b><?=$price?></b></div>
                    </a>
                <?endforeach;
                    wp_reset_postdata();?>
                    </div>
                <?endif;?>



                <?
                global $post;
                //Собираем все посты кроме тех, что времени
                $posts = get_posts(array(
                    'posts_per_page'   => 90,
                    'offset'           => 0,
                    'category' => 4,
                    'meta_key'			=> 'cert_price',
                    'orderby'			=> 'meta_value_num',
                    'order'				=> 'ASC',
                    'meta_query' => array(
                        array(
                            'key' => 'is_cert_time', // name of custom field
                            'value' => '"time"', // matches exactly "red"
                            'compare' => 'NOT LIKE'
                        )
                    )
                ));
                ?>

            <?php if( $posts ):?>
                <div class="hr"></div>
                <h3>Специальные предложения</h3>
                <div class="block-cert-wp">
                    <? foreach ( $posts as $post ):
                        setup_postdata( $post );?>

                        <a href="<?echo get_permalink();?>" class="card-cert">
                            <div class="card-cert-image" style="background-image: url('<?echo the_post_thumbnail_url();?>')"></div>
                            <div class="card-cert-header"><?echo get_the_title();?></div>
                            <?$price = get_post_meta(get_the_ID(), 'cert_price', true);
                            if (!empty($price)){
                                $price.=' руб.';
                            }
                            ?>
                            <div class="card-cert-price"><b><?=$price?></b></div>
                        </a>
                    <?endforeach;
                    wp_reset_postdata();?>
                </div>
            <?endif;?>



            <div class="hr"></div>
            <?php if (category_description()) : // Show an optional category description ?>
                <div class="archive-meta"><?php echo $cat_description; ?></div>
            <?php endif; ?>
        </div>
        <div class="clear"></div>
    </div>

    <?php get_sidebar(); ?>
    <div class="clear"></div>
<?php get_footer(); ?>