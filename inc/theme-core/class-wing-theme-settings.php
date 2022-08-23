<?php
/*
|--------------------------------------------------------------------------
| Theme Settings
|--------------------------------------------------------------------------
|
| Handle the process of customizing theme settings, i.e. sections visibility,
| scroll to top button, and WhatsApp chat button.
|
*/

defined( 'ABSPATH' ) || exit;

class Wing_Theme_Settings extends Wing_Theme_Core {
  /**
   * Constructor
   * 
   * Call the set_sections_map() to initialize the $this->sections variable.
   *
   * @return void
   */
  public function __construct() {
    $this->set_sections_map();
    $this->update_settings();
  }

  /**
   * Setup the updater if the setting form is submitted and do refresh to
   * make the sections on the menu list updated automatically.
   *
   * @return void
   */
  private function update_settings() {
    if ( isset( $_POST['wing_nonce'] ) && wp_verify_nonce( $_POST['wing_nonce'], 'update_theme_settings' ) ) {
      $theme_settings = get_option( 'wing_theme_settings', [] );

      // Sections Visibility
      foreach ( $this->sections as $section ) {
        $theme_settings['sections'][ $section['id'] ] = isset( $_POST['wing_section_' . $section['id']] );
      }
    
      // Scroll To Top Button
      $theme_settings['scroll_to_top_button'] = [
        'show_button' => isset( $_POST['wing_scroll_to_top_button'] ),
        'size'        => sanitize_text_field( $_POST['wing_scroll_to_top_button_size'] ),
        'position'    => sanitize_text_field( $_POST['wing_scroll_to_top_button_position'] )
      ];
      
      // WhatsApp Chat Button
      $theme_settings['wa_chat_button'] = [
        'show_button' => isset( $_POST['wing_wa_chat_button'] ),
        'number'      => sanitize_text_field( $_POST['wing_wa_chat_button_number'] ),
        'message'     => sanitize_textarea_field( $_POST['wing_wa_chat_button_message'] ),
        'size'        => sanitize_text_field( $_POST['wing_wa_chat_button_size'] ),
        'position'    => sanitize_text_field( $_POST['wing_wa_chat_button_position'] )
      ];
      
      update_option( 'wing_theme_settings', $theme_settings );
      wp_redirect( $_SERVER['HTTP_REFERER'] );
    }
  }
}

new Wing_Theme_Settings();