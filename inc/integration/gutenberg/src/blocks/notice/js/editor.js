import { registerBlockType } from '@wordpress/blocks';

// Internal dependencies for this block.
import Edit from './edit';
import save from './save';

registerBlockType('wpbf/notice-block', {
	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save,
});