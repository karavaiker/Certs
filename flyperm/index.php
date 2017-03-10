<?php
/**
 * The main template file.
 *
 */
?>
<?php get_header(); ?>
<?php get_wp_block('visualimage_main'); ?>
</div>
</div>
<div class="clear"></div>
<div class="wr">
  <div id="content">
    <div id="wrap">
      <div class="cLeft">
         <?php get_wp_block('main_today'); ?>
 	<div class="hr">&nbsp;</div>
	 
	 <div class="main">
		<ul class="sp">
			<li class="first"><?php get_wp_block('first_block'); ?></li>
			<li><?php get_wp_block('second_block'); ?></li>
			<li class="last"><?php get_wp_block('third_block'); ?></li>
		</ul>
		<div class="clear">&nbsp;</div>
	 </div>
	 <div class="hr">&nbsp;</div>

         <?php $main = new WP_query(); $main->query('page_id=25'); ?> 
              <?php while ($main->have_posts()) : $main->the_post(); ?>
              <?php get_template_part( 'content', 'page' ); ?>
         <?php endwhile; ?>
      </div>
    </div>
    <?php get_sidebar(); ?>
    <div class="clear"></div>

    <?php get_footer(); ?>