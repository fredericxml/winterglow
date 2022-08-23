<?php
/*
|--------------------------------------------------------------------------
| Custom Post-Type Sections
|--------------------------------------------------------------------------
|
| The sections that are built using the custom post-type. This class controls
| the name of the label that appears in the dashboard menu, the columns that
| appear in the table list, as well as the metaboxes and how they are being
| stored.
|
*/

defined( 'ABSPATH' ) || exit;

class Wing_Custom_Sections_Post_Type extends Wing_Custom_Sections_Base {
  /**
   * Constructor
   *
   * @return void
   */
  public function __construct() {
    parent::__construct( 'post_type' );
    add_action( 'init', [ $this, 'register_post_type' ] );
    add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ] );
    add_action( 'save_post', [ $this, 'save_meta_data' ] );
    add_action( 'admin_menu', [ $this, 'register_menu' ] );
    $this->manage_post_columns();
  }

  /**
   * Register custom post-type.
   *
   * @return void
   */
  public function register_post_type() {
    foreach ( $this->sections as $section ) {
      $labels = array(
        'name'                  => __( $section['name'], 'wing' ),
        'singular_name'         => __( $section['labels']['singular_name'], 'wing' ),
        'add_new'               => __( 'New ' . $section['labels']['singular_name'], 'wing' ),
        'add_new_item'          => __( 'Add New ' . $section['labels']['singular_name'], 'wing' ),
        'edit_item'             => __( 'Edit ' . $section['labels']['singular_name'], 'wing' ),
        'search_items'          => __( 'Search ' . $section['labels']['singular_name'], 'wing' ),
        'not_found'             => __( 'No ' . $section['labels']['singular_name'] . ' found', 'wing' ),
        'not_found_in_trash'    => __( 'Nothing found in Trash', 'wing' ),
        'featured_image'        => __( $section['labels']['image_name'], 'wing' ),
        'set_featured_image'    => __( 'Set ' . strtolower( $section['labels']['image_name'] ), 'wing' ),
        'remove_featured_image' => __( 'Remove ' . strtolower( $section['labels']['image_name'] ), 'wing' ),
        'items_list'            => __( $section['labels']['singular_name'] . ' list', 'wing' )
      );
  
      $args = array(
        'labels' => $labels,
        'show_ui' => true,
        'menu_position' => 31,
        'menu_icon' => 'dashicons-open-folder',
        'supports' => [
          'title',
          ( $section['has_editor'] ? 'editor' : '' ),
          ( $section['has_thumbnail'] ? 'thumbnail' : '' )
        ]
      );
  
      register_post_type( $section['id'], $args );
    }
  }
  
  /**
   * Add meta box if the section needs it.
   *
   * @return void
   */
  public function add_meta_box() {
    foreach ( $this->sections as $section ) {
      if ( $section['meta_box'] !== null ) {
        add_meta_box(
          'wing_section_' . $section['id'] . '_meta_box',
          $section['meta_box']['title'],
          [ $this, 'render_meta_box' ],
          $section['id'],
          'normal',
          'high',
          $section
        );
      }
    }
  }

  /**
   * Setup the updater if any meta box form is submitted and break the loop
   * while it has been updated to avoid redundant check.
   * 
   * Note: If you are working with serialized data, the array is updated
   * with an extra nested array. In order to keep the same structure, update
   * the object in the first nested position.
   *
   * @param  int $post_id
   * @return void
   */
  public function save_meta_data( $post_id ) {
    if ( isset( $_POST['wing_nonce'] ) ) {
      $meta_data = get_post_meta( $post_id, 'wing_section_meta' );

      foreach ( $this->sections as $section ) {
        if ( wp_verify_nonce( $_POST['wing_nonce'], 'update_section_' . $section['id'] . '_meta' ) ) {
          foreach ( $section['meta_box']['fields'] as $field => $field_name ) {
            $value = $_POST['wing_section_' . $section['id'] . '_meta_' . $field];

            // Determine how the data should be sanitized.
            switch ( $field ) {
              case 'fontawesome_icon_class':
                $value = sanitize_text_field( $value );
                break;

              default:
                $value = sanitize_text_field( $value );
            }

            $meta_data[0][0][ $field ] = $value;
          }
          break;
        }
      }

      update_post_meta( $post_id, 'wing_section_meta', $meta_data[0] );
    }
  }

  /**
   * Render the meta box form.
   *
   * @param  mixed $post
   * @param  array $metabox
   * @return void
   */
  public function render_meta_box( $post, $metabox ) {
    if ( ! current_user_can( 'manage_options' ) ) {
      return;
    }
    
    $section   = $metabox['args'];
    $meta_data = wing_get( get_post_meta( $post->ID, 'wing_section_meta' )[0][0], [] );
    
    require_once WING_THEME_PATH . 'inc/custom-sections/templates/metabox-form.php';
  }

  /**
   * Manage the columns that will be shown in the table.
   *
   * @return void
   */
  private function manage_post_columns() {
    foreach ( $this->sections as $section ) {
      add_filter( 'manage_' . $section['id'] . '_posts_columns', function ( $columns ) use ( $section ) {
        unset( $columns['date'] );

        $columns['title'] = $section['post_columns']['title'];

        if ( isset( $section['post_columns']['thumbnail'] ) ) {
          $columns['thumbnail'] = $section['post_columns']['thumbnail'];
        }
        if ( isset( $section['post_columns']['meta'] ) ) {
          foreach ( $section['post_columns']['meta'] as $field => $field_name ) {
            $columns[ $field ] = $field_name;
          }
        }
        if ( isset( $section['post_columns']['content'] ) ) {
          $columns['content'] = $section['post_columns']['content'];
        }
        $columns['date'] = 'Date';

        return $columns;
      } );

      add_action( 'manage_' . $section['id'] . '_posts_custom_column', function ( $column, $post_id ) use ( $section ) {
        // This column contains the featured images.
        if ( $column === 'thumbnail' ) {
          $img = get_the_post_thumbnail( $post_id, 'thumbnail' );
          echo ( ! empty( $img ) ) ? $img : '—';
        }
        
        // This column contains single-line text from the metabox.
        if ( isset( $section['post_columns']['meta'] ) ) {
          $meta_data = get_post_meta( $post_id, 'wing_section_meta' )[0][0];

          foreach ( $section['post_columns']['meta'] as $field => $field_name ) {
            if ( $column === $field ) {
              echo ( ! empty( $meta_data[ $field ] ) ) ? $meta_data[ $field ] : '—';
            }
          }
        }

        // This column contains long text from the built-in editor.
        if ( $column === 'content' ) {
          $post_data = get_post( $post_id );
          $content = substr( $post_data->post_content, 0, 50 );

          if ( strlen( $post_data->post_content ) > 50 ) {
            $content .= ' […]';
          }
          echo ( ! empty( $content ) ) ? $content : '—';
        }
      }, 10, 2 );
    }
  }
  
  /**
   * Register submenu for setting page.
   *
   * @return void
   */
  public function register_menu() {
    foreach ( $this->sections as $section ) {
      add_submenu_page(
        'edit.php?post_type=' . $section['id'],
        'Section Settings',
        'Settings',
        'manage_options',
        'wing-section-' . $section['id'] . '-settings',
        function() use ( $section ) { $this->render_setting_page( $section ); }
      );
    }
  }
}

new Wing_Custom_Sections_Post_Type();