<?php
/**
 * WP_Whitelabel
 *
 * @package   WP_Whitelabel_Admin
 * @author    RC Lations II <rc@hallme.com>
 * @license   GPL-2.0+
 * @link      https://github.com/hallme/wp-whitelabel
 * @copyright 2014 RC Lations II
 */

/**
 * WP_Whitelabel_Admin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * If you're interested in introducing public-facing
 * functionality, then refer to `class-plugin-name.php`
 *
 * @package WP_Whitelabel_Admin
 * @author  RC Lations II <rc@hallme.com>
 */
class WP_Whitelabel_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		/*
		 * Call $plugin_slug from public plugin class.
		 */
		$plugin = WP_Whitelabel::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );
		
		// Populate options page
		add_action( 'admin_init', array( $this, 'wp_whitelabel_settings_init' ) );
		
		/*
		 * Define custom functionality.
		 *
		 * Read more about actions and filters:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( '@TODO', array( $this, 'action_method_name' ) );
		add_filter( '@TODO', array( $this, 'filter_method_name' ) );

		if(get_option('wp_whitelabel_yoast_ads') && is_plugin_active('wordpress-seo/wp-seo.php')) {
		
			function whitelabel_yoast() {
			   echo '<style type="text/css">
			           body.toplevel_page_wpseo_dashboard #sidebar-container { display: none; }
			           body.seo_page_wpseo_titles #sidebar-container { display: none; }
			           body.seo_page_wpseo_social #sidebar-container { display: none; }
			           body.seo_page_wpseo_xml #sidebar-container { display: none; }
			           body.seo_page_wpseo_permalinks #sidebar-container { display: none; }
			           body.seo_page_wpseo_internal-links #sidebar-container { display: none; }
			           body.seo_page_wpseo_rss #sidebar-container { display: none; }
			           body.seo_page_wpseo_import #sidebar-container { display: none; }
			           body.seo_page_wpseo_files #sidebar-container { display: none; }
			         </style>';
			}
			add_action('admin_head', 'whitelabel_yoast');
		
		}
		
		function remove_page_analysis_from_publish_box() { return false; }
		add_filter('wpseo_use_page_analysis', 'remove_page_analysis_from_publish_box');
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), WP_Whitelabel::VERSION );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), WP_Whitelabel::VERSION );
		}
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 * @TODO:
		 *
		 * - Change 'manage_options' to the capability you see fit
		 *   For reference: http://codex.wordpress.org/Roles_and_Capabilities
		 */
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Whitelabel Settings', $this->plugin_slug ),
			__( 'Whitelabeling', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function wp_whitelabel_settings_init() {
		add_settings_section( 'wp_whitelabel_general', 'Section One', array( $this, 'wp_whitelabel_general_callback'), 'wp_whitelabel' );
		add_settings_field( 'wp_whitelabel_yoast_ads', 'Remove Yoast Ads?', array( $this, 'yoast_ads_callback'), 'wp_whitelabel', 'wp_whitelabel_general' );
		register_setting( 'wp_whitelabel', 'wp_whitelabel_yoast_ads' );
	}
	
	public function wp_whitelabel_general_callback() {
	    echo 'Some help text goes here.';
	}
	
	public function yoast_ads_callback() {
	    echo '<input name="wp_whitelabel_yoast_ads" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'wp_whitelabel_yoast_ads' ), false ) . ' />';
	}

	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}

	/**
	 * NOTE:     Actions are points in the execution of a page or process
	 *           lifecycle that WordPress fires.
	 *
	 *           Actions:    http://codex.wordpress.org/Plugin_API#Actions
	 *           Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function action_method_name() {
		// @TODO: Define your action hook callback here
	}

	/**
	 * NOTE:     Filters are points of execution in which WordPress modifies data
	 *           before saving it or sending it to the browser.
	 *
	 *           Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *           Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	public function filter_method_name() {
		// @TODO: Define your filter hook callback here
	}

}
