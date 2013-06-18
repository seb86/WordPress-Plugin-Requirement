<?php
/**
 * WordPress Plugin Requirement Class.
 *
 * Contains the main functions for verifying the plugin requirements, 
 * stores variables, and handles error messages.
 *
 * @class WordPress Plugin Requirement
 * @version 1.0.0
 * @author Sebs Studio
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * @access public
 * @return string
 */
$plugin = plugin_basename(__FILE__);

if(!class_exists('WordPress_Plugin_Requirement')){
	class WordPress_Plugin_Requirement {

		/**
		 * WordPress Plugin Requirement Check.
		 *
		 * @access public
		 * @return void
		 */
		public function wordpress_plugin_requires( $args = array( 'wpversion' => '3.3' ) ) {
			global $wp_version, $plugin;

			// First we check the minimum version of WordPress required.
			if ( version_compare( $wp_version, $args['wpversion'], "<" ) ) {

				// If the first requirement is not available then we check if the plugin was activated.
				if ( function_exists( 'is_plugin_active' ) ) {

					// Checks if plugin was activated on a single site setup.
					if ( is_plugin_active( $plugin ) ) {

						// Now we deactivate the plugin.
						deactivate_plugins( $plugin, false, false );
					}
				}

				else if ( function_exists( 'is_plugin_active_for_network' ) ) {

					// Checks if plugin was activated on a single site setup.
					if ( is_plugin_active_for_network( $plugin ) ) {

						// Now we deactivate the plugin.
						deactivate_plugins( $plugin, false, true );
					}
				}

				wp_die("'".$args['plugin_name']."' requires WordPress ".$args['wpversion']." or higher, and has been deactivated! Please upgrade WordPress and try again.<br /><br />Back to <a href='".admin_url()."'>WordPress Admin</a>.");

			} // end if wordpress version has met first plugin requirement.

			else {

				// If woocommerce is required, we check to see if it is active.
				if( in_array( 'woocommerce', $args ) && function_exists( 'is_woocommerce_activated' ) ) {
					if( $this->is_woocommerce_activated() ) {
						wp_die("'".$args['plugin_name']."' ".__('requires <a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a> to be activated in order to work. Please install and activate <a href="'.admin_url('plugin-install.php?tab=search&type=term&s=WooCommerce').'">WooCommerce</a> first.', 'wc_product_page_layouts'));
					}
				}

			}

		} // end if wordpress_plugin_requires

		//////////////////////////////////////////////////////////////////////////
		// The functions below are for detecting various other popular plugins. //
		//////////////////////////////////////////////////////////////////////////

		/**
		 * Query whether WooCommerce is activated.
		 *
		 * @access public
		 * @return void
		 */
		public function is_woocommerce_activated(){
			if(class_exists('woocommerce')){
				$is_woocommerce_active = true;
			}
			else{
				$is_woocommerce_active = false;
			}
			return $is_woocommerce_active;
		}

		/**
		 * Query whether Jigoshop is activated.
		 *
		 * @access public
		 * @return void
		 */
		public function is_jigoshop_activated(){
			if(class_exists('jigoshop')){
				$is_jigoshop_active = true;
			}
			else{
				$is_jigoshop_active = false;
			}
			return $is_jigoshop_active;
		}

	} // end of WordPress_Plugin_Requirement class.
} // end if WordPress_Plugin_Requirement class exists.

/**
 * Init wordpress plugin requirements class
 */
$wprequire = new WordPress_Plugin_Requirement;

?>