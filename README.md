WordPress-Plugin-Requirement
============================

WordPress Plugin Requirement is a simple class that can be inserted into your plugin to identify if all the requirements the plugin requires have been met before it can be fully activated and used.

For example, the plugin requires WordPress to be at least version 3.3 or higher to run.

## Installation

Simply paste the following code in your plugin and change the 'wpversion' value to the version of WordPress you require. e.g. '3.3'

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

* WooCommerce = woocommerce
* Jigoshop = jigoshop

## Contributing

Please submit all pull requests against *-dev branch.

Thanks!

= Changelog =

1.0.0 - 18th June 2013
* Initial Release