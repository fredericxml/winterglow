<div class="wrap wing metabox">
  <form action="" method="post">
    <?php wp_nonce_field( 'update_section_' . $section['id'] . '_meta', 'wing_nonce' ); ?>
    
    <table class="form-table">
      <?php foreach ( $section['meta_box']['fields'] as $field => $field_name ) : ?>
        <tr>
          <th><label for="wing-section-<?php echo $section['id']; ?>-meta-<?php echo $field; ?>"><?php _e( $field_name, 'wing' ); ?></label></th>
          <td>
            <?php if ( $field !== 'fontawesome_icon_class' ) : ?>
              <input
                type="text"
                class="regular-text"
                name="wing_section_<?php echo $section['id']; ?>_meta_<?php echo $field; ?>"
                id="wing-section-<?php echo $section['id']; ?>-meta-<?php echo $field; ?>"
                value="<?php echo esc_attr( wing_get( $meta_data[ $field ] ) ); ?>"
              >
            <?php endif; ?>

            <?php
              // FontAwesome icon picker field

              if ( $field === 'fontawesome_icon_class' ) : ?>
              <div class="howl-iconpicker">
                <input
                  type="hidden"
                  name="wing_section_<?php echo $section['id']; ?>_meta_<?php echo $field; ?>"
                  value="<?php echo esc_attr( wing_get( $meta_data[ $field ] ) ); ?>"
                >
                <button type="button" class="howl-select button">Select icon</button>
                <a href="#!" class="howl-remove">Remove icon</a>
                <i class="<?php echo esc_attr( wing_get( $meta_data[ $field ] ) ); ?>"></i>
              </div>

              <div class="howl-iconpicker-modal" tabindex="-1">
                <div class="howl-iconpicker-dialog">
                  <div class="howl-iconpicker-content">
                    <div class="howl-iconpicker-header">
                      <h5 class="howl-iconpicker-title">Icon Gallery</h5>
                      <button type="button" class="howl-iconpicker-close"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <div class="howl-iconpicker-body">
                      <input placeholder="Filter by name...">
                      <div class="icons-card-wrapper"></div>
                    </div>
                    <div class="howl-iconpicker-footer">
                      <button type="button" class="howl-iconpicker-insert button-primary">Insert icon</button>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </form>
</div>