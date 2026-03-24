<?php get_header(); ?>

<?php
$term       = get_queried_object();
$term_name  = is_category() ? single_cat_title( '', false ) : ( is_tag() ? single_tag_title( '', false ) : get_the_archive_title() );
$term_desc  = is_category() ? category_description() : ( is_tag() ? tag_description() : '' );
$cat_class  = ( $term && isset( $term->slug ) ) ? nb_cat_class( $term->slug ) : 'cat-default';
?>

<!-- ARCHIVE HEADER -->
<div class="archive-header">
  <div class="archive-header-inner">
    <?php if ( is_category() ) : ?>
      <div class="archive-eyebrow"><?php esc_html_e( 'Category', 'numberbarn' ); ?></div>
    <?php elseif ( is_tag() ) : ?>
      <div class="archive-eyebrow"><?php esc_html_e( 'Tag', 'numberbarn' ); ?></div>
    <?php endif; ?>
    <h1><?php echo esc_html( $term_name ); ?></h1>
    <?php if ( $term_desc ) : ?>
      <p><?php echo esc_html( wp_strip_all_tags( $term_desc ) ); ?></p>
    <?php endif; ?>
  </div>
</div>

<!-- CATEGORY FILTER BAR (on category archives) -->
<?php if ( is_category() ) : ?>
<div class="filter-bar">
  <div class="filter-inner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="filter-btn">
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
<?php endif; ?>

<!-- MAIN + SIDEBAR -->
<div class="main-wrap">
  <main>
    <div class="section-label">
      <?php printf( esc_html__( 'Articles in %s', 'numberbarn' ), esc_html( $term_name ) ); ?>
    </div>

    <?php if ( have_posts() ) : ?>
    <div class="post-grid">
      <?php $first = true; while ( have_posts() ) : the_post();
          $cats      = get_the_category();
          $cat       = ! empty( $cats ) ? $cats[0] : null;
          $cat_class = $cat ? nb_cat_class( $cat->slug ) : 'cat-default';
          $thumb     = get_the_post_thumbnail_url( null, 'nb-card' );
          $read      = nb_read_time();
          $a_id      = get_the_author_meta( 'ID' );

          if ( $first ) : $first = false; ?>
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

      <?php endwhile; ?>
    </div>

    <div class="nb-pagination">
      <?php the_posts_pagination( [ 'prev_text' => '←', 'next_text' => '→' ] ); ?>
    </div>

    <?php else : ?>
    <div class="no-results">
      <h2><?php esc_html_e( 'No posts found', 'numberbarn' ); ?></h2>
      <p><?php esc_html_e( 'Try browsing another category or search for what you need.', 'numberbarn' ); ?></p>
    </div>
    <?php endif; ?>

  </main>

  <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
