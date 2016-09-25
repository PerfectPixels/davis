<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$registration = false;
$popup_style = get_theme_mod('login_style', 'left_img');
$form_container_classes = 'col-sm-12';

if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : 
	$registration = true;
endif; 

if ( 'yes' === get_option( 'woocommerce_registration_generate_username' ) ) :
	$form_container_classes .= 'no-reg-username';
endif; 

if ($popup_style == 'left_img') : 
	$form_container_classes .= ' col-md-7'; 
else : 
	$form_container_classes .= ' col-md-12';
endif;

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ($popup_style == 'left_img') : ?>

	<div class="col-md-5">	
		<div class="login-panel toggle-view">
			<div class="content">	
				<h2><?php echo get_theme_mod('login_title', 'Hi There!'); ?></h2>
				<h6><?php echo get_theme_mod('login_subtitle', 'If you don’t have an account yet, you can join us by clicking on the button below.'); ?></h6>
				<?php if ( $registration ){ ?><a class="toggle-btn button" data-switch="div.account-panel" data-target="#registration"><?php echo get_theme_mod('login_btn', 'Create an account'); ?></a><?php } ?>
			</div>
		</div>
		<?php if ( $registration ){ ?>
			<div class="account-panel toggle-view hide">
				<div class="content">
					<h2><?php echo get_theme_mod('registration_title', 'Welcome back!' ); ?></h2>
					<h6><?php echo get_theme_mod('registration_subtitle', 'If you already have an account, you can sign in again by clicking on the button below.'); ?></h6>
					<a class="toggle-btn button" data-switch="div.login-panel" data-target="#login"><?php echo get_theme_mod('registration_btn', 'Login now'); ?></a>
				</div>
			</div>
		<?php } ?>
	</div>
	
<?php else : ?>
	
	<ul id="login-tabs">
		<li><a class="toggle-btn active" data-target="#login"><?php _e('Login', 'david'); ?></a></li>
		<?php if ( $registration ){ ?><li><a class="toggle-btn" data-target="#registration"><?php _e('Register', 'davis'); ?></a></li><?php } ?>
	</ul>

<?php endif; ?>

<div class="<?php echo $form_container_classes; ?>">
	<div class="wrap-form">
		<form id="login" class="form login" action="ajaxlogin" method="post">
			<div class="content">
		        <h2><?php _e( 'Login', 'davis' ); ?></h2>
		        
		        <?php do_action( 'woocommerce_login_form_start' ); ?>
		        
		        <label for="username">
					<input type="text" id="username" class="email" tabindex="1" autocapitalize="off" autocorrect="off" required="required" placeholder="<?php _e( 'Username or Email Address*', 'davis' ); ?>" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>">
				</label>
		        <label for="password">
					<input type="password" id="password" class="password" tabindex="2" autocapitalize="off" autocorrect="off" required="required" placeholder="<?php _e( 'Password*', 'davis' ); ?>">
				</label>
	
				<?php do_action( 'woocommerce_login_form' ); ?>
				
				<input name="rememberme" type="checkbox" id="rememberme" class="remember" tabindex="3" value="true" /> 
				<label for="rememberme" class="rememberme"><?php _e( 'Remember me', 'davis' ); ?></label>
				<button name="login" type="submit" tabindex="4" data-message="<?php _e( 'Please wait', 'davis' ); ?>" class="button black submit"><?php _e( 'Login', 'davis' ); ?></button>
		        <a class="lost toggle-btn" data-target="#password"><?php _e( 'Lost your password?', 'davis' ); ?></a>
					
		        	<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
					<?php wp_nonce_field( 'woocommerce-login' ); ?>
	
				<?php do_action( 'woocommerce_login_form_end' ); ?>
			</div>
	    </form>
	    
	    <form id="password" class="hide form" action="lost_pass" method="post">
	    	<div class="content">
		        <h2><?php _e( 'Lost you password?', 'davis' ); ?></h2>
		        <h6><?php _e( 'Please enter your username or email address. You will receive a link to create a new password via email.', 'davis' ); ?></h6>
		        <label for="login-email">
					<input type="email" id="lost-email" class="email" tabindex="1" autocapitalize="off" autocorrect="off" required="required" placeholder="<?php _e( 'Username or Email Address*', 'davis' ); ?>">
				</label>
				<button type="submit" tabindex="2" data-message="<?php _e( 'Sending email', 'davis' ); ?>" class="button black submit"><?php _e( 'Reset Password', 'davis' ); ?></button>
				<a class="lost toggle-btn" data-target="#login"><?php _e( 'Cancel', 'davis' ); ?></a>
		        <?php wp_nonce_field( 'ajax-forgot-nonce', 'security' ); ?>
	    	</div>
	    </form>
	    
	    <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
	    
		    <form id="registration" class="hide form register" action="ajaxregistration" method="post">
		    	<div class="content">
			        <h2><?php _e( 'Registration', 'davis' ); ?></h2>
			        
			        <?php do_action( 'woocommerce_register_form_start' ); ?>
			        
			        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
				       	<label for="reg_username">
							<input type="text" id="reg_username" class="username" tabindex="1" autocapitalize="off" autocorrect="off" required="required" placeholder="<?php _e( 'Username*', 'davis' ); ?>">
						</label>
					<?php endif; ?>
					
					<label for="reg_email">
						<input type="email" id="reg_email" class="email" tabindex="1" autocapitalize="off" autocorrect="off" required="required" placeholder="<?php _e( 'Email Address*', 'davis' ); ?>">
					</label>
					
					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
				        <label for="reg_password">
							<input type="password" id="reg_password" class="password" tabindex="2" autocapitalize="off" autocorrect="off" required="required" placeholder="<?php _e( 'Password*', 'davis' ); ?>">
						</label>
					<?php endif; ?>
					
					<!-- Spam Trap -->
					<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>
					
					<?php do_action( 'woocommerce_register_form' ); ?>
					<?php do_action( 'register_form' ); ?>
									
					<button name="register" type="submit" tabindex="3" data-message="<?php _e( 'Registering', 'davis' ); ?>" class="button black submit"><?php _e( 'Register', 'davis' ); ?></button>
					<input type="submit" name="register" tabindex="3" data-message="<?php _e( 'Registering', 'davis' ); ?>" class="button black submit" value="<?php _e( 'Register', 'davis' ); ?>">
					<spam class="lost"></span>
					
			        <?php wp_nonce_field( 'ajax-registration-nonce', 'security' ); ?>
					<?php wp_nonce_field( 'woocommerce-register' ); ?>
			        <input type="hidden" class="rememnber" tabindex="3" value="false">
	
					<?php do_action( 'woocommerce_register_form_end' ); ?>
				</div>
		    </form>
		   
		<?php endif; ?>	
	</div>
	<?php if ( class_exists( 'WC_Social_Login' ) ) { ?>
		<?php echo do_shortcode('[woocommerce_social_login_buttons return_url="'. $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] .'"]'); ?>
		<small><?php _e('We would never post anything without your permission.', 'davis' ); ?></small>
	<?php } ?>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
