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
   *
   * @return void
   */
  public function __construct() {
    self::import_contents();
    // self::contents_cleaner();
  }

  /**
   * Only do the importing when the theme installation has never done. After
   * the process, do redirect to avoid this function being called twice.
   *
   * @return void
   */
  private static function import_contents() {
    if ( ! get_option( 'wing_has_imported_starter_contents' ) ) {
      // Run the importer.
      new Wing_Starter_Contents_Importer();

      update_option( 'wing_has_imported_starter_contents', true );
      wp_redirect( admin_url( 'admin.php?page=wing-theme-core' ) );
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