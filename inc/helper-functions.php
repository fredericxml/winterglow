<?php
/*
|--------------------------------------------------------------------------
| Helper Functions
|--------------------------------------------------------------------------
|
| Provide basic helper functionality.
|
*/

defined( 'ABSPATH' ) || exit;

/**
 * Check whether certain section is active and mark as inactive if the
 * section setting is not found.
 *
 * @param  array  $theme_settings
 * @param  string $section
 * @return bool
 */
function wing_section_is_active( $theme_settings, $section ) {
  return wing_get( $theme_settings['sections'][ $section ], false );
}

/**
 * Check by reference whether the value exists or not. If there is, then
 * return it. Otherwise, return a default value.
 *
 * @param  mixed &$value
 * @param  mixed $default
 * @return mixed
 */
function wing_get( &$value, $default = null ) {
  return isset( $value ) ? $value : $default;
}

/**
 * Echo the images full URL.
 *
 * @param  string $filename
 * @return void
 */
function wing_img_url( $filename ) {
  echo WING_THEME_URL . 'assets/images/' . $filename;
}

/**
 * Echo escaped CSS style string.
 *
 * @param  array $style_array
 * @return void
 */
function wing_generate_style_string( $style_array ) {
  $style_string = '';
  $empty_values = [ 'px', 'url()' ];

  foreach ( $style_array as $key => $value ) {
    if ( empty( $value ) || in_array( $value, $empty_values ) ) {
      continue;
    }
    $style_string .= $key . ':' . $value . ';';
  }
  
  echo esc_attr( $style_string );
}