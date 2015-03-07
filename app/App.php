<?php
namespace Plugin_Name;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @package    Plugin_Name
 * @author     Your Name <email@example.com>
 * @link       http://example.com
 * @since      1.0.0
 */
class App {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The class respsponsible for the dashboard-specific functionality of the plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      Dashboard    $admin    Controls all the admin functionality for the plugin.
	 */
	public $dashboard;

	/**
	 * The class respsponsible for the web-facing functionality of the plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      Web    $public    Controls all the public functionality for the plugin.
	 */
	public $web;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->loader = new Loader();
		$this->set_locale();
		$this->define_dashboard_hooks();
		$this->define_web_hooks();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new I18n();
		$plugin_i18n->set_domain( Plugin_Name::$plugin_name );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_dashboard_hooks() {

		$this->dashboard = new Dashboard();

		$this->loader->add_action( 'admin_enqueue_scripts', $this->dashboard, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this->dashboard, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $this->dashboard, 'add_plugin_admin_menu' );
		$this->loader->add_filter( 'plugin_action_links_' . PLUGIN_NAME_BASENAME, $this->settings, 'add_action_links' );

	}

	/**
	 * Register all of the hooks related to the web functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_web_hooks() {

		$this->web = new Web();

		$this->loader->add_action( 'wp_enqueue_scripts', $this->web, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $this->web, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

}
