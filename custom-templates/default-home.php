<?php
/**
 * Template Name: Wing Default Home
 */
get_header(); ?>



<main>

<h1 id="hero-title" class="visually-hidden"><?php bloginfo( 'description' );?></h1>

<?php
  // Banner

  if ( wing_section_is_active( $theme_settings, 'wing_banner' ) ) :

  $query = new WP_Query( [ 'post_type' => 'wing_banner', 'orderby' => 'ID' ] );
?>
  <header id="wing-banner">
    <div id="banner-slider" class="splide" aria-label="Banner Slider">
      <div class="splide__track">
        <ul class="splide__list text-center">

          <?php
            while ( $query->have_posts() ) : $query->the_post();

            $style = array(
              'background-color' => wing_get( $section['wing_banner']['background_color'] )
            );

            if ( Wing_Theme_Guard::is_safe() ) {
              $style['background-image'] = 'url(' . esc_url( get_the_post_thumbnail_url( $query->ID ) ) . ')';
            } else {
              $style['background-image'] = 'url(' . esc_url( get_the_post_thumbnail_url( $query->ID, $image_size ) ) . ')';
            }

            $meta_data = get_post_meta( $post->ID, 'wing_section_meta' )[0][0];
          ?>

            <li class="splide__slide" style="<?php wing_generate_style_string( $style ); ?>">
              <div class="overlay"></div>
              <div class="container">
                <p class="banner-subtitle"><?php echo esc_html( $meta_data['subtitle'] ); ?></p>
                <h2 class="banner-title"><?php the_title(); ?></h2>
                <p class="banner-description"><?php echo get_the_content(); ?></p>

                <a href="<?php echo esc_url( $meta_data['button_link'] ); ?>" class="banner-button btn">
                  <?php echo esc_html( $meta_data['button_text'] ); ?>
                </a>
              </div>
            </li>

          <?php endwhile; wp_reset_query(); ?>

        </ul>
      </div>
    </div>
  </header>
<?php endif; ?>


<?php
  // About Us

  if ( wing_section_is_active( $theme_settings, 'wing_about_us' ) ) :
  
  $style = array(
    'padding-top'      => wing_get( $section['wing_about_us']['padding'] ) . 'px',
    'padding-bottom'   => wing_get( $section['wing_about_us']['padding'] ) . 'px',
    'background-color' => wing_get( $section['wing_about_us']['background_color'] ),
    'background-image' => 'url(' . esc_url( wing_get( $section['wing_about_us']['background_image--url'] ) ) . ')'
  );
?>
  <section id="wing-about-us" class="section" style="<?php wing_generate_style_string( $style ); ?>">
    <div class="container text-center text-lg-start">
      <div class="row align-items-center">
        <div class="col-lg">
          <?php echo wp_get_attachment_image( wing_get( $section['wing_about_us']['image--id'] ), $image_size, false, [ 'class' => 'about-us-image' ] ); ?>
        </div>
        <div class="col-lg">
          <p class="section-subtitle"><?php echo esc_html( wing_get( $section['wing_about_us']['subtitle'] ) ); ?></p>
          <h2 class="section-title mb-4"><?php echo esc_html( wing_get( $section['wing_about_us']['title'] ) ); ?></h2>
          <p class="about-us-description"><?php echo esc_html( wing_get( $section['wing_about_us']['description'] ) ); ?></p>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>


<?php
  // Our Services

  if ( wing_section_is_active( $theme_settings, 'wing_service' ) ) :
  
  $query = new WP_Query( [ 'post_type' => 'wing_service', 'orderby' => 'ID' ] );
  
  $style = array(
    'padding-top'      => wing_get( $section['wing_service']['padding'] ) . 'px',
    'padding-bottom'   => wing_get( $section['wing_service']['padding'] ) . 'px',
    'background-color' => wing_get( $section['wing_service']['background_color'] ),
    'background-image' => 'url(' . esc_url( wing_get( $section['wing_service']['background_image--url'] ) ) . ')'
  );

  $n_columns = wing_get( $section['wing_service']['n_columns'], '' ) === '' ? 3 : $section['wing_service']['n_columns'];
  $excess    = $query->found_posts % $n_columns;
