/**
 * Every control, panel and section type of the theme's Customizer, built into one script and one stylesheet
 * (Customizer/dist/customizer-controls-min.js / .css, handle 'wpbf-customizer-controls').
 *
 * The styles come first, in the order the separate stylesheets used to load, so the cascade stays the same. The scripts
 * follow in the order they used to run.
 */

// Styles.
import "../Controls/Base/src/base-control.scss";
import "../Controls/Responsive/src/responsive-control.scss";
import "../Controls/Tabs/src/section-tabs-control.scss";
import "../Controls/Headline/src/headline-control.scss";
import "../Controls/Color/src/color-control.scss";
import "../Controls/Dimension/src/dimension-control.scss";
import "../Controls/Checkbox/src/toggle-control.scss";
import "../Controls/Radio/src/radio-control.scss";
import "../Controls/Select/src/select-control.scss";
import "../Controls/Sortable/src/sortable-control.scss";
import "../Controls/Slider/src/slider-control.scss";
import "../Controls/MarginPadding/src/margin-padding-control.scss";
import "../Controls/Headline/src/headline-toggle-control.scss";
import "../Controls/Repeater/src/repeater-control.scss";
import "../Controls/Editor/src/editor-control.scss";
import "../Controls/Typography/src/typography-control.scss";
import "../Sections/src/section-types.scss";

// Scripts.
import "../Controls/Base/src/base-control";
import "../Controls/Tabs/src/section-tabs-control";
import "../Controls/Color/src/color-control";
import "../Controls/Media/src/image-control";
import "../Controls/Dimension/src/dimension-control";
import "../Controls/Checkbox/src/checkbox-control";
import "../Controls/Radio/src/radio-control";
import "../Controls/Select/src/select-control";
import "../Controls/Sortable/src/sortable-control";
import "../Controls/Slider/src/slider-control";
import "../Controls/MarginPadding/src/margin-padding-control";
import "../Controls/Generic/src/generic-control";
import "../Controls/Generic/src/assoc-array-control";
import "../Controls/Repeater/src/repeater-control";
import "../Controls/Editor/src/editor-control";
import "../Controls/Typography/src/typography-control";
import "../Panels/src/panel-types";
import "../Sections/src/section-types";
