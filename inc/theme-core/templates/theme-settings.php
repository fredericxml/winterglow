<div class="wrap wing setting-page">
  <h1>Theme Settings</h1>

  <form action="" method="post">
    <?php wp_nonce_field( 'update_theme_settings', 'wing_nonce' ); ?>

    <h2>Sections</h2>
    <table class="form-table">
      <?php foreach ( $this->sections as $section ) : ?>
        <tr>
          <th><?php _e( $section['name'], 'wing' ); ?></th>
          <td>
            <label for="wing-section-<?php echo $section['id']; ?>">
              <input
                type="checkbox"
                name="wing_section_<?php echo $section['id']; ?>"
                id="wing-section-<?php echo $section['id']; ?>"
                value="1"
                <?php echo wing_get( $settings['sections'][$section['id']] ) ? 'checked' : ''; ?>
              >
              Tampilkan section
            </label>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>

    <h2>Footer</h2>
    <table class="form-table">
      <tr>
        <th><?php _e( 'Scroll To Top Button', 'wing' ); ?></th>
        <td>
          <div class="inner-row">
            <label for="wing-scroll-to-top-button">
              <input
                type="checkbox"
                name="wing_scroll_to_top_button"
                id="wing-scroll-to-top-button"
                value="1"
                <?php echo wing_get( $settings['scroll_to_top_button']['show_button'] ) ? 'checked' : ''; ?>
              >
              Tampilkan tombol
            </label>
          </div>
          <div class="inner-row">
            <label for="wing-scroll-to-top-button-size"><?php _e( 'Ukuran tombol', 'wing' ); ?></label>
            <input
              type="number"
              class="small-text"
              name="wing_scroll_to_top_button_size"
              id="wing-scroll-to-top-button-size"
              min="0"
              value="<?php echo esc_attr( wing_get( $settings['scroll_to_top_button']['size'] ) ); ?>"
            >
            <span>px</span>
          </div>
          <div class="inner-row">
            <label for="wing-scroll-to-top-button-position"><?php _e( 'Posisi tombol', 'wing' ); ?></label>
            <input
              type="number"
              class="small-text"
              name="wing_scroll_to_top_button_position"
              id="wing-scroll-to-top-button-position"
              value="<?php echo esc_attr( wing_get( $settings['scroll_to_top_button']['position'] ) ); ?>"
            >
            <span>px</span>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php _e( 'WhatsApp Chat Button', 'wing' ); ?></th>
        <td>
          <div class="inner-row">
            <label for="wing-wa-chat-button">
              <input
                type="checkbox"
                name="wing_wa_chat_button"
                id="wing-wa-chat-button"
                value="1"
                <?php echo wing_get( $settings['wa_chat_button']['show_button'] ) ? 'checked' : ''; ?>
              >
              Tampilkan tombol
            </label>
          </div>
          <div class="inner-row">
            <label for="wing-wa-chat-button-number"><?php _e( 'Nomor WhatsApp', 'wing' ); ?></label>
            <input
              type="text"
              class="regular-text"
              name="wing_wa_chat_button_number"
              id="wing-wa-chat-button-number"
              value="<?php echo esc_attr( wing_get( $settings['wa_chat_button']['number'] ) ); ?>"
            >
          </div>
          <div class="inner-row">
            <label for="wing-wa-chat-button-message"><?php _e( 'Pesan default', 'wing' ); ?></label>
            <textarea
              class="regular-text code"
              name="wing_wa_chat_button_message"
              id="wing-wa-chat-button-message"
              rows="5"
            ><?php echo esc_textarea( wing_get( $settings['wa_chat_button']['message'] ) ); ?></textarea>
          </div>
          <div class="inner-row">
            <label for="wing-wa-chat-button-size"><?php _e( 'Ukuran tombol', 'wing' ); ?></label>
            <input
              type="number"
              class="small-text"
              name="wing_wa_chat_button_size"
              id="wing-wa-chat-button-size"
              min="0"
              value="<?php echo esc_attr( wing_get( $settings['wa_chat_button']['size'] ) ); ?>"
            >
            <span>px</span>
          </div>
          <div class="inner-row">
            <label for="wing-wa-chat-button-position"><?php _e( 'Posisi tombol', 'wing' ); ?></label>
            <input
              type="number"
              class="small-text"
              name="wing_wa_chat_button_position"
              id="wing-wa-chat-button-position"
              value="<?php echo esc_attr( wing_get( $settings['wa_chat_button']['position'] ) ); ?>"
            >
            <span>px</span>
          </div>
        </td>
      </tr>
    </table>

    <p class="submit">
      <input type="submit" class="button-primary" value="Save Changes">
    </p>
  </form>
</div>