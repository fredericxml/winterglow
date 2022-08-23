<?php
/*
|--------------------------------------------------------------------------
| Custom Sections Config File
|--------------------------------------------------------------------------
|
| The base configurations of the custom sections.
|
| Available sections:
| Page
| - wing_about_us    => About Us
| - wing_contact     => Contact Us
| Post-Type
| - wing_banner      => Banner
| - wing_client      => Recent Clients
| - wing_fact        => Fact Numbers
| - wing_faq         => Frequently Asked Questions
| - wing_product     => Our Products
| - wing_service     => Our Services
| - wing_team        => Our Team
| - wing_testimonial => Testimonials
|
*/

defined( 'ABSPATH' ) || exit;

// One-time load the reference for checking whether particular section is active.
$theme_settings = get_option( 'wing_theme_settings', [] );

// About Us
if ( wing_section_is_active( $theme_settings, 'wing_about_us' ) ) {
  $sections['page'][] = array(
    'id'   => 'wing_about_us',
    'name' => 'About Us',
    'settings' => [
      'fields' => [
        'title',
        'subtitle',
        'description',
        'image--id',
        'image--url',
        'image--alt',
        'padding',
        'background_color',
        'background_image--id',
        'background_image--url',
        'background_image--alt'
      ]
    ]
  );
}

// Contact Us
if ( wing_section_is_active( $theme_settings, 'wing_contact' ) ) {
  $sections['page'][] = array(
    'id'   => 'wing_contact',
    'name' => 'Contact Us',
    'settings' => [
      'fields' => [
        'title',
        'subtitle',
        'description',
        'padding',
        'background_color',
        'background_image--id',
        'background_image--url',
        'background_image--alt'
      ]
    ]
  );
}

// Banner
if ( wing_section_is_active( $theme_settings, 'wing_banner' ) )  {
  $sections['post_type'][] = array(
    'id'   => 'wing_banner',
    'name' => 'Banner',
    'has_editor' => true,
    'has_thumbnail' => true,
    'labels' => [
      'singular_name' => 'Slide',
      'image_name' => 'Background Image'
    ],
    'meta_box' => [
      'title' => 'Slide Details',
      'fields' => [
        'subtitle'    => 'Subtitle',
        'button_text' => 'Button Text',
        'button_link' => 'Button Link'
      ]
    ],
    'post_columns' => [
      'title' => 'Name',
      'content' => 'Description'
    ],
    'settings' => [
      'fields' => [
        'background_color'
      ]
    ]
  );
}

// Recent Clients
if ( wing_section_is_active( $theme_settings, 'wing_client' ) )  {
  $sections['post_type'][] = array(
    'id'   => 'wing_client',
    'name' => 'Recent Clients',
    'has_editor' => false,
    'has_thumbnail' => true,
    'labels' => [
      'singular_name' => 'Client',
      'image_name' => 'Logo'
    ],
    'meta_box' => [
      'title' => 'Client Details',
      'fields' => [
        'link' => 'Link'
      ]
    ],
    'post_columns' => [
      'title' => 'Name',
      'thumbnail' => 'Logo'
    ],
    'settings' => [
      'fields' => [
        'title',
        'subtitle',
        'description',
        'n_columns',
        'padding',
        'background_color',
        'background_image--id',
        'background_image--url',
        'background_image--alt'
      ]
    ]
  );
}

// Fact Numbers
if ( wing_section_is_active( $theme_settings, 'wing_fact' ) )  {
  $sections['post_type'][] = array(
    'id'   => 'wing_fact',
    'name' => 'Fact Numbers',
    'has_editor' => false,
    'has_thumbnail' => true,
    'labels' => [
      'singular_name' => 'Number',
      'image_name' => 'Icon'
    ],
    'meta_box' => [
      'title' => 'Number Details',
      'fields' => [
        'fontawesome_icon_class' => 'Icon Code',
        'number' => 'Number'
      ]
    ],
    'post_columns' => [
      'title' => 'Name',
      'meta' => [
        'number' => 'Number'
      ]
    ],
    'settings' => [
      'fields' => [
        'title',
        'subtitle',
        'description',
        'n_columns',
        'padding',
        'background_color',
        'background_image--id',
        'background_image--url',
        'background_image--alt'
      ]
    ]
  );
}

