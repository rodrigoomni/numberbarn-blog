<?php get_header(); ?>

<?php
// ── HERO: use sticky post, or fall back to most recent ─────────
$hero_query = new WP_Query( [
    'posts_per_page'      => 1,
    'post__in'            => get_option( 'sticky_posts' ),
    'ignore_sticky_posts' => false,
] );
if ( ! $hero_query->have_posts() ) {
    $hero_query = new WP_Query( [ 'posts_per_page' => 1 ] );
}
$hero_query->the_post();
$hero_cats    = get_the_category();
$hero_cat     = ! empty( $hero_cats ) ? $hero_cats[0] : null;
$hero_img     = get_the_post_thumbnail_url( null, 'nb-hero' );
$hero_tag     = get_theme_mod( 'nb_hero_tag', 'Featured' );
$hero_read    = nb_read_time();
$author_id    = get_the_author_meta( 'ID' );
$author_name  = get_the_author();
$author_url   = get_author_posts_url( $author_id );
$hero_excerpt = get_the_excerpt();
?>

<!-- HERO -->
<section class="hero">
  <div class="hero-inner">
    <div>
      <span class="hero-tag"><?php echo esc_html( $hero_tag ); ?></span>
      <h1><?php the_title(); ?></h1>
      <p><?php echo esc_html( $hero_excerpt ); ?></p>
      <a href="<?php the_permalink(); ?>" class="read-btn">
        <?php esc_html_e( 'Read Article', 'numberbarn' ); ?>
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
      <div class="hero-meta">
        <a href="<?php echo esc_url( $author_url ); ?>" class="avatar">
          <?php echo get_avatar( $author_id, 76, '', $author_name ); ?>
        </a>
        <div>
          <strong><?php echo esc_html( $author_name ); ?></strong>
          &nbsp;·&nbsp; <?php the_date( 'F j, Y' ); ?>
          &nbsp;·&nbsp; <?php echo esc_html( $hero_read ); ?> min read
        </div>
      </div>
    </div>
    <?php if ( $hero_img ) : ?>
    <div class="hero-img">
      <img src="<?php echo esc_url( $hero_img ); ?>" alt="<?php the_title_attribute(); ?>" />
    </div>
    <?php endif; ?>
  </div>
</section>

<?php wp_reset_postdata(); ?>

<!-- CATEGORY FILTER BAR -->
<div class="filter-bar">
  <div class="filter-inner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="filter-btn <?php echo ( ! is_category() ) ? 'active' : ''; ?>">
      <?php esc_html_e( 'All', 'numberbarn' ); ?>
    </a>
    <?php
    $filter_cats = get_categories( [ 'orderby' => 'name', 'hide_empty' => true ] );
    foreach ( $filter_cats as $fc ) :
        $active = ( is_category( $fc->slug ) ) ? 'active' : '';
    ?>
    <a href="<?php echo esc_url( get_category_link( $fc ) ); ?>" class="filter-btn <?php echo esc_attr( $active ); ?>">
        <?php echo esc_html( $fc->name ); ?>
    </a>
    <?php endforeach; ?>
  </div>
</div>

<!-- MAIN + SIDEBAR -->
<div class="main-wrap">
  <main>
    <div class="section-label"><?php esc_html_e( 'Latest Articles', 'numberbarn' ); ?></div>
    <div class="post-grid">

      <?php
      // Exclude hero post from grid
      $hero_id    = get_queried_object_id();
      $sticky_ids = get_option( 'sticky_posts' );
      $grid_query = new WP_Query( [
          'posts_per_page'      => 7,
          'post__not_in'        => $sticky_ids ?: [],
          'ignore_sticky_posts' => true,
          'paged'               => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
      ] );

      $first = true;
      while ( $grid_query->have_posts() ) : $grid_query->the_post();
          $cats      = get_the_category();
          $cat       = ! empty( $cats ) ? $cats[0] : null;
          $cat_class = $cat ? nb_cat_class( $cat->slug ) : 'cat-default';
          $cat_name  = $cat ? $cat->name : '';
          $thumb     = get_the_post_thumbnail_url( null, 'nb-card' );
          $read      = nb_read_time();
          $a_id      = get_the_author_meta( 'ID' );
          $a_name    = get_the_author();
          $a_url     = get_author_posts_url( $a_id );

          if ( $first ) : $first = false; ?>
          <!-- Wide card (first post in grid) -->
          <article class="post-card post-card-wide">
            <div class="post-card-thumb">
              <?php if ( $thumb ) : ?>
                <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
              <?php endif; ?>
            </div>
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

          <?php else : ?>
          <!-- Regular card -->
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
          <?php endif; ?>

      <?php endwhile; wp_reset_postdata(); ?>

    </div>

    <!-- PAGINATION -->
    <div class="nb-pagination">
      <?php
      echo paginate_links( [
          'total'   => $grid_query->max_num_pages,
          'current' => max( 1, get_query_var( 'paged' ) ),
          'prev_text' => '←',
          'next_text' => '→',
      ] );
      ?>
    </div>
  </main>

  <?php get_sidebar(); ?>
</div>

<!-- MEET THE AUTHORS -->
<section class="authors-section">
  <div class="authors-inner">
    <div class="authors-header">
      <div class="authors-header-text">
        <div class="authors-eyebrow"><?php esc_html_e( 'Our Writers', 'numberbarn' ); ?></div>
        <h2><?php esc_html_e( 'Meet the phone tech experts', 'numberbarn' ); ?></h2>
        <p><?php esc_html_e( 'Real people who know phone numbers inside and out — from journalists to marketers to content pros.', 'numberbarn' ); ?></p>
      </div>
      <div class="authors-slider-controls">
        <button class="slider-arrow" id="authors-prev" aria-label="Previous">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
        </button>
        <div class="slider-dots" id="authors-dots"></div>
        <button class="slider-arrow" id="authors-next" aria-label="Next">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
        </button>
      </div>
    </div>

    <div class="authors-slider-wrap">
      <div class="authors-slider" id="authors-slider">
        <?php
        $authors = get_users( [ 'who' => 'authors', 'has_published_posts' => true ] );
        foreach ( $authors as $author ) :
            $role   = get_user_meta( $author->ID, 'nb_author_role', true ) ?: $author->roles[0] ?? 'Contributor';
            $bio    = get_user_meta( $author->ID, 'description', true ) ?: '';
            $a_url  = get_author_posts_url( $author->ID );
            $avatar = get_avatar( $author->ID, 176, '', $author->display_name );
        ?>
        <div class="author-card">
          <a href="<?php echo esc_url( $a_url ); ?>" class="author-card-photo"><?php echo $avatar; ?></a>
          <h3><?php echo esc_html( $author->display_name ); ?></h3>
          <div class="author-role"><?php echo esc_html( $role ); ?></div>
          <p><?php echo esc_html( $bio ); ?></p>
          <a href="<?php echo esc_url( $a_url ); ?>" class="view-posts">
            <?php esc_html_e( 'All posts', 'numberbarn' ); ?>
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
