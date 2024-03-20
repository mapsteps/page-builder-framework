/**
 * Encode a specific type of object as JSON string or return an empty string if failed.
 *
 * @param {T} value - The value to encode.
 * @return {string} The JSON encoded version of the value.
 */
export function encodeJsonOrDefault<T>(value: T): string {
	try {
		return JSON.stringify(value);
	} catch (e) {
		return "";
	}
}

/**
 * Parse a JSON string or return undefined if failed.
 *
 * @param {string | null | undefined} jsonStr - The JSON string to parse.
 * @return {T | undefined} The parsed value or undefined if failed.
 */
export function parseJsonOrUndefined<T>(
	jsonStr: string | null | undefined,
): T | undefined {
	if ("" === jsonStr || !jsonStr) {
		return undefined;
	}

	try {
		return JSON.parse(jsonStr);
	} catch (e) {
		return undefined;
	}
}
