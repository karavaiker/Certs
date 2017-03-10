<?php get_header(); ?>
<?php the_post_thumbnail('full', array('class' => 'vis')); ?>

</div>
</div>
<div class="clear"></div>

<div class="wr">
  <div id="content">
    <div id="wrap">
      <div class="cLeft">
         <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'content', 'page' ); ?>
	 <?php endwhile; // end of the loop. ?>
      </div>
      <div class="clear"></div>
    </div>
        
    <?php get_sidebar(); ?>
    <div class="clear"></div>
<?php get_footer(); ?>
  