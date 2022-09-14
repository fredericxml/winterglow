<?php
/*
|--------------------------------------------------------------------------
| Starter Content Importer
|--------------------------------------------------------------------------
|
| Import starter contents.
|
*/

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
	require_once ABSPATH . 'wp-admin/includes/image.php';
}

class Wing_Starter_Contents_Importer {
  /**
   * Runner
   */
  public static function run() {
    self::import_pages();
    self::import_nav_settings();
    self::import_nav_menu();
    self::import_theme_settings();
    self::import_section_settings();
    self::import_custom_post_data();
  }

  /**
   * Import home and blog page. Then set thumbnail for the "Hello world!"
   * example post.
   *
   * @return void
   */
  private static function import_pages() {
    update_option( 'show_on_front', 'page' );

    $home_page_id = wp_insert_post([
      'post_title' => 'Home',
      'post_type' => 'page',
      'post_status' => 'publish',
      'ping_status' => 'close',
      'comment_status' => 'close',
      'page_template' => 'custom-templates/default-home.php'
    ]);
    update_option( 'page_on_front', $home_page_id );
  
    $blog_page_id = wp_insert_post([
      'post_title' => 'Blog',
      'post_type' => 'page',
      'post_status' => 'publish',
      'ping_status' => 'close',
      'comment_status' => 'close'
    ]);
    update_option( 'page_for_posts', $blog_page_id );

    // Set thumbnail for the "Hello world!" example post.
    set_post_thumbnail( 1, self::insert_attachment( 'blog-sample.jpg' ) );
  }
  
  /**
   * Import nav settings.
   *
   * @return void
   */
  private static function import_nav_settings() {
    set_theme_mod( 'header_text', 0 );
    set_theme_mod( 'custom_logo', self::insert_attachment( 'site-logo.png' ) );
    set_theme_mod( 'wing_navbar_button--show_button', true );
  }
  
  /**
   * Import nav menu.
   *
   * @return void
   */
  private static function import_nav_menu() {
    $nav_menu_id = wp_create_nav_menu( 'Primary Menu' );
   
    wp_update_nav_menu_item( $nav_menu_id, 0, [
      'menu-item-title'  => 'Home',
      'menu-item-url'    => home_url( '/#' ), 
      'menu-item-status' => 'publish'
    ]);
    wp_update_nav_menu_item( $nav_menu_id, 0, [
      'menu-item-title'  => 'Service',
      'menu-item-url'    => home_url( '/#wing-service' ), 
      'menu-item-status' => 'publish'
    ]);
    wp_update_nav_menu_item( $nav_menu_id, 0, [
      'menu-item-title'  => 'Product',
      'menu-item-url'    => home_url( '/#wing-product' ), 
      'menu-item-status' => 'publish'
    ]);
    wp_update_nav_menu_item( $nav_menu_id, 0, [
      'menu-item-title'  => 'Testimonial',
      'menu-item-url'    => home_url( '/#wing-testimonial' ), 
      'menu-item-status' => 'publish'
    ]);
    wp_update_nav_menu_item( $nav_menu_id, 0, [
      'menu-item-title'  => 'Team',
      'menu-item-url'    => home_url( '/#wing-team' ), 
      'menu-item-status' => 'publish'
    ]);
    wp_update_nav_menu_item( $nav_menu_id, 0, [
      'menu-item-title'  => 'Client',
      'menu-item-url'    => home_url( '/#wing-client' ), 
      'menu-item-status' => 'publish'
    ]);
    wp_update_nav_menu_item( $nav_menu_id, 0, [
      'menu-item-title'  => 'Blog',
      'menu-item-url'    => get_permalink( get_option( 'page_for_posts' ) ), 
      'menu-item-status' => 'publish'
    ]);
  }

