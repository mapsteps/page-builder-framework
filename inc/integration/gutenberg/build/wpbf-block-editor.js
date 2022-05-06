(function () {
function $parcel$interopDefault(a) {
  return a && a.__esModule ? a.default : a;
}

var $c005a2da7048c8dc$exports = {};
$c005a2da7048c8dc$exports = wp.i18n;


var $025fe6f199ddaec3$exports = {};
$025fe6f199ddaec3$exports = wp.blocks;


var $b56520c6448058e4$exports = {};
$b56520c6448058e4$exports = JSON.parse("{\"apiVersion\":2,\"name\":\"wpbf/notices\",\"title\":\"Notices\",\"category\":\"wpbf\",\"icon\":\"info-outline\",\"description\":\"Notice block utilizing CSS Framework of Page Builder Framework.\",\"textdomain\":\"page-builder-framework\",\"supports\":{\"anchor\":true},\"attributes\":{\"contentJustification\":{\"type\":\"string\",\"default\":\"left\"},\"orientation\":{\"type\":\"string\",\"default\":\"horizontal\"},\"id\":{\"type\":\"string\"}}}");




var $4ad015f3c8307374$var$transforms = {
    from: [
        {
            type: "block",
            isMultiBlock: true,
            blocks: [
                "wpbf/notice"
            ],
            transform: function(notices) {
                return(// Creates the notices block
                $025fe6f199ddaec3$exports.createBlock($b56520c6448058e4$exports.name, {}, // Loop the selected notices
                notices.map(function(attributes) {
                    return(// Create singular notice in the notices block
                    $025fe6f199ddaec3$exports.createBlock("wpbf/notice", attributes));
                })));
            }
        },
        {
            type: "block",
            isMultiBlock: true,
            blocks: [
                "core/paragraph"
            ],
            transform: function(notices) {
                return(// Creates the notices block
                $025fe6f199ddaec3$exports.createBlock($b56520c6448058e4$exports.name, {}, // Loop the selected notices
                notices.map(function(attributes) {
                    // Create singular notice in the notices block
                    return $025fe6f199ddaec3$exports.createBlock("wpbf/notice", {
                        message: attributes.content
                    });
                })));
            }
        }, 
    ]
};
var $4ad015f3c8307374$export$2e2bcd8739ae039 = $4ad015f3c8307374$var$transforms;


function $af2a5c48ea008d99$export$2e2bcd8739ae039(obj, key, value) {
    if (key in obj) Object.defineProperty(obj, key, {
        value: value,
        enumerable: true,
        configurable: true,
        writable: true
    });
    else obj[key] = value;
    return obj;
}


function $55ed12119eb86ded$export$2e2bcd8739ae039(target) {
    for(var i = 1; i < arguments.length; i++){
        var source = arguments[i] != null ? arguments[i] : {};
        var ownKeys = Object.keys(source);
        if (typeof Object.getOwnPropertySymbols === 'function') ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function(sym) {
            return Object.getOwnPropertyDescriptor(source, sym).enumerable;
        }));
        ownKeys.forEach(function(key) {
            $af2a5c48ea008d99$export$2e2bcd8739ae039(target, key, source[key]);
        });
    }
    return target;
}

function $c86d260461abd2be$export$2e2bcd8739ae039(obj) {
    return obj && obj.constructor === Symbol ? "symbol" : typeof obj;
}




var $e7ce011e45c0562f$exports = {};
$e7ce011e45c0562f$exports = wp.blockEditor;


var $f86dd0ec9fb2fff3$exports = {};

/*!
  Copyright (c) 2018 Jed Watson.
  Licensed under the MIT License (MIT), see
  http://jedwatson.github.io/classnames
*/ /* global define */ (function() {
    var hasOwn = {}.hasOwnProperty;
    function classNames() {
        var classes = [];
        for(var i = 0; i < arguments.length; i++){
            var arg = arguments[i];
            if (!arg) continue;
            var argType = typeof arg === "undefined" ? "undefined" : $c86d260461abd2be$export$2e2bcd8739ae039(arg);
            if (argType === 'string' || argType === 'number') classes.push(arg);
            else if (Array.isArray(arg)) {
                if (arg.length) {
                    var inner = classNames.apply(null, arg);
                    if (inner) classes.push(inner);
                }
            } else if (argType === 'object') {
                if (arg.toString === Object.prototype.toString) {
                    for(var key in arg)if (hasOwn.call(arg, key) && arg[key]) classes.push(key);
                } else classes.push(arg.toString());
            }
        }
        return classes.join(' ');
    }
    if ($f86dd0ec9fb2fff3$exports) {
        classNames.default = classNames;
        $f86dd0ec9fb2fff3$exports = classNames;
    } else if (typeof define === 'function' && typeof define.amd === 'object' && define.amd) // register as 'classnames', consistent with npm package name
    define('classnames', [], function() {
        return classNames;
    });
    else window.classNames = classNames;
})();