?>
  <section id="wing-service" class="section" style="<?php wing_generate_style_string( $style ); ?>">
    <div class="container text-center">
      <p class="section-subtitle"><?php echo esc_html( wing_get( $section['wing_service']['subtitle'] ) ); ?></p>
      <h2 class="section-title"><?php echo esc_html( wing_get( $section['wing_service']['title'] ) ); ?></h2>
      <p class="section-description"><?php echo esc_html( wing_get( $section['wing_service']['description'] ) ); ?></p>
      
      <div class="grid excess-<?php echo $excess; ?>">

        <?php
          while ( $query->have_posts() ) : $query->the_post();
          
          $meta_data = get_post_meta( $post->ID, 'wing_section_meta' )[0][0];
        ?>

          <div class="g-col-12 g-col-md-6 g-col-lg-<?php echo ( 12 / $n_columns ); ?>">
            <div class="service-card">
              <?php
                if ( has_post_thumbnail() ) :
                  the_post_thumbnail( $image_size, [ 'class' => 'service-icon' ] );
              ?>
              <?php else : ?>
                <i class="service-icon <?php echo esc_attr( $meta_data['fontawesome_icon_class'] ); ?>"></i>
              <?php endif; ?>
              
              <h3 class="service-name"><?php the_title(); ?></h3>
              <p class="service-description"><?php echo get_the_content(); ?></p>
            </div>
          </div>

        <?php endwhile; wp_reset_query(); ?>

      </div>
    </div>
  </section>
<?php endif; ?>


<?php
  // Fact Numbers

  if ( wing_section_is_active( $theme_settings, 'wing_fact' ) ) :
  
  $query = new WP_Query( [ 'post_type' => 'wing_fact', 'orderby' => 'ID' ] );
  
  $style = array(
    'padding-top'      => wing_get( $section['wing_fact']['padding'] ) . 'px',
    'padding-bottom'   => wing_get( $section['wing_fact']['padding'] ) . 'px',
    'background-color' => wing_get( $section['wing_fact']['background_color'] ),
    'background-image' => 'url(' . esc_url( wing_get( $section['wing_fact']['background_image--url'] ) ) . ')'
  );

  $n_columns = wing_get( $section['wing_fact']['n_columns'], '' ) === '' ? 4 : $section['wing_fact']['n_columns'];
  $excess    = $query->found_posts % $n_columns;
?>
  <section id="wing-fact" class="section" style="<?php wing_generate_style_string( $style ); ?>">
    <div class="container text-center">
      <p class="section-subtitle"><?php echo esc_html( wing_get( $section['wing_fact']['subtitle'] ) ); ?></p>
      <h2 class="section-title"><?php echo esc_html( wing_get( $section['wing_fact']['title'] ) ); ?></h2>
      <p class="section-description"><?php echo esc_html( wing_get( $section['wing_fact']['description'] ) ); ?></p>
      
      <div class="grid excess-<?php echo $excess; ?>">
      
        <?php
          while ( $query->have_posts() ) : $query->the_post();
          
          $meta_data = get_post_meta( $post->ID, 'wing_section_meta' )[0][0];
        ?>

          <div class="g-col-12 g-col-md-6 g-col-lg-<?php echo ( 12 / $n_columns ); ?>">
            <div class="fact-card">
              <?php
                if ( has_post_thumbnail() ) :
                  the_post_thumbnail( $image_size, [ 'class' => 'fact-icon' ] );
              ?>
              <?php else : ?>
                <i class="fact-icon <?php echo esc_attr( $meta_data['fontawesome_icon_class'] ); ?>"></i>
              <?php endif; ?>

              <p class="fact-number"><?php echo esc_html( $meta_data['number'] ); ?></p>
              <h3 class="fact-name"><?php the_title(); ?></h3>
            </div>
          </div>

        <?php endwhile; wp_reset_query(); ?>

      </div>
    </div>
  </section>
<?php endif; ?>


