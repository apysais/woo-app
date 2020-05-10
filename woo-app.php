<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              acsolutionsph.com
 * @since             1.0.0
 * @package           Woo_App
 *
 * @wordpress-plugin
 * Plugin Name:       Woo APP
 * Plugin URI:        acsolutionsph.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Allan Paul Casilum
 * Author URI:        acsolutionsph.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-app
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOO_APP_VERSION', '1.0.0' );
define( 'WA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WA_STORE_TIME_INTERVAL', 15);//15 minutes
define( 'WA_STORE_DELIVERY_TIME', 25);//15 minutes
define( 'WA_TIME_ZONE', 'Asia/Manila');
/**
 * For autoloading classes
 * */
spl_autoload_register('wa_directory_autoload_class');
function wa_directory_autoload_class($class_name) {
		if ( false !== strpos( $class_name, 'WA' ) ) {
	 $include_classes_dir = realpath( get_template_directory( __FILE__ ) ) . DIRECTORY_SEPARATOR;
	 $admin_classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR;
	 $class_file = str_replace( '_', DIRECTORY_SEPARATOR, $class_name ) . '.php';
	 if( file_exists($include_classes_dir . $class_file) ){
		 require_once $include_classes_dir . $class_file;
	 }
	 if( file_exists($admin_classes_dir . $class_file) ){
		 require_once $admin_classes_dir . $class_file;
	 }
 }
}
function wa_get_plugin_details() {
 // Check if get_plugins() function exists. This is required on the front end of the
 // site, since it is in a file that is normally only loaded in the admin.
 if ( ! function_exists( 'get_plugins' ) ) {
	 require_once ABSPATH . 'wp-admin/includes/plugin.php';
 }
 $ret = get_plugins();
 return $ret['woo-app/woo-app.php'];
}

/**
* get the text domain of the plugin.
**/
function wa_get_text_domain() {
 $ret = wa_get_plugin_details();
 return $ret['TextDomain'];
}

/**
* get the plugin directory path.
**/
function wa_get_plugin_dir() {
 return plugin_dir_path( __FILE__ );
}

/**
* get the plugin url path.
**/
function wa_get_plugin_dir_url() {
 return plugin_dir_url( __FILE__ );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-app-activator.php
 */
function activate_woo_app() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-app-activator.php';
	Woo_App_Activator::activate();

	WA_User_Role::get_instance()->add();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-app-deactivator.php
 */
function deactivate_woo_app() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-app-deactivator.php';
	Woo_App_Deactivator::deactivate();

	WA_User_Role::get_instance()->remove();
}

register_activation_hook( __FILE__, 'activate_woo_app' );
register_deactivation_hook( __FILE__, 'deactivate_woo_app' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-app.php';
require plugin_dir_path( __FILE__ ) . 'functions/helper.php';

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_app() {

	$plugin = new Woo_App();
	$plugin->run();

	\Carbon_Fields\Carbon_Fields::boot();

	WA_WPMenu::get_instance();
	WA_Warehouse_DashboardWidget::get_instance();
	WA_Orders_Index::get_instance();
	WA_Delivery_Details::get_instance();

	//options
	WA_CarbonFields_Options::get_instance();

	//woocommerce
	WA_WOO_CheckOut::get_instance();
	WA_WOO_ThankYou::get_instance();

	//ajax
	WA_Orders_Ajax::get_instance();

}
//run_woo_app();
add_action('plugins_loaded', 'run_woo_app');

function wa_init() {
	wa_remove_cap_shop_manager();
}
add_action( 'init', 'wa_init' );

function wa_wp_loaded() {

}
add_action('wp', 'wa_wp_loaded');