var $bb75fdb3648fa637$exports = {};
$bb75fdb3648fa637$exports = JSON.parse("{\"apiVersion\":2,\"name\":\"wpbf/notice\",\"title\":\"Notice\",\"category\":\"wpbf\",\"parent\":[\"wpbf/notices\"],\"description\":\"Notice block utilizing CSS Framework of Page Builder Framework.\",\"textdomain\":\"page-builder-framework\",\"supports\":{\"html\":false},\"attributes\":{\"typeClassName\":{\"type\":\"string\",\"default\":\"\"},\"message\":{\"type\":\"string\",\"default\":\"\"},\"contentAlignment\":{\"type\":\"string\",\"default\":\"\"},\"id\":{\"type\":\"string\"}},\"styles\":[{\"name\":\"\",\"label\":\"Inline\",\"isDefault\":true},{\"name\":\"wpbf-full-width\",\"label\":\"Full width\"}]}");





var $9a4aca5c1b6e9743$exports = {};
$9a4aca5c1b6e9743$exports = wp.components;



/**
 * Describes the structure of the block in the context of the editor.
 * This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */ function $b308b8bbe71c131f$var$NoticeEdit(param) {
    var attributes = param.attributes, setAttributes = param.setAttributes, className = param.className;
    var typeClassName = attributes.typeClassName, message = attributes.message, contentAlignment = attributes.contentAlignment, id = attributes.id;
    var defaultClassName = "wpbf-block wpbf-block-notice wpbf-notice";
    var fullClassName = (/*@__PURE__*/$parcel$interopDefault($f86dd0ec9fb2fff3$exports))(defaultClassName, typeClassName);
    var blockProps = $e7ce011e45c0562f$exports.useBlockProps({
        className: fullClassName
    });
    return /*#__PURE__*/ React.createElement(React.Fragment, null, /*#__PURE__*/ React.createElement($e7ce011e45c0562f$exports.BlockControls, null, /*#__PURE__*/ React.createElement($e7ce011e45c0562f$exports.AlignmentToolbar, {
        value: contentAlignment,
        onChange: function(value) {
            return setAttributes({
                contentAlignment: value
            });
        }
    })), /*#__PURE__*/ React.createElement($e7ce011e45c0562f$exports.InspectorControls, null, /*#__PURE__*/ React.createElement($9a4aca5c1b6e9743$exports.PanelBody, {
        title: $c005a2da7048c8dc$exports.__("Notice Settings", "page-builder-framework")
    }, /*#__PURE__*/ React.createElement($9a4aca5c1b6e9743$exports.SelectControl, {
        label: "Notice Type",
        value: typeClassName,
        options: [
            {
                label: $c005a2da7048c8dc$exports.__("Default", "page-builder-framework"),
                value: ""
            },
            {
                label: $c005a2da7048c8dc$exports.__("Success", "page-builder-framework"),
                value: "wpbf-notice-success"
            },
            {
                label: $c005a2da7048c8dc$exports.__("Warning", "page-builder-framework"),
                value: "wpbf-notice-warning"
            },
            {
                label: $c005a2da7048c8dc$exports.__("Error", "page-builder-framework"),
                value: "wpbf-notice-error"
            },
            {
                label: $c005a2da7048c8dc$exports.__("Primary", "page-builder-framework"),
                value: "wpbf-notice-primary"
            }, 
        ],
        onChange: function(value) {
            setAttributes({
                typeClassName: value
            });
            fullClassName = (/*@__PURE__*/$parcel$interopDefault($f86dd0ec9fb2fff3$exports))(defaultClassName, value);
        }
    }))), /*#__PURE__*/ React.createElement($e7ce011e45c0562f$exports.RichText, $55ed12119eb86ded$export$2e2bcd8739ae039({}, blockProps, {
        placeholder: $c005a2da7048c8dc$exports.__("Add notice message...", "page-builder-framework"),
        style: {
            textAlign: contentAlignment
        },
        onChange: function(val) {
            return setAttributes({
                message: val
            });
        },
        value: message
    })));
}
var $b308b8bbe71c131f$export$2e2bcd8739ae039 = $b308b8bbe71c131f$var$NoticeEdit;