  /**
   * Import theme settings.
   *
   * @return void
   */
  private static function import_theme_settings() {
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

    // Sections Visibility
    foreach ( $sections as $section ) {
      $theme_settings['sections'][ 'wing_' . $section ] = true;
    }
  
    // Scroll To Top Button
    $theme_settings['scroll_to_top_button'] = [
      'show_button' => true,
      'size'        => '',
      'position'    => ''
    ];
    
    // WhatsApp Chat Button
    $theme_settings['wa_chat_button'] = [
      'show_button' => true,
      'number'      => '6282362361344',
      'message'     => 'Halo Min, ...',
      'size'        => '',
      'position'    => ''
    ];
    update_option( 'wing_theme_settings', $theme_settings );
  }

  /**
   * Import section settings.
   *
   * @return void
   */
  private static function import_section_settings() {
    $description = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint blanditiis obcaecati, ducimus quos minima et, natus iste atque quis culpa odio totam amet, dignissimos pariatur distinctio incidunt. Odit, nobis explicabo!';

    $about_us_image           = self::insert_attachment( 'about-us.jpg', true );
    $contact_background_image = self::insert_attachment( 'contact.jpg', true );
    
    update_option( 'wing_section_settings', [
      'wing_banner' => array(
        'background_color' => '#d3d3d3'
      ),
      'wing_about_us' => array(
        'title' => 'Few Words About Us',
        'subtitle' => 'ABOUT US',
        'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem doloremque mollitia ut cupiditate aut maxime iure aliquid quaerat blanditiis omnis aspernatur ratione neque unde exercitationem, sequi distinctio eius odio?\n\nReprehenderit voluptate totam, dolor esse illum veritatis provident molestias placeat quae quidem, nihil autem repellendus nam omnis saepe deleniti eligendi dolorem quod ullam distinctio illo aperiam nisi.\n\nEnim quo, porro hic impedit totam repudiandae ad commodi nulla temporibus eveniet ratione delectus facere nobis deleniti voluptatibus reiciendis debitis quae quam repellendus aspernatur blanditiis sed pariatur. Voluptatibus doloribus illum magni eveniet quis tenetur error quo possimus? Sit repellendus aperiam culpa a reprehenderit earum?",
        'image--id' => $about_us_image['id'],
        'image--url' => $about_us_image['url']
      ),
      'wing_service' => array(
        'title' => 'Why Choose Us',
        'subtitle' => 'OUR SERVICES',
        'description' => $description,
        'background_color' => '#fafafa'
      ),
      'wing_fact' => array(
        'title' => 'Some Interesting Facts About Us',
        'subtitle' => 'FACTS',
        'description' => $description
      ),
      'wing_product' => array(
        'title' => 'The Products We Offer',
        'subtitle' => 'OUR PRODUCTS',
        'description' => $description,
        'background_color' => '#fafafa'
      ),
      'wing_testimonial' => array(
        'title' => 'What Clients Say',
        'subtitle' => 'TESTIMONIALS',
        'description' => $description
      ),
      'wing_team' => array(
        'title' => 'Meet The Crew',
        'subtitle' => 'OUR TEAM',
        'description' => $description
      ),
      'wing_client' => array(
        'title' => 'Recent Clients',
        'subtitle' => 'CLIENTS',
        'description' => $description
      ),
      'wing_faq' => array(
        'title' => 'Frequently Asked Questions',
        'subtitle' => 'FAQs',
        'description' => $description
      ),
      'wing_contact' => array(
        'title' => 'Let\'s Work Together',
        'subtitle' => 'CONTACT US',
        'description' => "Office address: 2880 Broadway, New York, NY 10025, USA\n\nPhone number: +62 823 6236 1344\n\nEmail : fdcodestudio@gmail.com",
        'background_color' => '#efefef',
        'background_image--id' => $contact_background_image['id'],
        'background_image--url' => $contact_background_image['url']
      )
    ]);
  }

