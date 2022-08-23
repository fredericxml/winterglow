<?php
/*
|--------------------------------------------------------------------------
| Theme Core Settings
|--------------------------------------------------------------------------
|
| Setup the core functionality of the theme.
|
*/

defined( 'ABSPATH' ) || exit;

class Wing_Theme_Core {
  /**
   * List of sections with their corresponding display name.
   *
   * @var array
   */
  protected $sections;

  /**
   * Constructor
   *
   * @return void
   */
  public function __construct() {
    $this->set_sections_map();
    self::import_starter_contents();
    add_action( 'admin_menu', [ $this, 'register_menu' ] );
  }

  /**
   * Register menu for the theme main pages.
   *
   * @return void
   */
  public function register_menu() {
    add_menu_page(
      'Winter Glow',
      'Winter Glow',
      'manage_options',
      'wing-theme-core',
      [ $this, 'render_welcome_page' ],
      '',
      30
    );
    add_submenu_page(
      'wing-theme-core',
      'Theme Settings',
      'Settings',
      'manage_options',
      'wing-theme-settings',
      [ $this, 'render_setting_page' ]
    );
    add_submenu_page(
      'wing-theme-core',
      'Starter Contents',
      'Starter Contents',
      'manage_options',
      'wing-starter-contents',
      [ $this, 'render_import_starter_contents_page' ]
    );
  }
  
  /**
   * Import starter contents.
   *
   * @return void
   */
  private static function import_starter_contents() {
    if ( isset( $_POST['wing_nonce'] ) && wp_verify_nonce( $_POST['wing_nonce'], 'import_starter_contents' ) ) {
      // Run the importer.
      new Wing_Starter_Contents_Importer();
    }
  }

  /**
   * Set the list of sections with their corresponding display name.
   *
   * @return void
   */
  protected function set_sections_map() {
    $this->sections = require WING_THEME_PATH . 'inc/theme-core/sections-map.php';
  }
  
  /**
   * Render the welcome page view.
   *
   * @return void
   */
  public function render_welcome_page() {
    require_once WING_THEME_PATH . 'inc/theme-core/templates/welcome.php';
  }

  /**
   * Render the setting page view.
   *
   * @return void
   */
  public function render_setting_page() {
    $settings = get_option( 'wing_theme_settings', [] );

    require_once WING_THEME_PATH . 'inc/theme-core/templates/theme-settings.php';
  }

  /**
   * Render the import starter contents view.
   *
   * @return void
   */
  public function render_import_starter_contents_page() {
    $settings = get_option( 'wing_theme_settings', [] );

    require_once WING_THEME_PATH . 'inc/theme-core/templates/import-starter-contents.php';
  }
}

new Wing_Theme_Core();