<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
add_action('wp_footer', 'add_script');

function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style',
	        get_stylesheet_directory_uri() . '/style.css',
	        array( 'parent_style' )
	    );
}

function add_script(){
	wp_enqueue_script( 'my-script', 
       get_stylesheet_directory_uri() . '/jscript/my-script.js', 
       array( 'jquery' ), 
       '0.1', 
       true);
}

function copy_widget(){
    if ( function_exists('register_sidebar') )
      register_sidebar(array(
        'name' => __('Footer Payment', 'virtue'),
        'id' => 'footer_copy_02',
        'before_widget' => '<div class="footer-widget"><aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
      )
    );

    if ( function_exists('register_sidebar') )
      register_sidebar(array(
        'name' => __('Footer Partners', 'virtue'),
        'id' => 'footer_copy_01',
        'before_widget' => '<div class="footer-widget"><aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
      )
    );
}

copy_widget();

// Add a confirm password field on the register form under My Accounts.
add_filter('woocommerce_registration_errors', 'registration_errors_validation', 10,3);
function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
	global $woocommerce;
	extract( $_POST );

	if ( strcmp( $password, $password2 ) !== 0 ) {
		return new WP_Error( 'registration-error', __( 'Passwords do not match.', 'woocommerce' ) );
	}
	return $reg_errors;
}

add_action( 'woocommerce_register_form', 'wc_register_form_password_repeat' );
function wc_register_form_password_repeat() {
	?>
	<p class="form-row form-row-wide">
		<label for="reg_password2"><?php _e( 'Confirm Password', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
	</p>
	<?php
}

add_action( 'woocommerce_edit_account_form', 'my_woocommerce_edit_account_form' );
add_action( 'woocommerce_save_account_details', 'my_woocommerce_save_account_details' );
 
function my_woocommerce_edit_account_form() {
 
  $user_id = get_current_user_id();
  $user = get_userdata( $user_id );
 
  if ( !$user )
    return;
 
  $display_name = $user->display_name;
 
  ?>
 
  <fieldset>
    <p class="form-row form-row-thirds">
      <label for="display_name">Display Name:</label>
      <input type="text" name="display_name" value="<?php echo esc_attr( $display_name ); ?>" class="input-text" />
    </p>
  </fieldset>
 
  <?php
 
}
 
function my_woocommerce_save_account_details( $user_id ) {
 
  $user = wp_update_user( array( 'ID' => $user_id, 'display_name' => $_POST[ 'display_name' ] ) );
 
}

// Fix wp_password_change_notification
add_action( 'password_reset', 'password_change_notification_admin',10,2);

function password_change_notification_admin( $user, $key ) {
    // send a copy of password change notification to the admin
    // but check to see if it's the admin whose password we're changing, and skip this
    if ( 0 !== strcasecmp( $user->user_email, get_option( 'admin_email' ) ) ) {

        $admin_mail = 'webmaster@taffenPH.com';
        $headers= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: $blogname <$admin_mail>\r\n";

        $message = sprintf(__('Password Lost and Changed for user: %s'), $user->user_login . ' ' . $user->user_email) . "\r\n";
        // The blogname option is escaped with esc_html on the way into the database in sanitize_option
        // we want to reverse this for the plain text arena of emails.
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        // wp_mail(get_option('admin_email'), sprintf(__('[%s] Password Lost/Changed'), $blogname), $message); 
        mail($admin_mail, sprintf(__('[%s] Password Lost/Changed'), $blogname), $message, $headers);
    }
}

?>