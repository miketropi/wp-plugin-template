<?php
/**
 * Blocks
 *
 * @package __PLUGIN_SLUG__
 * @since 1.0.0
 */

/**
 * Register blocks
 *
 * @return void
 */
add_action( 'init', '__PLUGIN_SLUG___register_blocks' );

/**
 * Register blocks
 *
 * @return void
 */
//phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionDoubleUnderscore, WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid, Squiz.Commenting.FunctionComment.Missing
function __PLUGIN_SLUG___register_blocks() {
	$blocks_build_dir = __NAMESPACE___PLUGIN_DIR . 'build/blocks';

	// if no blocks, return.
	if ( ! is_dir( $blocks_build_dir ) ) {
		return;
	}

	foreach ( glob( $blocks_build_dir . '/*' ) as $block_dir ) {
		// is dir.
		if ( is_dir( $block_dir ) ) {
			// check file exists.
			register_block_type( $block_dir . '/block.json' );
		}
	}
}
