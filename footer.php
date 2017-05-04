<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Davis
 */

$sidebar = (get_theme_mod('shop_sidebar', 'no') === 'no') ? false : get_theme_mod('shop_sidebar', 'no');

?>

        </main>

        <?php if (display_sidebar() && $sidebar) : ?>
            <?php get_sidebar(); ?>
        <?php endif; ?>

    </div>

    <?php if ( !is_quick_checkout() ){

	    pp_can_display( 'sidebar_footer' ); ?>

        <footer id="footer">

            <?php if (  get_theme_mod('footer_sidebar_bottom', true) == true ){ ?>
                <aside class="bottom-widgets">
                    <div class="container">
                        <?php dynamic_sidebar('sidebar-footer-bottom'); ?>
                    </div>
                </aside>
            <?php } ?>

            <div class="container-fluid footer_bottom">
                <div class="container">
                    <div class="col-md-4 footer_copyrights">
                        <p><?php echo get_theme_mod('copyright_text', '© 2016 Perfect Pixels. All Rights Reserved.'); ?></p>
                    </div>
                    <div class="col-md-8 footer_nav">
                        <?php if ( get_theme_mod('footer_social', false) == true ) { ?>
                            <ul id="footer-social">
                                <?php get_template_part( 'template-parts/header/elements/social-media' ); ?>
                            </ul>
                        <?php } ?>

                        <?php if ( has_nav_menu('footer_navigation') ) {
                            wp_nav_menu(['theme_location' => 'footer_navigation']);
                        } ?>
                    </div>
                </div>

            </div>
        </footer>

        <div class="modal fade" id="message-modal" tabindex="-1" role="dialog" aria-labelledby="message-modal">
            <div class="modal-dialog container" role="document">
                <div class="content"></div>
                <a class="button" data-dismiss="modal">OK</a>
            </div>
        </div>

        <div class="nav-overlay"></div>

        <?php wc_get_template_part( 'template-parts/login-modal' ); ?>

    <?php } ?>

    <?php wp_footer(); ?>

    </body>
</html>
