<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <title><?php wp_title( '&bull;', true, 'right' ); bloginfo( 'name' ); ?></title>
  
  <?php
    wp_head();

    // Make the variables accessible across all the template files.
    global $section, $theme_settings;
    
    $section = get_option( 'wing_section_settings', [] );
    $theme_settings = get_option( 'wing_theme_settings', [] );
  ?>
</head>
<body <?php body_class( 'wing' ); ?>>

<?php
  $fixed       = ( get_theme_mod( 'wing_navbar_fixed' ) ) ? 'fixed-top ' : '';
  $transparent = ( get_theme_mod( 'wing_navbar_transparent' ) && is_front_page() ) ? 'navbar-transparent' : '';
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm <?php echo $fixed . $transparent; ?>">
  <div class="container">
    <a href="<?php echo home_url(); ?>" class="navbar-brand">
      <?php
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $custom_logo    = wp_get_attachment_image_src( $custom_logo_id , 'full' );

        if ( has_custom_logo() ) {
          echo '<img src="' . esc_url( $custom_logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '" height="30" class="d-inline-block align-text-top">';
        }
        if ( get_theme_mod( 'header_text' ) || ! has_custom_logo() ) {
          echo '<span class="ms-1">' . get_bloginfo( 'name' ) . '</span>';
        }
      ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <div class="navbar-toggler-bar"></div><div class="navbar-toggler-bar"></div><div class="navbar-toggler-bar"></div>
    </button>
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title invisible" id="offcanvasNavbarLabel">Offcanvas</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <?php
          // Navbar menu list
          wp_nav_menu([
            'menu' => 'Primary Menu',
            'theme_location' => 'primary_menu',
            'menu_class' => 'navbar-nav justify-content-end flex-wrap flex-grow-1',
            'li_class' => 'nav-item',
            'anchor_class' => 'nav-link',
            'container' => false
          ]);
        ?>
        
        <?php
          // Navbar button
          if ( get_theme_mod( 'wing_navbar_button--show_button' ) ) :
        ?>
          <div class="d-flex pt-4 pt-lg-0 ps-lg-3">
            <a href="<?php echo ( get_theme_mod( 'wing_navbar_button--link', '#wing-contact' ) ); ?>" class="navbar-button btn">
              <?php echo esc_html( get_theme_mod( 'wing_navbar_button--text', 'Contact Us' ) ); ?>
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>