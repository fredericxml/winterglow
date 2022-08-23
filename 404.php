<?php get_header(); ?>



<style>
.wing .not-found {
  padding-top: 5rem;
  padding-bottom: 5rem;
}
.wing .not-found .number-404 {
  color: var(--wing-primary);
  font-family: "Exo", sans-serif;
  font-size: 5rem;
  font-weight: 500;
}
.wing .not-found h1 {
  color: var(--wing-primary);
  font-family: "Exo", sans-serif;
  font-weight: 700;
  letter-spacing: -1px;
  text-transform: uppercase;
}
.wing .not-found .btn {
  margin-top: 1.5rem;
  margin-bottom: 2rem;
}
</style>

<main class="not-found">
  <div class="container text-center">
    <p class="number-404">404</p>
    <h1>Page Not Found</h1>
    <p>We’re unable to find the page you’re looking for…</p>
    <a href="<?php echo home_url(); ?>" class="btn">Home</a>
  </div>
</main>



<?php get_footer(); ?>