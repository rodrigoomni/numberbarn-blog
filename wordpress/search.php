<?php get_header(); ?>

<!-- SEARCH HEADER -->
<div class="archive-header">
  <div class="archive-header-inner">
    <div class="archive-eyebrow"><?php esc_html_e( 'Search Results', 'numberbarn' ); ?></div>
    <h1>
      <?php
      if ( get_search_query() ) {
          printf( esc_html__( 'Results for: "%s"', 'numberbarn' ), esc_html( get_search_query() ) );
      } else {
          esc_html_e( 'Search the Blog', 'numberbarn' );
      }
      ?>
    </h1>
    <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-header-form">
      <input type="search" name="s" placeholder="<?php esc_attr_e( 'Search articles…', 'numberbarn' ); ?>" value="<?php echo get_search_query(); ?>" />
      <button type="submit"><?php esc_html_e( 'Search', 'numberbarn' ); ?></button>
    </form>
  </div>
</div>

<!-- RESULTS + SIDEBAR -->
<div class="main-wrap">
  <main>
    <?php if ( have_posts() ) : ?>
    <div class="section-label">
      <?php
      global $wp_query;
      printf( esc_html__( '%d results found', 'numberbarn' ), $wp_query->found_posts );
      ?>
    </div>
    <div class="post-grid">
      <?php while ( have_posts() ) : the_post();
          $cats      = get_the_category();
          $cat       = ! empty( $cats ) ? $cats[0] : null;
          $cat_class = $cat ? nb_cat_class( $cat->slug ) : 'cat-default';
          $thumb     = get_the_post_thumbnail_url( null, 'nb-card' );
          $read      = nb_read_time();
          $a_id      = get_the_author_meta( 'ID' );
      ?>
      <article class="post-card">
        <?php if ( $thumb ) : ?>
        <div class="post-card-thumb">
          <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
        </div>
        <?php endif; ?>
        <div class="post-card-body">
          <?php echo nb_first_cat_tag(); ?>
          <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <p class="post-excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
          <div class="post-footer">
            <?php echo nb_author_chip( $a_id ); ?>
            <span class="read-time">⏱ <?php echo esc_html( $read ); ?> min read</span>
          </div>
        </div>
      </article>
      <?php endwhile; ?>
    </div>

    <div class="nb-pagination">
      <?php the_posts_pagination( [ 'prev_text' => '←', 'next_text' => '→' ] ); ?>
    </div>

    <?php else : ?>
    <div class="no-results">
      <h2><?php esc_html_e( 'No results found', 'numberbarn' ); ?></h2>
      <p><?php esc_html_e( 'Try a different search term, or browse our categories below.', 'numberbarn' ); ?></p>
    </div>
    <?php endif; ?>
  </main>

  <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
