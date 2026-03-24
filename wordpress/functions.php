<?php
/**
 * NumberBarn Blog — Theme Functions
 */

// ── THEME SETUP ────────────────────────────────────────────────
add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
    add_theme_support( 'custom-logo', [
        'height'      => 86,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    // Custom image sizes
    add_image_size( 'nb-hero',    1200, 750, true );
    add_image_size( 'nb-card',    800,  450, true );
    add_image_size( 'nb-wide',    900,  500, true );

    // Navigation menus
    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'numberbarn' ),
        'footer'  => __( 'Footer Navigation', 'numberbarn' ),
    ] );
} );

// ── ENQUEUE STYLES & SCRIPTS ───────────────────────────────────
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'numberbarn-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'numberbarn-style',
        get_stylesheet_uri(),
        [ 'numberbarn-fonts' ],
        wp_get_theme()->get( 'Version' )
    );
    wp_enqueue_script(
        'numberbarn-script',
        get_template_directory_uri() . '/assets/js/theme.js',
        [],
        wp_get_theme()->get( 'Version' ),
        true
    );
} );

// ── REGISTER WIDGET AREAS ──────────────────────────────────────
add_action( 'widgets_init', function () {
    $shared = [
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="widget-head">',
        'after_title'   => '</div><div class="widget-body">',
    ];

    register_sidebar( array_merge( $shared, [
        'name'          => __( 'Blog Sidebar', 'numberbarn' ),
        'id'            => 'sidebar-blog',
        'description'   => __( 'Widgets shown on the blog index and archive pages.', 'numberbarn' ),
    ] ) );

    register_sidebar( array_merge( $shared, [
        'name'          => __( 'Article Sidebar', 'numberbarn' ),
        'id'            => 'sidebar-article',
        'description'   => __( 'Widgets shown on single post pages.', 'numberbarn' ),
    ] ) );

    register_sidebar( array_merge( $shared, [
        'name'          => __( 'Author Sidebar', 'numberbarn' ),
        'id'            => 'sidebar-author',
        'description'   => __( 'Widgets shown on author archive pages.', 'numberbarn' ),
    ] ) );
} );

