/**
 * SharedFontDataAdapter - Custom Select2 DataAdapter for shared global font data.
 *
 * This adapter extends ArrayAdapter and overrides `_normalizeItem` to AVOID
 * using $.extend() for each item. This reduces memory from ~7MB to ~500KB
 * for 24 typography controls using the same font list.
 *
 * Key optimization: The original _normalizeItem creates deep copies of each
 * item using $.extend(). We override it to return a minimal object without
 * deep cloning the original data.
 */

import { SelectControlChoice } from "./select-interface";

declare const jQuery: JQueryStatic;

// Select2 AMD modules - will be loaded at runtime
let Utils: any;
let ArrayAdapter: any;

/**
 * Initialize the adapter by requiring Select2 AMD modules.
 * Must be called before using createSharedFontDataAdapter.
 */
function initializeSelect2Modules(): boolean {
	if (Utils && ArrayAdapter) return true;

	const select2Amd = (jQuery.fn as any).select2?.amd;
	if (!select2Amd) {
		console.error("SharedFontDataAdapter: Select2 AMD not available");
		return false;
	}

	try {
		Utils = select2Amd.require("select2/utils");
		ArrayAdapter = select2Amd.require("select2/data/array");
		return true;
	} catch (e) {
		console.error("SharedFontDataAdapter: Failed to load Select2 modules", e);
		return false;
	}
}

/**
 * Create a SharedFontDataAdapter class for the given global variable.
 *
 * @param globalVarName - Name of the window property containing font data
 * @param initialSelectedValues - Currently selected value(s)
 * @returns A Select2 DataAdapter class
 */
export function createSharedFontDataAdapter(
	globalVarName: string,
	initialSelectedValues: string[],
): any {
	if (!initializeSelect2Modules()) {
		return null;
	}

	// Get reference to global data - NO COPY
	const globalData = (window as any)[globalVarName] as SelectControlChoice[];
	if (!globalData || !Array.isArray(globalData)) {
		console.error(`SharedFontDataAdapter: Global variable "${globalVarName}" not found or not an array`);
		return null;
	}

	// Track initial selection state - ensure all values are strings for consistent matching
	const selectedIdsSet = new Set<string>(
		initialSelectedValues.map((v) => String(v)),
	);

	/**
	 * Pre-process the data to add selection state WITHOUT mutating original data.
	 * This creates a shallow structure that references original text/id values.
	 */
	function prepareDataWithSelection(
		items: SelectControlChoice[],
	): SelectControlChoice[] {
		return items.map((item) => {
			// Create shallow copy with selection state
			const prepared: SelectControlChoice = {
				id: item.id,
				text: item.text,
				disabled: item.disabled,
				selected: item.id ? selectedIdsSet.has(item.id) : undefined,
			};

			if (item.children && item.children.length) {
				prepared.children = item.children.map((child) => ({
					id: child.id,
					text: child.text,
					disabled: child.disabled,
					selected: selectedIdsSet.has(child.id),
				}));
			}

			return prepared;
		});
	}

	// Prepare data once with selection state
	const preparedData = prepareDataWithSelection(globalData);

	/**
	 * SharedFontDataAdapter extends ArrayAdapter
	 */
	function SharedFontDataAdapter(
		this: any,
		$element: JQuery,
		options: any,
	) {
		// Set the data to our prepared data with selection state
		this._dataToConvert = preparedData;

		// Call parent's parent constructor (SelectAdapter), skipping ArrayAdapter's
		// constructor which would try to get data from options
		const SelectAdapter = Object.getPrototypeOf(ArrayAdapter.prototype);
		SelectAdapter.constructor.call(this, $element, options);
	}

	// Extend ArrayAdapter
	Utils.Extend(SharedFontDataAdapter, ArrayAdapter);

	/**
	 * Override _normalizeItem to avoid $.extend() copying.
	 * This is the key memory optimization.
	 *
	 * Original does: return $.extend({}, defaults, item);
	 * We do: return minimal object without deep cloning
	 */
	SharedFontDataAdapter.prototype._normalizeItem = function (
		item: SelectControlChoice,
	) {
		// Handle primitives (not expected for font data, but for safety)
		if (item !== Object(item)) {
			return {
				id: String(item),
				text: String(item),
				selected: false,
				disabled: false,
			};
		}

		// Return a minimal object with required properties
		// Don't use $.extend() - that's what causes memory bloat
		return {
			id: item.id !== undefined ? String(item.id) : undefined,
			text: item.text !== undefined ? String(item.text) : "",
			selected: !!item.selected,
			disabled: !!item.disabled,
			children: item.children, // Keep reference, don't copy
		};
	};

	return SharedFontDataAdapter;
}
