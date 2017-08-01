<?php
/**
 * Plugin Name: PureHTML
 * Version: 2.0.1
 * Description: Allows HTML in the HTML window without it being stripped in the visual editor.  Allows the insertion of pre-saved html
 * Author: Hit Reach
 * Author URI: http://www.hitreach.co.uk/
 * Plugin URI: http://www.hitreach.co.uk/wordpress-plugins/pure-html/
 */
define("PUREHTMLVERSION","2.0.0");
if (!class_exists('PureHTML')) {
	class PureHTML{	
		static $dbVersion = '2.0.0';
		static $option_name = 'pureHTML_options';
		static $default_404 = '<span style="font-weight:bold; color:red">Error 404: Function Not Found</span>';
		static $table_name = 'pureHTML_functions';
		
		function __construct(){
			add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
			add_shortcode( 'pureHTML', array( __CLASS__, 'shortcode_handler' ) );
			add_shortcode( 'purehtml', array( __CLASS__, 'shortcode_handler' ) );
			add_shortcode( 'PUREHTML', array( __CLASS__, 'shortcode_handler' ) );
		}

		function get_option(){
			$defaults = array(
				"show404" => 0,
				"fourohfourmsg" => 0,
				"database_version" => 0,
				"complete_uninstall"=> 0
			);
			$options = get_option( self::$option_name, $defaults );
			return $options;
		}
		
		function update_option($opt){
			return update_option( self::$option_name, $opt );
		}

		function activation_hook(){
			global $wpdb;
			$option = self::get_option();
			if( $option["database_version"] != self::$dbVersion ){
				$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."pureHTML_functions(
				id int NOT NULL AUTO_INCREMENT,
				name varchar(100) NOT NULL,
				function text NOT NULL,
				PRIMARY KEY(id)
				);";
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($sql);
			}
			$option["database_version"] = self::$dbVersion;
			self::update_option( $option );
		}

		function deactivation_hook(){
			global $wpdb;
			$option = self::get_option();
			if( $option["complete_uninstall"] == 1 ){
				$wpdb->get_results("DROP TABLE ".$wpdb->prefix.self::$table_name);
				delete_option(self::$option_name);	
			}
		}

		function shortcode_handler($args, $content=null){
			global $wpdb;
			$option = self::get_option();
			$args = shortcode_atts(array('debug' => 0,'id' =>0), $args);
			if( $args["id"] > 0 ){
				$snippet = self::get_snippet( $args["id"] );	
				$content = $snippet["function"];
			}else{
				$snippet = false;
				$content =(htmlspecialchars($content,ENT_QUOTES));
				$content = str_replace("&amp;#8217;","'",$content);
				$content = str_replace("&amp;#8216;","'",$content);
				$content = str_replace("&amp;#8242;","'",$content);
				$content = str_replace("&amp;#8220;","\"",$content);
				$content = str_replace("&amp;#8221;","\"",$content);
				$content = str_replace("&amp;#8243;","\"",$content);
				$content = str_replace("&amp;#039;","'",$content);
				$content = str_replace("&#039;","'",$content);
				$content = str_replace("&amp;#038;","&",$content);
				$content = str_replace("&amp;lt;br /&amp;gt;"," ", $content);
				$content = htmlspecialchars_decode($content);
				$content = str_replace("<br />"," ",$content);
				$content = str_replace("<p>"," ",$content);
				$content = str_replace("</p>"," ",$content);
				$content = str_replace("[br/]","<br/>",$content);
				$content = str_replace("\\[","&#91;",$content);
				$content = str_replace("\\\\]","\\&#93;",$content);
				$content = str_replace("\\]","&#93;",$content);
				$content = str_replace("[","<",$content);
				$content = str_replace("]",">",$content);
				$content = str_replace("&#91;",'[',$content);
				$content = str_replace("&#93;",']',$content);
				$content = str_replace("&gt;",'>',$content);
				$content = str_replace("&lt;",'<',$content);
			}
			$content = do_shortcode( $content );
			ob_start();
			echo $content;
			if($args['debug'] == 1){
				echo "<pre style='background:#ffc;color:black;'>";
				echo "<p><strong>Pure HTML version ".PUREHTMLVERSION."</strong></p>";
				if( $snippet != false && $snippet["id"] == 0){
					echo "<p><em>Cause: Original Snippet Not Found</em></p>";	
				}elseif( $snippet == false ){
					echo "<p><em>Remember all tags need to be written using square brackets rather than &lt; and &gt; (bbCode)</em></p>";	
				}
				echo "<hr />";
				echo "<p><strong>Evaluated Code</strong></p>";
				echo htmlspecialchars( $content, ENT_QUOTES );
				echo "</pre>";
			}
			$returned = ob_get_clean();
			return $returned;
		}

		function menu(){
			add_menu_page( "Pure HTML", "Pure HTML", "edit_posts", "pure-html-menu", array(__CLASS__, "primary_menu"), plugin_dir_url(__FILE__)."/icons/icon-16.png");
		}
		
		function add_snippet( $name, $code ){
			global $wpdb;
			if( $wpdb->insert( $wpdb->prefix.self::$table_name, array( "name"=> $name, "function" => $code ), array( "%s","%s" ) ) ){
				return $wpdb->insert_id;	
			}else{
				return -1;	
			}
		}
		
		function update_snippet( $id, $name, $code ){
			global $wpdb;
			if( $wpdb->update( $wpdb->prefix.self::$table_name, array( "name"=> $name, "function" => $code ), array( "id"=> $id ), array( "%s","%s" ), array( "%d" ) ) ){
				return true;	
			}else{
				return false;
			}
		}
		
		function get_snippet( $id ){
			global $wpdb;
			$snippet = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `".$wpdb->prefix.self::$table_name."` WHERE `id` = %d;", $id ), ARRAY_A );
			if( empty( $snippet ) )
				return self::get_404_snippet();
			else
				$snippet[0]["function"] = stripslashes($snippet[0]["function"]);
				return $snippet[0];
		}
		
		function get_404_snippet(){
			global $wpdb;
			$option = self::get_option();
			if( $option["show404"] == 0 )
				return array( "id"=>0, "function"=>"" );
			if( $option["fourohfourmsg"] != 0 ){
				$snippet = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `".$wpdb->prefix.self::$table_name."` WHERE `id` = %d;", $option["fourohfourmsg"] ), ARRAY_A );
				if( empty( $snippet ) ){
					return array( "id"=>0, "function"=>self::$default_404 );
				}else{
					$snippet[0]["function"] = stripslashes($snippet[0]["function"]);
					return $snippet[0];
				}
			}else{
				return array( "id"=>0, "function"=>self::$default_404 );
			}
		}
		
		function delete_snippet( $id ){
			global $wpdb;
			return $wpdb->get_results( $wpdb->prepare( "DELETE FROM ".$wpdb->prefix.self::$table_name." WHERE `id` = %d", $id ) );
		}

		function check_post(){
			if( !isset( $_POST[self::$option_name] ) || !isset( $_POST["_".self::$option_name] ) )
				return;
			if( !wp_verify_nonce( $_POST["_".self::$option_name], basename(__FILE__) ) )
				return;
			if( !isset( $_POST[self::$option_name]["action"] ) )
				return;
			
			if( $_POST[self::$option_name]["action"] == "option" ){
				$option = self::get_option();
				$option["fourohfourmsg"] = $_POST[self::$option_name]["fourohfourmsg"];

				if( isset( $_POST[self::$option_name]["show404"] ) )
					$option["show404"] = 1;
				else
					$option["show404"] = 0;

				if( isset( $_POST[self::$option_name]["complete_uninstall"] ) )
					$option["complete_uninstall"] = 1;
				else
					$option["complete_uninstall"] = 0;

				if( self::update_option( $option ) )
					echo '<div class="updated"><p><strong>Plugin Options Updated</strong></p></div>';
				return;
			}
			
			elseif( $_POST[self::$option_name]["action"] == "new" ){
				$id = self::add_snippet( $_POST[self::$option_name]["snippet"]["name"], $_POST[self::$option_name]["snippet"]["code"] );
				if( $id < 0 )
					echo '<div class="error"><p><strong>Could Not Insert Snippet</strong></p></div>';
				else
					echo '<div class="updated"><p><strong>Code Snippet Added</strong> - Add it to your posts using the shortcode <code>[purehtml id='.$id.']</code></p></div>';
				return;
			}

			elseif( $_POST[self::$option_name]["action"] == "modify" ){
				if( md5(NONCE_SALT.$_POST[self::$option_name]["snippet"]["id"] ) == $_POST[self::$option_name]["snippet"]["_id"] ) {
					if( isset( $_POST[self::$option_name]["snippet"]["update"] ) ){
						if( self::update_snippet( $_POST[self::$option_name]["snippet"]["id"], $_POST[self::$option_name]["snippet"]["name"], $_POST[self::$option_name]["snippet"]["code"] ) )
							echo '<div class="updated"><p><strong>Code Snippet Updated</strong> - Add it to your posts using the shortcode <code>[purehtml id='.$_POST[self::$option_name]["snippet"]["id"].']</code></p></div>';
						else
							echo '<div class="error"><p><strong>Could Not Update Snippet</strong></p></div>';
					}elseif( isset( $_POST[self::$option_name]["snippet"]["delete"] ) ){
						if( self::delete_snippet( $_POST[self::$option_name]["snippet"]["id"] ) !== false )
							echo '<div class="updated"><p><strong>Code Snippet Deleted</strong> - Make sure it is no longer in use in any post!</p></div>';
						else
							echo '<div class="error"><p><strong>Could Not Delete Snippet</strong></p></div>';
					}
				}
				return;
			}
		}

		function primary_menu(){
			global $wpdb;
			if (!current_user_can('manage_options'))
		      wp_die( __('You do not have sufficient permissions to access this page.') );
			self::check_post();
			$option = self::get_option();
			$message_404 = self::get_snippet( $option["fourohfourmsg"] );
			$sql = "SELECT * FROM ".$wpdb->prefix.self::$table_name;
			$all_snippets = $wpdb->get_results( $sql );
			?>
			<div class='wrap'>
				<div class="icon32"><img src='<?php echo plugin_dir_url(__FILE__)?>/icons/icon-32.jpg' alt='' width='32' height='32' /></div>
				<h2>Pure HTML</h2>
				<h3>Plugin Options</h3>
				<form action='' method="post" style="margin-bottom:50px">
					<?php wp_nonce_field( basename(__FILE__), '_'.self::$option_name ); ?>
					<input type='hidden' name='<?php echo self::$option_name?>[action]' value='option' />
					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row">Current 404 message</th>
								<td><?php echo ($message_404["function"]=="")?"<em style='color:#444;background:#ddd;padding:3px;'>Not Shown</em>":htmlspecialchars($message_404["function"]);?></td>
							</tr>
							<tr>
								<th scope="row"><label for="show404">Show the snippet not found message?</label></th>
								<td><input type='checkbox' name='<?php echo self::$option_name?>[show404]' id='show404' value='1' <?php checked( $option["show404"], "1", true )?>/></td>
							</tr>
							<tr>
								<th scope="row"><label for="fourohfourmsg">Custom 404 message to be displayed</label></th>
								<td><select name='<?php echo self::$option_name?>[fourohfourmsg]'>
									<option value='0'> - Default Message - </option>
									<?php
										foreach($all_snippets as $snippet){
											printf("<option value='%s'%s>(%s) %s</option>", esc_attr($snippet->id), selected($snippet->id, $option["fourohfourmsg"], false), esc_html($snippet->id), esc_html($snippet->name) );
										}
									?>
								</select></td>
							</tr>
							<tr>
								<th scope="row"><label for="complete_uninstall">Remove all plugin data on uninstall?</label></th>
								<td><input type='checkbox' name='<?php echo self::$option_name?>[complete_uninstall]' id='complete_uninstall' value='1' <?php checked( $option["complete_uninstall"], "1", true )?>/></td>
							</tr>
						</tbody>
					</table>
					<p><input type='submit' class='button-primary' value='Save Plugin Options' /></p>
				</form>
				
				<h3>Code Snippets</h3>
				<?php if( sizeof( $all_snippets ) > 0 ):?>
					<div style="display:block;overflow:hidden">
					<?php foreach( $all_snippets as $snippet ):?>
						<div style='width:30%; margin:5px; padding:5px; float:left;border:1px #ccc solid;resize:both;overflow:auto;' >
							<form action='' method="post" onsubmit="return confirm( 'Are you sure you want to modify this snippet? ' );">
								<?php wp_nonce_field( basename(__FILE__), '_'.self::$option_name ); ?>
								<input type='hidden' name='<?php echo self::$option_name?>[action]' value='modify' />
								<input type='hidden' name='<?php echo self::$option_name?>[snippet][id]' value='<?php echo $snippet->id?>' />
								<input type='hidden' name='<?php echo self::$option_name?>[snippet][_id]' value='<?php echo md5(NONCE_SALT.$snippet->id)?>' />
								<table class="form-table">
									<tbody>
										<tr>
											<th scope='row'><label for='name_<?php echo $snippet->id?>'>Snippet Name</label></th>
											<td><input type='text' id='name_<?php echo $snippet->id?>' name='<?php echo self::$option_name?>[snippet][name]' value='<?php print esc_attr( stripslashes( $snippet->name ) )?>' class='large-text' maxlength="100" /></td>
										</tr>
										<tr>
											<th scope='row'><label for='code_<?php echo $snippet->id?>'>Snippet Code</label></th>
											<td><textarea id='code_<?php echo $snippet->id?>' name='<?php echo self::$option_name?>[snippet][code]' class='large-text code'><?php print esc_textarea( stripslashes( $snippet->function ) )?></textarea></td>
										</tr>
										<tr>
											<th scope='row'>Shortcode</th>
											<td><code>[purehtml id=<?php echo $snippet->id?>]</code></td>
										</tr>
									</tbody>
								</table>
								<p><input type='submit' class='button' value='Delete Snippet' name='<?php echo self::$option_name?>[snippet][delete]' style='float:right;'/> <input type='submit' class='button-secondary' value='Update Snippet' name='<?php echo self::$option_name?>[snippet][update]' /></p>
							</form>
						</div>
					<?php endforeach ?>
					</div>
				<?php else: ?>
					<p><em>No Saved Code Snippets</em></p>
				<?php endif;?>
				<h3 style="margin-top:50px;clear:both;">Add New Code Snippet</h3>
				<div style='width:30%; margin:5px; padding:5px; float:left;border:1px #ccc solid;resize:both;overflow:auto;'>
					<form action='' method="post">
						<?php wp_nonce_field( basename(__FILE__), '_'.self::$option_name ); ?>
						<input type='hidden' name='<?php echo self::$option_name?>[action]' value='new' />
						<table class="form-table">
							<tbody>
								<tr>
									<th scope='row'><label for='name_<?php echo $snippet->id?>'>Snippet Name</label></th>
									<td><input type='text' id='name_<?php echo $snippet->id?>' name='<?php echo self::$option_name?>[snippet][name]' required='required' placeholder='Snippet Name' class='large-text' maxlength="100" /></td>
								</tr>
								<tr>
									<th scope='row'><label for='code_<?php echo $snippet->id?>'>Snippet Code</label></th>
									<td><textarea id='code_<?php echo $snippet->id?>' name='<?php echo self::$option_name?>[snippet][code]' required='required' placeholder='Snippet Code' class='large-text code'></textarea></td>
								</tr>
							</tbody>
						</table>
						<p><input type='submit' class='button-primary' value='Add Snippet' /></p>
					</form>
				</div>
			</div>
			<?php
		}

	}
	register_activation_hook(__FILE__, array( "PureHTML", 'activation_hook' ) );
	register_deactivation_hook(__FILE__, array( "PureHTML", 'deactivation_hook' ) );
	new PureHTML();
}

?>