// ── CUSTOMIZER SETTINGS ────────────────────────────────────────
add_action( 'customize_register', function ( $wp_customize ) {

    // Section: Top Bar
    $wp_customize->add_section( 'nb_topbar', [
        'title'    => __( 'Top Bar', 'numberbarn' ),
        'priority' => 30,
    ] );
    foreach ( [
        'nb_topbar_text'      => [ 'label' => 'Top bar text',      'default' => 'New to NumberBarn?' ],
        'nb_topbar_link_text' => [ 'label' => 'Top bar link text', 'default' => 'Get your perfect number today →' ],
        'nb_topbar_link_url'  => [ 'label' => 'Top bar link URL',  'default' => 'https://www.numberbarn.com' ],
    ] as $id => $args ) {
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $id, [ 'label' => $args['label'], 'section' => 'nb_topbar', 'type' => 'text' ] );
    }

    // Section: Nav CTA Button
    $wp_customize->add_section( 'nb_nav_cta', [
        'title'    => __( 'Nav CTA Button', 'numberbarn' ),
        'priority' => 31,
    ] );
    foreach ( [
        'nb_nav_cta_text' => [ 'label' => 'Button text', 'default' => 'Get a Number' ],
        'nb_nav_cta_url'  => [ 'label' => 'Button URL',  'default' => 'https://www.numberbarn.com' ],
    ] as $id => $args ) {
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $id, [ 'label' => $args['label'], 'section' => 'nb_nav_cta', 'type' => 'text' ] );
    }

    // Section: CTA Banner (bottom of pages)
    $wp_customize->add_section( 'nb_banner', [
        'title'    => __( 'CTA Banner', 'numberbarn' ),
        'priority' => 32,
    ] );
    foreach ( [
        'nb_banner_title'    => [ 'label' => 'Headline',    'default' => 'Find Your Perfect Phone Number Today' ],
        'nb_banner_text'     => [ 'label' => 'Subtext',     'default' => 'Search millions of available numbers — local, toll-free, and vanity — starting at just $2/month.' ],
        'nb_banner_btn_text' => [ 'label' => 'Button text', 'default' => 'Search Numbers' ],
        'nb_banner_btn_url'  => [ 'label' => 'Button URL',  'default' => 'https://www.numberbarn.com' ],
    ] as $id => $args ) {
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $id, [ 'label' => $args['label'], 'section' => 'nb_banner', 'type' => 'text' ] );
    }

    // Section: Footer
    $wp_customize->add_section( 'nb_footer', [
        'title'    => __( 'Footer', 'numberbarn' ),
        'priority' => 33,
    ] );
    $wp_customize->add_setting( 'nb_footer_desc', [
        'default'           => 'The smarter way to find, park, and manage phone numbers. Trusted by thousands of businesses and entrepreneurs across the US.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ] );
    $wp_customize->add_control( 'nb_footer_desc', [
        'label'   => __( 'Footer brand description', 'numberbarn' ),
        'section' => 'nb_footer',
        'type'    => 'textarea',
    ] );

    // Section: Homepage Hero
    $wp_customize->add_section( 'nb_hero', [
        'title'    => __( 'Homepage Hero', 'numberbarn' ),
        'priority' => 29,
    ] );
    $wp_customize->add_setting( 'nb_hero_tag', [
        'default'           => 'Featured',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'nb_hero_tag', [
        'label'   => __( 'Hero tag label', 'numberbarn' ),
        'section' => 'nb_hero',
        'type'    => 'text',
    ] );
} );

// ── AUTHOR CUSTOM FIELDS ───────────────────────────────────────
// Adds "Role", "Twitter", and "LinkedIn" to user profiles
add_action( 'show_user_profile',        'nb_extra_user_fields' );
add_action( 'edit_user_profile',        'nb_extra_user_fields' );
add_action( 'personal_options_update',  'nb_save_extra_user_fields' );
add_action( 'edit_user_profile_update', 'nb_save_extra_user_fields' );

function nb_extra_user_fields( $user ) { ?>
    <h3><?php esc_html_e( 'NumberBarn Author Info', 'numberbarn' ); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="nb_author_role"><?php esc_html_e( 'Author Role / Title', 'numberbarn' ); ?></label></th>
            <td><input type="text" name="nb_author_role" id="nb_author_role" value="<?php echo esc_attr( get_user_meta( $user->ID, 'nb_author_role', true ) ); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="nb_twitter"><?php esc_html_e( 'Twitter / X URL', 'numberbarn' ); ?></label></th>
            <td><input type="url" name="nb_twitter" id="nb_twitter" value="<?php echo esc_attr( get_user_meta( $user->ID, 'nb_twitter', true ) ); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="nb_linkedin"><?php esc_html_e( 'LinkedIn URL', 'numberbarn' ); ?></label></th>
            <td><input type="url" name="nb_linkedin" id="nb_linkedin" value="<?php echo esc_attr( get_user_meta( $user->ID, 'nb_linkedin', true ) ); ?>" class="regular-text" /></td>
        </tr>
    </table>
<?php }

function nb_save_extra_user_fields( $user_id ) {
    if ( ! current_user_can( 'edit_user', $user_id ) ) return;
    foreach ( [ 'nb_author_role', 'nb_twitter', 'nb_linkedin' ] as $key ) {
        if ( isset( $_POST[ $key ] ) ) {
            update_user_meta( $user_id, $key, sanitize_text_field( $_POST[ $key ] ) );
        }
    }
}

// ── HELPER: CATEGORY CSS CLASS ─────────────────────────────────
function nb_cat_class( $slug ) {
    $map = [
        'general'            => 'cat-general',
        'number-tips'        => 'cat-general',
        'ask-the-pig'        => 'cat-askpig',
        'by-the-numbers'     => 'cat-bynumbers',
        'featured-customers' => 'cat-featured',
        'toll-free'          => 'cat-tollfree',
        'voip-tech'          => 'cat-voip',
        'voip'               => 'cat-voip',
        'business'           => 'cat-business',
        'guides'             => 'cat-guides',
        'news'               => 'cat-news',
    ];
    return $map[ $slug ] ?? 'cat-default';
}

// ── HELPER: FIRST CATEGORY TAG ─────────────────────────────────
function nb_first_cat_tag( $post_id = null ) {
    $cats = get_the_category( $post_id );
    if ( empty( $cats ) ) return '';
    $cat   = $cats[0];
    $class = nb_cat_class( $cat->slug );
    return sprintf(
        '<span class="cat-tag %s">%s</span>',
        esc_attr( $class ),
        esc_html( $cat->name )
    );
}

// ── HELPER: ESTIMATED READ TIME ────────────────────────────────
function nb_read_time( $post_id = null ) {
    $post  = get_post( $post_id );
    if ( ! $post ) return 1;
    $words = str_word_count( wp_strip_all_tags( $post->post_content ) );
    return max( 1, (int) ceil( $words / 200 ) );
}

// ── HELPER: AUTHOR AVATAR + CHIP ──────────────────────────────
function nb_author_chip( $author_id = null ) {
    if ( ! $author_id ) $author_id = get_the_author_meta( 'ID' );
    $name   = get_the_author_meta( 'display_name', $author_id );
    $avatar = get_avatar( $author_id, 56, '', $name, [ 'class' => '' ] );
    $url    = get_author_posts_url( $author_id );
    ob_start(); ?>
    <div class="author-chip">
        <a href="<?php echo esc_url( $url ); ?>" class="author-av"><?php echo $avatar; ?></a>
        <div>
            <div class="author-name"><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $name ); ?></a></div>
            <div class="post-date"><?php echo get_the_date( 'M j, Y' ); ?></div>
        </div>
    </div>
    <?php return ob_get_clean();
}

// ── HELPER: CTA BANNER ────────────────────────────────────────
function nb_cta_banner() {
    $title    = get_theme_mod( 'nb_banner_title',    'Find Your Perfect Phone Number Today' );
    $text     = get_theme_mod( 'nb_banner_text',     'Search millions of available numbers — local, toll-free, and vanity — starting at just $2/month.' );
    $btn_text = get_theme_mod( 'nb_banner_btn_text', 'Search Numbers' );
    $btn_url  = get_theme_mod( 'nb_banner_btn_url',  'https://www.numberbarn.com' );
    ?>
    <section class="banner-cta">
        <h2><?php echo esc_html( $title ); ?></h2>
        <p><?php echo esc_html( $text ); ?></p>
        <a href="<?php echo esc_url( $btn_url ); ?>" class="banner-btn">
            <?php echo esc_html( $btn_text ); ?>
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </section>
    <?php
}

// ── DOCUMENT TITLE ────────────────────────────────────────────
add_filter( 'document_title_separator', fn() => '–' );
