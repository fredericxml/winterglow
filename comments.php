<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) return;
require_once WING_THEME_PATH . 'template-parts/comment-list.php'; ?>



<div id="comments" class="comments-area">
  <h2 class="screen-reader-text"><?php _e( 'Reader Interactions', 'wing' ); ?></h2>
  
  <h3 class="comments-title">
    <i class="fa-regular fa-comment-dots"></i>
    <?php
      printf(
        _nx( '%1$s Comment', '%1$s Comments', get_comments_number(), 'Comments title', 'wing' ),
        number_format_i18n( get_comments_number() )
      );
    ?>
  </h3>
  
  <?php
    comment_form([
      'class_submit' => 'btn submit',
      'comment_notes_before' => ''
    ]);
  ?>

  <?php if ( ! comments_open() ) : ?>
    <p class="no-comments"><?php _e( 'Comments are closed.', 'wing' ); ?></p>
  <?php endif; ?>

  <?php if ( have_comments() ) : ?>
    <ol class="comment-list">
      <?php
        wp_list_comments([
          'style' => 'ol',
          'avatar_size' => 38,
          'reverse_top_level' => true,
          'reverse_children' => true,
          'callback' => 'wing_comment_list',
          'per_page' => -1
        ]);
      ?>
    </ol>
  <?php endif; ?>
</div>