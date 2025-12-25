<?php
/**
 * Plugin Name:     __PLUGIN_NAME__
 * Plugin URI:      #
 * Description:     #
 * Author:          __AUTHOR__
 * Author URI:      #
 * Text Domain:     __TEXT_DOMAIN__
 * Version:         1.0.0
 * Requires at least: 6.0
 * Requires PHP: 8.2
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package         __NAMESPACE__
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define plugin constants.
define( '__NAMESPACE___VERSION', '1.0.1' );
define( '__NAMESPACE___PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( '__NAMESPACE___PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( '__NAMESPACE___PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// Include Composer autoloader.
if ( file_exists( __NAMESPACE___PLUGIN_DIR . 'vendor/autoload.php' ) ) {
	require_once __NAMESPACE___PLUGIN_DIR . 'vendor/autoload.php';
} else {
	add_action(
		'admin_notices',
		function () {
			?>
		<div class="notice notice-error">
			<p><?php esc_html_e( '__PLUGIN_NAME__ requires Composer dependencies to be installed. Please run "composer install" in the plugin directory.', '__TEXT_DOMAIN__' ); ?></p>
		</div>
			<?php
		}
	);
	return;
}

// Initialize plugin.
require_once __NAMESPACE___PLUGIN_DIR . 'src/class-plugin.php';

// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$plugin = new \__NAMESPACE__\Plugin();
$plugin->init();