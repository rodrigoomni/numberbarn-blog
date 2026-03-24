<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<!-- PAGE HEADER -->
<div class="archive-header">
  <div class="archive-header-inner">
    <h1><?php the_title(); ?></h1>
  </div>
</div>

<!-- PAGE CONTENT + SIDEBAR -->
<div class="article-wrap">
  <article class="article-content">
    <?php the_content(); ?>
    <?php wp_link_pages(); ?>
  </article>

  <?php get_template_part( 'sidebar', 'article' ); ?>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
