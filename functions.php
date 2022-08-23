<?php

defined( 'ABSPATH' ) || exit;

define( 'WING_THEME_PATH', get_template_directory() . '/' );
define( 'WING_THEME_URL', get_template_directory_uri() . '/' );
define( 'WING_THEME_VERSION', wp_get_theme()->get( 'Version' ) );



require_once WING_THEME_PATH . 'inc/functions.php';



// Enqueue scripts on front-end.
function wing_enqueue_theme_scripts() {
  // Register scripts
	wp_register_style( 'wing-fonts', 'https://fonts.googleapis.com/css?family=Exo:wght@500,700|Open+Sans:wght@400,500,700&display=swap', [], WING_THEME_VERSION );
  wp_register_style( 'font-awesome-6-all', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css', [], '6.1.1' );

	wp_register_style( 'bootstrap', WING_THEME_URL . 'assets/css/bootstrap.min.css', [], '5.1.3' );
	wp_register_style( 'splide', WING_THEME_URL . 'assets/css/splide.min.css', [], '4.0.1' );
  wp_register_style( 'wing-utilities', WING_THEME_URL . 'assets/css/utilities.css', [], WING_THEME_VERSION );
	wp_register_style( 'wing-main', WING_THEME_URL . 'assets/css/styles.css', [], WING_THEME_VERSION );

  wp_register_script( 'bootstrap', WING_THEME_URL . 'assets/js/bootstrap.min.js', [], '5.1.3', true );
  wp_register_script( 'splide', WING_THEME_URL . 'assets/js/splide.min.js', [], '4.0.1', true );
  wp_register_script( 'wing-main', WING_THEME_URL . 'assets/js/scripts.js', [], WING_THEME_VERSION, true );
  
  // Enqueue scripts
	wp_enqueue_style( 'wing-fonts' );
	wp_enqueue_style( 'font-awesome-6-all' );

	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'splide' );
  wp_enqueue_style( 'wing-utilities' );
	wp_enqueue_style( 'wing-main' );

  wp_enqueue_script( 'bootstrap' );
  wp_enqueue_script( 'splide' );
  wp_enqueue_script( 'wing-main' );
}
add_action( 'wp_enqueue_scripts', 'wing_enqueue_theme_scripts' );

// Enqueue scripts on dashboard.
function wing_enqueue_admin_scripts() {
  // Register scripts
  wp_register_style( 'font-awesome-6-all', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css', [], '6.1.1' );
  wp_register_style( 'wing-dashboard', WING_THEME_URL . 'assets/css/dashboard.css', [], WING_THEME_VERSION );
  
  wp_register_script( 'wing-media-uploader', WING_THEME_URL . 'assets/js/wp-media-uploader.js', [ 'jquery' ], WING_THEME_VERSION, true );
  wp_register_script( 'wing-icon-picker', WING_THEME_URL . 'assets/js/simple-iconpicker.js', [ 'jquery' ], WING_THEME_VERSION, true );
  
  // Enqueue scripts
  wp_enqueue_style( 'font-awesome-6-all' );
  wp_enqueue_style( 'wing-dashboard' );

  wp_enqueue_script( 'wing-media-uploader' );
  wp_enqueue_script( 'wing-icon-picker' );
  
  // Allow the use of all media JS APIs.
  wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'wing_enqueue_admin_scripts' );



// Add theme support.
function wing_theme_setup() {
  add_theme_support( 'post-thumbnails' );
  
  add_theme_support( 'custom-logo', [
    'height'               => 100,
    'width'                => 300,
    'flex-height'          => true,
    'flex-width'           => true,
    'header-text'          => [ 'site-title', 'site-description' ],
    'unlink-homepage-logo' => true
  ]);
}
add_action( 'after_setup_theme', 'wing_theme_setup' );

// Register nav menu.
function wing_register_nav_menu() {
  register_nav_menus( [ 'primary_menu' => 'Primary Menu' ] );
}
add_action( 'after_setup_theme', 'wing_register_nav_menu' );



// Add a custom class to nav menu li.
function wing_add_nav_menu_li_class( $classes, $item, $args ) {
  if ( isset( $args->li_class ) ) {
    $classes[] = $args->li_class;
  }
  return $classes;
}
add_filter( 'nav_menu_css_class', 'wing_add_nav_menu_li_class', 10, 3 );

// Add a custom class to nav menu submenu.
function wing_add_nav_menu_submenu_class( $classes ) {
  $classes[] = 'dropdown-menu';
  return $classes;
}
add_filter( 'nav_menu_submenu_css_class', 'wing_add_nav_menu_submenu_class' );

// Add a custom class to nav menu anchor.
function wing_add_nav_menu_anchor_class( $atts, $item, $args, $depth ) {
  if ( isset( $args->anchor_class ) ) {
    if ( $depth === 0 ) {
      $atts['class'] = $args->anchor_class;
    } else {
      $atts['class'] = 'dropdown-item';
    }

    if ( in_array( 'menu-item-has-children', $item->classes ) ) {
      $atts['class'] .= ' dropdown-toggle';
      $atts['data-bs-toggle'] = 'dropdown';
      $atts['aria-expanded'] = 'false';
      $atts['role'] = 'button';
    }
  }
  return $atts;
}
add_filter( 'nav_menu_link_attributes', 'wing_add_nav_menu_anchor_class', 10, 4 );



// Add a custom class to the comment fields.
function wing_set_comment_form_defaults( $defaults ) {
  $defaults['fields']['author'] = str_replace(
    '<input',
    '<input class="form-control"',
    $defaults['fields']['author']
  );

  $defaults['fields']['email'] = str_replace(
    '<input',
    '<input class="form-control"',
    $defaults['fields']['email']
  );

  $defaults['fields']['url'] = str_replace(
    '<input',
    '<input class="form-control"',
    $defaults['fields']['url']
  );

  $defaults['comment_field'] = str_replace(
    '<textarea',
    '<textarea class="form-control"',
    $defaults['comment_field']
  );

  return $defaults;
}
add_filter( 'comment_form_defaults', 'wing_set_comment_form_defaults' );

// Reorder the comment fields.
function wing_comment_fields_reorder( $fields ) {
  $comment_field = $fields['comment'];
  $author_field = $fields['author'];
  $email_field = $fields['email'];
  $url_field = $fields['url'];
  $cookies_field = $fields['cookies'];

  unset( $fields['comment'] );
  unset( $fields['author'] );
  unset( $fields['email'] );
  unset( $fields['url'] );
  unset( $fields['cookies'] );

  $fields['author'] = $author_field;
  $fields['email'] = $email_field;
  $fields['url'] = $url_field;
  $fields['comment'] = $comment_field;
  $fields['cookies'] = $cookies_field;

  return $fields;
}
add_filter( 'comment_form_fields', 'wing_comment_fields_reorder' );