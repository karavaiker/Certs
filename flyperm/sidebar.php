<?php
/**
 * The sidebar containing the sms-form, owner block, weather block and social block.
 */
?>

<div class="cRight">
  <div class="pad">
      
    <span class="smsHead">
      <span>Подпишитесь на нашу рассылку</span>
      <span class="r"></span>
    </span>

    <div id="sms">
      <p id="pretext">Мы&nbsp;не&nbsp;спамим, все только по&nbsp;делу.</p>
      <?php //echo do_shortcode('[contact-form-7 id="21" title="SMS-рассылка"]'); ?>
      <?php echo do_shortcode('[wysija_form id="1"]'); ?>
    </div>
    
    <?php get_wp_block('owner_block');  //Owner's foto and status ?>

    <?php get_wp_block('weather_block');   //Links to the forecast ?>

    <?php get_wp_block('social_block');   //Links to social groups ?>
    </div>
</div>