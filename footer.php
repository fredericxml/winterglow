<?php global $theme_settings; ?>



<?php
  // Scroll To Top Button

  if ( wing_get( $theme_settings['scroll_to_top_button']['show_button'] ) ) :
  
  $style = array(
    'width'  => $theme_settings['scroll_to_top_button']['size'] . 'px',
    'height' => $theme_settings['scroll_to_top_button']['size'] . 'px',
    'bottom' => $theme_settings['scroll_to_top_button']['position'] . 'px'
  );
?>
  <a href="#" class="footer-btn to-top-btn" style="<?php wing_generate_style_string( $style ); ?>">
    <img class="w-100" src="<?php wing_img_url( 'top-arrow.svg' ) ?>" alt="To Top Button">
  </a>
<?php endif; ?>

<?php
  // WhatsApp Chat Button

  if ( wing_get( $theme_settings['wa_chat_button']['show_button'] ) ) :
  
  $style = array(
    'width'  => $theme_settings['wa_chat_button']['size'] . 'px',
    'bottom' => $theme_settings['wa_chat_button']['position'] . 'px'
  );
  
  if ( Wing_Theme_Guard::is_safe() ) :
    $wa_link = sprintf( 'https://api.whatsapp.com/send?phone=%s&text=%s', $theme_settings['wa_chat_button']['number'], $theme_settings['wa_chat_button']['message'] );
?>
    <a href="<?php echo $wa_link; ?>" class="footer-btn wa-chat-btn" style="<?php wing_generate_style_string( $style ); ?>" target="_blank" rel="nofollow noreferrer">
  <?php else : ?>
    <a href="#!" class="footer-btn wa-chat-btn" style="<?php wing_generate_style_string( $style ); ?>">
  <?php endif; ?>
  
    <img class="w-100" src="<?php wing_img_url( 'whatsapp.svg' ) ?>" alt="WhatsApp Chat Button">
  </a>
<?php endif; ?>

<footer>
  <div class="container text-center">
    &copy; 
    <?php
      $year = ( new DateTime() )->format( 'Y' );
      $fcos = '<a href="https://fdcodestudio.my.id">FD Code Studio</a>';
      $default_copyright = "$year Winter Glow. All Rights Reserved. Designed by $fcos.";

      if ( Wing_Theme_Guard::is_safe() ) {
        $custom_copyright = get_theme_mod( 'wing_copyright_text' );
        
        if ( $custom_copyright ) {
          echo esc_html( $custom_copyright );
        } else {
          echo $default_copyright;
        }
      } else {
        echo $default_copyright;
      }
    ?>
  </div>
</footer>



<?php if ( ! Wing_Theme_Guard::is_safe() ) : ?>

<style>
.modal {
  background-color: rgba(0, 0, 0, 0.4);
  height: 100%;
  width: 100%;
  position: fixed;
  top: 0;
  overflow: auto;
  z-index: 1080;
}
.modal-content {
  background-color: #fefefe;
  position: relative;
  width: 60%;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.2);
  border: 1px solid #888;
  margin: 15% auto;
  animation-name: slidedown;
  animation-duration: 0.4s;
}
.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: var(--wing-bg-light);
  color: var(--wing-primary);
  font-family: "Exo", sans-serif;
  padding: 0.5rem 1.5rem 0.25rem;
}
.modal-body {
  padding: 1.25rem 1.5rem;
}
.close {
  color: var(--wing-text-gray);
  font-size: 2rem;
  font-weight: 700;
  cursor: pointer;
  transition: var(--wing-transition);
}
.close:hover,
.close:focus {
  color: var(--wing-text-dark);
}
@keyframes slidedown {
  from {
    top: -300px;
    opacity: 0;
  }
  to {
    top: 0;
    opacity: 1;
  }
}
</style>

<div class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="mb-0">Theme is Inactive</h2>
      <span class="close">&times;</span>
    </div>
    <div class="modal-body">
      <p>Lisensi template website ini belum diaktivasi/telah berakhir!</p>
      <p>Silahkan lakukan aktivasi/perpanjangan lisensi untuk mengaktifkan kembali website Anda.</p>
      <p>Jika Anda belum memiliki lisensi, Anda dapat menghubungi nomor WhatsApp <a href="https://api.whatsapp.com/send?phone=6282362361344&text=Halo+kak,+saya+ingin+melakukan+order+lisensi+tema+Winter+Glow">0823 6236 1344</a> untuk melakukan order… :)</p>
    </div>
  </div>
</div>

<script>
(function() {
  const modal  = document.getElementsByClassName('modal')[0];
  const close  = document.getElementsByClassName('close')[0];
  const button = document.getElementsByClassName('wa-chat-btn')[0];
  
  button.addEventListener('click', function() {
    modal.style.display = 'block';
  });
  
  close.addEventListener('click', function() {
    modal.style.display = 'none';
  });
  
  window.addEventListener('click', function(event) {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });
})();
</script>

<?php endif; ?>



<?php wp_footer(); ?>
</body>
</html>