<?php
/*
|--------------------------------------------------------------------------
| Custom Sections Base Class
|--------------------------------------------------------------------------
|
| This class provides the basic functions that the custom sections will use.
| The utilities include loading sections configurations from sections-config.php
| and managing settings storage of the settings on each section.
|
*/

defined( 'ABSPATH' ) || exit;

class Wing_Custom_Sections_Base {
  /**
   * List of sections with current type.
   *
   * @var array
   */
  protected $sections;

  /**
   * Constructor
   *
   * @param  string $type
   * @return void
   */
  protected function __construct( $type ) {
    $this->load_config( $type );
    $this->update_settings();
    add_action( 'admin_menu', [ $this, 'add_separator' ] );
  }

  /**
   * Load sections config and save appropriate type to class variable.
   * An empty array will be set if none of current type section is activated.
   *
   * @param  string $type
   * @return void
   */
  private function load_config( $type ) {
    require WING_THEME_PATH . 'inc/custom-sections/sections-config.php';
    $this->sections = wing_get( $sections[ $type ], [] );
  }

  /**
   * Setup the updater if any setting form is submitted and break the loop
   * while it has been updated to avoid redundant check. The section settings
   * is taken from section config.
   *
   * @return void
   */
  private function update_settings() {
    if ( isset( $_POST['wing_nonce'] ) ) {
      $section_settings = get_option( 'wing_section_settings', [] );
      
      foreach ( $this->sections as $section ) {
        if ( wp_verify_nonce( $_POST['wing_nonce'], 'update_section_' . $section['id'] ) ) {

          foreach ( $section['settings']['fields'] as $field ) {
            $value = $_POST['wing_section_' . $section['id'] . '_' . $field];

            // Determine how the data should be sanitized.
            switch ( $field ) {
              case 'img_src':
              case 'bg_img_src':
                $value = esc_url_raw( $value );
                break;

              case 'description':
                $value = sanitize_textarea_field( stripslashes( $value ) );
                break;

              default:
                $value = sanitize_text_field( stripslashes( $value ) );
            }

            $section_settings[ $section['id'] ][ $field ] = $value;
          }
          break;

        }
      }

      update_option( 'wing_section_settings', $section_settings );
    }
  }

  /**
   * Render the setting page view.
   *
   * @param  array $section
   * @return void
   */
  protected function render_setting_page( $section ) {
    if ( ! current_user_can( 'manage_options' ) ) {
      return;
    }

    // Get available setting fields for a particular section.
    $section_fields = [];
    foreach ($this->sections as $section_config) {
      if ( $section['id'] === $section_config['id'] ) {
        $section_fields = $section_config['settings']['fields'];
        break;
      }
    }

    // Get the setting value for each field in a particular section.
    $section_settings = get_option( 'wing_section_settings', [] );
    $settings = wing_get( $section_settings[ $section['id'] ], [] );
    
    // Render the view.
    require_once WING_THEME_PATH . 'inc/custom-sections/templates/setting-page.php';
  }

  /**
   * Add separator for custom sections to the admin menu.
   *
   * @return void
   */
  public function add_separator() {
    global $menu;
    $menu[29] = ['', 'read', '', '', 'wp-menu-separator'];
  }
}