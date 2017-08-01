<?php

add_action( 'admin_init', 'wpmc_admin_init' );

/**
 *
 * SETTINGS PAGE
 *
 */

function wpmc_settings_page() {
  global $wpmc_settings_api;
	echo '<div class="wrap">';
  jordy_meow_donation();
	echo "<div id='icon-options-general' class='icon32'><br></div><h2>Media Cleaner";
  by_jordy_meow();
  echo "</h2>";

  if ( !wpmc_is_pro() && wpmc_getoption( 'scan_files', 'wpmc_basics', false ) ) {
    _e( "<div class='error'><p>The Pro version is required to scan files. You can <a target='_blank' href='http://apps.meow.fr/media-cleaner'>get a serial for the Pro version here</a>.</p></div>", 'media-cleaner' );
  }

  $wpmc_settings_api->show_navigation();
  $wpmc_settings_api->show_forms();
  jordy_meow_footer();
  echo '</div>';
}

function wpmc_getoption( $option, $section, $default = '' ) {
	$options = get_option( $section );
	if ( isset( $options[$option] ) ) {
        if ( $options[$option] == "off" ) {
            return false;
        }
        if ( $options[$option] == "on" ) {
            return true;
        }
		return $options[$option];
    }
	return $default;
}

function wpmc_admin_init() {
  if ( isset( $_POST ) && isset( $_POST['wpmc_pro'] ) )
      wpmc_validate_pro( $_POST['wpmc_pro']['subscr_id'] );
  $pro_status = get_option( 'wpmc_pro_status', "Not Pro." );
  require( 'wpmc_class.settings-api.php' );
  global $wpmc_settings_api;
  $wpmc_settings_api = new WeDevs_Settings_API;
	$sections = array(
        array(
            'id' => 'wpmc_basics',
            'title' => __( 'Options', 'media-cleaner' )
        ),
        array(
            'id' => 'wpmc_pro',
            'title' => __( 'Serial Key (Pro)', 'media-cleaner' )
        )
    );

    global $shortcode_tags;
    try {
      $allshortcodes = array_diff( $shortcode_tags, array(  ) );
      $my_shortcodes = array();
      foreach ( $allshortcodes as $sc )
        if ( $sc != '__return_false' ) {
          if ( is_string( $sc ) )
            array_push( $my_shortcodes, str_replace( '_shortcode', '', (string)$sc ) );
        }
      $my_shortcodes = implode( ', ', $my_shortcodes );
    }
    catch (Exception $e) {
      $my_shortcodes = "";
    }
    $fields = array(
        'wpmc_basics' => array(
            array(
                'name' => 'scan_media',
                'label' => __( 'Scan Media', 'media-cleaner' ),
                'desc' => __( 'The Media Library will be scanned.<br /><small>The medias from Media Library which seem not being used in your WordPress will be marked as to be deleted.</small>', 'media-cleaner' ),
                'type' => 'checkbox',
                'default' => false
            ),
            array(
                'name' => 'scan_files',
                'label' => __( 'Scan Files (Pro)', 'media-cleaner' ),
                'desc' => __( 'The Uploads folder will be scanned.<br /><small>The files in your /uploads folder that don\'t seem being used in your WordPress will be marked as to be deleted. <br /><b style="color: red">If the files are registered as a media in your Media Library, they will be considered as fine (even if they are not used in the content of your website). The Scan Media will check for their actual usage.</b></small>', 'media-cleaner' ),
                'type' => 'checkbox',
                'default' => false
            ),
            array(
                'name' => 'shortcode',
                'label' => __( 'Resolve Shortcode', 'media-cleaner' ),
                'desc' => sprintf( __( 'The shortcodes you are using in your posts and widgets will be resolved and checked.<br /><small>This process takes more resources. If the scanning suddenly stops, this might be the cause. Here is the list of the shortcodes enabled on your WordPress that you might be using: <b>%s</b>. Please note that the gallery shortcode is checked by the normal process. You don\'t need to have this option enabled for the WP gallery.</small>', 'media-cleaner' ), $my_shortcodes ),
                'type' => 'checkbox',
                'default' => false
            ),
            array(
                'name' => 'scan_non_ascii',
                'label' => __( 'UTF-8 Support', 'media-cleaner' ),
                'desc' => __( 'The filenames in UTF-8 will not be skipped.<br /><small>PHP does not always work well with UTF-8 on all systems (Windows?). If the scanning suddenly stops, this might be the cause.</small>', 'media-cleaner' ),
                'type' => 'checkbox',
                'default' => false
            ),
            array(
                'name' => 'hide_thumbnails',
                'label' => __( 'Hide Thumbnails', 'media-cleaner' ),
                'desc' => __( 'Hide the thumbnails column.<br /><small>Useful if your WordPress if filled-up with huge images.</small>', 'media-cleaner' ),
                'type' => 'checkbox',
                'default' => false
            ),
            array(
                'name' => 'hide_warning',
                'label' => __( 'Hide Warning', 'media-cleaner' ),
                'desc' => __( 'Hide the long but important warning displayed in the dashboard.<br /><small>Please make sure you read it a few times ;)</small>', 'media-cleaner' ),
                'type' => 'checkbox',
                'default' => false
            ),
            array(
                'name' => 'hide_ads',
                'label' => __( 'Hide Ads & Info', 'media-cleaner' ),
                'desc' => __( 'Hide the ads, the Flattr button and the information about the Pro.', 'media-cleaner' ),
                'type' => 'checkbox',
                'default' => false
            ),
        ),
        'wpmc_pro' => array(
            array(
                'name' => 'pro',
                'label' => '',
                'desc' => sprintf( __( "Status: %s", 'media-cleaner' ), $pro_status ),
                'type' => 'html'
            ),
            array(
                'name' => 'subscr_id',
                'label' => __( 'Serial', 'media-cleaner' ),
                'desc' => __( '<br />Enter your serial or subscription ID here. If you don\'t have one yet, get one <a target="_blank" href="http://apps.meow.fr/media-cleaner/">right here</a>.', 'media-cleaner' ),
                'type' => 'text',
                'default' => ""
            ),
        )
    );
    $wpmc_settings_api->set_sections( $sections );
    $wpmc_settings_api->set_fields( $fields );
    $wpmc_settings_api->admin_init();

}

?>
