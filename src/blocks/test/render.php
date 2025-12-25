<?php
/**
 * Test block render
 *
 * @package __PLUGIN_SLUG__
 * @since 1.0.0
 */

/**
 * Get block attributes
 */
//phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$title = $attributes['title'] ?? '';

//phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
$description = $attributes['description'] ?? esc_html__( 'This is a sample block description. Update this message as needed.', '__PLUGIN_SLUG__' );
?>
<div class="__PLUGIN_SLUG__-bg-white __PLUGIN_SLUG__-rounded-md __PLUGIN_SLUG__-p-6 __PLUGIN_SLUG__-border __PLUGIN_SLUG__-border-solid __PLUGIN_SLUG__-border-blue-500" style="border-left: 8px solid #6366f1;">
	<h3 class="__PLUGIN_SLUG__-text-xl __PLUGIN_SLUG__-font-bold" style="color:#6366f1; margin:0;"><?php echo esc_html( $title ); ?></h3>
	<?php if ( ! empty( $description ) ) : ?>
		<p class="__PLUGIN_SLUG__-text-base" style="color:#374151;"><?php echo esc_html( $description ); ?></p>
	<?php endif; ?>
</div>