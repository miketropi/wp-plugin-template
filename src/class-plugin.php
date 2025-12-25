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
		// Includes files.
		$this->includes();

		// Init hooks.
		$this->init_hooks();
	}

	/**
	 * Init hooks.
	 */
	public function init_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'enqueue_block_assets', array( $this, 'enqueue_block_assets' ) );
	}

	/**
	 * Includes files.
	 *
	 * @return void
	 */
	public function includes() {
		require_once __NAMESPACE___PLUGIN_DIR . 'src/blocks/blocks.php';
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
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
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

		// register style.
		wp_register_style(
			'__PLUGIN_SLUG__-main',
			__NAMESPACE___PLUGIN_URL . 'dist' . $enqueue_style,
			array(),
			$version,
			'all'
		);

		// enqueue style.
		wp_enqueue_style( '__PLUGIN_SLUG__-main' );

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

	/**
	 * Enqueue block assets.
	 */
	public function enqueue_block_assets() {
		$version = __NAMESPACE___VERSION;

		// check mix-manifest.json is exists.
		if ( ! file_exists( __NAMESPACE___PLUGIN_DIR . 'dist/mix-manifest.json' ) ) {
			return;
		}

		// load manifest file.
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$manifest       = json_decode( file_get_contents( __NAMESPACE___PLUGIN_DIR . 'dist/mix-manifest.json' ), true );
		$enqueue_style  = $manifest['/__PLUGIN_SLUG__.main.bundle.css'];

		// enqueue style.
		wp_register_style(
			'__PLUGIN_SLUG__-blocks',
			__NAMESPACE___PLUGIN_URL . 'dist' . $enqueue_style,
			array(),
			$version,
			'all'
		);

		// enqueue style.
		wp_enqueue_style( '__PLUGIN_SLUG__-blocks' );
	}
}
