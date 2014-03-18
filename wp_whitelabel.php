<?php
/**
 * WP Whitelabel
 *
 * Simple, no-nonsense whitelabel plugin for WordPress
 *
 * @package   WP_Whitelabel
 * @author    RC Lations II <rc@hallme.com>
 * @license   GPL-2.0+
 * @link      https://github.com/hallme/wp-whitelabel
 * @copyright 2014 RC Lations II
 *
 * @wordpress-plugin
 * Plugin Name:       WP Whitelabel
 * Plugin URI:        https://github.com/hallme/wp-whitelabel
 * Description:       Simple, no-nonsense whitelabel plugin for WordPress
 * Version:           1.0
 * Author:            RC Lations II
 * Author URI:        www.hallme.com
 * Text Domain:       wp_whitelabel
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/hallme/wp-whitelabel
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-wp_whitelabel.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'WP_Whitelabel', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WP_Whitelabel', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'WP_Whitelabel', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-wp_whitelabel-admin.php' );
	add_action( 'plugins_loaded', array( 'WP_Whitelabel_Admin', 'get_instance' ) );

}
