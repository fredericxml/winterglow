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
   */
  public function __construct() {
    $this->set_sections_map();
    add_action( 'wp_head', [ $this, 'theme_guard_style_support' ] );
    add_action( 'rest_api_init', [ $this, 'create_routes' ] );
    add_action( 'admin_menu', [ $this, 'register_menu' ] );
    add_action( 'admin_notices', [ $this, 'theme_guard_notification_support' ] );
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
      'Starter Contents',
      'Starter Contents',
      'manage_options',
      'wing-starter-contents',
      [ $this, 'render_import_starter_contents_page' ]
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
      'License',
      'License',
      'manage_options',
      'wing-license-management',
      [ $this, 'render_license_management_page' ]
    );
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
  
  /**
   * Render the license management view.
   *
   * @return void
   */
  public function render_license_management_page() {
    require_once WING_THEME_PATH . 'inc/theme-core/templates/license-activation.php';
  }

  /**
   * Set the theme installation date.
   *
   * @return void
   */
  public static function set_installation_date() {
    if ( ! get_option( 'wing_installation_date' ) ) {
      $today = new DateTime();
      update_option( 'wing_installation_date', $today->format( 'Y-m-d' ) );
    }
  }

  /**
   * Register routes for API calls.
   *
   * @return void
   */
  public function create_routes() {
    register_rest_route( 'flm/v1', '/update-license', [
      'methods' => 'POST',
      'callback' => [ $this, 'update_license_data' ],
      'permission_callback' => function ( WP_REST_Request $request ) {
        $rule_1 = $request['secret_key'] === WING_SPECIAL_SECRET_KEY;
        $rule_2 = isset( $request['lic_status'] )   &&
                  isset( $request['date_expiry'] )  &&
                  isset( $request['license_key'] )  &&
                  isset( $request['email'] )        &&
                  isset( $request['registered_domains'] );

        if ( $rule_1 && $rule_2 ) {
          return true;
        } else {
          return false;
        }
      }
    ]);

    register_rest_route( 'flm/v1', '/remove-domain', [
      'methods' => 'POST',
      'callback' => [ $this, 'remove_registered_domain' ],
      'permission_callback' => function ( WP_REST_Request $request ) {
        $rule_1 = $request['secret_key'] === WING_SPECIAL_SECRET_KEY;
        $rule_2 = isset( $request['license_key'] ) && isset( $request['current_domain'] );

        if ( $rule_1 && $rule_2 ) {
          return true;
        } else {
          return false;
        }
      }
    ]);
  }
  
  /**
   * Update license data locally whenever it has been updated on the license server.
   * This method also used to update the status of license expiration.
   * To ensure license integrity between client and server.
   *
   * @param  WP_REST_Request $request
   * @return mixed
   */
  public function update_license_data( WP_REST_Request $request ) {
    update_option( 'wing_lic_data', [
      'status'             => $request['lic_status'],
      'date_expiry'        => $request['date_expiry'],
      'lic_key'            => $request['license_key'],
      'email'              => $request['email'],
      'registered_domains' => $request['registered_domains']
    ]);
    
    return rest_ensure_response( [ 'message' => 'License data was successfully updated!' ] );
  }
  
  /**
   * Delete license data locally when the domain has been removed
   * from the license server.
   *
   * @return mixed
   */
  public function remove_registered_domain() {
    delete_option( 'wing_lic_data' );
    
    return rest_ensure_response([
      'status'  => 'success',
      'message' => 'The domain was successfully removed!'
    ]);
  }

  /**
   * Handle the license activation process where an API request
   * will be sent to the license server. After a successful activation,
   * this method will call update_local_license() to update the license data locally.
   *
   * @return void
   */
  public static function activate_license() {
    if ( isset( $_POST['wing_nonce'] ) && wp_verify_nonce( $_POST['wing_nonce'], 'activate_license' ) ) {
      $license_key    = sanitize_text_field( $_POST['wing_license_key'] );
      $current_domain = trim( str_replace( [ 'http://', 'https://', 'www.' ], '', get_home_url() ), '/' );

      $api_params = array(
        'rest_route'        => '',
        'slm_action'        => 'slm_activate',
        'license_key'       => $license_key,
        'registered_domain' => $current_domain,
        'secret_key'        => WING_SPECIAL_SECRET_KEY
      );

      $query = esc_url_raw( add_query_arg( $api_params, WING_LICENSE_SERVER_URL ) );
      $response = wp_remote_get( $query, [ 'timeout' => 20, 'sslverify' => false ] );

      if ( is_wp_error( $response ) ) {
        $message = $response->get_error_message();
        echo '<div id="message" class="updated fade"><p>';
        echo 'Error: ' . $message;
  			echo '</p></div>';
        return;
      }
      
      $license_data = json_decode( wp_remote_retrieve_body( $response ) );

      if ( $license_data->result === 'success' ) {
        $query = self::update_local_license( $license_key );
        
        if ( $query ) {
          echo '<div id="message" class="updated fade"><p>';
          echo 'Selamat, tema Winter Glow Anda telah berhasil diaktivasi. Nikmati kemudahan mengelola website bersama Winter Glow!';
          echo '</p></div>';
        }        
      }
      else {
        echo '<div id="message" class="updated fade"><p>';
        echo 'Error: ' . $license_data->message;
  			echo '</p></div>';
      }
    }
  }

  /**
   * Store the license data of the successfully activated key where
   * an API request is sent to retrieve the data.
   * This method will be called if and only if the activation was success.
   * It will return true/false indicating the process status.
   *
   * @param  string $license_key
   * @return boolean
   */
  private static function update_local_license( $license_key ) {
    $api_params = array(
      'rest_route'  => '',
      'slm_action'  => 'slm_check',
      'license_key' => $license_key,
      'secret_key'  => WING_SPECIAL_SECRET_KEY
    );

    $query = esc_url_raw( add_query_arg( $api_params, WING_LICENSE_SERVER_URL ) );
    $response = wp_remote_get( $query, [ 'timeout' => 20, 'sslverify' => false ] );

    if ( is_wp_error( $response ) ){
      $message = $response->get_error_message();
      echo '<div id="message" class="updated fade"><p>';
      echo 'Error: ' . $message;
      echo '</p></div>';
      return false;
    }

    $license_data = json_decode( wp_remote_retrieve_body( $response ) );

    $registered_domains = [];
    foreach ( $license_data->registered_domains as $domain ) {
      $registered_domains[] = $domain->registered_domain;
    }
    
    update_option( 'wing_lic_data', [
      'status'             => $license_data->status,
      'date_expiry'        => $license_data->date_expiry,
      'lic_key'            => $license_data->license_key,
      'email'              => $license_data->email,
      'registered_domains' => $registered_domains
    ]);

    return true;
  }

  /**
   * Support the Wing_Theme_Guard::is_safe() by providing admin notice.
   *
   * @return void
   */
  public function theme_guard_notification_support() {
    $license_data = get_option( 'wing_lic_data' );

    if ( empty( $license_data ) ) {
      $today    = new DateTime();
      $interval = $today->diff( new DateTime( get_option( 'wing_installation_date' ) ) );
      $used     = intval( $interval->format( '%a' ) );

      if ( $used <= 30 ) {
        $left = 30 - $used;

        echo '<div class="notice notice-warning"><p>';
        echo 'PENTING: Template Anda sedang berada pada masa trial yang akan berakhir ';
        echo ( $left > 1 ? "dalam $left hari" : ( $left === 1 ? 'besok' : 'hari ini' ) );
        echo '. Segera lakukan aktivasi agar tema Anda tetap aktif!';
        echo '</p></div>';
      }
      else {
        echo '<div class="notice notice-warning"><p>';
        echo 'PENTING: Template Anda sedang tidak aktif. Semua gambar halaman utama menjadi blur!';
        echo '</p></div>';
      }
    }
  }

  /**
   * Support the Wing_Theme_Guard::is_safe() by providing style sheet.
   *
   * @return void
   */
  public function theme_guard_style_support() {
    if ( ! Wing_Theme_Guard::is_safe() ) {
      echo '<style>.wing .section i { filter: blur(8px); } .wing .section img { filter: blur(1px); }</style>';
    }
  }
}