// Frequently Asked Questions
if ( wing_section_is_active( $theme_settings, 'wing_faq' ) )  {
  $sections['post_type'][] = array(
    'id'   => 'wing_faq',
    'name' => 'FAQs',
    'has_editor' => true,
    'has_thumbnail' => false,
    'labels' => [
      'singular_name' => 'Question',
      'image_name' => ''
    ],
    'meta_box' => null,
    'post_columns' => [
      'title' => 'Question',
      'content' => 'Answer'
    ],
    'settings' => [
      'fields' => [
        'title',
        'subtitle',
        'description',
        'padding',
        'background_color',
        'background_image--id',
        'background_image--url',
        'background_image--alt'
      ]
    ]
  );
}

// Our Products
if ( wing_section_is_active( $theme_settings, 'wing_product' ) ) {
  $sections['post_type'][] = array(
    'id'   => 'wing_product',
    'name' => 'Our Products',
    'has_editor' => true,
    'has_thumbnail' => true,
    'labels' => [
      'singular_name' => 'Product',
      'image_name' => 'Image'
    ],
    'meta_box' => [
      'title' => 'Product Details',
      'fields' => [
        'button_text' => 'Button Text',
        'button_link' => 'Button Link'
      ]
    ],
    'post_columns' => [
      'title'     => 'Name',
      'thumbnail' => 'Image',
      'content'   => 'Description'
    ],
    'settings' => [
      'fields' => [
        'title',
        'subtitle',
        'description',
        'n_columns',
        'padding',
        'background_color',
        'background_image--id',
        'background_image--url',
        'background_image--alt'
      ]
    ]
  );
}

// Our Services
if ( wing_section_is_active( $theme_settings, 'wing_service' ) ) {
  $sections['post_type'][] = array(
    'id'   => 'wing_service',
    'name' => 'Our Services',
    'has_editor' => true,
    'has_thumbnail' => true,
    'labels' => [
      'singular_name' => 'Service',
      'image_name' => 'Icon Image'
    ],
    'meta_box' => [
      'title' => 'Service Details',
      'fields' => [
        'fontawesome_icon_class' => 'Icon Code',
        'button_text' => 'Button Text',
        'button_link' => 'Button Link'
      ]
    ],
    'post_columns' => [
      'title'   => 'Name',
      'content' => 'Description'
    ],
    'settings' => [
      'fields' => [
        'title',
        'subtitle',
        'description',
        'n_columns',
        'padding',
        'background_color',
        'background_image--id',
        'background_image--url',
        'background_image--alt'
      ]
    ]
  );
}

// Our Team
if ( wing_section_is_active( $theme_settings, 'wing_team' ) ) {
  $sections['post_type'][] = array(
    'id'   => 'wing_team',
    'name' => 'Our Team',
    'has_editor' => true,
    'has_thumbnail' => true,
    'labels' => [
      'singular_name' => 'Member',
      'image_name'    => 'Photo'
    ],
    'meta_box' => [
      'title' => 'Member Details',
      'fields' => [
        'position' => 'Position'
      ]
    ],
    'post_columns' => [
      'title' => 'Name',
      'thumbnail' => 'Photo',
      'content' => 'Quote',
      'meta' => [
        'position' => 'Position'
      ]
    ],
    'settings' => [
      'fields' => [
        'title',
        'subtitle',
        'description',
        'n_columns',
        'padding',
        'background_color',
        'background_image--id',
        'background_image--url',
        'background_image--alt'
      ]
    ]
  );
}

// Testimonials
if ( wing_section_is_active( $theme_settings, 'wing_testimonial' ) ) {
  $sections['post_type'][] = array(
    'id'   => 'wing_testimonial',
    'name' => 'Testimonials',
    'has_editor' => true,
    'has_thumbnail' => true,
    'labels' => [
      'singular_name' => 'Testimonial',
      'image_name'    => 'Photo'
    ],
    'meta_box' => [
      'title' => 'Testimonial Details',
      'fields' => [
        'company' => 'Company'
      ]
    ],
    'post_columns' => [
      'title' => 'Name',
      'thumbnail' => 'Photo',
      'content' => 'Quote'
    ],
    'settings' => [
      'fields' => [
        'title',
        'subtitle',
        'description',
        'n_columns',
        'padding',
        'background_color',
        'background_image--id',
        'background_image--url',
        'background_image--alt'
      ]
    ]
  );
}