<?php
  // Our Products

  if ( wing_section_is_active( $theme_settings, 'wing_product' ) ) :
  
  $query = new WP_Query( [ 'post_type' => 'wing_product', 'orderby' => 'ID' ] );
  
  $style = array(
    'padding-top'      => wing_get( $section['wing_product']['padding'] ) . 'px',
    'padding-bottom'   => wing_get( $section['wing_product']['padding'] ) . 'px',
    'background-color' => wing_get( $section['wing_product']['background_color'] ),
    'background-image' => 'url(' . esc_url( wing_get( $section['wing_product']['background_image--url'] ) ) . ')'
  );

  $n_columns = wing_get( $section['wing_product']['n_columns'], '' ) === '' ? 3 : $section['wing_product']['n_columns'];
  $excess    = $query->found_posts % $n_columns;
?>
  <section id="wing-product" class="section" style="<?php wing_generate_style_string( $style ); ?>">
    <div class="container text-center">
      <p class="section-subtitle"><?php echo esc_html( wing_get( $section['wing_product']['subtitle'] ) ); ?></p>
      <h2 class="section-title"><?php echo esc_html( wing_get( $section['wing_product']['title'] ) ); ?></h2>
      <p class="section-description"><?php echo esc_html( wing_get( $section['wing_product']['description'] ) ); ?></p>
      
      <div class="grid excess-<?php echo $excess; ?>">
      
        <?php
          while ( $query->have_posts() ) : $query->the_post();
          
          $meta_data = get_post_meta( $post->ID, 'wing_section_meta' )[0][0];
        ?>
        
          <div class="g-col-12 g-col-md-6 g-col-lg-<?php echo ( 12 / $n_columns ); ?>">
            <div class="product-card">
              <?php the_post_thumbnail( $image_size, [ 'class' => 'product-image' ] ); ?>
      
              <h3 class="product-name"><?php the_title(); ?></h3>
              <p class="product-description"><?php echo get_the_content(); ?></p>

              <?php if ( ! empty( $meta_data['button_text'] ) ) : ?>
                <a href="<?php echo esc_url( $meta_data['button_link'] ); ?>" class="product-button btn">
                  <?php echo esc_html( $meta_data['button_text'] ); ?>
                </a>
              <?php endif; ?>
            </div>
          </div>

        <?php endwhile; wp_reset_query(); ?>

      </div>
    </div>
  </section>
<?php endif; ?>


<?php
  // Testimonials

  if ( wing_section_is_active( $theme_settings, 'wing_testimonial' ) ) :
  
  $query = new WP_Query( [ 'post_type' => 'wing_testimonial', 'orderby' => 'ID' ] );
  
  $style = array(
    'padding-top'      => wing_get( $section['wing_testimonial']['padding'] ) . 'px',
    'padding-bottom'   => wing_get( $section['wing_testimonial']['padding'] ) . 'px',
    'background-color' => wing_get( $section['wing_testimonial']['background_color'] ),
    'background-image' => 'url(' . esc_url( wing_get( $section['wing_testimonial']['background_image--url'] ) ) . ')'
  );

  $n_columns = wing_get( $section['wing_testimonial']['n_columns'], '' ) === '' ? 3 : $section['wing_testimonial']['n_columns'];
?>
  <section id="wing-testimonial" class="section" style="<?php wing_generate_style_string( $style ); ?>">
    <div class="container text-center">
      <p class="section-subtitle"><?php echo esc_html( wing_get( $section['wing_testimonial']['subtitle'] ) ); ?></p>
      <h2 class="section-title"><?php echo esc_html( wing_get( $section['wing_testimonial']['title'] ) ); ?></h2>
      <p class="section-description"><?php echo esc_html( wing_get( $section['wing_testimonial']['description'] ) ); ?></p>
      
      <div id="testimonial-slider" data-column="<?php echo esc_attr( $n_columns ); ?>" class="splide" aria-label="Testimonial Slider">
        <div class="splide__track">
          <ul class="splide__list">

            <?php
              while ( $query->have_posts() ) : $query->the_post();
              
              $meta_data = get_post_meta( $post->ID, 'wing_section_meta' )[0][0];
            ?>

              <li class="splide__slide">
                <div class="testimonial-card">
                  <?php the_post_thumbnail( $image_size, [ 'class' => 'testimonial-photo' ] ); ?>
          
                  <p class="testimonial-quote"><?php echo get_the_content(); ?></p>
                  <h3 class="testimonial-name"><?php the_title(); ?></h3>
                  <p class="testimonial-company"><?php echo esc_html( $meta_data['company'] ); ?></p>
                </div>
              </li>

            <?php endwhile; wp_reset_query(); ?>

          </ul>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>