/**
 * Defines the way in which the different attributes should be combined into the final markup,
 * which is then serialized by the block editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */ function $6cbd2c92d1015c3e$var$save(param) {
    var attributes = param.attributes;
    var typeClassName = attributes.typeClassName, message = attributes.message, contentAlignment = attributes.contentAlignment, id = attributes.id;
    var textAlignClassName = "";
    switch(contentAlignment){
        case "left":
            textAlignClassName = "wpbf-text-left";
            break;
        case "center":
            textAlignClassName = "wpbf-text-center";
            break;
        case "right":
            textAlignClassName = "wpbf-text-right";
            break;
        case "justify":
            textAlignClassName = "wpbf-text-justify";
            break;
        default:
            break;
    }
    var noticeClassName = (/*@__PURE__*/$parcel$interopDefault($f86dd0ec9fb2fff3$exports))("wpbf-block wpbf-block-notice wpbf-notice", typeClassName, textAlignClassName);
    return /*#__PURE__*/ React.createElement("div", $e7ce011e45c0562f$exports.useBlockProps.save({
        className: noticeClassName
    }), /*#__PURE__*/ React.createElement($e7ce011e45c0562f$exports.RichText.Content, {
        value: message
    }));
}
var $6cbd2c92d1015c3e$export$2e2bcd8739ae039 = $6cbd2c92d1015c3e$var$save;


var $cc3f6f01d0fdde5e$export$a8ff84c12d48cfa6 = (/*@__PURE__*/$parcel$interopDefault($bb75fdb3648fa637$exports)).name;
/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */ $025fe6f199ddaec3$exports.registerBlockType("wpbf/notice", {
    icon: 'info',
    example: {
        attributes: {
            typeClassName: "wpbf-notice-success",
            message: $c005a2da7048c8dc$exports.__("Sample of success message", "page-builder-framework")
        }
    },
    /**
	 * @see ./edit.js
	 */ edit: $b308b8bbe71c131f$export$2e2bcd8739ae039,
    /**
	 * @see ./save.js
	 */ save: $6cbd2c92d1015c3e$export$2e2bcd8739ae039
});


var $15336f58a141421b$var$ALLOWED_BLOCKS = [
    $cc3f6f01d0fdde5e$export$a8ff84c12d48cfa6
];
var $15336f58a141421b$var$NOTICES_TEMPLATE = [
    [
        "wpbf/notice"
    ]
];
/**
 * Describes the structure of the block in the context of the editor.
 * This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */ function $15336f58a141421b$var$NoticesEdit(param) {
    var _attributes = param.attributes, contentJustification = _attributes.contentJustification, orientation = _attributes.orientation, setAttributes = param.setAttributes;
    var _obj;
    var blockProps = $e7ce011e45c0562f$exports.useBlockProps({
        className: (/*@__PURE__*/$parcel$interopDefault($f86dd0ec9fb2fff3$exports))("wpbf-block wpbf-block-notices", (_obj = {}, $af2a5c48ea008d99$export$2e2bcd8739ae039(_obj, "wpbf-content-justified-".concat(contentJustification), contentJustification), $af2a5c48ea008d99$export$2e2bcd8739ae039(_obj, "wpbf-is-vertical", orientation === "vertical"), _obj))
    });
    var innerBlocksProps = $e7ce011e45c0562f$exports.useInnerBlocksProps(blockProps, {
        allowedBlocks: $15336f58a141421b$var$ALLOWED_BLOCKS,
        template: $15336f58a141421b$var$NOTICES_TEMPLATE,
        orientation: orientation,
        __experimentalLayout: {
            type: "default",
            alignments: []
        },
        templateInsertUpdatesSelection: true
    });
    // This is related to JustifyContentControl (see @import section above).
    var justifyControls = orientation === "vertical" ? [
        "left",
        "center",
        "right"
    ] : [
        "left",
        "center",
        "right",
        "space-between"
    ];
    return /*#__PURE__*/ React.createElement(React.Fragment, null, /*#__PURE__*/ React.createElement($e7ce011e45c0562f$exports.BlockControls, {
        group: "block"
    }, /*#__PURE__*/ React.createElement($e7ce011e45c0562f$exports.AlignmentToolbar, {
        value: contentJustification,
        onChange: function(value) {
            return setAttributes({
                contentJustification: value
            });
        }
    })), /*#__PURE__*/ React.createElement("div", innerBlocksProps));
}
var $15336f58a141421b$export$2e2bcd8739ae039 = $15336f58a141421b$var$NoticesEdit;