  /**
   * Import custom post data.
   *
   * @return void
   */
  private static function import_custom_post_data() {
    $sections = array(
      // Banner
      array(
        'id' => 'wing_banner',
        'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cumque vitae iste doloribus nostrum mollitia. Nemo!',
        'posts' => [
          [
            'title' => 'Welcome to Winter Glow',
            'thumbnail' => self::insert_attachment( 'banner-3.jpg' ),
            'meta' => [
              'subtitle' => 'COMPANY PROFILE',
              'button_text' => 'Learn More',
              'button_link' => '#wing-about-us'
            ]
          ],
          [
            'title' => 'Welcome to Winter Glow',
            'thumbnail' => self::insert_attachment( 'banner-2.jpg' ),
            'meta' => [
              'subtitle' => 'COMPANY PROFILE',
              'button_text' => 'Learn More',
              'button_link' => '#wing-about-us'
            ]
          ],
          [
            'title' => 'Welcome to Winter Glow',
            'thumbnail' => self::insert_attachment( 'banner-1.jpg' ),
            'meta' => [
              'subtitle' => 'COMPANY PROFILE',
              'button_text' => 'Learn More',
              'button_link' => '#wing-about-us'
            ]
          ]
        ]
      ),

      // Our Services
      array(
        'id' => 'wing_service',
        'content' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, beatae quisquam iure cupiditate provident a!',
        'posts' => [
          [
            'title' => 'Dedicated Team',
            'meta' => [ 'fontawesome_icon_class' => 'fa-solid fa-user-tie' ]
          ],
          [
            'title' => 'Customer support',
            'meta' => [ 'fontawesome_icon_class' => 'fa-solid fa-headset' ]
          ],
          [
            'title' => 'Best Quality',
            'meta' => [ 'fontawesome_icon_class' => 'fa-solid fa-leaf' ]
          ]
        ]
      ),

      // Fact Numbers
      array(
        'id' => 'wing_fact',
        'posts' => [
          [
            'title' => 'Employees',
            'meta' => [
              'fontawesome_icon_class' => 'fa-solid fa-users',
              'number' => '5.500'
            ]
          ],
          [
            'title' => 'Completed Projects',
            'meta' => [
              'fontawesome_icon_class' => 'fa-solid fa-briefcase',
              'number' => '350'
            ]
          ],
          [
            'title' => 'Awards & Honours',
            'meta' => [
              'fontawesome_icon_class' => 'fa-solid fa-award',
              'number' => '125'
            ]
          ],
          [
            'title' => 'Years In Business',
            'meta' => [
              'fontawesome_icon_class' => 'fa-solid fa-globe',
              'number' => '25'
            ]
          ]
        ]
      ),

      // Our Products
      array(
        'id' => 'wing_product',
        'content' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam exercitationem libero ab a vitae aspernatur.',
        'posts' => [
          [
            'title' => 'Product 3',
            'thumbnail' => self::insert_attachment( 'product-3.jpg' ),
            'meta' => [
              'button_text' => 'See Details',
              'button_link' => '#'
            ]
          ],
          [
            'title' => 'Product 2',
            'thumbnail' => self::insert_attachment( 'product-2.jpg' ),
            'meta' => [
              'button_text' => 'See Details',
              'button_link' => '#'
            ]
          ],
          [
            'title' => 'Product 1',
            'thumbnail' => self::insert_attachment( 'product-1.jpg' ),
            'meta' => [
              'button_text' => 'See Details',
              'button_link' => '#'
            ]
          ]
        ]
      ),

      // Testimonials
      array(
        'id' => 'wing_testimonial',
        'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi accusantium optio asperiores nobis voluptatum. Voluptatem voluptas saepe fuga accusantium dolore, natus sit corrupti ipsa, eius, neque delectus libero enim consequatur?',
        'posts' => [
          [
            'title' => 'Tommy',
            'thumbnail' => self::insert_attachment( 'testimonial-4.jpg' ),
            'meta' => [ 'company' => 'Lorem Company' ]
          ],
          [
            'title' => 'Bob',
            'thumbnail' => self::insert_attachment( 'testimonial-3.jpg' ),
            'meta' => [ 'company' => 'Lorem Company' ]
          ],
          [
            'title' => 'Richard',
            'thumbnail' => self::insert_attachment( 'testimonial-2.jpg' ),
            'meta' => [ 'company' => 'Lorem Company' ]
          ],
          [
            'title' => 'Harry',
            'thumbnail' => self::insert_attachment( 'testimonial-1.jpg' ),
            'meta' => [ 'company' => 'Lorem Company' ]
          ]
        ]
      ),

      // Our Team
      array(
        'id' => 'wing_team',
        'content' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perferendis, quidem!',
        'posts' => [
          [
            'title' => 'Jane Doe',
            'thumbnail' => self::insert_attachment( 'team-3.jpg' ),
            'meta' => [ 'position' => 'Production Manager' ]
          ],
          [
            'title' => 'Alice Roe',
            'thumbnail' => self::insert_attachment( 'team-2.jpg' ),
            'meta' => [ 'position' => 'General Manager' ]
          ],
          [
            'title' => 'John Doe',
            'thumbnail' => self::insert_attachment( 'team-1.jpg' ),
            'meta' => [ 'position' => 'Chief Executive Officer' ]
          ]
        ]
      ),

      // Recent Clients
      array(
        'id' => 'wing_client',
        'posts' => [
          [
            'title' => 'Client 5',
            'thumbnail' => self::insert_attachment( 'client-5.png' ),
            'meta' => [ 'link' => '#' ]
          ],
          [
            'title' => 'Client 4',
            'thumbnail' => self::insert_attachment( 'client-4.png' ),
            'meta' => [ 'link' => '#' ]
          ],
          [
            'title' => 'Client 3',
            'thumbnail' => self::insert_attachment( 'client-3.png' ),
            'meta' => [ 'link' => '#' ]
          ],
          [
            'title' => 'Client 2',
            'thumbnail' => self::insert_attachment( 'client-2.png' ),
            'meta' => [ 'link' => '#' ]
          ],
          [
            'title' => 'Niagahoster',
            'thumbnail' => self::insert_attachment( 'client-niagahoster.png' ),
            'meta' => [ 'link' => '#' ]
          ],
          [
            'title' => 'FD Code Studio',
            'thumbnail' => self::insert_attachment( 'client-fdcodestudio.png' ),
            'meta' => [ 'link' => '#' ]
          ],
          [
            'title' => 'Client 1',
            'thumbnail' => self::insert_attachment( 'client-1.png' ),
            'meta' => [ 'link' => '#' ]
          ]
        ]
      ),

      // Frequently Asked Questions
      array(
        'id' => 'wing_faq',
        'content' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, beatae quisquam iure cupiditate provident a!',
        'posts' => [
          [ 'title' => 'Question Item #3', ],
          [ 'title' => 'Question Item #2', ],
          [ 'title' => 'Question Item #1', ]
        ]
      )
    );
    
    // For each section
    foreach ( $sections as $section ) {
      // For each post in the section
      foreach ( $section['posts'] as $post ) {
        $postarr = array(
          'post_type' => $section['id'],
          'post_title' => $post['title'],
          'post_status' => 'publish',
          'ping_status' => 'close',
          'comment_status' => 'close',
        );

        if ( isset( $section['content'] ) ) {
          $postarr['post_content'] = $section['content'];
        }
        if ( isset( $post['meta'] ) ) {
          $postarr['meta_input'] = [ 'wing_section_meta' => [ $post['meta'] ] ];
        }

        // Insert post
        $post_id = wp_insert_post( $postarr );

        // Set thumbnail if there is one
        if ( isset( $post['thumbnail'] ) ) {
          set_post_thumbnail( $post_id, $post['thumbnail'] );
        }
      }
    }
  }

  /**
   * Insert attachment and get the ID with URL.
   *
   * @return mixed
   */
  private static function insert_attachment( $filename, $get_url = false ) {
    $path   = WING_THEME_PATH . 'starter-contents/images/' . $filename;
    $upload = wp_upload_bits( $filename, null, file_get_contents( $path ) );

    if ( $upload['error'] ) {
      echo 'Failed uploading: ' . $upload['error'];
    }

    $attachment_id = wp_insert_attachment([  
      'guid' => $upload['url'],
      'post_mime_type' => $upload['type']
    ], $upload['file'] );

    // Generate sub-sizes of the image.
    wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $upload['file'] ) );

    if ( $get_url ) {
      return array(
        'id'  => $attachment_id,
        'url' => $upload['url']
      );
    } else {
      return $attachment_id;
    }
  }
}