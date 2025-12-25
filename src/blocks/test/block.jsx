/**
 * Test block
 *
 * @package __PLUGIN_SLUG__
 * @since 1.0.0
 */
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { Disabled, PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';

import './style.css';

registerBlockType('wp-plugin-template/test', {
	attributes: {
		title: {
			type: 'string',
			default: __('Test Block', '__PLUGIN_SLUG__'),
		},
	},
	edit(props) {
		const { attributes, setAttributes } = props;
		const blockProps = useBlockProps();
		return (
			<>
				<InspectorControls>
					<PanelBody title={__('Test Block', '__PLUGIN_SLUG__')}>
						<TextControl
							label={__('Title', '__PLUGIN_SLUG__')}
							value={attributes.title}
							onChange={(value) => setAttributes({ title: value })}
						/>
					</PanelBody>
				</InspectorControls>
				<div {...blockProps}>
					<Disabled>
						<ServerSideRender block="wp-plugin-template/test" attributes={attributes} />
					</Disabled>
				</div>
			</>
		);
	},
});
