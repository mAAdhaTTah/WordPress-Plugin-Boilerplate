<?php
namespace Plugin_Name;

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, a settings page, and two examples hooks
 * for how to enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @author     Your Name <email@example.com>
 * @link       http://example.com
 * @since      1.0.0
 */
class Dashboard {

	/**
	 * The minification string
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var string
	 */
	private $min = '';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( ! defined( 'SCRIPT_DEBUG' ) || true !== SCRIPT_DEBUG ) {
			$this->min = '.min';
		}

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( Plugin_Name::$plugin_slug, PLUGIN_NAME_URL . 'assets/css/dashboard' . $this->min . '.css', array(), Plugin_Name::$version, 'all' );

	}

	/**
	 * Register the JavaScript for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( Plugin_Name::$plugin_slug, PLUGIN_NAME_URL . 'assets/js/dashboard' . $this->min . '.js', array( 'jquery' ), Plugin_Name::$version, false );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Plugin Name Settings', Plugin_Name::$plugin_slug ),
			__( 'Plugin Name', Plugin_Name::$plugin_slug ),
			'edit_posts',
			Plugin_Name::$plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {

		include_once( PLUGIN_NAME_DIR . 'partials/settings-page.php' );

	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . Plugin_Name::$plugin_slug ) . '">' . __( 'Settings', Plugin_Name::$plugin_slug ) . '</a>'
			),
			$links
		);

	}

}
