<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<?php $hero_img = get_the_post_thumbnail_url( null, 'nb-hero' ); ?>
<?php if ( $hero_img ) : ?>
<div class="post-hero-img-wrap">
  <div class="post-hero-img-inner">
    <img src="<?php echo esc_url( $hero_img ); ?>" alt="<?php the_title_attribute(); ?>" />
  </div>
</div>
<?php endif; ?>

<?php
$cats      = get_the_category();
$cat       = ! empty( $cats ) ? $cats[0] : null;
$cat_class = $cat ? nb_cat_class( $cat->slug ) : 'cat-default';
$cat_name  = $cat ? $cat->name : '';
$cat_url   = $cat ? get_category_link( $cat ) : '';
$author_id = get_the_author_meta( 'ID' );
$read_time = nb_read_time();
?>

<!-- ARTICLE HERO -->
<div class="article-hero">
  <div class="article-hero-inner">

    <!-- Breadcrumb -->
    <nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'numberbarn' ); ?>">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Blog', 'numberbarn' ); ?></a>
      <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
      <?php if ( $cat ) : ?>
        <a href="<?php echo esc_url( $cat_url ); ?>"><?php echo esc_html( $cat_name ); ?></a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
      <?php endif; ?>
      <span><?php the_title(); ?></span>
    </nav>

    <?php if ( $cat ) : ?>
      <span class="article-cat-tag <?php echo esc_attr( $cat_class ); ?>"><?php echo esc_html( $cat_name ); ?></span>
    <?php endif; ?>

    <h1><?php the_title(); ?></h1>

    <?php if ( has_excerpt() ) : ?>
      <p class="article-deck"><?php echo esc_html( get_the_excerpt() ); ?></p>
    <?php endif; ?>

    <!-- Byline -->
    <div class="article-byline">
      <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" class="byline-av">
        <?php echo get_avatar( $author_id, 96, '', get_the_author() ); ?>
      </a>
      <div class="byline-meta">
        <div class="byline-name">
          <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><?php the_author(); ?></a>
        </div>
        <div class="byline-details">
          <?php the_date( 'F j, Y' ); ?> &nbsp;·&nbsp;
          <?php echo esc_html( $read_time ); ?> min read
          <?php if ( $cat ) : ?>&nbsp;·&nbsp; <?php echo esc_html( $cat_name ); ?><?php endif; ?>
        </div>
      </div>
      <div class="byline-share">
        <span style="font-size:12px;color:#9ca7b0;font-weight:500;"><?php esc_html_e( 'Share', 'numberbarn' ); ?></span>
        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>" class="share-btn" aria-label="Share on Twitter" target="_blank" rel="noopener">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </a>
        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode( get_permalink() ); ?>" class="share-btn" aria-label="Share on LinkedIn" target="_blank" rel="noopener">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
        </a>
        <a href="<?php echo esc_url( get_permalink() ); ?>" class="share-btn" aria-label="Copy link" onclick="navigator.clipboard.writeText(this.href);return false;">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
        </a>
      </div>
    </div>
  </div><!-- /.article-hero-inner -->

</div><!-- /.article-hero -->

<!-- ARTICLE BODY + SIDEBAR -->
<div class="article-wrap">

  <!-- MAIN CONTENT -->
  <article class="article-content">
    <?php the_content(); ?>

    <!-- Post tags -->
    <?php $tags = get_the_tags(); if ( $tags ) : ?>
    <div class="article-tags">
      <?php foreach ( $tags as $tag ) : ?>
        <a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>" class="article-tag"><?php echo esc_html( $tag->name ); ?></a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Author bio box -->
    <?php
    $bio      = get_the_author_meta( 'description' );
    $role     = get_user_meta( $author_id, 'nb_author_role', true );
    $twitter  = get_user_meta( $author_id, 'nb_twitter',     true );
    $linkedin = get_user_meta( $author_id, 'nb_linkedin',    true );
    ?>
    <div class="author-bio">
      <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" class="author-bio-photo">
        <?php echo get_avatar( $author_id, 160 ); ?>
      </a>
      <div class="author-bio-text">
        <div class="author-bio-name">
          <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><?php the_author(); ?></a>
        </div>
        <?php if ( $role ) : ?>
          <div class="author-bio-role"><?php echo esc_html( $role ); ?></div>
        <?php endif; ?>
        <?php if ( $bio ) : ?>
          <p><?php echo esc_html( $bio ); ?></p>
        <?php endif; ?>
        <div class="author-bio-links">
          <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" class="author-bio-link">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            <?php esc_html_e( 'All posts', 'numberbarn' ); ?>
          </a>
          <?php if ( $twitter ) : ?>
            <a href="<?php echo esc_url( $twitter ); ?>" class="author-bio-link" target="_blank" rel="noopener">Twitter / X</a>
          <?php endif; ?>
          <?php if ( $linkedin ) : ?>
            <a href="<?php echo esc_url( $linkedin ); ?>" class="author-bio-link" target="_blank" rel="noopener">LinkedIn</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </article>

  <!-- ARTICLE SIDEBAR -->
  <?php get_template_part( 'sidebar', 'article' ); ?>

</div><!-- /.article-wrap -->

<!-- RELATED POSTS -->
<?php
$related = new WP_Query( [
    'posts_per_page'      => 3,
    'category__in'        => wp_list_pluck( $cats, 'term_id' ),
    'post__not_in'        => [ get_the_ID() ],
    'orderby'             => 'rand',
    'ignore_sticky_posts' => true,
] );
if ( $related->have_posts() ) : ?>
<div class="related-section">
  <div class="related-inner">
    <div class="section-label"><?php esc_html_e( 'You Might Also Like', 'numberbarn' ); ?></div>
    <div class="related-grid">
      <?php while ( $related->have_posts() ) : $related->the_post();
          $r_cats    = get_the_category();
          $r_cat     = ! empty( $r_cats ) ? $r_cats[0] : null;
          $r_class   = $r_cat ? nb_cat_class( $r_cat->slug ) : 'cat-default';
          $r_thumb   = get_the_post_thumbnail_url( null, 'nb-card' );
          $r_read    = nb_read_time();
          $r_a_id    = get_the_author_meta( 'ID' );
      ?>
      <article class="post-card">
        <?php if ( $r_thumb ) : ?>
        <div class="post-card-thumb">
          <img src="<?php echo esc_url( $r_thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
        </div>
        <?php endif; ?>
        <div class="post-card-body">
          <?php if ( $r_cat ) : ?>
            <span class="cat-tag <?php echo esc_attr( $r_class ); ?>"><?php echo esc_html( $r_cat->name ); ?></span>
          <?php endif; ?>
          <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <div class="post-footer">
            <?php echo nb_author_chip( $r_a_id ); ?>
            <span class="read-time">⏱ <?php echo esc_html( $r_read ); ?> min</span>
          </div>
        </div>
      </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</div>
<?php endif; ?>

<?php endwhile; ?>

<!-- BACK TO TOP -->
<button class="back-to-top" id="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'numberbarn' ); ?>">
  <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</button>

<?php get_footer(); ?>
