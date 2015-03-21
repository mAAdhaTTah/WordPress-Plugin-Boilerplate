<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Plugin Boilerplate
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress dashboard.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Define Constants
 *----------------------------------------------------------------------------*/

// Directory i.e. /home/user/public_html...
define( 'PLUGIN_NAME_DIR', plugin_dir_path( __FILE__ ) );
// URL i.e. http://www.yoursite.com/wp-content/plugins/wp-gistpen/
define( 'PLUGIN_NAME_URL', plugin_dir_url( __FILE__ ) );
// Plugin Basename, for settings page
define( 'PLUGIN_NAME_BASENAME', plugin_basename( __FILE__ ) );

/*----------------------------------------------------------------------------*
 * Autoload Classes
 *----------------------------------------------------------------------------*/

require_once 'lib/autoload.php';

/*----------------------------------------------------------------------------*
 * Register Activation and Deactivation Hooks
 *----------------------------------------------------------------------------*/

/** This action is documented in app/Activator.php */
register_activation_hook( __FILE__, array( 'Plugin_Name\Activator', 'activate' ) );

/** This action is documented in app/Deactivator.php */
register_deactivation_hook( __FILE__, array( 'Plugin_Name\Deactivator', 'deactivate' ) );

/**
 * Singleton Container.
 *
 * Maintains a single copy of the app object and kicks off
 * the plugin execution when a new one is created.
 *
 * @package    Plugin_Name
 * @author     Your Name <email@example.com>
 * @link       http://example.com
 * @since      1.0.0
 */
class Plugin_Name {

	static $app;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_slug    The string used to uniquely identify this plugin.
	 */
	static $plugin_slug = 'plugin-name';

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	static $version = '0.1.0';

	public static function init() {

		if ( null == self::$app ) {
			self::$app = new Plugin_Name\App();
			self::$app->run();
		}

		return self::$app;
	}
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * Also returns copy of the app object so 3rd party developers
 * can interact with the plugin's hooks contained within.
 *
 * @return   Plugin_Name\App    App Plugin's app object
 * @since    1.0.0
 */
function plugin_name() {
	return Plugin_Name::init();
}

$updatePhp = new WPUpdatePhp( '5.3.0' );

if ( $updatePhp->does_it_meet_required_php_version( PHP_VERSION ) ) {
	plugin_name();
}
