<?php
/**
 * WordPress Plugin Requirement Class.
 *
 * Contains the main functions for verifying the plugin requirements, 
 * stores variables, and handles error messages.
 *
 * @class WordPress Plugin Requirement
 * @version 1.1.1
 * @author Seb's Studio
 * @author url http://www.sebs-studio.com
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * @access public
 * @return string
 */
$plugin = plugin_basename(__FILE__);

if(!class_exists('WordPress_Plugin_Requirement')){

	/* Localisation */
	$locale = apply_filters('plugin_locale', get_locale(), 'wordpress_plugin_requirement');
	load_textdomain('wordpress_plugin_requirement', WP_PLUGIN_DIR."/".plugin_basename(dirname(__FILE__)).'/languages/wordpress_plugin_requirement-'.$locale.'.mo');
	load_plugin_textdomain('wordpress_plugin_requirement', false, dirname(plugin_basename(__FILE__)).'/languages/');

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

				wp_die( sprintf("'%s' ".__('requires WordPress %s or higher, and has been deactivated! Please upgrade WordPress and try again.<br /><br />Back to <a href="%s">WordPress Admin</a>.', 'wordpress_plugin_requirement'), $args['plugin_name'], $args['wpversion'], admin_url() );

			} // end if wordpress version has met first plugin requirement.

			// If easy digital downloads is required, we check to see if it is active.
			if( in_array( 'edd', $args ) && function_exists( 'is_edd_activated' ) ) {
				if( $this->is_edd_activated() ) {
					wp_die( sprintf("'%s' ".__('requires <a href="%s" target="_blank">Easy Digital Downloads</a> to be activated in order to work. Please install and activate <a href="%s">Easy Digital Downloads</a> first.', 'wordpress_plugin_requirement'), $args['plugin_name'], 'https://easydigitaldownloads.com' admin_url('plugin-install.php?tab=search&type=term&s=easy+digital+downloads') );
				}
			}

			// If jigoshop is required, we check to see if it is active.
			if( in_array( 'jigoshop', $args ) && function_exists( 'is_jigoshop_activated' ) ) {
				if( $this->is_jigoshop_activated() ) {
					wp_die( sprintf("'%s' ".__('requires <a href="%s" target="_blank">Jigoshop</a> to be activated in order to work. Please install and activate <a href="%s">WooCommerce</a> first.', 'wordpress_plugin_requirement'), $args['plugin_name'], 'http://www.jigoshop.com/' admin_url('plugin-install.php?tab=search&type=term&s=Jigoshop') );
				}
			}

			// If woocommerce is required, we check to see if it is active.
			if( in_array( 'woocommerce', $args ) && function_exists( 'is_woocommerce_activated' ) ) {
				if( $this->is_woocommerce_activated() ) {
					wp_die( sprintf("'%s' ".__('requires <a href="%s" target="_blank">WooCommerce</a> to be activated in order to work. Please install and activate <a href="%s">WooCommerce</a> first.', 'wordpress_plugin_requirement'), $args['plugin_name'], 'http://www.woothemes.com/woocommerce/' admin_url('plugin-install.php?tab=search&type=term&s=WooCommerce') );
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
			$active_plugins = (array) get_option('active_plugins', array());

			if(is_multisite()){
				$active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
			}

			return in_array('woocommerce/woocommerce.php', $active_plugins) || array_key_exists('woocommerce/woocommerce.php', $active_plugins);
		}

		/**
		 * Query whether Jigoshop is activated.
		 *
		 * @access public
		 * @return void
		 */
		public function is_jigoshop_activated(){
			$active_plugins = (array) get_option('active_plugins', array());

			if(is_multisite()){
				$active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
			}

			return in_array('jigoshop/jigoshop.php', $active_plugins) || array_key_exists('jigoshop/jigoshop.php', $active_plugins);
		}

		/**
		 * Query whether Easy Digital Downloads is activated.
		 *
		 * @access public
		 * @return void
		 */
		public function is_edd_activated(){
			$active_plugins = (array) get_option('active_plugins', array());

			if(is_multisite()){
				$active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
			}

			return in_array('easy-digital-downloads/easy-digital-downloads.php', $active_plugins) || array_key_exists('easy-digital-downloads/easy-digital-downloads.php', $active_plugins);
		}

	} // end of WordPress_Plugin_Requirement class.
} // end if WordPress_Plugin_Requirement class exists.

/**
 * Init wordpress plugin requirements class
 */
$wprequire = new WordPress_Plugin_Requirement;

?>