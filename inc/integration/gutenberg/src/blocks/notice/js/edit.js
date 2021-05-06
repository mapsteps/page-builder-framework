import { __ } from '@wordpress/i18n';
import { useBlockProps, BlockControls, InspectorControls, AlignmentToolbar, RichText } from '@wordpress/block-editor';

/**
 * Describes the structure of the block in the context of the editor.
 * This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const {type, message, contentAlignment, className, id} = attributes;

	return (
		<>
			<BlockControls>
				<AlignmentToolbar
					value={contentAlignment}
					onChange={(value) => setAttributes({ contentAlignment: value })}
				/>
			</BlockControls>

			<div {...useBlockProps()}>
				<RichText
					tagName="div"
					className='wpbf-block wpbf-notice-block wpbf-notice'
					style={{ textAlign: contentAlignment }}
					onChange={(val) => setAttributes({ message: val })}
					value={message}
				/>
			</div>
		</>
	);
}
