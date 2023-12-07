!function(){function e(e,t){if((e instanceof NodeList||"string"==typeof e)&&"function"==typeof t){var n=e instanceof NodeList?e:document.querySelectorAll(e);if(n.length)for(var i=0;i<n.length;i++)t(n[i])}}function t(e,t,n){"string"==typeof e&&"function"==typeof t&&document.addEventListener(e,(function(e){if(t){if(!e.target||!e.target.matches)return;if(!e.target.matches(t))return}n.bind(e.target)(e)}))}function n(e,t){var n=e instanceof HTMLElement?e:document.querySelector(e);return n&&n.getAttribute&&t?n.getAttribute(t):""}function i(e,t){var i=n(e,t);return i?parseInt(i,10):0}function s(){return!(!window.wp||!wp.customize)}var o={desktop:1024,tablet:768,mobile:480};function a(e){var t=o[e]||0,n="wpbf-"+e+"-breakpoint-[\\w-]*\\b",i=document.body.className.match(n);if(!i)return t;var s=i.toString().match(/\d+/),a=Array.isArray(s)?s[0]:s;return parseInt(a,10)||0}function u(){var e=o;return e.desktop=a("desktop"),e.tablet=a("tablet"),e.mobile=a("mobile"),e}function c(){var e=u(),t=document.documentElement.clientWidth,n="desktop";return t>e.desktop?n:n=t>e.tablet?"tablet":"mobile"}!function(e){var t=u();function n(){var e=document.documentElement.clientWidth,n="";n=e>t.desktop?"wpbf-is-desktop":e>t.tablet?"wpbf-is-tablet":"wpbf-is-mobile",document.body.classList.remove("wpbf-is-desktop"),document.body.classList.remove("wpbf-is-tablet"),document.body.classList.remove("wpbf-is-mobile"),document.body.classList.add(n)}n(),function(){var t=document.querySelector(".scrolltop");if(t){var n=t.dataset.scrolltopValue;window.addEventListener("scroll",(function(t){window.scrollY>n?e(".scrolltop").fadeIn():e(".scrolltop").fadeOut()})),addEventHandler("click",".scrolltop",(function(t){document.body.tabIndex=-1,document.body.focus(),this.blur(),e("body, html").animate({scrollTop:0},500)}))}}(),processElements(".wpcf7-form-control-wrap",(function(t){t.addEventListener("mouseenter",(function(){e(".wpcf7-not-valid-tip",t).fadeOut()}))})),function(){var e=document.querySelector(".wpbf-page");if(e){var t=window.getComputedStyle(e).marginTop;window.addEventListener("resize",(function(){e.offsetWidth>=documument.documentElement.clientWidth?(e.style.marginTop="0",e.style.marginBottom="0"):(e.style.marginTop=t,e.style.marginBottom=t)}))}}(),window.addEventListener("resize",(function(e){n()})),window.addEventListener("load",(function(){e(".opacity").delay(200).animate({opacity:"1"},200),processElements(".display-none",(function(e){e.style.display="block"})),window.dispatchEvent(new Event("resize")),window.dispatchEvent(new Event("scroll"))}))}(jQuery),function(n){var o=i(".wpbf-navigation","sub-menu-animation-duration");function a(){e(".wpbf-menu-item-search",(function(e){e.classList.contains("active")&&(n(".wpbf-menu-search",e).stop().animate({opacity:"0",width:"0px"},250,(function(){this.classList.style.display="none"})),setTimeout((function(){e.classList.remove("active"),e.setAttribute("aria-expanded","false")}),400))}))}function u(){if(document.querySelector(".wpbf-menu-centered")){var t=document.querySelectorAll(".wpbf-navigation .wpbf-menu-centered .wpbf-menu > li > a").length/2;t=Math.floor(t),t-=1,e(".wpbf-menu-centered .logo-container",(function(e){var n=document.querySelector(".wpbf-navigation .wpbf-menu-centered .wpbf-menu > li:nth-child("+t+")");n&&(n.parentNode.insertBefore(e,n.nextSibling),e.style.display="block")}))}}function c(){if(!document.body.classList.contains("using-mouse")){e(".wpbf-sub-menu > .menu-item-has-children",(function(e){e.classList.remove("wpbf-sub-menu-focus")})),n(".wpbf-sub-menu > .menu-item-has-children > .sub-menu").stop().hide();for(var t=this;t.parentNode;)t.classList.contains("menu-item-has-children")&&t.classList.add("wpbf-sub-menu-focus"),t=t.parentNode}}t("click",".wpbf-menu-item-search",(function(t){t.stopPropagation(),function(t){var i=document.querySelectorAll(".wpbf-navigation .wpbf-menu > li");Array.from(i).slice(-3).forEach((function(e){e.classList.add("calculate-width")}));var s=0;if(e(".calculate-width",(function(e){s+=e.offsetWidth})),s<200&&(s=250),!t.classList.contains("active")){t.classList.add("active"),t.setAttribute("aria-expanded","true"),n(".wpbf-menu-search",t).stop().css({display:"block"}).animate({width:s,opacity:"1"},200);var o=t.querySelector("input[type=search]");o&&(o.value="",o.focus())}}(this)})),window.addEventListener("click",(function(e){a()})),document.addEventListener("keyup",(function(e){"Escape"!==e.key&&"Esc"!==e.key?"Tab"===e.key&&(e.target.classList.contains("wpbff-search")||a()):a()})),u(),t("mouseenter",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",(function(e){n(".sub-menu",this).first().stop().css({display:"block"}).animate({opacity:"1"},o)})),t("mouseleave",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",(function(){n(".sub-menu",this).first().stop().animate({opacity:"0"},o,(function(){this.classList.style.display="none"}))})),t("mouseenter",".wpbf-sub-menu-animation-fade > .menu-item-has-children",(function(){n(".sub-menu",this).first().stop().fadeIn(o)})),t("mouseleave",".wpbf-sub-menu-animation-fade > .menu-item-has-children",(function(){n(".sub-menu",this).first().stop().fadeOut(o)})),e(".menu-item-has-children",(function(e){e.setAttribute("aria-haspopup","true")})),document.body.addEventListener("mousedown",(function(){this.classList.add("using-mouse"),e(".menu-item-has-children",(function(e){e.removeClass("wpbf-sub-menu-focus")}))})),document.body.addEventListener("keydown",(function(){this.classList.remove("using-mouse")})),t("mouseenter",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-sub-menu-focus)",(function(){document.body.classList.add("using-mouse"),e(".menu-item-has-children",(function(e){e.classList.remove("wpbf-sub-menu-focus")})),n(this).find("> a").focus()})),t("mouseleave",".wpbf-sub-menu > .menu-item-has-children.wpbf-sub-menu-focus",(function(){this.classList.remove("wpbf-sub-menu-focus")})),t("focus",".wpbf-sub-menu a",c),s()&&wp.customize.bind("preview-ready",(function(){wp.customize.selectiveRefresh.bind("partial-content-rendered",(function(e){o=i(".wpbf-navigation","sub-menu-animation-duration"),u()}))}))}(jQuery),function(n){var i,s=u();function o(){var e=document.querySelector(".wpbf-mobile-menu-hamburger");e?i="hamburger":(e=document.querySelector(".wpbf-mobile-menu-default"),i=e?"default":"premium")}function a(e){if("premium"!==e){var t=document.querySelector("#wpbf-mobile-menu-toggle");t&&t.classList.contains("active")&&(n(".wpbf-mobile-menu-container").removeClass("active").stop().slideUp(),t.classList.remove("active"),t.setAttribute("aria-expanded","false"),"hamburger"===e&&(t.classList.remove("wpbff-times"),t.classList.add("wpbff-hamburger")))}}function c(e){t("click","hamburger"===e?".wpbf-mobile-menu-hamburger .wpbf-submenu-toggle":".wpbf-mobile-menu-default .wpbf-submenu-toggle",(function(e){var t;e.preventDefault(),(t=this).classList.contains("active")?m(t):r(t)}))}function r(e){e.querySelectorAll("i").forEach((function(e){e.classList.remove("wpbff-arrow-down"),e.classList.add("wpbff-arrow-up")})),e.classList.add("active"),e.setAttribute("aria-expanded","true"),n(e).siblings(".sub-menu").stop().slideDown(),function(e){if(!n(e).closest(".wpbf-navigation").hasClass("wpbf-mobile-sub-menu-auto-collapse"))return;n(e).closest(".menu-item-has-children").siblings(".menu-item-has-children").each((function(e,t){m(t.querySelector(".wpbf-submenu-toggle"))}))}(e)}function m(e){e.querySelectorAll("i").forEach((function(e){e.classList.remove("wpbff-arrow-up"),e.classList.add("wpbff-arrow-down")})),e.classList.remove("active"),e.setAttribute("aria-expanded","false"),n(e).siblings(".sub-menu").stop().slideUp()}window.addEventListener("resize",(function(e){s=u()})),o(),t("click",".wpbf-mobile-menu a",(function(){var e;"premium"!==i&&(this.href.match("#")||this.href.match("/#"))&&(this.parentNode.classList.contains("menu-item-has-children")?n(this).closest(".wpbf-mobile-mega-menu").length?a(i):(e=n(this).siblings(".wpbf-submenu-toggle")).length&&((e=e[0]).classList.contains("active")?m(e):r(e)):a(i))})),t("click",".wpbf-mobile-menu-toggle",(function(){o(),function(e){if("premium"!==e){var t=document.querySelector("#wpbf-mobile-menu-toggle");t&&(t.classList.contains("active")?a(e):function(e){if("premium"!==e){var t=document.querySelector("#wpbf-mobile-menu-toggle");t&&(n(".wpbf-mobile-menu-container").addClass("active").stop().slideDown(),t.classList.add("active"),t.setAttribute("aria-expanded","true"),"hamburger"===e&&(t.classList.remove("wpbff-hamburger"),t.classList.add("wpbff-times")))}}(e))}}(i)})),window.addEventListener("resize",(function(){var t=document.documentElement.clientHeight,n=document.documentElement.clientWidth,o=document.querySelector(".wpbf-mobile-nav-wrapper"),u=o?o.offsetHeight:0;e(".wpbf-mobile-menu-container.active nav",(function(e){e.style.maxHeight=t-u+"px"})),n>s.desktop&&a(i)})),c("default"),c("hamburger")}(jQuery);var r={getBreakpoints:u,getActiveBreakpoint:c,isInsideCustomizer:s,forEachEl:e,listenDocumentEvent:t,getAttr:n,getAttrAsNumber:i};window.Aura=r,window.Wpbf={site:{breakpoints:u(),activeBreakpoint:c(),isInsideCustomizer:s()}}}();