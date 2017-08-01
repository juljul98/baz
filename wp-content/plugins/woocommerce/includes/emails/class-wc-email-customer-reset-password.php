<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WC_Email_Customer_Reset_Password' ) ) :

/**
 * Customer Reset Password.
 *
 * An email sent to the customer when they reset their password.
 *
 * @class       WC_Email_Customer_Reset_Password
 * @version     2.3.0
 * @package     WooCommerce/Classes/Emails
 * @author      WooThemes
 * @extends     WC_Email
 */
class WC_Email_Customer_Reset_Password extends WC_Email {

	/**
	 * User login name.
	 *
	 * @var string
	 */
	public $user_login;

	/**
	 * User email.
	 *
	 * @var string
	 */
	public $user_email;

	/**
	 * Reset key.
	 *
	 * @var string
	 */
	public $reset_key;

	/**
	 * Constructor.
	 */
	function __construct() {

		$this->id               = 'customer_reset_password';
		$this->title            = __( 'Reset password', 'woocommerce' );
		$this->description      = __( 'Customer "reset password" emails are sent when customers reset their passwords.', 'woocommerce' );
		$this->customer_email   = true;

		$this->template_html    = 'emails/customer-reset-password.php';
		$this->template_plain   = 'emails/plain/customer-reset-password.php';

		$this->subject          = __( 'Password Reset for {site_title}', 'woocommerce');
		$this->heading          = __( 'Password Reset Instructions', 'woocommerce');

		// Trigger
		add_action( 'woocommerce_reset_password_notification', array( $this, 'trigger' ), 10, 2 );

		// Call parent constructor
		parent::__construct();
	}

	/**
	 * Trigger.
	 *
	 * @param string $user_login
	 * @param string $reset_key
	 */
	function trigger( $user_login = '', $reset_key = '' ) {
		if ( $user_login && $reset_key ) {
			$this->object     = get_user_by( 'login', $user_login );

			$this->user_login = $user_login;
			$this->reset_key  = $reset_key;
			$this->user_email = stripslashes( $this->object->user_email );
			$this->recipient  = $this->user_email;
		}

		if ( ! $this->is_enabled() || ! $this->get_recipient() ) {
			return;
		}

		$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );

		$to_mail = $this->get_recipient();
        $headers= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: admin@taffen.korinteraktiv.com\r\n";

        // $message = sprintf(__('Password Lost and Changed for user: %s'), $user->user_login . ' ' . $user->user_email) . "\r\n";
        $message = $this->get_content()."\r\n";
        // The blogname option is escaped with esc_html on the way into the database in sanitize_option
        // we want to reverse this for the plain text arena of emails.
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        // wp_mail(get_option('admin_email'), sprintf(__('[%s] Password Lost/Changed'), $blogname), $message); 
        mail($to_mail, sprintf(__('[%s] Password Lost/Changed'), $blogname), $message, $headers);

	}

	/**
	 * Get content html.
	 *
	 * @access public
	 * @return string
	 */
	function get_content_html() {
		return wc_get_template_html( $this->template_html, array(
			'email_heading' => $this->get_heading(),
			'user_login'    => $this->user_login,
			'reset_key'     => $this->reset_key,
			'blogname'      => $this->get_blogname(),
			'sent_to_admin' => false,
			'plain_text'    => false,
			'email'			=> $this
		) );
	}

	/**
	 * Get content plain.
	 *
	 * @access public
	 * @return string
	 */
	function get_content_plain() {
		return wc_get_template_html( $this->template_plain, array(
			'email_heading' => $this->get_heading(),
			'user_login'    => $this->user_login,
			'reset_key'     => $this->reset_key,
			'blogname'      => $this->get_blogname(),
			'sent_to_admin' => false,
			'plain_text'    => true,
			'email'			=> $this
		) );
	}
}

endif;

return new WC_Email_Customer_Reset_Password();
