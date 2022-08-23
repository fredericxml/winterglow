<div class="wrap wing setting-page">

<h1><?php echo $section['name']; ?></h1>
<form action="" method="post">
<?php wp_nonce_field( 'update_section_' . $section['id'], 'wing_nonce' ); ?>

<?php
  // Hide the "General" for banner section because this section has its individual title.
  if ( $section['id'] !== 'banner' ) :
?>
  <h2>General</h2>
<?php endif; ?>

<table class="form-table">
  <?php
    // Title

    if ( in_array( 'title', $section_fields ) ) : ?>
    <tr>
      <th><label for="wing-section-<?php echo $section['id']; ?>-title"><?php _e( 'Title', 'wing' ); ?></label></th>
      <td>
        <input
          type="text"
          class="regular-text"
          name="wing_section_<?php echo $section['id']; ?>_title"
          id="wing-section-<?php echo $section['id']; ?>-title"
          value="<?php echo esc_attr( wing_get( $settings['title'] ) ); ?>"
        >
      </td>
    </tr>
  <?php endif; ?>

  <?php
    // Subtitle

    if ( in_array( 'subtitle', $section_fields ) ) : ?>
    <tr>
      <th><label for="wing-section-<?php echo $section['id']; ?>-subtitle"><?php _e( 'Subtitle', 'wing' ); ?></label></th>
      <td>
        <input
          type="text"
          class="regular-text"
          name="wing_section_<?php echo $section['id']; ?>_subtitle"
          id="wing-section-<?php echo $section['id']; ?>-subtitle"
          value="<?php echo esc_attr( wing_get( $settings['subtitle'] ) ); ?>"
        >
      </td>
    </tr>
  <?php endif; ?>
  
  <?php
    // Description

    if ( in_array( 'description', $section_fields ) ) : ?>
    <tr>
      <th><label for="wing-section-<?php echo $section['id']; ?>-description"><?php _e( 'Description', 'wing' ); ?></label></th>
      <td>
        <textarea
          class="regular-text code"
          name="wing_section_<?php echo $section['id']; ?>_description"
          id="wing-section-<?php echo $section['id']; ?>-description"
          rows="15"
        ><?php echo esc_textarea( wing_get( $settings['description'] ) ); ?></textarea>
      </td>
    </tr>
  <?php endif; ?>
  
  <?php
    // Image

    if ( in_array( 'image--id', $section_fields ) ) : ?>
    <tr>
      <th><label><?php _e( 'Image', 'wing' ); ?></label></th>
      <td>
        <div class="smartcat-uploader">
          <input
            type="hidden"
            id="wing-smartcat-id"
            name="wing_section_<?php echo $section['id']; ?>_image--id"
            value="<?php echo esc_attr( wing_get( $settings['image--id'] ) ); ?>"
          >
          <input
            type="hidden"
            id="wing-smartcat-src"
            name="wing_section_<?php echo $section['id']; ?>_image--url"
            value="<?php echo esc_attr( wing_get( $settings['image--url'] ) ); ?>"
          >
          <input
            type="hidden"
            id="wing-smartcat-alt"
            name="wing_section_<?php echo $section['id']; ?>_image--alt"
            value="<?php echo esc_attr( wing_get( $settings['image--alt'] ) ); ?>"
          >

          <button type="button" class="smartcat-upload button">Upload image</button>
          <a href="#!" class="smartcat-remove">Remove image</a>
          <img
            src="<?php echo esc_url( wing_get( $settings['image--url'] ) ); ?>"
            alt="<?php echo esc_attr( wing_get( $settings['image--alt'] ) ); ?>"
            srcset="<?php echo wp_get_attachment_image_srcset( $settings['image--id'] ); ?>"
            class="smartcat-image regular-text"
            loading="lazy"
          >
        </div>
      </td>
    </tr>
  <?php endif; ?>
</table>

