<?php get_header(); ?>



<main>
  <?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>">
      <header style="background-image: url(<?php the_post_thumbnail_url( $post->ID ); ?>);">
        <div class="overlay"></div>
        <div class="container position-relative">
          <h1><?php the_title(); ?></h1>
        </div>
      </header>
      
      <nav class="breadcrumb-wrapper shadow-sm" aria-label="breadcrumb">
        <div class="container">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo get_post_type_archive_link( 'post' ); ?>">Blog</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
          </ol>
        </div>
      </nav>

      <main class="container">
        <div class="entry-content"><?php the_content(); ?></div>
        
        <div class="post-navigation">
          <span class="prev"><?php previous_post_link(); ?></span>
          <span class="next"><?php next_post_link(); ?></span>
        </div>

        <?php comments_template(); ?>
      </main>
    </article>
    
  <?php endwhile; ?>
</main>



<?php get_footer(); ?>