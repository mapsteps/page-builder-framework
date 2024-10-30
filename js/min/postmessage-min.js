!function(o,n){if(!n)return;let e=window.WpbfTheme.breakpoints,t={tablet:"max-width: "+(e.desktop-1).toString()+"px",mobile:"max-width: "+(e.tablet-1).toString()+"px"};function i(o){if(!o)return!1;let n=String(o).match(/[a-z%]+$/i);return!!n&&n.length>0}function r(o){return o?o.replace(/\{site_url\}/g,window.WpbfObj.siteUrl):""}function c(o){let n=document.head.querySelector(`style[data-id="${o}"]`);if(n instanceof HTMLStyleElement)return n;let e=document.createElement("style");return e.dataset.id=o,e.className="wpbf-customize-live-style",document.head.append(e),e}function l(o,n,e,t){let i=Object.keys(window.WpbfTheme.breakpoints),r="";for(let o of i)t.hasOwnProperty(o)&&""!==t[o]&&(r+=`${n} {
				${"string"==typeof e?`${e}: ${t[o]};`:e.map(n=>`${n}: ${t[o]};`).join("\n")}
			}`);o.innerHTML=r}function u(o){n&&n(o.controlId,function(n){let e=c(o.controlId),t=["default","hover","active","focus"];n.bind(n=>{if(!n){e.innerHTML="";return}let i="";for(let e of t){if(!n.hasOwnProperty(e))continue;let t="default"===e?"":`:${e}`;if(e in n){if(!n[e])continue;i+=`
								${o.cssSelector}${t} {
									${"string"==typeof o.cssProps?`${o.cssProps}: ${n[e]};`:o.cssProps.map(o=>`${o}: ${n[e]};`).join("\n")}
								}
							`}}e.innerHTML=i})})}function b(o){n&&n(o.controlId,function(n){let e=c(o.controlId);n.bind(n=>{if("string"==typeof n){e.innerHTML="";return}let t={};for(let e in n){if(!n.hasOwnProperty(e)||""===n[e])continue;let r=o.useValueSuffix?i(n[e])?n[e]:n[e]+"px":n[e];t[e]=r}l(e,o.cssSelector,o.cssProps,t)})})}n("page_max_width",function(o){let n=c("page_max_width");o.bind(function(o){o=o||"1200px",n.innerHTML=".wpbf-container, .wpbf-boxed-layout .wpbf-page {max-width: "+o+";}"})}),n("page_padding",function(o){let n=c("page_padding");o.bind(function(o){let e=JSON.parse(o),i=e.desktop_top,r=e.desktop_right,c=e.desktop_bottom,l=e.desktop_left,u=e.tablet_top,b=e.tablet_right,m=e.tablet_bottom,_=e.tablet_left,a=e.mobile_top,d=e.mobile_right,p=e.mobile_bottom,f=e.mobile_left;n.innerHTML="				#inner-content {					padding-top: "+i+"px;					padding-right: "+r+"px;					padding-bottom: "+c+"px;					padding-left: "+l+"px;				}				@media ("+t.tablet+") {					#inner-content {						padding-top: "+u+"px;						padding-right: "+b+"px;						padding-bottom: "+m+"px;						padding-left: "+_+"px;					}				}				@media ("+t.mobile+") {					#inner-content {						padding-top: "+a+"px;						padding-right: "+d+"px;						padding-bottom: "+p+"px;						padding-left: "+f+"px;					}				}			"})}),n("page_boxed_margin",function(n){n.bind(function(n){o(".wpbf-page").css("margin-top",n+"px").css("margin-bottom",n+"px")})}),n("page_boxed_padding",function(o){let n=c("page_boxed_padding");o.bind(function(o){n.innerHTML=".wpbf-container {padding-left: "+o+"px; padding-right: "+o+"px;}"})}),n("page_boxed_background",function(o){let n=c("page_boxed_background");o.bind(function(o){n.innerHTML=".wpbf-page {background-color: "+o+";}"})}),n("scrolltop_position",function(o){let n=c("scrolltop_position");o.bind(function(o){"left"===o?n.innerHTML=".scrolltop {left: 20px; right: auto;}":n.innerHTML=".scrolltop {left: auto; right: 20px;}"})}),n("scrolltop_bg_color",function(o){let n=c("scrolltop_bg_color");o.bind(function(o){n.innerHTML=".scrolltop {background-color: "+o+";}"})}),n("scrolltop_bg_color_alt",function(o){let n=c("scrolltop_bg_color_alt");o.bind(function(o){n.innerHTML=".scrolltop:hover {background-color: "+o+";}"})}),n("scrolltop_icon_color",function(o){let n=c("scrolltop_icon_color");o.bind(function(o){n.innerHTML=".scrolltop {color: "+o+";}"})}),n("scrolltop_icon_color_alt",function(o){let n=c("scrolltop_icon_color_alt");o.bind(function(o){n.innerHTML=".scrolltop:hover {color: "+o+";}"})}),n("scrolltop_border_radius",function(o){let n=c("scrolltop_border_radius");o.bind(function(o){n.innerHTML=".scrolltop {border-radius: "+o+"px;}"})}),n("page_font_color",function(o){let n=c("page_font_color");o.bind(function(o){n.innerHTML="body {color: "+o+";}"})}),n("404_headline",function(n){n.bind(function(n){o(".wpbf-404-content .entry-title").text(n)})}),n("404_text",function(n){n.bind(function(n){o(".wpbf-404-content p").text(n)})}),n("menu_width",function(o){let n=c("menu_width");o.bind(function(o){o=o||"1200px",n.innerHTML=".wpbf-nav-wrapper {max-width: "+o+";}"})}),n("menu_height",function(o){let n=c("menu_height");o.bind(function(o){n.innerHTML=".wpbf-nav-wrapper {padding-top: "+o+"px; padding-bottom: "+o+"px;}"})}),n("menu_padding",function(o){let n=c("menu_padding");o.bind(function(o){n.innerHTML=".wpbf-navigation .wpbf-menu > .menu-item > a {padding-left: "+o+"px; padding-right: "+o+"px;}"})}),n("menu_bg_color",function(o){let n=c("menu_bg_color");o.bind(function(o){n.innerHTML=".wpbf-navigation:not(.wpbf-navigation-transparent):not(.wpbf-navigation-active) {background-color: "+o+";}"})}),n("menu_font_color",function(o){let n=c("menu_font_color");o.bind(function(o){n.innerHTML=".wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a, .wpbf-close {color: "+o+";}"})}),n("menu_font_color_alt",function(o){let n=c("menu_font_color_alt");o.bind(function(o){n.innerHTML="				.wpbf-navigation .wpbf-menu a:hover, .wpbf-mobile-menu a:hover {color: "+o+";}				.wpbf-navigation .wpbf-menu > .current-menu-item > a, .wpbf-mobile-menu > .current-menu-item > a {color: "+o+"!important;}			"})}),n("menu_font_size",function(n){let e=c("menu_font_size");n.bind(function(n){var t=o.isNumeric(n)?"px":"";e.innerHTML=".wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a {font-size: "+n+t+";}"})}),n("sub_menu_text_alignment",function(o){let n=c("sub_menu_text_alignment");o.bind(function(o){n.innerHTML="				.wpbf-sub-menu .sub-menu {					text-align: "+o+"				}			"})}),n("sub_menu_padding",function(o){let n=c("sub_menu_padding");o.bind(function(o){var e=JSON.parse(o),t=e.top,i=e.right,r=e.bottom,c=e.left;n.innerHTML="				.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu a {					padding-top: "+t+"px;					padding-right: "+i+"px;					padding-bottom: "+r+"px;					padding-left: "+c+"px;				}			"})}),n("sub_menu_width",function(o){let n=c("sub_menu_width");o.bind(function(o){n.innerHTML=".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu {width: "+o+"px;}"})}),n("sub_menu_bg_color",function(o){let n=c("sub_menu_bg_color");o.bind(function(o){n.innerHTML="				.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li,				.wpbf-sub-menu > .wpbf-mega-menu > .sub-menu {					background-color: "+o+";				}			"})}),n("sub_menu_bg_color_alt",function(o){let n=c("sub_menu_bg_color_alt");o.bind(function(o){n.innerHTML="				.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li:hover {					background-color: "+o+";				}			"})}),n("sub_menu_accent_color",function(o){let n=c("sub_menu_accent_color");o.bind(function(o){n.innerHTML=".wpbf-menu .sub-menu a {color: "+o+";}"})}),n("sub_menu_accent_color_alt",function(o){let n=c("sub_menu_accent_color_alt");o.bind(function(o){n.innerHTML=".wpbf-navigation .wpbf-menu .sub-menu a:hover {color: "+o+";}"})}),n("sub_menu_font_size",function(n){let e=c("sub_menu_font_size");n.bind(function(n){var t=o.isNumeric(n)?"px":"";e.innerHTML=".wpbf-menu .sub-menu a {font-size: "+n+t+";}"})}),n("sub_menu_separator_color",function(o){let n=c("sub_menu_separator_color");o.bind(function(o){n.innerHTML=".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) li {border-bottom-color: "+o+";}"})}),n("mobile_menu_height",function(o){let n=c("mobile_menu_height");o.bind(function(o){n.innerHTML=".wpbf-mobile-nav-wrapper {padding-top: "+o+"px; padding-bottom: "+o+"px;}"})}),n("mobile_menu_background_color",function(o){let n=c("mobile_menu_background_color");o.bind(function(o){n.innerHTML=".wpbf-mobile-nav-wrapper {background-color: "+o+";}"})}),n("mobile_menu_hamburger_color",function(o){let n=c("mobile_menu_hamburger_color");o.bind(function(o){n.innerHTML=".wpbf-mobile-nav-item, .wpbf-mobile-nav-item a {color: "+o+";}"})}),n("mobile_menu_hamburger_size",function(n){let e=c("mobile_menu_hamburger_size");n.bind(function(n){var t=o.isNumeric(n)?"px":"";e.innerHTML=".wpbf-mobile-nav-item {font-size: "+n+t+";}"})}),n("mobile_menu_hamburger_border_radius",function(o){let n=c("mobile_menu_hamburger_border_radius");o.bind(function(o){n.innerHTML=".wpbf-mobile-nav-item {border-radius: "+o+"px;}"})}),n("mobile_menu_padding",function(o){let n=c("mobile_menu_padding");o.bind(function(o){var e=JSON.parse(o),t=e.top,i=e.right,r=e.bottom,c=e.left;n.innerHTML="				.wpbf-mobile-menu a,				.wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle {					padding-top: "+t+"px;					padding-right: "+i+"px;					padding-bottom: "+r+"px;					padding-left: "+c+"px;				}			"})}),n("mobile_menu_bg_color",function(o){let n=c("mobile_menu_bg_color");o.bind(function(o){n.innerHTML=".wpbf-mobile-menu > .menu-item a {background-color: "+o+";}"})}),n("mobile_menu_bg_color_alt",function(o){let n=c("mobile_menu_bg_color_alt");o.bind(function(o){n.innerHTML=".wpbf-mobile-menu > .menu-item a:hover {background-color: "+o+";}"})}),n("mobile_menu_font_color",function(o){let n=c("mobile_menu_font_color");o.bind(function(o){n.innerHTML=".wpbf-mobile-menu a, .wpbf-mobile-menu-container .wpbf-close {color: "+o+";}"})}),n("mobile_menu_font_color_alt",function(o){let n=c("mobile_menu_font_color_alt");o.bind(function(o){n.innerHTML=".wpbf-mobile-menu a:hover, .wpbf-mobile-menu > .current-menu-item > a {color: "+o+"!important;}"})}),n("mobile_menu_border_color",function(o){let n=c("mobile_menu_border_color");o.bind(function(o){n.innerHTML="				.wpbf-mobile-menu .menu-item {border-top-color: "+o+";}				.wpbf-mobile-menu > .menu-item:last-child {border-bottom-color: "+o+";}			"})}),n("mobile_menu_submenu_arrow_color",function(o){let n=c("mobile_menu_submenu_arrow_color");o.bind(function(o){n.innerHTML=".wpbf-submenu-toggle {color: "+o+";}"})}),n("mobile_menu_font_size",function(n){let e=c("mobile_menu_font_size");n.bind(function(n){var t=o.isNumeric(n)?"px":"";e.innerHTML=".wpbf-mobile-menu a, .wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle {font-size: "+n+t+";}"})}),n("mobile_sub_menu_auto_collapse",function(n){n.bind(function(n){document.querySelector("#mobile-navigation")&&(n?o("#mobile-navigation").closest(".wpbf-navigation").addClass("wpbf-mobile-sub-menu-auto-collapse"):o("#mobile-navigation").closest(".wpbf-navigation").removeClass("wpbf-mobile-sub-menu-auto-collapse"))})}),n("mobile_sub_menu_indent",function(o){let e=c("mobile_sub_menu_indent");o.bind(function(o){var t=n("mobile_menu_padding").get();t=JSON.parse(t);var i=parseInt(o,10)+parseInt(t.left,10);e.innerHTML=".wpbf-mobile-menu .sub-menu a {padding-left: "+i+"px;}"})}),n("mobile_sub_menu_bg_color",function(o){let n=c("mobile_sub_menu_bg_color");o.bind(function(o){n.innerHTML=".wpbf-mobile-menu .sub-menu a {background-color: "+o+";}"})}),n("mobile_sub_menu_bg_color_alt",function(o){let n=c("mobile_sub_menu_bg_color_alt");o.bind(function(o){n.innerHTML=".wpbf-mobile-menu .sub-menu a:hover {background-color: "+o+";}"})}),n("mobile_sub_menu_font_color",function(o){let n=c("mobile_sub_menu_font_color");o.bind(function(o){n.innerHTML=".wpbf-mobile-menu .sub-menu a {color: "+o+";}"})}),n("mobile_sub_menu_font_color_alt",function(o){let n=c("mobile_sub_menu_font_color_alt");o.bind(function(o){n.innerHTML=".wpbf-mobile-menu .sub-menu a:hover, .wpbf-mobile-menu .sub-menu > .current-menu-item > a {color: "+o+"!important;}"})}),n("mobile_sub_menu_border_color",function(o){let n=c("mobile_sub_menu_border_color");o.bind(function(o){n.innerHTML=".wpbf-mobile-menu .sub-menu .menu-item {border-top-color: "+o+";}"})}),n("mobile_sub_menu_arrow_color",function(o){let n=c("mobile_sub_menu_arrow_color");o.bind(function(o){n.innerHTML=".wpbf-mobile-menu .sub-menu .wpbf-submenu-toggle {color: "+o+";}"})}),n("mobile_sub_menu_font_size",function(n){let e=c("mobile_sub_menu_font_size");n.bind(function(n){var t=o.isNumeric(n)?"px":"";e.innerHTML=".wpbf-mobile-menu .sub-menu a, .wpbf-mobile-menu .sub-menu .menu-item-has-children .wpbf-submenu-toggle {font-size: "+n+t+";}"})}),n("menu_logo_size",function(n){let e=c("menu_logo_size");n.bind(function(n){var i=JSON.parse(n),r=i.desktop,c=i.tablet,l=i.mobile,u=o.isNumeric(r)?"px":"",b=o.isNumeric(c)?"px":"",m=o.isNumeric(l)?"px":"";e.innerHTML="				.wpbf-logo img, .wpbf-mobile-logo img {					width: "+r+u+";				}				@media ("+t.tablet+") {					.wpbf-mobile-logo img {width: "+c+b+";}				}				@media ("+t.mobile+") {					.wpbf-mobile-logo img {width: "+l+m+";}				}			"})}),n("menu_logo_font_size",function(n){let e=c("menu_logo_font_size");n.bind(function(n){var i=JSON.parse(n),r=i.desktop,c=i.tablet,l=i.mobile,u=o.isNumeric(r)?"px":"",b=o.isNumeric(c)?"px":"",m=o.isNumeric(l)?"px":"";e.innerHTML="				.wpbf-logo a, .wpbf-mobile-logo a {					font-size: "+r+u+";				}				@media ("+t.tablet+") {					.wpbf-mobile-logo a {font-size: "+c+b+";}				}				@media ("+t.mobile+") {					.wpbf-mobile-logo a {font-size: "+l+m+";}				}			"})}),n("menu_logo_color",function(o){let n=c("menu_logo_color");o.bind(function(o){n.innerHTML=".wpbf-logo a, .wpbf-mobile-logo a {color: "+o+";}"})}),n("menu_logo_color_alt",function(o){let n=c("menu_logo_color_alt");o.bind(function(o){n.innerHTML=".wpbf-logo a:hover, .wpbf-mobile-logo a:hover {color: "+o+";}"})}),n("menu_logo_container_width",function(o){let n=c("menu_logo_container_width");o.bind(function(o){n.innerHTML="				.wpbf-navigation .wpbf-1-4 {width: "+o+"%;}				.wpbf-navigation .wpbf-3-4 {width: "+(100-o)+"%;}			"})}),n("mobile_menu_logo_container_width",function(o){let n=c("mobile_menu_logo_container_width");o.bind(function(o){n.innerHTML="				@media ("+t.tablet+") {					.wpbf-navigation .wpbf-2-3 {width: "+o+"%;}					.wpbf-navigation .wpbf-1-3 {width: "+(100-o)+"%;}				}			"})}),n("menu_logo_description_font_size",function(n){let e=c("menu_logo_description_font_size");n.bind(function(n){var i=JSON.parse(n),r=i.desktop,c=i.tablet,l=i.mobile,u=o.isNumeric(r)?"px":"",b=o.isNumeric(c)?"px":"",m=o.isNumeric(l)?"px":"";e.innerHTML="				.wpbf-logo .wpbf-tagline, .wpbf-mobile-logo .wpbf-tagline {					font-size: "+r+u+";				}				@media ("+t.tablet+") {					.wpbf-mobile-logo .wpbf-tagline {font-size: "+c+b+";}				}				@media ("+t.mobile+") {					.wpbf-mobile-logo .wpbf-tagline {font-size: "+l+m+";}				}			"})}),n("menu_logo_description_color",function(o){let n=c("menu_logo_description_color");o.bind(function(o){n.innerHTML=".wpbf-tagline {color: "+o+";}"})}),n("pre_header_width",function(o){let n=c("pre_header_width");o.bind(function(o){o=o||"1200px",n.innerHTML=".wpbf-inner-pre-header {max-width: "+o+";}"})}),n("pre_header_height",function(o){let n=c("pre_header_height");o.bind(function(o){n.innerHTML=".wpbf-inner-pre-header {padding-top: "+o+"px; padding-bottom: "+o+"px;}"})}),n("pre_header_bg_color",function(o){let n=c("pre_header_bg_color");o.bind(function(o){n.innerHTML=".wpbf-pre-header {background-color: "+o+";}"})}),n("pre_header_font_color",function(o){let n=c("pre_header_font_color");o.bind(function(o){n.innerHTML=".wpbf-pre-header {color: "+o+";}"})}),n("pre_header_accent_color",function(o){let n=c("pre_header_accent_color");o.bind(function(o){n.innerHTML=".wpbf-pre-header a {color: "+o+";}"})}),n("pre_header_accent_color_alt",function(o){let n=c("pre_header_accent_color_alt");o.bind(function(o){n.innerHTML=".wpbf-pre-header a:hover, .wpbf-pre-header .wpbf-menu > .current-menu-item > a {color: "+o+"!important;}"})}),n("pre_header_font_size",function(n){let e=c("pre_header_font_size");n.bind(function(n){var t=o.isNumeric(n)?"px":"";e.innerHTML="				.wpbf-pre-header,				.wpbf-pre-header .wpbf-menu,				.wpbf-pre-header .wpbf-menu .sub-menu a {					font-size: "+n+t+";				}			"})}),n("blog_pagination_border_radius",function(o){let n=c("blog_pagination_border_radius");o.bind(function(o){n.innerHTML=".pagination .page-numbers {border-radius: "+o+"px;}"})}),n("blog_pagination_background_color",function(o){let n=c("blog_pagination_background_color");o.bind(function(o){n.innerHTML=".pagination .page-numbers:not(.current) {background-color: "+o+";}"})}),n("blog_pagination_background_color_alt",function(o){let n=c("blog_pagination_background_color_alt");o.bind(function(o){n.innerHTML=".pagination .page-numbers:not(.current):hover {background-color: "+o+";}"})}),n("blog_pagination_background_color_active",function(o){let n=c("blog_pagination_background_color_active");o.bind(function(o){n.innerHTML=".pagination .page-numbers.current {background-color: "+o+";}"})}),n("blog_pagination_font_color",function(o){let n=c("blog_pagination_font_color");o.bind(function(o){n.innerHTML=".pagination .page-numbers:not(.current) {color: "+o+";}"})}),n("blog_pagination_font_color_alt",function(o){let n=c("blog_pagination_font_color_alt");o.bind(function(o){n.innerHTML=".pagination .page-numbers:not(.current):hover {color: "+o+";}"})}),n("blog_pagination_font_color_active",function(o){let n=c("blog_pagination_font_color_active");o.bind(function(o){n.innerHTML=".pagination .page-numbers.current {color: "+o+";}"})}),n("blog_pagination_font_size",function(n){let e=c("blog_pagination_font_size");n.bind(function(n){var t=o.isNumeric(n)?"px":"";e.innerHTML=".pagination .page-numbers {font-size: "+n+t+";}"})}),n("sidebar_width",function(o){let n=c("sidebar_width");o.bind(function(o){n.innerHTML="				@media (min-width: 769px) {					body:not(.wpbf-no-sidebar) .wpbf-sidebar-wrapper.wpbf-medium-1-3 {width: "+o+"%;}					body:not(.wpbf-no-sidebar) .wpbf-main.wpbf-medium-2-3 {width: "+(100-o)+"%;}				}			"})}),n("sidebar_bg_color",function(o){let n=c("sidebar_bg_color");o.bind(function(o){n.innerHTML=".wpbf-sidebar .widget, .elementor-widget-sidebar .widget {background-color: "+o+";}"})}),n("button_bg_color",function(o){let n=c("button_bg_color");o.bind(function(o){n.innerHTML='.wpbf-button:not(.wpbf-button-primary), input[type="submit"] {background-color: '+o+";}"})}),n("button_bg_color_alt",function(o){let n=c("button_bg_color_alt");o.bind(function(o){n.innerHTML='.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover {background-color: '+o+";}"})}),n("button_text_color",function(o){let n=c("button_text_color");o.bind(function(o){n.innerHTML='.wpbf-button:not(.wpbf-button-primary), input[type="submit"] {color: '+o+";}"})}),n("button_text_color_alt",function(o){let n=c("button_text_color_alt");o.bind(function(o){n.innerHTML='.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover {color: '+o+";}"})}),n("button_primary_bg_color",function(o){let n=c("button_primary_bg_color");o.bind(function(o){n.innerHTML="				.wpbf-button-primary {background-color: "+o+";}				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background) {background-color: "+o+";}				.is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background) {border-color: "+o+"; color: "+o+";}			"})}),n("button_primary_bg_color_alt",function(o){let n=c("button_primary_bg_color_alt");o.bind(function(o){n.innerHTML="				.wpbf-button-primary:hover {background-color: "+o+";}				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover {background-color: "+o+";}				.is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background):hover {border-color: "+o+"; color: "+o+";}			"})}),n("button_primary_text_color",function(o){let n=c("button_primary_text_color");o.bind(function(o){n.innerHTML="				.wpbf-button-primary {color: "+o+";}				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-text-color) {color: "+o+";}			"})}),n("button_primary_text_color_alt",function(o){let n=c("button_primary_text_color_alt");o.bind(function(o){n.innerHTML="				.wpbf-button-primary:hover {color: "+o+";}				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover {color: "+o+";}			"})}),n("button_border_radius",function(o){let n=c("button_border_radius");o.bind(function(o){n.innerHTML='.wpbf-button, input[type="submit"] {border-radius: '+o+"px;}"})}),n("button_border_width",function(o){let n=c("button_border_width");o.bind(function(o){n.innerHTML='.wpbf-button, input[type="submit"] {border-width: '+o+"px; border-style: solid;}"})}),n("button_border_color",function(o){let n=c("button_border_color");o.bind(function(o){n.innerHTML='.wpbf-button:not(.wpbf-button-primary), input[type="submit"] {border-color: '+o+";}"})}),n("button_border_color_alt",function(o){let n=c("button_border_color_alt");o.bind(function(o){n.innerHTML='.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover {border-color: '+o+";}"})}),n("button_primary_border_color",function(o){let n=c("button_primary_border_color");o.bind(function(o){n.innerHTML=".wpbf-button-primary {border-color: "+o+";}"})}),n("button_primary_border_color_alt",function(o){let n=c("button_primary_border_color_alt");o.bind(function(o){n.innerHTML=".wpbf-button-primary:hover {border-color: "+o+";}"})}),n("breadcrumbs_background_color",function(o){let n=c("breadcrumbs_background_color");o.bind(function(o){n.innerHTML=".wpbf-breadcrumbs-container {background-color: "+o+";}"})}),n("breadcrumbs_alignment",function(o){let n=c("breadcrumbs_alignment");o.bind(function(o){n.innerHTML=".wpbf-breadcrumbs-container {text-align: "+o+";}"})}),n("breadcrumbs_font_color",function(o){let n=c("breadcrumbs_font_color");o.bind(function(o){n.innerHTML=".wpbf-breadcrumbs {color: "+o+";}"})}),n("breadcrumbs_accent_color",function(o){let n=c("breadcrumbs_accent_color");o.bind(function(o){n.innerHTML=".wpbf-breadcrumbs a {color: "+o+";}"})}),n("breadcrumbs_accent_color_alt",function(o){let n=c("breadcrumbs_accent_color_alt");o.bind(function(o){n.innerHTML=".wpbf-breadcrumbs a:hover {color: "+o+";}"})}),n("footer_width",function(o){let n=c("footer_width");o.bind(function(o){o=o||"1200px",n.innerHTML=".wpbf-inner-footer {max-width: "+o+";}"})}),n("footer_height",function(o){let n=c("footer_height");o.bind(function(o){n.innerHTML=".wpbf-inner-footer {padding-top: "+o+"px; padding-bottom: "+o+"px;}"})}),n("footer_bg_color",function(o){let n=c("footer_bg_color");o.bind(function(o){n.innerHTML=".wpbf-page-footer {background-color: "+o+";}"})}),n("footer_font_color",function(o){let n=c("footer_font_color");o.bind(function(o){n.innerHTML=".wpbf-inner-footer {color: "+o+";}"})}),n("footer_accent_color",function(o){let n=c("footer_accent_color");o.bind(function(o){n.innerHTML=".wpbf-inner-footer a {color: "+o+";}"})}),n("footer_accent_color_alt",function(o){let n=c("footer_accent_color_alt");o.bind(function(o){n.innerHTML=".wpbf-inner-footer a:hover, .wpbf-inner-footer .wpbf-menu > .current-menu-item > a {color: "+o+";}"})}),n("footer_font_size",function(n){let e=c("footer_font_size");n.bind(function(n){var t=o.isNumeric(n)?"px":"";e.innerHTML=".wpbf-inner-footer, .wpbf-inner-footer .wpbf-menu {font-size: "+n+t+";}"})}),n("button_border_radius",function(o){let n=c("button_border_radius");o.bind(function(o){n.innerHTML=".woocommerce a.button, .woocommerce button.button {border-radius: "+o+"px;}"})}),n("woocommerce_loop_custom_width",function(o){let n=c("woocommerce_loop_custom_width");o.bind(function(o){o=o||"1200px",n.innerHTML=".archive.woocommerce #inner-content {max-width: "+o+";}"})}),n("woocommerce_menu_item_desktop_color",function(o){let n=c("woocommerce_menu_item_desktop_color");o.bind(function(o){n.innerHTML="				.wpbf-menu .wpbf-woo-menu-item .wpbf-woo-menu-item-count {background-color: "+o+";}			"})}),n("woocommerce_menu_item_mobile_color",function(o){let n=c("woocommerce_menu_item_mobile_color");o.bind(function(o){n.innerHTML="				.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count {background-color: "+o+";}			"})}),n("woocommerce_loop_content_alignment",function(o){let n=c("woocommerce_loop_content_alignment");o.bind(function(o){"center"===o?n.innerHTML="						.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {text-align: "+o+";}						.woocommerce .products .star-rating {margin: 0 auto 10px auto;}					":"right"===o?n.innerHTML="						.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {text-align: "+o+";}						.woocommerce .products .star-rating {display: inline-block; text-align: right;}					":n.innerHTML=".woocommerce ul.products li.product, .woocommerce-page ul.products li.product {text-align: "+o+";}"})}),n("woocommerce_loop_image_alignment",function(o){let n=c("woocommerce_loop_image_alignment");o.bind(function(o){"left"==o?n.innerHTML="					.wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper {float: left;}					.wpbf-woo-list-view .wpbf-woo-loop-summary {float: right;}				":n.innerHTML="					.wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper {float: right;}					.wpbf-woo-list-view .wpbf-woo-loop-summary {float: left;}				"})}),n("woocommerce_loop_image_width",function(o){let n=c("woocommerce_loop_image_width");o.bind(function(o){n.innerHTML="				.wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper {width: "+(o-2)+"%;}				.wpbf-woo-list-view .wpbf-woo-loop-summary {width: "+(98-o)+"%;}			"})}),n("woocommerce_loop_title_size",function(n){let e=c("woocommerce_loop_title_size");n.bind(function(n){var t=o.isNumeric(n)?"px":"";e.innerHTML="				.woocommerce ul.products li.product h3,				.woocommerce ul.products li.product .woocommerce-loop-product__title,				.woocommerce ul.products li.product .woocommerce-loop-category__title {					font-size: "+n+t+";				}			"})}),n("woocommerce_loop_title_color",function(o){let n=c("woocommerce_loop_title_color");o.bind(function(o){n.innerHTML="				.woocommerce ul.products li.product h3,				.woocommerce ul.products li.product .woocommerce-loop-product__title,				.woocommerce ul.products li.product .woocommerce-loop-category__title {					color: "+o+";				}			"})}),n("woocommerce_loop_price_size",function(n){let e=c("woocommerce_loop_price_size");n.bind(function(n){var t=o.isNumeric(n)?"px":"";e.innerHTML=".woocommerce ul.products li.product .price {font-size: "+n+t+";}"})}),n("woocommerce_loop_price_color",function(o){let n=c("woocommerce_loop_price_color");o.bind(function(o){n.innerHTML=".woocommerce ul.products li.product .price {color: "+o+";}"})}),n("woocommerce_loop_out_of_stock_font_size",function(n){let e=c("woocommerce_loop_out_of_stock_font_size");n.bind(function(n){var t=o.isNumeric(n)?"px":"";e.innerHTML=".woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock {font-size: "+n+t+";}"})}),n("woocommerce_loop_out_of_stock_font_color",function(o){let n=c("woocommerce_loop_out_of_stock_font_color");o.bind(function(o){n.innerHTML=".woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock {color: "+o+";}"})}),n("woocommerce_loop_out_of_stock_background_color",function(o){let n=c("woocommerce_loop_out_of_stock_background_color");o.bind(function(o){n.innerHTML=".woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock {background-color: "+o+";}"})}),n("woocommerce_loop_sale_font_size",function(n){let e=c("woocommerce_loop_sale_font_size");n.bind(function(n){var t=o.isNumeric(n)?"px":"";e.innerHTML=".woocommerce span.onsale {font-size: "+n+t+";}"})}),n("woocommerce_loop_sale_font_color",function(o){let n=c("woocommerce_loop_sale_font_color");o.bind(function(o){n.innerHTML=".woocommerce span.onsale {color: "+o+";}"})}),n("woocommerce_loop_sale_background_color",function(o){let n=c("woocommerce_loop_sale_background_color");o.bind(function(o){n.innerHTML=".woocommerce span.onsale {background-color: "+o+";}"})}),n("woocommerce_single_custom_width",function(o){let n=c("woocommerce_single_custom_width");o.bind(function(o){o=o||"1200px",n.innerHTML=".single.woocommerce #inner-content {max-width: "+o+";}"})}),n("woocommerce_single_alignment",function(o){let n=c("woocommerce_single_alignment");o.bind(function(o){"right"===o?n.innerHTML="					.woocommerce div.product div.summary,					.woocommerce #content div.product div.summary,					.woocommerce-page div.product div.summary,					.woocommerce-page #content div.product div.summary {float: left;}										.woocommerce div.product div.images,					.woocommerce #content div.product div.images,					.woocommerce-page div.product div.images,					.woocommerce-page #content div.product div.images {float: right;}										.single-product.woocommerce span.onsale {display: none;}				":n.innerHTML="					.woocommerce div.product div.summary,					.woocommerce #content div.product div.summary,					.woocommerce-page div.product div.summary,					.woocommerce-page #content div.product div.summary {float: right;}										.woocommerce div.product div.images,					.woocommerce #content div.product div.images,					.woocommerce-page div.product div.images,					.woocommerce-page #content div.product div.images {float: left;}										.single-product.woocommerce span.onsale {display: block;}				"})}),n("woocommerce_single_image_width",function(o){let n=c("woocommerce_single_image_width");o.bind(function(o){n.innerHTML="				.woocommerce div.product div.images,				.woocommerce #content div.product div.images,				.woocommerce-page div.product div.images,				.woocommerce-page #content div.product div.images {width: "+(o-2)+"%;}								.woocommerce div.product div.summary,				.woocommerce #content div.product div.summary,				.woocommerce-page div.product div.summary,				.woocommerce-page #content div.product div.summary {width: "+(98-o)+"%;}			"})}),n("woocommerce_single_price_size",function(n){let e=c("woocommerce_single_price_size");n.bind(function(n){var t=o.isNumeric(n)?"px":"";e.innerHTML=".woocommerce div.product span.price, .woocommerce div.product p.price {font-size: "+n+t+";}"})}),n("woocommerce_single_price_color",function(o){let n=c("woocommerce_single_price_color");o.bind(function(o){n.innerHTML=".woocommerce div.product span.price, .woocommerce div.product p.price {color: "+o+";}"})}),n("woocommerce_single_tabs_background_color",function(o){let n=c("woocommerce_single_tabs_background_color");o.bind(function(o){n.innerHTML=".woocommerce div.product .woocommerce-tabs ul.tabs li {background-color: "+o+";}"})}),n("woocommerce_single_tabs_background_color_alt",function(o){let n=c("woocommerce_single_tabs_background_color_alt");o.bind(function(o){n.innerHTML=".woocommerce div.product .woocommerce-tabs ul.tabs li:hover {background-color: "+o+"; border-bottom-color: "+o+";}"})}),n("woocommerce_single_tabs_background_color_active",function(o){let n=c("woocommerce_single_tabs_background_color_active");o.bind(function(o){n.innerHTML=".woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce div.product .woocommerce-tabs ul.tabs li.active:hover {background-color: "+o+"; border-bottom-color: "+o+";}"})}),n("woocommerce_single_tabs_font_color",function(o){let n=c("woocommerce_single_tabs_font_color");o.bind(function(o){n.innerHTML=".woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a {color: "+o+";}"})}),n("woocommerce_single_tabs_font_color_alt",function(o){let n=c("woocommerce_single_tabs_font_color_alt");o.bind(function(o){n.innerHTML=".woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a:hover {color: "+o+";}"})}),n("woocommerce_single_tabs_font_color_active",function(o){let n=c("woocommerce_single_tabs_font_color_active");o.bind(function(o){n.innerHTML=".woocommerce div.product .woocommerce-tabs ul.tabs li.active a {color: "+o+";}"})}),n("woocommerce_info_notice_color",function(o){let n=c("woocommerce_info_notice_color");o.bind(function(o){n.innerHTML="				.woocommerce-info {border-top-color: "+o+";}				.woocommerce-info:before, .woocommerce-info a {color: "+o+"}			"})}),n("woocommerce_message_notice_color",function(o){let n=c("woocommerce_message_notice_color");o.bind(function(o){n.innerHTML="				.woocommerce-message {border-top-color: "+o+";}				.woocommerce-message:before, .woocommerce-message a {color: "+o+"}			"})}),n("woocommerce_error_notice_color",function(o){let n=c("woocommerce_error_notice_color");o.bind(function(o){n.innerHTML="				.woocommerce-error {border-top-color: "+o+";}				.woocommerce-error:before, .woocommerce-error a {color: "+o+"}			"})}),n("woocommerce_notice_bg_color",function(o){let n=c("woocommerce_notice_bg_color");o.bind(function(o){n.innerHTML=".woocommerce-message {background-color: "+o+";}"})}),n("woocommerce_notice_text_color",function(o){let n=c("woocommerce_notice_text_color");o.bind(function(o){n.innerHTML=".woocommerce-message {color: "+o+";}"})}),n("woocommerce_single_tabs_font_size",function(n){let e=c("woocommerce_single_tabs_font_size");n.bind(function(n){let t=o.isNumeric(n)?"px":"";e.innerHTML=".woocommerce div.product .woocommerce-tabs ul.tabs li a {font-size: "+n+t+";}"})}),n("edd_menu_item_desktop_color",function(o){let n=c("edd_menu_item_desktop_color");o.bind(function(o){n.innerHTML="				.wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count {background-color: "+o+";}			"})}),n("edd_menu_item_mobile_color",function(o){let n=c("edd_menu_item_mobile_color");o.bind(function(o){n.innerHTML="				.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count {background-color: "+o+";}			"})}),n("button_border_radius",function(o){let n=c("button_border_radius");o.bind(function(o){n.innerHTML=".edd-submit.button {border-radius: "+o+"px;}"})}),["row_1","row_2","row_3"].forEach(o=>{let e=`wpbf_header_builder_${o}_`;if(n(`${e}visibility`,function(n){let e=["large","medium","small"];n.bind(function(n){if(!n||!Array.isArray(n))return;let t=document.querySelector(`.wpbf-header-row-${o}`);t&&e.forEach(function(o){n.includes(o)?t.classList.remove(`wpbf-hidden-${o}`):t.classList.add(`wpbf-hidden-${o}`)})})}),"row_1"!==o){n(`${e}use_container`,function(n){n.bind(function(n){let e=document.querySelector(`.wpbf-header-row-${o}`);if(!e)return;let t=e.querySelector(`.wpbf-header-row-${o} .wpbf-row-content`);if(!t)return;let i=t.parentElement;if(i){if(n){if(!i.classList.contains("wpbf-container")){let o=document.createElement("div");o.classList.add("wpbf-container","wpbf-container-center"),o.appendChild(t),i.appendChild(o)}}else if(i.classList.contains("wpbf-container-center")){let o=i.children;for(let n=0;n<o.length;n++){let t=o[n];e.appendChild(t)}i.remove()}}})});let t=`${e}min_height`;n(t,function(n){let e=c(t),r=`.wpbf-header-row-${o} .wpbf-row-content`;n.bind(function(o){l(e,r,"min-height",i(o)?o:o+"px")})});let r=`${e}vertical_padding`;n(r,function(n){let e=c(r),t=`.wpbf-header-row-${o} .wpbf-row-content`;n.bind(function(o){l(e,t,["padding-top","padding-bottom"],o)})});let u=`${e}bg_color`;n(u,function(n){let e=c(u),t=`.wpbf-header-row-${o}`;n.bind(function(o){if(!o){e.innerHTML="";return}!function(o,n,e,t){for(let i of(o.innerHTML=n+"{",e))o.innerHTML+=i+": "+t+";";o.innerHTML+="}"}(e,t,["background-color"],o)})})}let t=`${e}text_color`;n(t,function(n){let e=c(t);n.bind(function(n){n&&(e.innerHTML=`
				.wpbf-header-row-${o} {
					color: ${n};
				}
				`)})})}),["button_1","button_2"].forEach(o=>{let e=`wpbf_header_builder_${o}`;n(e+"_new_tab",function(o){o.bind(o=>{let n=document.querySelector(`.wpbf-button.${e}`);n instanceof HTMLAnchorElement&&(o?n.target="_blank":n.removeAttribute("target"))})}),n(e+"_text",function(o){o.bind(o=>{let n=document.querySelector(`.wpbf-button.${e}`);n instanceof HTMLAnchorElement&&(n.innerHTML=r(o))})}),n(e+"_url",function(o){o.bind(o=>{let n=document.querySelector(`.wpbf-button.${e}`);n instanceof HTMLAnchorElement&&(n.href=r(o))})}),n(e+"_rel",function(o){o.bind(o=>{let n=document.querySelector(`.wpbf-button.${e}`);n instanceof HTMLAnchorElement&&(Array.isArray(o)&&o.length?n.rel=o.join(" "):n.removeAttribute("rel"))})}),n(e+"_size",function(o){o.bind(o=>{let n=document.querySelector(`.wpbf-button.${e}`);n instanceof HTMLAnchorElement&&(n.classList.remove("wpbf-button-small"),n.classList.remove("wpbf-button-large"),"small"===o?n.classList.add("wpbf-button-small"):"large"===o&&n.classList.add("wpbf-button-large"))})}),b({controlId:`${e}_border_radius`,cssSelector:`.wpbf-button.${e}`,cssProps:"border-radius",useValueSuffix:!0}),b({controlId:`${e}_border_width`,cssSelector:`.wpbf-button.${e}`,cssProps:"border-width",useValueSuffix:!0}),n(`${e}_border_style`,function(o){let n=c(e);o.bind(function(o){n.innerHTML=`.wpbf-button.${e} {
						border-style: ${o};
					}`})}),u({controlId:`${e}_border_color`,cssSelector:`.wpbf-button.${e}`,cssProps:"border-color"}),u({controlId:`${e}_bg_color`,cssSelector:`.wpbf-button.${e}`,cssProps:"background-color"}),u({controlId:`${e}_text_color`,cssSelector:`.wpbf-button.${e}`,cssProps:"color"})})}(jQuery,window.wp.customize);
//# sourceMappingURL=postmessage-min.js.map
