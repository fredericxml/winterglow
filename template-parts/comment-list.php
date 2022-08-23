<?php

function wing_comment_list( $comment, $args, $depth ) { ?>

  <?php $has_noreply = ( $depth == $args['max_depth'] ) ? 'no-reply' : ''; ?>

  <li <?php comment_class( $has_noreply ); ?> id="comment-<?php comment_ID() ?>">
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
      <div class="comment-header">
        <div class="d-flex align-items-center">
          <?php echo get_avatar( $comment, $args['avatar_size'] ); ?>

          <div style="padding-left: 0.75rem;">
            <cite><?php comment_author() ?></cite>
            <span>
              <?php
                printf(
                  __( '%1$s at %2$s' ),
                  get_comment_date(),
                  get_comment_time()
                );
              ?>
            </span>
          </div>
        </div>
      </div>
		
      <div class="comment-content"><?php comment_text(); ?></div>

      <div class="comment-footer">
        <?php
          edit_comment_link(
            '<i class="fa-solid fa-pencil"></i>' . __( 'Edit' ), '',
            '<span class="separator">&bull;</span>'
          );
          
          comment_reply_link( array_merge(
            $args,
            array(
              'reply_text' => '<i class="fa-solid fa-reply"></i>' . __( 'Reply' ),
              'depth'      => $depth,
              'max_depth'  => $args['max_depth']
            )
          ) );
        ?>
      </div>
    </div>
  
<?php }