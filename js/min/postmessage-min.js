!function(){function o(o){if(""!==o&&o){if("string"!=typeof o)return o;try{return JSON.parse(o)}catch(o){return}}}!function(e,t){let r=window.WpbfTheme.breakpoints,n={tablet:"max-width: "+(r.desktop-1).toString()+"px",mobile:"max-width: "+(r.tablet-1).toString()+"px"};function c(o){return"number"==typeof o?o:""===o?0:parseFloat(o)}function p(o){return"0"!==o&&0!==o&&!o}function i(o){if(!o)return!1;let e=String(o).match(/[a-z%]+$/i);return!!e&&e.length>0}function l(o,e){if(void 0!==o&&""!==o&&null!==o)return e=e||"px",i(o)?o:o+e}function s(o){if(""===o||"number"==typeof o)return;if("string"==typeof o)return o;if(!("r"in o))return;let e="a"in o?o.a:1;return e&&e<1?`rgba(${o.r}, ${o.g}, ${o.b}, ${e})`:`rgb(${o.r}, ${o.g}, ${o.b})`}function u(o){return o?o.replace(/\{site_url\}/g,window.WpbfObj.siteUrl):""}function b(){return!!t?.("wpbf_enable_header_builder").get()}function m(o){let e=document.head.querySelector(`style[data-id="${o}"]`);if(e instanceof HTMLStyleElement)return e;let t=document.createElement("style");return t.dataset.id=o,t.className="wpbf-customize-live-style",document.head.append(t),t}function a(o,e){let t="string"==typeof o?m(o):o,r=e.blocks&&Array.isArray(e.blocks)?e.blocks:[],n=e.selector||"";if(!r.length&&!n)return;let c=e.mediaQuery||"",p="";if(r.length){c&&(p+=`${c} {`),r.forEach(o=>{let e=o.selector,t=o.props;if(e&&t&&Object.keys(t).length){for(let[o,r]of(p+=`${e} {`,Object.entries(t)))o&&null!=r&&(p+=`${o}: ${r};`);p+="}"}}),c&&(p+="}"),t.innerHTML=p;return}let i=e.props;if(i&&Object.keys(i).length){for(let[o,e]of(p="",c&&(p+=`${c} {`),p+=`${n} {`,Object.entries(i)))o&&null!=e&&(p+=`${o}: ${e};`);p+="}",c&&(p+="}"),t.innerHTML=p}}function f(o,e){t?.(o,function(t){t.bind(function(t){e(o,t)})})}function d(o){t?.(o.controlId,function(e){let t=m(o.controlId),r=["default","hover","active","focus"];e.bind(e=>{if(!e){t.innerHTML="";return}let n="";for(let t of r){if(!e.hasOwnProperty(t))continue;let r="default"===t?"":`:${t}`;if(t in e){if(!e[t])continue;n+=`
								${o.cssSelector}${r} {
									${"string"==typeof o.cssProps?`${o.cssProps}: ${e[t]};`:o.cssProps.map(o=>`${o}: ${e[t]};`).join("\n")}
								}
							`}}t.innerHTML=n})})}function _(o){t?.(o.controlId,function(e){let t=m(o.controlId);e.bind(e=>{if("string"==typeof e){t.innerHTML="";return}let r={};for(let t in e){if(!e.hasOwnProperty(t)||""===e[t])continue;let n=o.useValueSuffix?i(e[t])?e[t]:e[t]+"px":e[t];r[t]=n}!function(o,e,t,r){let n="string"==typeof o?m(o):o,c=Object.keys(window.WpbfTheme.breakpoints),p="";for(let o of c)r.hasOwnProperty(o)&&""!==r[o]&&(p+=`${e} {
				${"string"==typeof t?`${t}: ${r[o]};`:t.map(e=>`${e}: ${r[o]};`).join("\n")}
			}`);n.innerHTML=p}(t,o.cssSelector,o.cssProps,r)})})}f("page_max_width",function(o,e){a(o,{selector:".wpbf-container, .wpbf-boxed-layout .wpbf-page",props:{"max-width":l(e=p(e)?"1200px":e)}})}),f("page_padding",function(e,t){let r=o(t);a(e+"-desktop",{selector:"#inner-content",props:{"padding-top":l(r?.desktop_top),"padding-right":l(r?.desktop_right),"padding-bottom":l(r?.desktop_bottom),"padding-left":l(r?.desktop_left)}}),a(e+"-tablet",{mediaQuery:`@media (${n.tablet})`,selector:"#inner-content",props:{"padding-top":l(r?.tablet_top),"padding-right":l(r?.tablet_right),"padding-bottom":l(r?.tablet_bottom),"padding-left":l(r?.tablet_left)}}),a(e+"-mobile",{mediaQuery:`@media (${n.mobile})`,selector:"#inner-content",props:{"padding-top":l(r?.mobile_top),"padding-right":l(r?.mobile_right),"padding-bottom":l(r?.mobile_bottom),"padding-left":l(r?.mobile_left)}})}),f("page_boxed_margin",function(o,t){e(".wpbf-page").css("margin-top",t+"px").css("margin-bottom",t+"px")}),f("page_boxed_padding",function(o,e){a(o,{selector:".wpbf-container",props:{"padding-left":l(e),"padding-right":l(e)}})}),f("page_boxed_background",function(o,e){a(o,{selector:".wpbf-page",props:{"background-color":s(e)}})}),f("scrolltop_position",function(o,e){a(o,{selector:".scrolltop",props:{left:"left"===e?"20px":"auto",right:"left"===e?"auto":"20px"}})}),f("scrolltop_bg_color",function(o,e){a(o,{selector:".scrolltop",props:{"background-color":s(e)}})}),f("scrolltop_bg_color_alt",function(o,e){a(o,{selector:".scrolltop:hover",props:{"background-color":s(e)}})}),f("scrolltop_icon_color",function(o,e){a(o,{selector:".scrolltop",props:{color:s(e)}})}),f("scrolltop_icon_color_alt",function(o,e){a(o,{selector:".scrolltop:hover",props:{color:s(e)}})}),f("scrolltop_border_radius",function(o,e){a(o,{selector:".scrolltop",props:{borderRadius:l(e)}})}),f("page_font_color",function(o,e){a(o,{selector:"body",props:{color:s(e)}})}),f("404_headline",function(o,t){e(".wpbf-404-content .entry-title").text(t)}),f("404_text",function(o,t){e(".wpbf-404-content p").text(t)}),f("menu_width",function(o,e){a(o,{selector:b()?".wpbf-header-row-desktop_row_2 .wpbf-container":".wpbf-nav-wrapper",props:{"max-width":l(e)}})}),f("menu_height",function(o,e){a(o,{selector:b()?".wpbf-header-row-desktop_row_2":".wpbf-nav-wrapper",props:{"padding-top":l(e),"padding-bottom":l(e)}})}),f("menu_padding",function(o,e){a(o,{selector:".wpbf-navigation .wpbf-menu > .menu-item > a",props:{"padding-left":l(e),"padding-right":l(e)}})}),f("menu_bg_color",function(o,e){a(o,{selector:".wpbf-navigation:not(.wpbf-navigation-transparent):not(.wpbf-navigation-active)",props:{"background-color":s(e)}})}),f("menu_font_colors",(o,e)=>{let t=s(e.default??""),r=s(e.hover??"");a(o,{blocks:[{selector:".wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a, .wpbf-close",props:{color:t}},{selector:".wpbf-navigation .wpbf-menu a:hover, .wpbf-mobile-menu a:hover",props:{color:r}},{selector:".wpbf-navigation .wpbf-menu > .current-menu-item > a, .wpbf-mobile-menu > .current-menu-item > a",props:{color:`${r}!important`}}]})}),f("menu_font_size",function(o,e){a(o,{selector:".wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a",props:{fontSize:l(e)}})}),f("sub_menu_text_alignment",function(o,e){a(o,{selector:".wpbf-sub-menu .sub-menu",props:{"text-align":e}})}),f("sub_menu_padding",function(e,t){let r=o(t);a(e,{selector:".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu a",props:{"padding-top":l(r?.top),"padding-right":l(r?.right),"padding-bottom":l(r?.bottom),"padding-left":l(r?.left)}})}),f("sub_menu_width",function(o,e){a(o,{selector:".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu",props:{width:l(e)}})}),f("sub_menu_bg_color",function(o,e){a(o,{selector:".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li",props:{"background-color":s(e)}})}),f("sub_menu_bg_color_alt",function(o,e){a(o,{selector:".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li:hover",props:{"background-color":s(e)}})}),f("sub_menu_accent_color",function(o,e){a(o,{selector:".wpbf-menu .sub-menu a",props:{color:s(e)}})}),f("sub_menu_accent_color_alt",function(o,e){a(o,{selector:".wpbf-navigation .wpbf-menu .sub-menu a:hover",props:{color:s(e)}})}),f("sub_menu_font_size",function(o,e){a(o,{selector:".wpbf-menu .sub-menu a",props:{"font-size":l(e)}})}),f("sub_menu_separator_color",function(o,e){a(o,{selector:".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) li",props:{"border-bottom-color":s(e)}})}),f("mobile_menu_height",function(o,e){a(o,{selector:".wpbf-mobile-nav-wrapper",props:{"padding-top":l(e),"padding-bottom":l(e)}})}),f("mobile_menu_background_color",function(o,e){a(o,{selector:".wpbf-mobile-nav-wrapper",props:{"background-color":s(e)}})}),f("mobile_menu_hamburger_color",function(o,e){a(o,{selector:".wpbf-mobile-nav-item, .wpbf-mobile-nav-item a",props:{color:s(e)}})}),f("mobile_menu_hamburger_size",function(o,e){a(o,{selector:".wpbf-mobile-nav-item",props:{"font-size":l(e)}})}),f("mobile_menu_hamburger_bg_color",function(o,e){if(!e){!function(o){let e=document.querySelector(`style[data-id="${o}"]`);e?.remove()}(o);return}let r=t?.("mobile_menu_hamburger_border_radius").get();a(o,{selector:".wpbf-mobile-menu-toggle",props:{"background-color":s(e),color:"#ffffff !important",padding:"10px","line-height":1,"border-radius":p(r)?void 0:l(r)}})}),f("mobile_menu_hamburger_border_radius",function(o,e){a(o,{selector:".wpbf-mobile-menu-toggle",props:{"border-radius":l(e)}})}),f("mobile_menu_padding",function(e,t){let r=o(t);a(e,{selector:".wpbf-mobile-menu a, .wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle",props:{"padding-top":l(r?.top),"padding-right":l(r?.right),"padding-bottom":l(r?.bottom),"padding-left":l(r?.left)}})}),f("mobile_menu_bg_color",function(o,e){a(o,{selector:".wpbf-mobile-menu > .menu-item a",props:{"background-color":s(e)}})}),f("mobile_menu_bg_color_alt",function(o,e){a(o,{selector:".wpbf-mobile-menu > .menu-item a:hover",props:{"background-color":s(e)}})}),f("mobile_menu_font_color",function(o,e){a(o,{selector:".wpbf-mobile-menu a, .wpbf-mobile-menu-container .wpbf-close",props:{color:s(e)}})}),f("mobile_menu_font_color_alt",function(o,e){a(o,{selector:".wpbf-mobile-menu a:hover, .wpbf-mobile-menu > .current-menu-item > a",props:{color:s(e)+"!important"}})}),f("mobile_menu_border_color",function(o,e){a(o,{blocks:[{selector:".wpbf-mobile-menu .menu-item",props:{"border-top-color":s(e)}},{selector:".wpbf-mobile-menu > .menu-item:last-child",props:{"border-bottom-color":s(e)}}]})}),f("mobile_menu_submenu_arrow_color",function(o,e){a(o,{selector:".wpbf-submenu-toggle",props:{color:s(e)}})}),f("mobile_menu_font_size",function(o,e){a(o,{selector:".wpbf-mobile-menu a, .wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle",props:{"font-size":l(e)}})}),f("mobile_sub_menu_auto_collapse",function(o,t){document.querySelector("#mobile-navigation")&&(t?e("#mobile-navigation").closest(".wpbf-navigation").addClass("wpbf-mobile-sub-menu-auto-collapse"):e("#mobile-navigation").closest(".wpbf-navigation").removeClass("wpbf-mobile-sub-menu-auto-collapse"))}),f("mobile_sub_menu_indent",function(e,r){let n=o(t?.("mobile_menu_padding").get()),c=String(n?.left??0);a(e,{selector:".wpbf-mobile-menu .sub-menu a",props:{"padding-left":l(parseInt(String(r),10)+parseInt(c,10))}})}),f("mobile_sub_menu_bg_color",function(o,e){a(o,{selector:".wpbf-mobile-menu .sub-menu a",props:{"background-color":s(e)}})}),f("mobile_sub_menu_bg_color_alt",function(o,e){a(o,{selector:".wpbf-mobile-menu .sub-menu a:hover",props:{"background-color":s(e)}})}),f("mobile_sub_menu_font_color",function(o,e){a(o,{selector:".wpbf-mobile-menu .sub-menu a",props:{color:s(e)}})}),f("mobile_sub_menu_font_color_alt",function(o,e){a(o,{selector:".wpbf-mobile-menu .sub-menu a:hover, .wpbf-mobile-menu .sub-menu > .current-menu-item > a",props:{color:s(e)+"!important"}})}),f("mobile_sub_menu_border_color",function(o,e){a(o,{selector:".wpbf-mobile-menu .sub-menu .menu-item",props:{"border-top-color":s(e)}})}),f("mobile_sub_menu_arrow_color",function(o,e){a(o,{selector:".wpbf-mobile-menu .sub-menu .wpbf-submenu-toggle",props:{color:s(e)}})}),f("mobile_sub_menu_font_size",function(o,e){a(o,{selector:".wpbf-mobile-menu .sub-menu a, .wpbf-mobile-menu .sub-menu .menu-item-has-children .wpbf-submenu-toggle",props:{"font-size":l(e)}})}),f("menu_logo_size",function(e,t){let r=o(t);a(e+"-desktop",{selector:".wpbf-logo img, .wpbf-mobile-logo img",props:{width:l(r?.desktop)}}),a(e+"-tablet",{mediaQuery:`@media (${n.tablet})`,selector:".wpbf-mobile-logo img",props:{width:l(r?.tablet)}}),a(e+"-mobile",{mediaQuery:`@media (${n.mobile})`,selector:".wpbf-mobile-logo img",props:{width:l(r?.mobile)}})}),f("menu_logo_font_size",function(e,t){let r=o(t);a(e+"-desktop",{selector:".wpbf-logo a, .wpbf-mobile-logo a",props:{"font-size":l(r?.desktop)}}),a(e+"-tablet",{mediaQuery:`@media (${n.tablet})`,selector:".wpbf-mobile-logo a",props:{"font-size":l(r?.tablet)}}),a(e+"-mobile",{mediaQuery:`@media (${n.mobile})`,selector:".wpbf-mobile-logo a",props:{"font-size":l(r?.mobile)}})}),f("menu_logo_color",function(o,e){a(o,{selector:".wpbf-logo a, .wpbf-mobile-logo a",props:{color:s(e)}})}),f("menu_logo_color_alt",function(o,e){a(o,{selector:".wpbf-logo a:hover, .wpbf-mobile-logo a:hover",props:{color:s(e)}})}),f("menu_logo_container_width",function(o,e){let t=100-c(e);a(o,{blocks:[{selector:".wpbf-navigation .wpbf-1-4",props:{width:l(e,"%")}},{selector:".wpbf-navigation .wpbf-3-4",props:{width:l(t,"%")}}]})}),f("mobile_menu_logo_container_width",function(o,e){let t=100-c(e);a(o,{mediaQuery:`@media (${n.tablet})`,blocks:[{selector:".wpbf-navigation .wpbf-2-3",props:{width:l(e,"%")}},{selector:".wpbf-navigation .wpbf-1-3",props:{width:l(t,"%")}}]})}),f("menu_logo_description_font_size",function(e,t){let r=o(t);a(e+"-desktop",{selector:".wpbf-logo .wpbf-tagline, .wpbf-mobile-logo .wpbf-tagline",props:{"font-size":l(r?.desktop)}}),a(e+"-tablet",{mediaQuery:`@media (${n.tablet})`,selector:".wpbf-mobile-logo .wpbf-tagline",props:{"font-size":l(r?.tablet)}}),a(e+"-mobile",{mediaQuery:`@media (${n.mobile})`,selector:".wpbf-mobile-logo .wpbf-tagline",props:{"font-size":l(r?.mobile)}})}),f("menu_logo_description_color",function(o,e){a(o,{selector:".wpbf-tagline",props:{color:s(e)}})}),f("pre_header_width",function(o,e){a(o,{selector:".wpbf-inner-pre-header",props:{"max-width":l(e=p(e)?"1200px":e)}})}),f("pre_header_height",function(o,e){a(o,{selector:".wpbf-inner-pre-header",props:{"padding-top":l(e),"padding-bottom":l(e)}})}),f("pre_header_bg_color",function(o,e){a(o,{selector:".wpbf-pre-header",props:{"background-color":s(e)}})}),f("pre_header_font_color",function(o,e){a(o,{selector:".wpbf-pre-header",props:{color:s(e)}})}),f("pre_header_accent_colors",(o,e)=>{let t=s(e.default??""),r=s(e.hover??"");a(o,{blocks:[{selector:".wpbf-pre-header a",props:{color:t}},{selector:".wpbf-pre-header a:hover, .wpbf-pre-header .wpbf-menu > .current-menu-item > a",props:{color:`${r}!important`}}]})}),f("pre_header_font_size",function(o,e){a(o,{selector:".wpbf-pre-header, .wpbf-pre-header .wpbf-menu, .wpbf-pre-header .wpbf-menu .sub-menu a",props:{"font-size":l(e)}})}),f("blog_pagination_border_radius",function(o,e){a(o,{selector:".pagination .page-numbers",props:{borderRadius:l(e)}})}),f("blog_pagination_background_color",function(o,e){a(o,{selector:".pagination .page-numbers:not(.current)",props:{"background-color":s(e)}})}),f("blog_pagination_background_color_alt",function(o,e){a(o,{selector:".pagination .page-numbers:not(.current):hover",props:{"background-color":s(e)}})}),f("blog_pagination_background_color_active",function(o,e){a(o,{selector:".pagination .page-numbers.current",props:{"background-color":s(e)}})}),f("blog_pagination_font_color",function(o,e){a(o,{selector:".pagination .page-numbers:not(.current)",props:{color:s(e)}})}),f("blog_pagination_font_color_alt",function(o,e){a(o,{selector:".pagination .page-numbers:not(.current):hover",props:{color:s(e)}})}),f("blog_pagination_font_color_active",function(o,e){a(o,{selector:".pagination .page-numbers.current",props:{color:s(e)}})}),f("blog_pagination_font_size",function(o,e){a(o,{selector:".pagination .page-numbers",props:{"font-size":l(e)}})}),f("sidebar_width",function(o,e){let t=100-c(e);a(o,{mediaQuery:"@media (min-width: 769px)",blocks:[{selector:"body:not(.wpbf-no-sidebar) .wpbf-sidebar-wrapper.wpbf-medium-1-3",props:{width:l(e,"%")}},{selector:"body:not(.wpbf-no-sidebar) .wpbf-main.wpbf-medium-2-3",props:{width:l(t,"%")}}]})}),f("sidebar_bg_color",function(o,e){a(o,{selector:".wpbf-sidebar .widget, .elementor-widget-sidebar .widget",props:{"background-color":s(e)}})}),f("button_bg_color",function(o,e){a(o,{selector:'.wpbf-button:not(.wpbf-button-primary), input[type="submit"]',props:{"background-color":s(e)}})}),f("button_bg_color_alt",function(o,e){a(o,{selector:'.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover',props:{"background-color":s(e)}})}),f("button_text_color",function(o,e){a(o,{selector:'.wpbf-button:not(.wpbf-button-primary), input[type="submit"]',props:{color:s(e)}})}),f("button_text_color_alt",function(o,e){a(o,{selector:'.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover',props:{color:s(e)}})}),f("button_primary_bg_color",function(o,e){a(o,{blocks:[{selector:".wpbf-button-primary",props:{"background-color":s(e)}},{selector:".wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background)",props:{"background-color":s(e)}},{selector:".is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background)",props:{"border-color":s(e),color:s(e)}}]})}),f("button_primary_bg_color_alt",function(o,e){a(o,{blocks:[{selector:".wpbf-button-primary:hover",props:{"background-color":s(e)}},{selector:".wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover",props:{"background-color":s(e)}},{selector:".is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background):hover",props:{"border-color":s(e),color:s(e)}}]})}),f("button_primary_text_color",function(o,e){a(o,{blocks:[{selector:".wpbf-button-primary",props:{color:s(e)}},{selector:".wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-text-color)",props:{color:s(e)}}]})}),f("button_primary_text_color_alt",function(o,e){a(o,{blocks:[{selector:".wpbf-button-primary:hover",props:{color:s(e)}},{selector:".wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover",props:{color:s(e)}}]})}),f("button_border_radius",function(o,e){a(o,{selector:'.wpbf-button, input[type="submit"]',props:{"border-radius":l(e)}})}),f("button_border_width",function(o,e){a(o,{selector:'.wpbf-button, input[type="submit"]',props:{"border-width":l(e),"border-style":"solid"}})}),f("button_border_color",function(o,e){a(o,{selector:'.wpbf-button:not(.wpbf-button-primary), input[type="submit"]',props:{"border-color":s(e)}})}),f("button_border_color_alt",function(o,e){a(o,{selector:'.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover',props:{"border-color":s(e)}})}),f("button_primary_border_color",function(o,e){a(o,{selector:".wpbf-button-primary",props:{"border-color":s(e)}})}),f("button_primary_border_color_alt",function(o,e){a(o,{selector:".wpbf-button-primary:hover",props:{"border-color":s(e)}})}),f("breadcrumbs_background_color",function(o,e){a(o,{selector:".wpbf-breadcrumbs-container",props:{"background-color":s(e)}})}),f("breadcrumbs_alignment",function(o,e){a(o,{selector:".wpbf-breadcrumbs-container",props:{"text-align":e}})}),f("breadcrumbs_font_color",function(o,e){a(o,{selector:".wpbf-breadcrumbs",props:{color:s(e)}})}),f("breadcrumbs_accent_color",function(o,e){a(o,{selector:".wpbf-breadcrumbs a",props:{color:s(e)}})}),f("breadcrumbs_accent_color_alt",function(o,e){a(o,{selector:".wpbf-breadcrumbs a:hover",props:{color:s(e)}})}),f("footer_width",function(o,e){a(o,{selector:".wpbf-inner-footer",props:{"max-width":l(e=p(e)?"1200px":e)}})}),f("footer_height",function(o,e){a(o,{selector:".wpbf-inner-footer",props:{"padding-top":l(e),"padding-bottom":l(e)}})}),f("footer_bg_color",function(o,e){a(o,{selector:".wpbf-page-footer",props:{"background-color":s(e)}})}),f("footer_font_color",function(o,e){a(o,{selector:".wpbf-inner-footer",props:{color:s(e)}})}),f("footer_accent_color",function(o,e){a(o,{selector:".wpbf-inner-footer a",props:{color:s(e)}})}),f("footer_accent_color_alt",function(o,e){a(o,{selector:".wpbf-inner-footer a:hover, .wpbf-inner-footer .wpbf-menu > .current-menu-item > a",props:{color:s(e)}})}),f("footer_font_size",function(o,e){a(o,{selector:".wpbf-inner-footer, .wpbf-inner-footer .wpbf-menu",props:{"font-size":l(e)}})}),f("button_border_radius",function(o,e){a(o,{selector:".woocommerce a.button, .woocommerce button.button",props:{"border-radius":l(e)}})}),f("woocommerce_loop_custom_width",function(o,e){a(o,{selector:".archive.woocommerce #inner-content",props:{"max-width":l(e=p(e)?"1200px":e)}})}),f("woocommerce_menu_item_desktop_color",function(o,e){a(o,{selector:".wpbf-menu .wpbf-woo-menu-item .wpbf-woo-menu-item-count",props:{"background-color":s(e)}})}),f("woocommerce_menu_item_mobile_color",function(o,e){a(o,{selector:".wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count",props:{"background-color":s(e)}})}),f("woocommerce_loop_content_alignment",function(o,e){a(o,{blocks:[{selector:".woocommerce ul.products li.product, .woocommerce-page ul.products li.product",props:{"text-align":e}},{selector:".woocommerce .products .star-rating",props:{display:"right"===e?"inline-block":void 0,margin:"center"===e?"0 auto 10px auto":void 0,"text-align":"right"===e?"right":void 0}}]})}),f("woocommerce_loop_image_alignment",function(o,e){a(o,{blocks:[{selector:".wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper",props:{float:"left"===e?"left":"right"}},{selector:".wpbf-woo-list-view .wpbf-woo-loop-summary",props:{float:"left"===e?"right":"left"}}]})}),f("woocommerce_loop_image_width",function(o,e){let t=c(e);a(o,{blocks:[{selector:".wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper",props:{width:String(t-2)+"%"}},{selector:".wpbf-woo-list-view .wpbf-woo-loop-summary",props:{width:String(98-t)+"%"}}]})}),f("woocommerce_loop_title_size",function(o,e){a(o,{selector:".woocommerce ul.products li.product h3, .woocommerce ul.products li.product .woocommerce-loop-product__title, .woocommerce ul.products li.product .woocommerce-loop-category__title",props:{"font-size":l(e)}})}),f("woocommerce_loop_title_color",function(o,e){a(o,{selector:".woocommerce ul.products li.product h3, .woocommerce ul.products li.product .woocommerce-loop-product__title, .woocommerce ul.products li.product .woocommerce-loop-category__title",props:{color:s(e)}})}),f("woocommerce_loop_price_size",function(o,e){a(o,{selector:".woocommerce ul.products li.product .price",props:{"font-size":l(e)}})}),f("woocommerce_loop_price_color",function(o,e){a(o,{selector:".woocommerce ul.products li.product .price",props:{color:s(e)}})}),f("woocommerce_loop_out_of_stock_font_size",function(o,e){a(o,{selector:".woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock",props:{"font-size":l(e)}})}),f("woocommerce_loop_out_of_stock_font_color",function(o,e){a(o,{selector:".woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock",props:{color:s(e)}})}),f("woocommerce_loop_out_of_stock_background_color",function(o,e){a(o,{selector:".woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock",props:{"background-color":s(e)}})}),f("woocommerce_loop_sale_font_size",function(o,e){a(o,{selector:".woocommerce span.onsale",props:{"font-size":l(e)}})}),f("woocommerce_loop_sale_font_color",function(o,e){a(o,{selector:".woocommerce span.onsale",props:{color:s(e)}})}),f("woocommerce_loop_sale_background_color",function(o,e){a(o,{selector:".woocommerce span.onsale",props:{"background-color":s(e)}})}),f("woocommerce_single_custom_width",function(o,e){a(o,{selector:".single.woocommerce #inner-content",props:{"max-width":l(e=p(e)?"1200px":e)}})}),f("woocommerce_single_alignment",function(o,e){a(o,{blocks:[{selector:".woocommerce div.product div.summary, .woocommerce #content div.product div.summary, .woocommerce-page div.product div.summary, .woocommerce-page #content div.product div.summary",props:{float:"right"===e?"left":"right"}},{selector:".woocommerce div.product div.images, .woocommerce #content div.product div.images, .woocommerce-page div.product div.images, .woocommerce-page #content div.product div.images",props:{float:"right"===e?"right":"left"}},{selector:".single-product.woocommerce span.onsale",props:{display:"right"===e?"none":"block"}}]})}),f("woocommerce_single_image_width",function(o,e){let t=c(e);a(o,{blocks:[{selector:".woocommerce div.product div.images, .woocommerce #content div.product div.images, .woocommerce-page div.product div.images, .woocommerce-page #content div.product div.images",props:{width:String(t-2)+"%"}},{selector:".woocommerce div.product div.summary, .woocommerce #content div.product div.summary, .woocommerce-page div.product div.summary, .woocommerce-page #content div.product div.summary",props:{width:String(98-t)+"%"}}]})}),f("woocommerce_single_price_size",function(o,e){a(o,{selector:".woocommerce div.product span.price, .woocommerce div.product p.price",props:{fontSize:l(e)}})}),f("woocommerce_single_price_color",function(o,e){a(o,{selector:".woocommerce div.product span.price, .woocommerce div.product p.price",props:{color:s(e)}})}),f("woocommerce_single_tabs_background_color",function(o,e){a(o,{selector:".woocommerce div.product .woocommerce-tabs ul.tabs li",props:{"background-color":s(e)}})}),f("woocommerce_single_tabs_background_color_alt",function(o,e){a(o,{selector:".woocommerce div.product .woocommerce-tabs ul.tabs li:hover",props:{"background-color":s(e),"border-bottom-color":s(e)}})}),f("woocommerce_single_tabs_background_color_active",function(o,e){a(o,{selector:".woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce div.product .woocommerce-tabs ul.tabs li.active:hover",props:{"background-color":s(e),"border-bottom-color":s(e)}})}),f("woocommerce_single_tabs_font_color",function(o,e){a(o,{selector:".woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a",props:{color:s(e)}})}),f("woocommerce_single_tabs_font_color_alt",function(o,e){a(o,{selector:".woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a:hover",props:{color:s(e)}})}),f("woocommerce_single_tabs_font_color_active",function(o,e){a(o,{selector:".woocommerce div.product .woocommerce-tabs ul.tabs li.active a",props:{color:s(e)}})}),f("woocommerce_info_notice_color",function(o,e){a(o,{blocks:[{selector:".woocommerce-info",props:{"border-top-color":s(e)}},{selector:".woocommerce-info:before, .woocommerce-info a",props:{color:s(e)}}]})}),f("woocommerce_message_notice_color",function(o,e){a(o,{blocks:[{selector:".woocommerce-message",props:{"border-top-color":s(e)}},{selector:".woocommerce-message:before, .woocommerce-message a",props:{color:s(e)}}]})}),f("woocommerce_error_notice_color",function(o,e){a(o,{blocks:[{selector:".woocommerce-error",props:{"border-top-color":s(e)}},{selector:".woocommerce-error:before, .woocommerce-error a",props:{color:s(e)}}]})}),f("woocommerce_notice_bg_color",function(o,e){a(o,{selector:".woocommerce-message",props:{"background-color":s(e)}})}),f("woocommerce_notice_text_color",function(o,e){a(o,{selector:".woocommerce-message",props:{color:s(e)}})}),f("woocommerce_single_tabs_font_size",function(o,e){a(o,{selector:".woocommerce div.product .woocommerce-tabs ul.tabs li a",props:{fontSize:l(e)}})}),f("edd_menu_item_desktop_color",function(o,e){a(o,{selector:".wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count",props:{"background-color":s(e)}})}),f("edd_menu_item_mobile_color",function(o,e){a(o,{selector:".wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count",props:{"background-color":s(e)}})}),f("button_border_radius",function(o,e){a(o,{selector:".edd-submit.button",props:{borderRadius:l(e)}})}),["desktop_row_1","desktop_row_2","desktop_row_3"].forEach(o=>{let e=`wpbf_header_builder_${o}_`,r=`${e}visibility`;t?.(r,e=>{let t=["large","medium","small"];e.bind(function(e){if(!e||!Array.isArray(e))return;let r="desktop_row_1"===o?".wpbf-pre-header":`.wpbf-header-row-${o}`,n=document.querySelector(r);n&&t.forEach(function(o){e.includes(o)?n.classList.remove(`wpbf-hidden-${o}`):n.classList.add(`wpbf-hidden-${o}`)})})}),"desktop_row_3"===o&&(f(`${e}max_width`,(e,t)=>{a(e,{selector:`.wpbf-header-row-${o} .wpbf-container`,props:{"max-width":l(t)}})}),f(`${e}vertical_padding`,function(e,t){a(e,{selector:`.wpbf-header-row-${o} .wpbf-row-content`,props:{"padding-top":l(t),"padding-bottom":l(t)}})}),f(`${e}font_size`,(e,t)=>{a(e,{selector:`.wpbf-header-row-${o}`,props:{"font-size":l(t)}})}),f(`${e}bg_color`,function(e,t){a(e,{selector:`.wpbf-header-row-${o}`,props:{"background-color":s(t)}})})),f(`${e}text_color`,function(e,t){a(e,{selector:`.wpbf-header-row-${o}`,props:{color:s(t)}})}),f(`${e}accent_colors`,(e,t)=>{a(e,{blocks:[{selector:`.wpbf-header-row-${o} a`,props:{color:s(t.default??"")}},{selector:`.wpbf-header-row-${o} a:hover, .wpbf-header-row-${o} a:focus`,props:{color:s(t.hover??"")}}]})})}),["desktop_button_1","desktop_button_2","mobile_button_1","mobile_button_2"].forEach(o=>{let e=`wpbf_header_builder_${o}`;f(e+"_new_tab",function(o,t){let r=document.querySelector(`.wpbf-button.${e}`);r instanceof HTMLAnchorElement&&(t?r.target="_blank":r.removeAttribute("target"))}),f(e+"_text",function(o,t){let r=document.querySelector(`.wpbf-button.${e}`);r instanceof HTMLAnchorElement&&(r.innerHTML=u(t))}),f(e+"_url",function(o,t){let r=document.querySelector(`.wpbf-button.${e}`);r instanceof HTMLAnchorElement&&(r.href=u(t))}),f(e+"_rel",function(o,t){let r=document.querySelector(`.wpbf-button.${e}`);r instanceof HTMLAnchorElement&&(Array.isArray(t)&&t.length?r.rel=t.join(" "):r.removeAttribute("rel"))}),f(e+"_size",function(o,t){let r=document.querySelector(`.wpbf-button.${e}`);r instanceof HTMLAnchorElement&&(r.classList.remove("wpbf-button-small"),r.classList.remove("wpbf-button-large"),"small"===t?r.classList.add("wpbf-button-small"):"large"===t&&r.classList.add("wpbf-button-large"))}),_({controlId:`${e}_border_radius`,cssSelector:`.wpbf-button.${e}`,cssProps:"border-radius",useValueSuffix:!0}),_({controlId:`${e}_border_width`,cssSelector:`.wpbf-button.${e}`,cssProps:"border-width",useValueSuffix:!0}),f(`${e}_border_style`,function(o,t){a(o,{selector:`.wpbf-button.${e}`,props:{"border-style":t}})}),d({controlId:`${e}_border_color`,cssSelector:`.wpbf-button.${e}`,cssProps:"border-color"}),d({controlId:`${e}_bg_color`,cssSelector:`.wpbf-button.${e}`,cssProps:"background-color"}),d({controlId:`${e}_text_color`,cssSelector:`.wpbf-button.${e}`,cssProps:"color"})})}(jQuery,window.wp.customize)}();
//# sourceMappingURL=postmessage-min.js.map
