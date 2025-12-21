<?php
/**
 * Plugin Name: __PLUGIN_NAME__
 *
 * @package __NAMESPACE__
 */

namespace __NAMESPACE__;

/**
 * Plugin class.
 */
class Plugin {

	/**
	 * Init plugin
	 */
	public function init() {
		// Init plugin.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enquue scripts.
	 */
	public function enqueue_scripts() {
		$version = __NAMESPACE___VERSION;

		// check mix-manifest.json is exists.
		if ( ! file_exists( __NAMESPACE___PLUGIN_DIR . 'dist/mix-manifest.json' ) ) {
			return;
		}

		// load manifest file.
		$manifest       = json_decode( file_get_contents( __NAMESPACE___PLUGIN_DIR . 'dist/mix-manifest.json' ), true );
		$enqueue_script = $manifest['/__PLUGIN_SLUG__.main.bundle.js'];
		$enqueue_style  = $manifest['/__PLUGIN_SLUG__.main.bundle.css'];

		// enqueue script.
		wp_enqueue_script(
			'__PLUGIN_SLUG__-main',
			__NAMESPACE___PLUGIN_URL . 'dist' . $enqueue_script,
			array( 'jquery' ),
			$version,
			true
		);

		// enqueue style.
		wp_enqueue_style(
			'__PLUGIN_SLUG__-main',
			__NAMESPACE___PLUGIN_URL . 'dist' . $enqueue_style,
			array(),
			$version,
			'all'
		);

		// localize script.
		wp_localize_script(
			'__PLUGIN_SLUG__-main',
			'__PLUGIN_SLUG__',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( '__PLUGIN_SLUG__-nonce' ),
			)
		);
	}
}
