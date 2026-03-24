  <!-- CTA BANNER -->
  <?php nb_cta_banner(); ?>

  <!-- FOOTER -->
  <footer>
    <div class="footer-inner">
      <div class="footer-top">

        <div class="footer-brand">
          <div class="footer-logo">
            <?php if ( has_custom_logo() ) :
                the_custom_logo();
            else : ?>
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo-dark.png" alt="<?php bloginfo( 'name' ); ?>" />
            <?php endif; ?>
          </div>
          <p><?php echo esc_html( get_theme_mod( 'nb_footer_desc', 'The smarter way to find, park, and manage phone numbers. Trusted by thousands of businesses and entrepreneurs across the US.' ) ); ?></p>
        </div>

        <div class="footer-col">
          <h4><?php esc_html_e( 'Blog', 'numberbarn' ); ?></h4>
          <ul>
            <?php
            $cats = get_categories( [ 'orderby' => 'name', 'number' => 6 ] );
            foreach ( $cats as $cat ) {
                echo '<li><a href="' . esc_url( get_category_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
            }
            ?>
          </ul>
        </div>

        <div class="footer-col">
          <h4><?php esc_html_e( 'Company', 'numberbarn' ); ?></h4>
          <ul>
            <li><a href="https://www.numberbarn.com"><?php esc_html_e( 'About Us', 'numberbarn' ); ?></a></li>
            <li><a href="#"><?php esc_html_e( 'Careers', 'numberbarn' ); ?></a></li>
            <li><a href="#"><?php esc_html_e( 'Press', 'numberbarn' ); ?></a></li>
            <li><a href="#"><?php esc_html_e( 'Contact', 'numberbarn' ); ?></a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4><?php esc_html_e( 'Support', 'numberbarn' ); ?></h4>
          <ul>
            <li><a href="#"><?php esc_html_e( 'Help Center', 'numberbarn' ); ?></a></li>
            <li><a href="#"><?php esc_html_e( 'Porting FAQ', 'numberbarn' ); ?></a></li>
            <li><a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Privacy Policy', 'numberbarn' ); ?></a></li>
            <li><a href="#"><?php esc_html_e( 'Terms of Service', 'numberbarn' ); ?></a></li>
          </ul>
        </div>

      </div>

      <div class="footer-bottom">
        <span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'numberbarn' ); ?></span>
        <div>
          <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Privacy', 'numberbarn' ); ?></a>
          <a href="#"><?php esc_html_e( 'Terms', 'numberbarn' ); ?></a>
          <a href="<?php echo esc_url( get_bloginfo( 'url' ) ); ?>/sitemap.xml"><?php esc_html_e( 'Sitemap', 'numberbarn' ); ?></a>
        </div>
      </div>
    </div>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>
