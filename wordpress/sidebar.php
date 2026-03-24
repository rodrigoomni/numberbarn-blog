<aside class="sidebar">

  <?php if ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
    <?php dynamic_sidebar( 'sidebar-blog' ); ?>
  <?php else : ?>

    <!-- SEARCH -->
    <div class="sidebar-widget">
      <div class="widget-head"><?php esc_html_e( 'Search', 'numberbarn' ); ?></div>
      <div class="widget-body">
        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-box">
          <input type="search" name="s" placeholder="<?php esc_attr_e( 'Search articles…', 'numberbarn' ); ?>" value="<?php echo get_search_query(); ?>" />
          <button type="submit" aria-label="<?php esc_attr_e( 'Search', 'numberbarn' ); ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>
          </button>
        </form>
      </div>
    </div>

    <!-- NEWSLETTER -->
    <div class="sidebar-widget newsletter-widget">
      <div class="widget-head"><?php esc_html_e( 'Weekly Digest', 'numberbarn' ); ?></div>
      <div class="widget-body">
        <p><?php esc_html_e( 'Get the best phone number tips and industry news delivered to your inbox every week.', 'numberbarn' ); ?></p>
        <?php echo do_shortcode( '[mc4wp_form]' ); // Mailchimp for WP shortcode — replace with your form ?>
        <?php /* Fallback plain form if no plugin active */ ?>
        <input class="nl-input" type="email" placeholder="<?php esc_attr_e( 'your@email.com', 'numberbarn' ); ?>" />
        <button class="nl-btn"><?php esc_html_e( 'Subscribe →', 'numberbarn' ); ?></button>
      </div>
    </div>

    <!-- POPULAR POSTS (recent as fallback) -->
    <div class="sidebar-widget">
      <div class="widget-head"><?php esc_html_e( 'Popular Posts', 'numberbarn' ); ?></div>
      <div class="widget-body">
        <ul class="popular-list">
          <?php
          $popular = new WP_Query( [
              'posts_per_page' => 4,
              'meta_key'       => 'post_views_count', // works with Post Views Counter plugin
              'orderby'        => 'meta_value_num',
              'order'          => 'DESC',
              'ignore_sticky_posts' => true,
          ] );
          // Fallback to recent posts if no view counts exist
          if ( ! $popular->have_posts() ) {
              $popular = new WP_Query( [ 'posts_per_page' => 4, 'ignore_sticky_posts' => true ] );
          }
          $n = 1;
          while ( $popular->have_posts() ) : $popular->the_post(); ?>
            <li class="popular-item">
              <span class="popular-num"><?php echo str_pad( $n++, 2, '0', STR_PAD_LEFT ); ?></span>
              <div>
                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                <span><?php the_date( 'M j, Y' ); ?></span>
              </div>
            </li>
          <?php endwhile; wp_reset_postdata(); ?>
        </ul>
      </div>
    </div>

  <?php endif; ?>
</aside>
