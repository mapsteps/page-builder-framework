/**
 * Customizer Controls Bundle
 *
 * This file imports all customizer control scripts to create a single bundled output.
 * This reduces HTTP requests from ~30+ individual files to just 1 bundled file.
 *
 * @package Wpbf
 */

// Base control (must be first - other controls depend on it)
import "../../Base/src/base-control";

// Responsive utilities (used by many controls)
import "../../Responsive/src/responsive-control";

// Individual controls (alphabetical order)
import "../../Checkbox/src/checkbox-control";
import "../../Color/src/color-control";
import "../../Dimension/src/dimension-control";
import "../../Editor/src/editor-control";

// Generic controls
import "../../Generic/src/generic-control";
import "../../Generic/src/assoc-array-control";
import "../../Generic/src/responsive-generic-control";

// More individual controls
import "../../MarginPadding/src/margin-padding-control";
import "../../Media/src/image-control";
import "../../Radio/src/radio-control";
import "../../Repeater/src/repeater-control";
import "../../Select/src/select-control";

// Slider controls
import "../../Slider/src/slider-control";
import "../../Slider/src/input-slider-control";
import "../../Slider/src/responsive-input-slider-control";

import "../../Sortable/src/sortable-control";
import "../../Typography/src/typography-control";

// Builder controls
import "../../Builder/src/builder-control";
import "../../Builder/src/responsive-builder-control";
