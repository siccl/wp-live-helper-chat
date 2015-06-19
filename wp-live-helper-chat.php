<?php
/*
Plugin Name: WP Live Helper Chat
Plugin URI: http://www.midlandwebcompany/downloads/wp-live-helper-chat/
Description: Allows you to insert live helper chat code into you're wordpress blog
Version: 1.0
Author: Midland Web Company
Author URI: http://www.midlandwebcompany.com
License: GPLv2 or later
*/

/*  Copyright 2015  Midland Web Company  (email : info@midlandwebcompany.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('wplhc_PLUGIN_DIR',str_replace('\\','/',dirname(__FILE__)));

if ( !class_exists( 'livehelperchat' ) ) {
	
	class livehelperchat {

		function livehelperchat() {
		
			add_action( 'init', array( &$this, 'init' ) );
			add_action( 'admin_init', array( &$this, 'admin_init' ) );
			add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
			add_action( 'wp_head', array( &$this, 'wp_head' ) );
			add_action( 'wp_footer', array( &$this, 'wp_footer' ) );
		
		}
		
	
		function init() {
			load_plugin_textdomain( 'wp-live-helper-chat', false, dirname( plugin_basename ( __FILE__ ) ).'/lang' );
		}
	
		function admin_init() {
			register_setting( 'wp-live-helper-chat', 'wplhc_insert_header', 'trim' );
			register_setting( 'wp-live-helper-chat', 'wplhc_insert_footer', 'trim' );

			foreach (array('post','page') as $type) 
			{
				add_meta_box('wplhc_all_post_meta', 'Insert Script to &lt;head&gt;', 'wplhc_meta_setup', $type, 'normal', 'high');
			}
			
			add_action('save_post','wplhc_post_meta_save');
		}
	
		function admin_menu() {
			$page = add_submenu_page( 'options-general.php', 'WP live Helper Chat', 'WP live Helper Chat', 'manage_options', __FILE__, array( &$this, 'wplhc_options_panel' ) );
			}
	
		function wp_head() {
			$meta = get_option( 'wplhc_insert_header', '' );
				if ( $meta != '' ) {
					echo $meta, "\n";
				}

			$wplhc_post_meta = get_post_meta( get_the_ID(), '_inpost_head_script' , TRUE );
				if ( $wplhc_post_meta != '' ) {
					echo $wplhc_post_meta['synth_header_script'], "\n";
				}
			
		}
		   
				
		function wplhc_options_panel() { ?>
        
        
        
<div id="wplhc-wrap">
	<div class="wrap">
				<?php screen_icon(); ?>
					<h2>WP Live Helper Chat</h2>
					<hr />
                    
                    
<table class="widefat" width="auto" border="0">
  <tr>
    <td valign="top"><form name="dofollow" action="options.php" method="post">
						
							<?php settings_fields( 'wp-live-helper-chat' ); ?>
                        	
							<h3 class="wplhc-labels" for="wplhc_insert_header">Paste your Live Helper Chat script here:</h3>
                            <textarea rows="5" cols="57" id="insert_header" name="wplhc_insert_header"><?php echo esc_html( get_option( 'wplhc_insert_header' ) ); ?></textarea><br />
                            <h3 class="wplhc-labels footerlabel" for="wplhc_insert_footer">
							  <input class="button button-primary" type="submit" name="Submit" value="Save settings" /> 
						</h3>

						</form></td>
    <td style="border:1px; border-color:#666"><div class="wplhc-sidebar" style="max-width: 270px;float: left;">
						<div class="wplhc-improve-site" style="padding: 1rem; background: rgba(0, 0, 0, .02);">
							<h2>Need Hosting for Live Helper Chat!</h2>
							<p>We wrote Live Helper Chat, and we can host it for you, too. By ordering Live Helper Chat hosting here you also support futher development.</p>
							<p><a href="https://livehelperchat.com/order/now" class="button" target="_blank">Hosting Plans &raquo;</a></p>
						</div>
						<div class="wplhc-support" style="padding: 1rem; background: rgba(0, 0, 0, .02);">
							<h2>Need Support?</h2>
							<p>For any help visit our Support Forums</p>
							<p><strong><a href="https://forum.livehelperchat.com/" target="_blank">Support Forums</a></strong></p>
						</div>
						<div class="wplhc-donate" style="padding: 1rem; background: rgba(0, 0, 0, .02);">
							<h3>Contribute or Donate!</h3>
							<p>Developing application takes a lot of time. You can support application by donating. There is no company behind this application and it takes away my free time. Every donation matters and does not matter how small it is!</p>
							<p><a href="https://livehelperchat.com/support-project-4c.html" target="_blank"><img src="<?php  echo plugin_dir_url( __FILE__ ); ?>images/paypal-donate.gif" alt="Subscribe to our Blog" style="margin: 0 5px 0 0; vertical-align: top; line-height: 18px;"/></a></p>
						</div>
						<div class="wplhc-donate" style="padding: 1rem; background: rgba(0, 0, 0, .02);">
						  <h3>Like this plugin</h3>
						  <p>Developed By: <a href="http://www.midlandwebcompany.com" title="Cisit Us" target="new">www.midlandwebcompany.com</a></p>
							<p><a href="www.midlandwebcompany.com"><img src="http://www.midlandwebcompany.com/wp-content/uploads/2015/06/wp-live-helper-chat-midkand-web-company-logo.png" alt="Visit Us" longdesc="http://www.midlandwebcompany.com" /></a></p>
						</div>
	  </div></td>
  </tr>
</table>
                    
                    
                    
					<div class="wplhc-wrap" style="width: auto;float: left;margin-right: 2rem;"><hr />
					
						</div>
                        
					</div>
				</div>
				
							
				<?php
		}
	}

	
$WP_live_Helper_Chat = new livehelperchat();

}