<h2>Design</h2>
<table class="form-table">
  <?php
    // Number of columns

    if ( in_array( 'n_columns', $section_fields ) ) : ?>
    <tr>
      <th><label for="wing-section-<?php echo $section['id']; ?>-n-columns"><?php _e( 'Number of Columns', 'wing' ); ?></label></th>
      <td>
        <?php $selected = wing_get( $settings['n_columns'] ); ?>
        <select name="wing_section_<?php echo $section['id']; ?>_n_columns" id="wing-section-<?php echo $section['id']; ?>-n-columns">
          <option value="" <?php echo $selected === '' ? 'selected' : ''; ?>>Default</option>
          <option value="1" <?php echo $selected === '1' ? 'selected' : ''; ?>>1</option>
          <option value="2" <?php echo $selected === '2' ? 'selected' : ''; ?>>2</option>
          <option value="3" <?php echo $selected === '3' ? 'selected' : ''; ?>>3</option>
          <option value="4" <?php echo $selected === '4' ? 'selected' : ''; ?>>4</option>
        </select>
      </td>
    </tr>
  <?php endif; ?>
  
  <?php
    // Padding

    if ( in_array( 'padding', $section_fields ) ) : ?>
    <tr>
      <th><label for="wing-section-<?php echo $section['id']; ?>-padding"><?php _e( 'Padding', 'wing' ); ?></label></th>
      <td>
        <input
          type="number"
          class="small-text"
          name="wing_section_<?php echo $section['id']; ?>_padding"
          id="wing-section-<?php echo $section['id']; ?>-padding"
          value="<?php echo esc_attr( wing_get( $settings['padding'] ) ); ?>"
          min="0"
        >
        <span>px</span>
      </td>
    </tr>
  <?php endif; ?>
  
  <?php
    // Background color

    if ( in_array( 'background_color', $section_fields ) ) : ?>
    <tr>
      <th><label for="wing-section-<?php echo $section['id']; ?>-background-color"><?php _e( 'Background Color', 'wing' ); ?></label></th>
      <td>
        <input
          type="color"
          name="wing_section_<?php echo $section['id']; ?>_background_color"
          id="wing-section-<?php echo $section['id']; ?>-background-color"
          value="<?php echo esc_attr( wing_get( $settings['background_color'], '#ffffff' ) ); ?>"
        >
      </td>
    </tr>
  <?php endif; ?>
  
  <?php
    // Background image
    
    if ( in_array( 'background_image--id', $section_fields ) ) : ?>
    <tr>
      <th><label><?php _e( 'Background Image', 'wing' ); ?></label></th>
      <td>
        <div class="smartcat-uploader">
          <input
            type="hidden"
            id="wing-smartcat-id"
            name="wing_section_<?php echo $section['id']; ?>_background_image--id"
            value="<?php echo esc_attr( wing_get( $settings['background_image--id'] ) ); ?>"
          >
          <input
            type="hidden"
            id="wing-smartcat-src"
            name="wing_section_<?php echo $section['id']; ?>_background_image--url"
            value="<?php echo esc_attr( wing_get( $settings['background_image--url'] ) ); ?>"
          >
          <input
            type="hidden"
            id="wing-smartcat-alt"
            name="wing_section_<?php echo $section['id']; ?>_background_image--alt"
            value="<?php echo esc_attr( wing_get( $settings['background_image--alt'] ) ); ?>"
          >

          <button type="button" class="smartcat-upload button">Upload image</button>
          <a href="#!" class="smartcat-remove">Remove image</a>
          <img
            src="<?php echo esc_url( wing_get( $settings['background_image--url'] ) ); ?>"
            alt="<?php echo esc_attr( wing_get( $settings['background_image--alt'] ) ); ?>"
            srcset="<?php echo wp_get_attachment_image_srcset( $settings['background_image--id'] ); ?>"
            class="smartcat-image regular-text"
            loading="lazy"
          >
        </div>
      </td>
    </tr>
  <?php endif; ?>
</table>

<p class="submit">
  <input type="submit" class="button-primary" value="Save Changes">
</p>

</form>
</div>