class Wing_Theme_Guard {
  public static function is_safe() {
    $today        = new DateTime();
    $license_data = get_option( 'wing_lic_data' );
    
    if ( empty( $license_data ) ) {
      $interval = $today->diff( new DateTime( get_option( 'wing_installation_date' ) ) );
      $used     = intval( $interval->format( '%a' ) );

      // Validation
      if ( $interval->format( '%R' ) === '+' ) {
        return false;
      }
      
      if ( $used <= 30 ) {
        return true;
      } else {
        return false;
      }
    }

    $current_domain = trim( str_replace( [ 'http://', 'https://', 'www.' ], '', get_home_url() ), '/' );
    $interval       = $today->diff( new DateTime( $license_data['date_expiry'] ) );

    $is_active       = $license_data['status'] === 'active' ? true : false;
    $is_valid_domain = in_array( $current_domain, $license_data['registered_domains'] );
    $is_not_expired  = $interval->format( '%R' ) === '+'; // Greater than today
    
    if ( $is_active && $is_not_expired && $is_valid_domain ) {
      return true;
    } else {
      return false;
    }
  }
}

define( 'WING_LICENSE_SERVER_URL', 'https://license.fdcodestudio.my.id' );
define( 'WING_SPECIAL_SECRET_KEY', '77217A25432A462D4A404E635266556A' );

Wing_Theme_Core::set_installation_date();
Wing_Theme_Core::activate_license();
new Wing_Theme_Core();