<?php global $theme_settings; ?>



<?php
  // Scroll To Top Button

  if ( wing_get( $theme_settings['scroll_to_top_button']['show_button'] ) ) :
  
  $style = esc_attr('
    width:' . $theme_settings['scroll_to_top_button']['size'] . 'px;
    height:' . $theme_settings['scroll_to_top_button']['size'] . 'px;
    bottom:' . $theme_settings['scroll_to_top_button']['position'] . 'px;
  ');
?>
  <a href="#" class="footer-btn to-top-btn" style="<?php echo $style; ?>">
    <img class="w-100" src="<?php wing_img_url( 'top-arrow.svg' ) ?>" alt="To Top Button">
  </a>
<?php endif; ?>

<?php
  // WhatsApp Chat Button

  if ( wing_get( $theme_settings['wa_chat_button']['show_button'] ) ) :
  
  $wa_link = 'https://api.whatsapp.com/send?phone=' . $theme_settings['wa_chat_button']['number'] . '&text=' . $theme_settings['wa_chat_button']['message'];
  $style = esc_attr('
    width:' . $theme_settings['wa_chat_button']['size'] . 'px;
    bottom:' . $theme_settings['wa_chat_button']['position'] . 'px;
  ');
?>
  <a href="<?php echo $wa_link; ?>" class="footer-btn wa-chat-btn" style="<?php echo $style; ?>" target="_blank" rel="nofollow noreferrer">
    <img class="w-100" src="<?php wing_img_url( 'whatsapp.svg' ) ?>" alt="WhatsApp Chat Button">
  </a>
<?php endif; ?>

<footer>
  <div class="container text-center">
    &copy; <?php echo esc_html( get_theme_mod( 'wing_copyright_text', '2022 Winter Glow. All Rights Reserved. Designed by FD Code Studio.' ) ); ?>
  </div>
</footer>



<?php wp_footer(); ?>
</body>
</html>