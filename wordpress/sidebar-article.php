<aside class="article-sidebar">

  <?php if ( is_active_sidebar( 'sidebar-article' ) ) : ?>
    <?php dynamic_sidebar( 'sidebar-article' ); ?>
  <?php else : ?>

    <!-- TABLE OF CONTENTS (auto-generated from headings) -->
    <div class="sidebar-widget">
      <div class="widget-head"><?php esc_html_e( 'In This Article', 'numberbarn' ); ?></div>
      <div class="widget-body">
        <ul class="toc-list" id="toc-list">
          <?php
          // Extract H2 headings from post content
          $content = get_the_content();
          preg_match_all( '/<h2[^>]*>(.*?)<\/h2>/is', $content, $matches );
          if ( ! empty( $matches[1] ) ) :
              foreach ( $matches[1] as $i => $heading ) :
                  $text = wp_strip_all_tags( $heading );
                  $slug = 'section-' . ( $i + 1 );
                  echo '<li><a href="#' . esc_attr( $slug ) . '" class="' . ( $i === 0 ? 'active' : '' ) . '">' . esc_html( $text ) . '</a></li>';
              endforeach;
          else : ?>
            <li><a href="#"><?php the_title(); ?></a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>

    <!-- NEWSLETTER -->
    <div class="sidebar-widget newsletter-widget">
      <div class="widget-head"><?php esc_html_e( 'Weekly Digest', 'numberbarn' ); ?></div>
      <div class="widget-body">
        <p><?php esc_html_e( 'Phone tips and industry news, once a week. No spam, ever.', 'numberbarn' ); ?></p>
        <input class="nl-input" type="email" placeholder="<?php esc_attr_e( 'your@email.com', 'numberbarn' ); ?>" />
        <button class="nl-btn"><?php esc_html_e( 'Subscribe →', 'numberbarn' ); ?></button>
      </div>
    </div>

    <!-- RELATED IN SIDEBAR -->
    <div class="sidebar-widget">
      <div class="widget-head"><?php esc_html_e( 'Related Posts', 'numberbarn' ); ?></div>
      <div class="widget-body">
        <?php
        $cats    = get_the_category();
        $cat_ids = wp_list_pluck( $cats, 'term_id' );
        $related = new WP_Query( [
            'posts_per_page'      => 3,
            'category__in'        => $cat_ids,
            'post__not_in'        => [ get_the_ID() ],
            'orderby'             => 'rand',
            'ignore_sticky_posts' => true,
        ] );
        while ( $related->have_posts() ) : $related->the_post();
            $r_cats  = get_the_category();
            $r_cat   = ! empty( $r_cats ) ? $r_cats[0] : null;
            $r_class = $r_cat ? nb_cat_class( $r_cat->slug ) : 'cat-default';
        ?>
        <div class="sidebar-related-item">
          <?php if ( $r_cat ) : ?>
            <div class="sidebar-related-cat cat-tag <?php echo esc_attr( $r_class ); ?>"><?php echo esc_html( $r_cat->name ); ?></div>
          <?php endif; ?>
          <a href="<?php the_permalink(); ?>" class="sidebar-related-title"><?php the_title(); ?></a>
          <div class="sidebar-related-date"><?php the_date( 'M j, Y' ); ?></div>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>

  <?php endif; ?>
</aside>
