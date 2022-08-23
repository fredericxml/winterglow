<?php get_header(); ?>



<main>
  <header style="background-image: url(<?php wing_img_url( 'blog.jpg' ); ?>);">
    <div class="overlay"></div>
    <div class="container position-relative">
      <h1>Blog</h1>
    </div>
  </header>
  
  <nav class="breadcrumb-wrapper shadow-sm" aria-label="breadcrumb">
    <div class="container">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Blog</li>
      </ol>
    </div>
  </nav>
  
  <main class="container text-center">
    <div class="grid">
      <?php while ( have_posts() ) : the_post(); ?>
      
        <div class="g-col-12 g-col-md-6 g-col-lg-4">
          <a href="<?php the_permalink(); ?>" class="blog-card">
            <?php the_post_thumbnail( 'medium_large', [ 'class' => 'blog-image' ] ); ?>
  
            <h2 class="blog-title"><?php the_title(); ?></h2>
          </a>
        </div>
  
      <?php endwhile; ?>
    </div>
  </main>
</main>



<?php get_footer(); ?>