function $50afddccfd53c3ce$var$save(param) {
    var _attributes = param.attributes, contentJustification = _attributes.contentJustification, orientation = _attributes.orientation, className = param.className;
    var _obj;
    var noticesClassName = (/*@__PURE__*/$parcel$interopDefault($f86dd0ec9fb2fff3$exports))(className, "wpbf-block wpbf-block-notices", (_obj = {}, $af2a5c48ea008d99$export$2e2bcd8739ae039(_obj, "wpbf-content-justified-".concat(contentJustification), contentJustification), $af2a5c48ea008d99$export$2e2bcd8739ae039(_obj, "wpbf-is-vertical", orientation === "vertical"), _obj));
    return /*#__PURE__*/ React.createElement("div", $e7ce011e45c0562f$exports.useBlockProps.save({
        className: noticesClassName
    }), /*#__PURE__*/ React.createElement($e7ce011e45c0562f$exports.InnerBlocks.Content, null));
}
var $50afddccfd53c3ce$export$2e2bcd8739ae039 = $50afddccfd53c3ce$var$save;



var $27feda30590ffc61$var$variations = [
    {
        name: "notices-horizontal",
        isDefault: true,
        title: $c005a2da7048c8dc$exports.__("Horizontal", "page-builder-framework"),
        description: $c005a2da7048c8dc$exports.__("Notices shown in a row.", "page-builder-framework"),
        attributes: {
            orientation: "horizontal"
        },
        scope: [
            "transform"
        ]
    },
    {
        name: "notices-vertical",
        title: $c005a2da7048c8dc$exports.__("Vertical", "page-builder-framework"),
        description: $c005a2da7048c8dc$exports.__("Notices shown in a column.", "page-builder-framework"),
        attributes: {
            orientation: "vertical"
        },
        scope: [
            "transform"
        ]
    }, 
];
var $27feda30590ffc61$export$2e2bcd8739ae039 = $27feda30590ffc61$var$variations;


var $1656f198b0030fda$export$a8ff84c12d48cfa6 = (/*@__PURE__*/$parcel$interopDefault($b56520c6448058e4$exports)).name;
/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */ $025fe6f199ddaec3$exports.registerBlockType("wpbf/notices", {
    icon: 'info',
    example: {
        innerBlocks: [
            {
                name: "wpbf/notice",
                attributes: {
                    message: $c005a2da7048c8dc$exports.__("Sample of notice message", "page-builder-framework")
                }
            },
            {
                name: "wpbf/notice",
                attributes: {
                    message: $c005a2da7048c8dc$exports.__("Sample of success message", "page-builder-framework"),
                    typeClassName: "wpbf-notice-success"
                }
            },
            {
                name: "wpbf/notice",
                attributes: {
                    message: $c005a2da7048c8dc$exports.__("Sample of warning message", "page-builder-framework"),
                    typeClassName: "wpbf-notice-warning"
                }
            },
            {
                name: "wpbf/notice",
                attributes: {
                    message: $c005a2da7048c8dc$exports.__("Sample of error message", "page-builder-framework"),
                    typeClassName: "wpbf-notice-error"
                }
            }, 
        ]
    },
    /**
	 * @see ./transforms.js
	 */ transforms: $4ad015f3c8307374$export$2e2bcd8739ae039,
    /**
	 * @see ./edit.js
	 */ edit: $15336f58a141421b$export$2e2bcd8739ae039,
    /**
	 * @see ./save.js
	 */ save: $50afddccfd53c3ce$export$2e2bcd8739ae039,
    /**
	 * @see ./variations.js
	 */ variations: $27feda30590ffc61$export$2e2bcd8739ae039
});




})();
//# sourceMappingURL=wpbf-block-editor.js.map
