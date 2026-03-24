<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- TOP BAR -->
<div class="topbar">
    <?php echo esc_html( get_theme_mod( 'nb_topbar_text', 'New to NumberBarn?' ) ); ?>
    <a href="<?php echo esc_url( get_theme_mod( 'nb_topbar_link_url', 'https://www.numberbarn.com' ) ); ?>">
        <?php echo esc_html( get_theme_mod( 'nb_topbar_link_text', 'Get your perfect number today →' ) ); ?>
    </a>
</div>

<!-- NAVIGATION -->
<header>
    <nav>
        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
            <?php if ( has_custom_logo() ) :
                the_custom_logo();
            else : ?>
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo-light.png" alt="<?php bloginfo( 'name' ); ?>" />
            <?php endif; ?>
        </a>

        <!-- Desktop nav links -->
        <?php
        wp_nav_menu( [
            'theme_location' => 'primary',
            'container'      => false,
            'items_wrap'     => '<ul class="nav-links">%3$s</ul>',
            'fallback_cb'    => 'nb_default_nav',
        ] );
        ?>

        <!-- Right actions -->
        <div class="nav-actions">
            <!-- Search -->
            <form class="nav-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" id="nav-search-form">
                <input type="search" name="s" value="<?php echo get_search_query(); ?>" aria-label="<?php esc_attr_e( 'Search', 'numberbarn' ); ?>" placeholder="<?php esc_attr_e( 'Search…', 'numberbarn' ); ?>" />
                <button type="button" id="nav-search-toggle" aria-label="<?php esc_attr_e( 'Toggle search', 'numberbarn' ); ?>">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>
                </button>
            </form>

            <!-- Hamburger (mobile only) -->
            <button class="nav-hamburger" id="nav-hamburger" aria-label="<?php esc_attr_e( 'Open menu', 'numberbarn' ); ?>" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>
</header>

<!-- MOBILE DRAWER -->
<div class="mobile-menu" id="mobile-menu" aria-hidden="true">
    <?php
    wp_nav_menu( [
        'theme_location' => 'primary',
        'container'      => false,
        'items_wrap'     => '<ul>%3$s</ul>',
        'fallback_cb'    => 'nb_mobile_nav',
    ] );
    ?>
    <div class="mobile-menu-footer">
        &copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>
    </div>
</div>

<?php
function nb_default_nav() {
    $cta_text = get_theme_mod( 'nb_nav_cta_text', 'Get a Number' );
    $cta_url  = get_theme_mod( 'nb_nav_cta_url',  'https://www.numberbarn.com' );
    $cats     = get_categories( [ 'orderby' => 'count', 'order' => 'DESC', 'number' => 6 ] );
    echo '<ul class="nav-links">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '" class="' . ( is_home() ? 'active' : '' ) . '">All Posts</a></li>';
    foreach ( $cats as $cat ) {
        echo '<li><a href="' . esc_url( get_category_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
    }
    echo '<li><a href="' . esc_url( $cta_url ) . '" class="nav-cta">' . esc_html( $cta_text ) . '</a></li>';
    echo '</ul>';
}

function nb_mobile_nav() {
    $cta_text = get_theme_mod( 'nb_nav_cta_text', 'Get a Number' );
    $cta_url  = get_theme_mod( 'nb_nav_cta_url',  'https://www.numberbarn.com' );
    $cats     = get_categories( [ 'orderby' => 'count', 'order' => 'DESC', 'number' => 6 ] );
    echo '<ul>';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">All Posts</a></li>';
    foreach ( $cats as $cat ) {
        echo '<li><a href="' . esc_url( get_category_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
    }
    echo '<li><a href="' . esc_url( $cta_url ) . '" class="nav-cta">' . esc_html( $cta_text ) . '</a></li>';
    echo '</ul>';
}
