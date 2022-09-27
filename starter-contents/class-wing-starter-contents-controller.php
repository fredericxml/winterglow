<?php
/*
|--------------------------------------------------------------------------
| Starter Content Controller
|--------------------------------------------------------------------------
|
| Control when to import the starter contents.
|
*/

defined( 'ABSPATH' ) || exit;

class Wing_Starter_Contents_Controller {
  /**
   * Constructor
   */
  public function __construct() {
    self::do_first_contents_import();
    self::starter_contents_import_handler();
    // self::contents_cleaner();
  }

  /**
   * Only do the importing when the theme has been activated and
   * this installation has never done any import. We need to update
   * has_imported status first to avoid this function being called twice.
   *
   * @return void
   */
  private static function do_first_contents_import() {
    if ( ! get_option( 'wing_has_imported_starter_contents' ) ) {
      update_option( 'wing_has_imported_starter_contents', true );
      Wing_Starter_Contents_Importer::run();
      wp_redirect( admin_url( 'admin.php?page=wing-license-management' ) );
    }
  }
  
  /**
   * Starter contents import handler. This method handles
   * the submission from contents importer form page.
   *
   * @return void
   */
  private static function starter_contents_import_handler() {
    if ( isset( $_POST['wing_nonce'] ) && wp_verify_nonce( $_POST['wing_nonce'], 'import_starter_contents' ) ) {
      Wing_Starter_Contents_Importer::run();
    }
  }

  /**
   * Clear custom sections.
   *
   * @return void
   */
  private static function contents_cleaner() {
    global $wpdb;

    $sections = [
      'about_us',
      'banner',
      'client',
      'contact',
      'fact',
      'faq',
      'product',
      'service',
      'team',
      'testimonial'
    ];

    $sections_string = '';
    $sections_count = count( $sections );
    
    for ( $i = 0; $i < $sections_count; $i++ ) {
      $sections_string .= "'wing_" . $sections[$i] . "'";

      if ( $i < $sections_count - 1 ) {
        $sections_string .= ',';
      }
    }

    $query = "DELETE p, tr, pm
      FROM      $wpdb->posts              p
      LEFT JOIN $wpdb->term_relationships tr ON (p.ID = tr.object_id)
      LEFT JOIN $wpdb->postmeta           pm ON (p.ID = pm.post_id)
      WHERE p.post_type IN ( $sections_string )";

    $wpdb->query( $query );
  }
}

new Wing_Starter_Contents_Controller();