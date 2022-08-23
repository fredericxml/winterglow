<?php get_header(); ?>



<?php while ( have_posts() ) : the_post(); ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container">
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <div class="entry-content"><?php the_content(); ?></div>
    </div>
  </article>	

<?php endwhile; ?>



<?php get_footer(); ?>