WordPress-Plugin-Requirement
============================

WordPress Plugin Requirement is a simple class that can be easily inserted into your plugin to identify if all the requirements the plugin needs have been installed and activated before hand.

This stops problems occuring during activation if the plugin needs to register new post type or create a new database to store data. Having the plugin do a checkup first is important to prevent any problems during activation on a live site.

For example, 'WooCommerce Product Page Layout' an extension to the shopping cart plugin 'WooCommerce' requires WordPress to be at least version 3.3 or higher and WooCommerce to run.

If both requirements have been met then the plugin will activate and continue to install anything it requires for it to work.

## Installation

Simply copy the class file from 'includes' folder into your plugin directory and paste the following code in your plugin and change the 'wpversion' value to the version of WordPress you require.

```
// WordPress Plugin Requirement Class.
if(!function_exists('plugin_check')){
	function plugin_check(){
		$plugin_data = get_plugin_data(__FILE__, false);
		require_once('includes/wordpress-plugin-requirements.php');
		$wprequire->wordpress_plugin_requires( 
						$args = array(
									'plugin_name' => $plugin_data['Name'], 
									'wpversion' => '3.3'
								)
						 );
	}
}
register_activation_hook( __FILE__, 'plugin_check' );
```

__Extra Requirements__

These requirements are extra ways of validating that the plugin will activate if the additional requirements have been met.

To apply any of these extra checks, simply apply the value to the list of `$args = array();` in lowercase. See example below.

```
$args = array(
			'plugin_name' => $plugin_data['Name'], 
			'wpversion' => '3.3',
			'woocommerce'
		)
);
```

Simply add the plugin you require to be active before your plugin can be active.

* Easy Digital Downloads = edd
* Jigoshop = jigoshop
* WooCommerce = woocommerce

## Contributing

Please read the 'CONTRIBUTING.md' file for details.

## Changelog

1.1.1 - 13th September 2013
* UPDATE - Made some minor adjustments.
* ADDED - Localization and default language file (English).
* ADDED - Support for Easy Digital Downloads.
* ADDED - Activation check for Jigoshop.

1.0.0 - 18th June 2013
* Initial Release