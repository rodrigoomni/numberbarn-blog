<?php get_header(); ?>

<?php
$author     = get_queried_object();
$author_id  = $author->ID;
$role       = get_user_meta( $author_id, 'nb_author_role', true ) ?: ucfirst( $author->roles[0] ?? 'Contributor' );
$bio        = get_the_author_meta( 'description', $author_id );
$twitter    = get_user_meta( $author_id, 'nb_twitter',  true );
$linkedin   = get_user_meta( $author_id, 'nb_linkedin', true );
$post_count = count_user_posts( $author_id );
?>

<!-- AUTHOR HERO -->
<section class="author-hero">
  <div class="author-hero-inner">
    <div class="author-hero-photo">
      <?php echo get_avatar( $author_id, 280, '', $author->display_name ); ?>
    </div>
    <div class="author-hero-text">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="author-hero-back">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        <?php esc_html_e( 'Back to Blog', 'numberbarn' ); ?>
      </a>
      <div class="author-hero-role"><?php echo esc_html( $role ); ?></div>
      <h1 class="author-hero-name"><?php echo esc_html( $author->display_name ); ?></h1>
      <?php if ( $bio ) : ?>
        <p class="author-hero-bio"><?php echo esc_html( $bio ); ?></p>
      <?php endif; ?>
      <div class="author-hero-socials">
        <?php if ( $twitter ) : ?>
        <a href="<?php echo esc_url( $twitter ); ?>" class="social-btn" target="_blank" rel="noopener">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          Twitter / X
        </a>
        <?php endif; ?>
        <?php if ( $linkedin ) : ?>
        <a href="<?php echo esc_url( $linkedin ); ?>" class="social-btn" target="_blank" rel="noopener">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          LinkedIn
        </a>
        <?php endif; ?>
        <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" class="social-btn">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          <?php esc_html_e( 'All Articles', 'numberbarn' ); ?>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- STATS BAR -->
<div class="author-stats">
  <div class="stats-inner">
    <div class="stat-item">
      <div class="stat-number"><?php echo esc_html( $post_count ); ?></div>
      <div class="stat-label"><?php esc_html_e( 'Articles', 'numberbarn' ); ?></div>
    </div>
    <?php
    // Avg read time across author posts
    $all_posts = get_posts( [ 'author' => $author_id, 'posts_per_page' => -1 ] );
    $total_rt  = 0;
    foreach ( $all_posts as $p ) { $total_rt += nb_read_time( $p->ID ); }
    $avg_rt = $post_count > 0 ? round( $total_rt / $post_count, 1 ) : '—';
    ?>
    <div class="stat-item">
      <div class="stat-number"><?php echo esc_html( $avg_rt ); ?></div>
      <div class="stat-label"><?php esc_html_e( 'Avg. Min Read', 'numberbarn' ); ?></div>
    </div>
    <div class="stat-item">
      <div class="stat-number"><?php echo esc_html( date( 'Y', strtotime( $author->user_registered ) ) ); ?></div>
      <div class="stat-label"><?php esc_html_e( 'Writing Since', 'numberbarn' ); ?></div>
    </div>
  </div>
</div>

<!-- POSTS + SIDEBAR -->
<div class="author-wrap">
  <main>
    <div class="section-label">
      <?php printf( esc_html__( 'Articles by %s', 'numberbarn' ), esc_html( $author->display_name ) ); ?>
    </div>
    <div class="post-grid">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
          $cats      = get_the_category();
          $cat       = ! empty( $cats ) ? $cats[0] : null;
          $cat_class = $cat ? nb_cat_class( $cat->slug ) : 'cat-default';
          $thumb     = get_the_post_thumbnail_url( null, 'nb-card' );
          $read      = nb_read_time();
      ?>
      <article class="post-card">
        <?php if ( $thumb ) : ?>
        <div class="post-card-thumb">
          <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
        </div>
        <?php endif; ?>
        <div class="post-card-body">
          <?php if ( $cat ) : ?>
            <span class="cat-tag <?php echo esc_attr( $cat_class ); ?>"><?php echo esc_html( $cat->name ); ?></span>
          <?php endif; ?>
          <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <p class="post-excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
          <div class="post-footer">
            <span class="post-date"><?php the_date( 'M j, Y' ); ?></span>
            <span class="read-time">⏱ <?php echo esc_html( $read ); ?> min read</span>
          </div>
        </div>
      </article>
      <?php endwhile; endif; ?>
    </div>

    <!-- PAGINATION -->
    <div class="nb-pagination">
      <?php the_posts_pagination( [ 'prev_text' => '←', 'next_text' => '→' ] ); ?>
    </div>
  </main>

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <?php if ( is_active_sidebar( 'sidebar-author' ) ) : ?>
      <?php dynamic_sidebar( 'sidebar-author' ); ?>
    <?php else : ?>

      <!-- About card -->
      <div class="sidebar-widget">
        <div class="widget-head"><?php esc_html_e( 'About the Author', 'numberbarn' ); ?></div>
        <div class="widget-body about-card">
          <div class="about-card-photo"><?php echo get_avatar( $author_id, 144 ); ?></div>
          <h3><?php echo esc_html( $author->display_name ); ?></h3>
          <div class="role"><?php echo esc_html( $role ); ?></div>
          <?php if ( $bio ) : ?><p><?php echo esc_html( $bio ); ?></p><?php endif; ?>
        </div>
      </div>

      <!-- Newsletter -->
      <div class="sidebar-widget newsletter-widget">
        <div class="widget-head"><?php esc_html_e( 'Weekly Digest', 'numberbarn' ); ?></div>
        <div class="widget-body">
          <p><?php printf( esc_html__( "Get %s's latest articles and phone number tips in your inbox.", 'numberbarn' ), esc_html( $author->display_name ) ); ?></p>
          <input class="nl-input" type="email" placeholder="<?php esc_attr_e( 'your@email.com', 'numberbarn' ); ?>" />
          <button class="nl-btn"><?php esc_html_e( 'Subscribe →', 'numberbarn' ); ?></button>
        </div>
      </div>

      <!-- Other authors -->
      <div class="sidebar-widget">
        <div class="widget-head"><?php esc_html_e( 'Other Writers', 'numberbarn' ); ?></div>
        <div class="widget-body">
          <ul class="other-authors-list">
            <?php
            $others = get_users( [
                'who'                => 'authors',
                'has_published_posts' => true,
                'exclude'            => [ $author_id ],
                'number'             => 4,
            ] );
            foreach ( $others as $other ) :
                $other_role = get_user_meta( $other->ID, 'nb_author_role', true ) ?: ucfirst( $other->roles[0] ?? 'Contributor' );
            ?>
            <li class="other-author-item">
              <a href="<?php echo esc_url( get_author_posts_url( $other->ID ) ); ?>" class="other-author-av">
                <?php echo get_avatar( $other->ID, 80 ); ?>
              </a>
              <div>
                <h4><a href="<?php echo esc_url( get_author_posts_url( $other->ID ) ); ?>"><?php echo esc_html( $other->display_name ); ?></a></h4>
                <span><?php echo esc_html( $other_role ); ?></span>
              </div>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

    <?php endif; ?>
  </aside>
</div>

<?php get_footer(); ?>
