import { __ } from '@wordpress/i18n';
import { useBlockProps, BlockControls, InspectorControls, AlignmentToolbar, RichText } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';

import classnames from 'classnames';

/**
 * Describes the structure of the block in the context of the editor.
 * This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {
	const { attributes, setAttributes, className } = props;
	const { typeClassName, message, contentAlignment, id } = attributes;

	const defaultClassName = 'wpbf-block wpbf-notice-block wpbf-notice';
	let fullClassName = defaultClassName + ' ' + typeClassName;

	const blockProps = useBlockProps({
		className: classnames(
			className,
			fullClassName
		)
	});

	return (
		<>
			<BlockControls>
				<AlignmentToolbar
					value={contentAlignment}
					onChange={(value) => setAttributes({ contentAlignment: value })}
				/>
			</BlockControls>

			<InspectorControls>
				<PanelBody title={__('Notice Settings', 'page-builder-framework')}>
					<SelectControl
						label="Notice Type"
						value={typeClassName}
						options={[
							{ label: __('Notice', 'page-builder-framework'), value: '' },
							{ label: __('Success', 'page-builder-framework'), value: 'wpbf-notice-success' },
							{ label: __('Warning', 'page-builder-framework'), value: 'wpbf-notice-warning' },
							{ label: __('Error', 'page-builder-framework'), value: 'wpbf-notice-error' },
						]}
						onChange={(value) => {
							setAttributes({ typeClassName: value });
							fullClassName = defaultClassName + ' ' + value;
						}}
					/>
				</PanelBody>
			</InspectorControls>

			<RichText
				tagName="div"
				focusOnInsert="true"
				isSelected="true"
				placeholder={__('Add notice message...', 'page-builder-framework')}
				style={{ textAlign: contentAlignment }}
				onChange={(val) => setAttributes({ message: val })}
				value={message}
				{...blockProps}
			/>
		</>
	);
}
