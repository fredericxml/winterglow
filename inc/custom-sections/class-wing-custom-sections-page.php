<?php
/*
|--------------------------------------------------------------------------
| One-Page Sections
|--------------------------------------------------------------------------
|
| The sections that are constructed using the WordPress menu page.
|
*/

defined( 'ABSPATH' ) || exit;

class Wing_Custom_Sections_Page extends Wing_Custom_Sections_Base {
  /**
   * Constructor
   *
   * @return void
   */
  public function __construct() {
    parent::__construct( 'page' );
    add_action( 'admin_menu', [ $this, 'register_menu' ] );
  }

  /**
   * Register section as menu.
   *
   * @return void
   */
  public function register_menu() {
    foreach ( $this->sections as $section ) {
      add_menu_page(
        $section['name'],
        $section['name'],
        'manage_options',
        'wing-section-' . $section['id'] . '-settings',
        function() use ( $section ) { $this->render_setting_page( $section ); },
        'dashicons-open-folder',
        31
      );
    }
  }
}

new Wing_Custom_Sections_Page();