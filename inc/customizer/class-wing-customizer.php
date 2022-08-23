<?php
/*
|--------------------------------------------------------------------------
| Theme Customizer
|--------------------------------------------------------------------------
|
| Register the settings for customizing the theme.
|
*/

defined( 'ABSPATH' ) || exit;

class Wing_Customizer {
  /**
   * Constructor
   *
   * @return void
   */
  public function __construct() {
    add_action( 'customize_register', [ $this, 'register_section' ] );
    add_action( 'customize_register', [ $this, 'register_setting' ] );
    add_action( 'customize_register', [ $this, 'register_control' ] );
    add_action( 'wp_head', [ $this, 'wing_generate_customizer_css' ] );
  }

  /**
   * Register customizer sections.
   *
   * @return void
   */
  public function register_section( $wp_customize ) {
    $wp_customize->add_section( 'wing_navbar_settings', [
      'title' => 'Navbar Settings',
      'priority' => 30
    ]);

    $wp_customize->add_section( 'wing_color_scheme', [
      'title' => 'Color Scheme',
      'priority' => 30
    ]);

    $wp_customize->add_section( 'wing_copyright', [
      'title' => 'Copyright',
      'priority' => 30
    ]);
  }

  /**
   * Register customizer settings.
   *
   * @return void
   */
  public function register_setting( $wp_customize ) { 
    $wp_customize->add_setting( 'wing_navbar_fixed', [
      'default' => false
    ]);
    $wp_customize->add_setting( 'wing_navbar_transparent', [
      'default' => false
    ]);


    $wp_customize->add_setting( 'wing_theme_color_primary', [
      'default' => '#0d6efd'
    ]);
    $wp_customize->add_setting( 'wing_theme_color_secondary', [
      'default' => '#0dcaf0'
    ]);
    $wp_customize->add_setting( 'wing_theme_color_background', [
      'default' => '#e7f1ff'
    ]);


    $wp_customize->add_setting( 'wing_navbar_button--show_button', [
      'default' => false
    ]);
    $wp_customize->add_setting( 'wing_navbar_button--text', [
      'default' => 'Contact Us'
    ]);
    $wp_customize->add_setting( 'wing_navbar_button--link', [
      'default' => '#wing-contact'
    ]);
  

    $wp_customize->add_setting( 'wing_copyright_text', [
      'default' => '2022 Winter Glow. All Rights Reserved. Designed by FD Code Studio.'
    ]);
  }

  /**
   * Register customizer controls.
   *
   * @return void
   */
  public function register_control( $wp_customize ) {
    $wp_customize->add_control( 'wing_navbar_fixed', [
      'label' => 'Fixed Navbar',
      'section' => 'wing_navbar_settings',
      'type' => 'checkbox'
    ]);
    $wp_customize->add_control( 'wing_navbar_transparent', [
      'label' => 'Transparent Navbar',
      'section' => 'wing_navbar_settings',
      'type' => 'checkbox'
    ]);


    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wing_theme_color_primary', [
      'label' => 'Primary',
      'section' => 'wing_color_scheme',
      'settings' => 'wing_theme_color_primary'
    ]));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wing_theme_color_secondary', [
      'label' => 'Secondary',
      'section' => 'wing_color_scheme',
      'settings' => 'wing_theme_color_secondary'
    ]));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wing_theme_color_background', [
      'label' => 'Background',
      'section' => 'wing_color_scheme',
      'settings' => 'wing_theme_color_background'
    ]));
  

    $wp_customize->add_control( 'wing_navbar_button--show_button', [
      'label' => 'Show Button',
      'section' => 'wing_navbar_settings',
      'type' => 'checkbox'
    ]);
    $wp_customize->add_control( 'wing_navbar_button--text', [
      'label' => 'Button Text',
      'section' => 'wing_navbar_settings'    
    ]);
    $wp_customize->add_control( 'wing_navbar_button--link', [
      'label' => 'Button Link',
      'section' => 'wing_navbar_settings'    
    ]);
  

    $wp_customize->add_control( 'wing_copyright_text', [
      'label' => 'Copyright',
      'section' => 'wing_copyright',
      'type' => 'textarea'
    ]);
  }

  /**
   * Generate customizer css to overwrite the default css color variable.
   *
   * @return void
   */
  public function wing_generate_customizer_css() {
    $primary    = get_theme_mod( 'wing_theme_color_primary', '#0d6efd' );
    $secondary  = get_theme_mod( 'wing_theme_color_secondary', '#0dcaf0' );
    $background = get_theme_mod( 'wing_theme_color_background', '#e7f1ff' );

    echo '<style>
      :root {
        --wing-primary:' . $primary . ';
        --wing-secondary:' . $secondary . ';
        --wing-bg-light:' . $background . ';
      }
    </style>';
  }
}

new Wing_Customizer();