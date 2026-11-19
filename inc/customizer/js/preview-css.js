/**
 * Instant Customizer preview for CSS written with wpbf_css() (see Customizer/Output/CssRules.php).
 *
 * Each area's CSS sits in <style id="wpbf-css-{area}">. PHP hands over the area's template (its CSS with a placeholder
 * per wpbf_css() block), the blocks, and the options the area reads outside wpbf_css().
 * - An option used by a block changes: the blocks are drawn again here, right away.
 * - An option read outside wpbf_css() changes: PHP renders the area again (selective refresh partial "wpbf_css_{area}").
 *
 * The rules below must match CssRules.php exactly (when a declaration prints, how values compare and print).
 */
(function (api) {
	"use strict";

	var areas = window.wpbfCssAreas || {};

	// Options changed in this preview (they count as saved: publishing saves them).
	var changedIds = {};

	var REF = /\{([A-Za-z0-9_\-]+)(?:\.([A-Za-z0-9_\-]+))?(?:\|([a-z%]+))?\}/g;
	var TOKEN = /\/\*wpbf-css:(\d+)\*\//g;
	var HEX = /^#[0-9a-fA-F]{3,8}$/;
	var BOOLEAN_TYPES = ["toggle", "checkbox", "headline-toggle"];
	var NUMBER_TYPES = ["slider", "number"];

	function isObject(value) {
		return null !== value && "object" === typeof value;
	}

	// PHP's is_numeric().
	function isNumeric(value) {
		if ("number" === typeof value) {
			return isFinite(value);
		}

		return "string" === typeof value && /^\s*[+-]?(\d+(\.\d*)?|\.\d+)([eE][+-]?\d+)?\s*$/.test(value);
	}

	function isEmpty(value) {
		if (null === value || undefined === value || "" === value || false === value) {
			return true;
		}

		return isObject(value) && 0 === Object.keys(value).length;
	}

	// PHP's truthiness.
	function isOn(value) {
		if (isObject(value)) {
			return Object.keys(value).length > 0;
		}

		return !(isEmpty(value) || 0 === value || "0" === value);
	}

	// OptionSchema::typed().
	function typed(meta, value) {
		if (meta.json) {
			if ("string" === typeof value) {
				try {
					value = JSON.parse(value);
				} catch (e) {
					value = null;
				}
			}

			return isObject(value) ? value : meta.default;
		}

		if (BOOLEAN_TYPES.indexOf(meta.type) !== -1) {
			return isOn(value);
		}

		if (NUMBER_TYPES.indexOf(meta.type) !== -1 && isNumeric(value)) {
			return parseFloat(value);
		}

		return value;
	}

	// wpbf_mod() in the preview.
	function mod(area, id) {
		var setting = api(id);
		var meta = area.options[id] || { default: null, type: "", json: false };

		if (!setting) {
			return meta.default;
		}

		return typed(meta, setting.get());
	}

	// CssRules::value(): the value, or the default when it's empty.
	function value(area, id) {
		var current = mod(area, id);

		return isEmpty(current) ? defaultOf(area, id) : current;
	}

	function defaultOf(area, id) {
		return area.options[id] ? area.options[id].default : null;
	}

	// CssRules::isSaved(): saved (PHP says so) or changed in this preview.
	function isSaved(area, id) {
		return Object.prototype.hasOwnProperty.call(changedIds, id) || !!(area.options[id] && area.options[id].saved);
	}

	// CssRules::raw(): the value as the setting holds it (not typed).
	function raw(id) {
		var setting = api(id);

		return setting ? setting.get() : false;
	}

	// CssRules::differs().
	function differs(area, block, ref, full, part) {
		var defaultValue;

		if (block.saved) {
			return null === block.unless || undefined === block.unless || block.unless !== raw(ref.id);
		}

		if (block.parts && ref.key) {
			defaultValue = defaultOf(area, ref.id);

			return !isObject(defaultValue) || !Object.prototype.hasOwnProperty.call(defaultValue, ref.key) || part !== defaultValue[ref.key];
		}

		return !same(full, defaultOf(area, ref.id));
	}

	function normalize(value) {
		var normal = {};

		Object.keys(value).forEach(function (key) {
			var part = value[key];

			if (isEmpty(part)) {
				return;
			}

			normal[key] = isNumeric(part) ? parseFloat(part) : isObject(part) ? JSON.stringify(part) : part;
		});

		return normal;
	}

	// CssRules::same().
	function same(value, defaultValue) {
		var a, b, keys;

		if (isObject(value) || isObject(defaultValue)) {
			if (!isObject(value) || !isObject(defaultValue)) {
				return false;
			}

			a = normalize(value);
			b = normalize(defaultValue);
			keys = Object.keys(a);

			return (
				keys.length === Object.keys(b).length &&
				keys.every(function (key) {
					return Object.prototype.hasOwnProperty.call(b, key) && a[key] === b[key];
				})
			);
		}

		if (isNumeric(value) && isNumeric(defaultValue)) {
			return parseFloat(value) === parseFloat(defaultValue);
		}

		// Hex colors ignore letter case (#FFFFFF is the default #ffffff).
		if ("string" === typeof value && "string" === typeof defaultValue && HEX.test(value) && HEX.test(defaultValue)) {
			return value.toLowerCase() === defaultValue.toLowerCase();
		}

		return value === defaultValue;
	}

	function text(value) {
		if ("boolean" === typeof value) {
			return value ? "1" : "";
		}

		return String(value);
	}

	// esc_attr().
	function escAttr(value) {
		return value
			.replace(/&(?!([a-zA-Z][a-zA-Z0-9]*|#\d+|#x[0-9a-fA-F]+);)/g, "&amp;")
			.replace(/</g, "&lt;")
			.replace(/>/g, "&gt;")
			.replace(/"/g, "&quot;")
			.replace(/'/g, "&#039;");
	}

	function refs(template) {
		var found = [];
		var match;

		REF.lastIndex = 0;

		while ((match = REF.exec(template))) {
			found.push({ placeholder: match[0], id: match[1], key: match[2] || "", unit: match[3] || "" });
		}

		return found;
	}

	// CssRules::whenId(): 'option_id' or 'option_id.key' (one part of a JSON option).
	function whenId(when) {
		return when.split(".")[0];
	}

	// CssRules::isOn().
	function whenOn(area, when) {
		var dot = when.indexOf(".");
		var current = mod(area, whenId(when));
		var key;

		if (-1 !== dot) {
			key = when.slice(dot + 1);
			current = isObject(current) && Object.prototype.hasOwnProperty.call(current, key) ? current[key] : null;
		}

		return isOn(current);
	}

	// CssRules::render().
	function render(area, block) {
		var printed = {};
		var any = false;
		var css = "";

		if (block.when && !whenOn(area, block.when)) {
			return "";
		}

		block.lines.forEach(function (line, index) {
			var lineRefs = refs(line[1]);
			var parts = {};
			var changed = false;
			var ok = true;

			if (!lineRefs.length) {
				return;
			}

			lineRefs.forEach(function (ref) {
				var full, part;

				if (!ok) {
					return;
				}

				if (block.saved && !isSaved(area, ref.id)) {
					ok = false;
					return;
				}

				full = block.saved ? mod(area, ref.id) : value(area, ref.id);
				part = "" === ref.key ? full : isObject(full) && Object.prototype.hasOwnProperty.call(full, ref.key) ? full[ref.key] : null;

				if (isEmpty(part) || isObject(part)) {
					ok = false;
					return;
				}

				parts[ref.placeholder] = escAttr(text(part) + (ref.unit && isNumeric(part) ? ref.unit : ""));
				changed = changed || differs(area, block, ref, full, part);
			});

			if (ok && (changed || block.always)) {
				printed[index] = line[1].replace(REF, function (placeholder) {
					return parts[placeholder];
				});
				any = true;
			}
		});

		if (!any && !block.always) {
			return "";
		}

		block.lines.forEach(function (line, index) {
			if (Object.prototype.hasOwnProperty.call(printed, index)) {
				css += line[0] + ":" + printed[index] + ";";
			} else if (!refs(line[1]).length) {
				css += line[0] + ":" + line[1] + ";";
			}
		});

		if ("" === css) {
			return "";
		}

		css = block.selector + "{" + css + "}";

		return "" === block.media ? css : "@media " + block.media + "{" + css + "}";
	}

	function draw(name) {
		var area = areas[name];
		var style = document.getElementById("wpbf-css-" + name);

		if (!area || !style) {
			return;
		}

		// A <style> with a title is an alternate style sheet: the browser drops it as soon as any style changes.
		style.removeAttribute("title");

		style.textContent = area.template.replace(TOKEN, function (token, index) {
			return area.blocks[index] ? render(area, area.blocks[index]) : "";
		});
	}

	function update(name, data) {
		if (!isObject(data) || "string" !== typeof data.template) {
			return false;
		}

		areas[name] = data;
		draw(name);

		return true;
	}

	// Ask PHP for the area again (an option used in an if, a calculation or an echo changed).
	function rerender(name) {
		var refresh = api.selectiveRefresh;
		var partial = refresh && refresh.partial("wpbf_css_" + name);

		if (!partial) {
			api.preview.send("refresh");
			return;
		}

		refresh
			.requestPartial(partial)
			.done(function (placements) {
				placements.forEach(function (placement) {
					update(name, placement.addedContent);
				});
			})
			.fail(function () {
				refresh.requestFullRefresh();
			});
	}

	function usesOption(area, id) {
		if (Object.prototype.hasOwnProperty.call(area.options, id)) {
			return true;
		}

		return area.blocks.some(function (block) {
			return block.when && whenId(block.when) === id;
		});
	}

	if (api.selectiveRefresh) {
		// The area partials are only ever refreshed from here; their content is data, not HTML.
		api.selectiveRefresh.partialConstructor.wpbf_css = api.selectiveRefresh.Partial.extend({
			isRelatedSetting: function () {
				return false;
			},
			// No "Shift-click to edit" for the area <style> tags: core would give them a title attribute, which turns a
			// <style> into an alternate style sheet that browsers switch off on the next style change (every area's CSS
			// then vanished from the preview after changing any option).
			ready: function () {},
			createEditShortcutForPlacement: function () {},
			renderContent: function (placement) {
				return update(this.id.replace(/^wpbf_css_/, ""), placement.addedContent);
			},
		});
	}

	api.bind("change", function (setting) {
		changedIds[setting.id] = true;

		Object.keys(areas).forEach(function (name) {
			var area = areas[name];

			if (area.reads.indexOf(setting.id) !== -1) {
				rerender(name);
			} else if (usesOption(area, setting.id)) {
				draw(name);
			}
		});
	});

	// For the preview check (bin/snapshot/customizer-check.mjs).
	window.wpbfPreviewCss = { areas: areas, draw: draw };
})(wp.customize);