<?php
  // Our Team

  if ( wing_section_is_active( $theme_settings, 'wing_team' ) ) :
  
  $query = new WP_Query( [ 'post_type' => 'wing_team', 'orderby' => 'ID' ] );
  
  $style = array(
    'padding-top'      => wing_get( $section['wing_team']['padding'] ) . 'px',
    'padding-bottom'   => wing_get( $section['wing_team']['padding'] ) . 'px',
    'background-color' => wing_get( $section['wing_team']['background_color'] ),
    'background-image' => 'url(' . esc_url( wing_get( $section['wing_team']['background_image--url'] ) ) . ')'
  );

  $n_columns = wing_get( $section['wing_team']['n_columns'], '' ) === '' ? 3 : $section['wing_team']['n_columns'];
  $excess    = $query->found_posts % $n_columns;
?>
  <section id="wing-team" class="section" style="<?php wing_generate_style_string( $style ); ?>">
    <div class="container text-center">
      <p class="section-subtitle"><?php echo esc_html( wing_get( $section['wing_team']['subtitle'] ) ); ?></p>
      <h2 class="section-title"><?php echo esc_html( wing_get( $section['wing_team']['title'] ) ); ?></h2>
      <p class="section-description"><?php echo esc_html( wing_get( $section['wing_team']['description'] ) ); ?></p>
      
      <div class="grid excess-<?php echo $excess; ?>">

        <?php
          while ( $query->have_posts() ) : $query->the_post();
          
          $meta_data = get_post_meta( $post->ID, 'wing_section_meta' )[0][0];
        ?>

          <div class="g-col-12 g-col-md-6 g-col-lg-<?php echo ( 12 / $n_columns ); ?>">
            <div class="team-card">
              <?php the_post_thumbnail( $image_size, [ 'class' => 'team-photo' ] ); ?>
      
              <h3 class="team-name"><?php the_title(); ?></h3>
              <p class="team-position"><?php echo esc_html( $meta_data['position'] ); ?></p>
              <p class="team-quote"><?php echo get_the_content(); ?></p>
            </div>
          </div>

        <?php endwhile; wp_reset_query(); ?>

      </div>
    </div>
  </section>
<?php endif; ?>


<?php
  // Recent Clients

  if ( wing_section_is_active( $theme_settings, 'wing_client' ) ) :
  
  $query = new WP_Query( [ 'post_type' => 'wing_client', 'orderby' => 'ID' ] );
  
  $style = array(
    'padding-top'      => wing_get( $section['wing_client']['padding'] ) . 'px',
    'padding-bottom'   => wing_get( $section['wing_client']['padding'] ) . 'px',
    'background-color' => wing_get( $section['wing_client']['background_color'] ),
    'background-image' => 'url(' . esc_url( wing_get( $section['wing_client']['background_image--url'] ) ) . ')'
  );

  $n_columns = wing_get( $section['wing_client']['n_columns'], '' ) === '' ? 4 : $section['wing_client']['n_columns'];
  $excess    = $query->found_posts % $n_columns;
?>
  <section id="wing-client" class="section" style="<?php wing_generate_style_string( $style ); ?>">
    <div class="container text-center">
      <p class="section-subtitle"><?php echo esc_html( wing_get( $section['wing_client']['subtitle'] ) ); ?></p>
      <h2 class="section-title"><?php echo esc_html( wing_get( $section['wing_client']['title'] ) ); ?></h2>
      <p class="section-description"><?php echo esc_html( wing_get( $section['wing_client']['description'] ) ); ?></p>
      
      <div class="grid align-items-center excess-<?php echo $excess; ?>">

        <?php
          while ( $query->have_posts() ) : $query->the_post();
          
          $meta_data = get_post_meta( $post->ID, 'wing_section_meta' )[0][0];
        ?>

          <div class="g-col-6 g-col-lg-<?php echo ( 12 / $n_columns ); ?>">
            <a href="<?php echo esc_url( $meta_data['link'] ); ?>" class="client-card">
              <h3 class="visually-hidden"><?php the_title(); ?></h3>

              <?php the_post_thumbnail( $image_size, [ 'class' => 'client-logo' ] ); ?>
            </a>
          </div>

        <?php endwhile; wp_reset_query(); ?>

      </div>
    </div>
  </section>
<?php endif; ?>


<?php
  // Frequently Asked Questions

  if ( wing_section_is_active( $theme_settings, 'wing_faq' ) ) :
  
  $query = new WP_Query( [ 'post_type' => 'wing_faq', 'orderby' => 'ID' ] );
  
  $style = array(
    'padding-top'      => wing_get( $section['wing_faq']['padding'] ) . 'px',
    'padding-bottom'   => wing_get( $section['wing_faq']['padding'] ) . 'px',
    'background-color' => wing_get( $section['wing_faq']['background_color'] ),
    'background-image' => 'url(' . esc_url( wing_get( $section['wing_faq']['background_image--url'] ) ) . ')'
  );
?>
  <section id="wing-faq" class="section" style="<?php wing_generate_style_string( $style ); ?>">
    <div class="container text-center">
      <p class="section-subtitle"><?php echo esc_html( wing_get( $section['wing_faq']['subtitle'] ) ); ?></p>
      <h2 class="section-title"><?php echo esc_html( wing_get( $section['wing_faq']['title'] ) ); ?></h2>
      <p class="section-description"><?php echo esc_html( wing_get( $section['wing_faq']['description'] ) ); ?></p>
      
      <div class="accordion accordion-flush text-start" id="wing-faq-accordion">

        <?php
          $index = 1;
          while ( $query->have_posts() ) : $query->the_post();
        ?>
        
          <div class="accordion-item">
            <h3 class="accordion-header" id="flush-heading-<?php echo $index; ?>">
              <button class="accordion-button <?php echo ( $index === 1 ) ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-<?php echo $index; ?>" aria-expanded="false" aria-controls="flush-collapse-<?php echo $index; ?>">
                <?php the_title(); ?>
              </button>
            </h3>
            <div id="flush-collapse-<?php echo $index; ?>" class="accordion-collapse collapse <?php echo ( $index === 1 ) ? 'show' : ''; ?>" aria-labelledby="flush-heading-<?php echo $index; ?>" data-bs-parent="#wing-faq-accordion">
              <div class="accordion-body"><?php echo get_the_content(); ?></div>
            </div>
          </div>
          
        <?php $index++; endwhile; wp_reset_query(); ?>

      </div>
    </div>
  </section>
<?php endif; ?>


<?php
  // Contact Us

  if ( wing_section_is_active( $theme_settings, 'wing_contact' ) ) :
  
  $query = new WP_Query( [ 'post_type' => 'wing_contact', 'orderby' => 'ID' ] );
  
  $style = array(
    'padding-top'      => wing_get( $section['wing_contact']['padding'] ) . 'px',
    'padding-bottom'   => wing_get( $section['wing_contact']['padding'] ) . 'px',
    'background-color' => wing_get( $section['wing_contact']['background_color'] )
  );
?>
  <section id="wing-contact" class="section" style="<?php wing_generate_style_string( $style ); ?>">
    <div class="overlay" style="<?php wing_generate_style_string( [ 'background-image' => 'url(' . wp_get_attachment_image_src( wing_get( $section['wing_contact']['background_image--id'] ), $image_size )[0] . ')' ] ); ?>"></div>
    <div class="container text-center">
      <div class="row">
        <div class="col-md text-md-end d-md-flex align-items-end justify-content-end mb-4 mb-md-0">
          <div>
            <p class="section-subtitle"><?php echo esc_html( wing_get( $section['wing_contact']['subtitle'] ) ); ?></p>
            <h2 class="section-title mb-0"><?php echo esc_html( wing_get( $section['wing_contact']['title'] ) ); ?></h2>
          </div>
        </div>
        <div class="col-md text-md-start">
          <p class="contact-description"><?php echo esc_html( wing_get( $section['wing_contact']['description'] ) ); ?></p>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

</main>



<?php get_footer(); ?>