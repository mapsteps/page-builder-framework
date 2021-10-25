"use strict";var WpbfTheme={};WpbfTheme.site=function(n){var e=!(!window.wp||!wp.customize),i={desktop:1024,tablet:768,mobile:480},s="desktop";function t(){var e=n(window).width(),t="";s=e>i.desktop?(t="wpbf-is-desktop","desktop"):e>i.tablet?(t="wpbf-is-tablet","tablet"):(t="wpbf-is-mobile","mobile"),document.body.classList.remove("wpbf-is-desktop"),document.body.classList.remove("wpbf-is-tablet"),document.body.classList.remove("wpbf-is-mobile"),document.body.classList.add(t)}function o(e){var t="wpbf-"+e+"-breakpoint-[\\w-]*\\b",n=document.body.className.match(t);null!=n&&(i[e]=n.toString().match(/\d+/),i[e]=Array.isArray(i[e])?i[e][0]:i[e])}return o("desktop"),o("tablet"),o("mobile"),t(),function(){var e=document.querySelector(".scrolltop");if(!e)return;var t=e.dataset.scrolltopValue;window.addEventListener("scroll",function(e){n(this).scrollTop()>t?n(".scrolltop").stop().fadeIn():n(".scrolltop").stop().fadeOut()}),n(document).on("click",".scrolltop",function(){document.body.tabIndex=-1,document.body.focus(),this.blur(),n("body, html").animate({scrollTop:0},500)})}(),n(".wpcf7-form-control-wrap").on("mouseenter",function(){n(".wpcf7-not-valid-tip",this).fadeOut()}),function(){var e=n(".wpbf-page"),t=e.css("margin-top");window.addEventListener("resize",function(){e.width()>=n(window).width()?e.css({"margin-top":"0","margin-bottom":"0"}):e.css({"margin-top":t,"margin-bottom":t})})}(),window.addEventListener("resize",function(e){t()}),window.addEventListener("load",function(){n(".opacity").delay(200).animate({opacity:"1"},200),n(".display-none").show(),n(window).trigger("resize"),n(window).trigger("scroll")}),{isInsideCustomizer:e,breakpoints:i,activeBreakpoint:s}}(jQuery),WpbfTheme.desktopMenu=function(i){var e=WpbfTheme.isInsideCustomizer,t=parseInt(i(".wpbf-navigation").data("sub-menu-animation-duration"),10);function n(){i(".wpbf-menu-item-search").hasClass("active")&&(i(".wpbf-menu-search").stop().animate({opacity:"0",width:"0px"},250,function(){i(this).css({display:"none"})}),setTimeout(function(){i(".wpbf-menu-item-search").removeClass("active").attr("aria-expanded","false")},400))}function s(){var e;document.querySelector(".wpbf-menu-centered")&&(e=i(".wpbf-navigation .wpbf-menu-centered .wpbf-menu > li > a").length/2,e=(e=Math.floor(e))-1,i(".wpbf-menu-centered .logo-container").insertAfter(".wpbf-navigation .wpbf-menu-centered .wpbf-menu >li:eq("+e+")").css({display:"block"}))}function o(){i("body").hasClass("using-mouse")||(i(".wpbf-sub-menu > .menu-item-has-children").removeClass("wpbf-sub-menu-focus"),i(".wpbf-sub-menu > .menu-item-has-children > .sub-menu").stop().hide(),i(this).parents(".menu-item-has-children").addClass("wpbf-sub-menu-focus"))}i(document).on("click",".wpbf-menu-item-search",function(e){e.stopPropagation(),i(".wpbf-navigation .wpbf-menu > li").slice(-3).addClass("calculate-width");var n=0;i(".calculate-width").each(function(e,t){n+=i(t).outerWidth()}),n<200&&(n=250),this.classList.contains("active")||(this.classList.add("active"),this.setAttribute("aria-expanded","true"),i(".wpbf-menu-search",this).stop().css({display:"block"}).animate({width:n,opacity:"1"},200),i("input[type=search]",this).val("").focus())}),window.addEventListener("click",function(e){n()}),document.addEventListener("keyup",function(e){"Escape"===e.key||"Esc"===e.key?n():"Tab"===e.key&&(e.target.classList.contains("wpbff-search")||n())}),s(),i(document).on("mouseenter",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",function(){i(".sub-menu",this).first().stop().css({display:"block"}).animate({opacity:"1"},t)}).on("mouseleave",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",function(){i(".sub-menu",this).first().stop().animate({opacity:"0"},t,function(){i(this).css({display:"none"})})}),i(document).on("mouseenter",".wpbf-sub-menu-animation-fade > .menu-item-has-children",function(){i(".sub-menu",this).first().stop().fadeIn(t)}).on("mouseleave",".wpbf-sub-menu-animation-fade > .menu-item-has-children",function(){i(".sub-menu",this).first().stop().fadeOut(t)}),i(".menu-item-has-children").each(function(e,t){i(t).attr("aria-haspopup","true")}),document.body.addEventListener("mousedown",function(){this.classList.add("using-mouse"),i(".menu-item-has-children").removeClass("wpbf-sub-menu-focus")}),document.body.addEventListener("keydown",function(){this.classList.remove("using-mouse")}),i(document).on("mouseenter",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-sub-menu-focus)",function(){document.body.classList.add("using-mouse"),i(".menu-item-has-children").removeClass("wpbf-sub-menu-focus"),i(this).find("> a").focus()}).on("mouseleave",".wpbf-sub-menu > .menu-item-has-children.wpbf-sub-menu-focus",function(){i(this).removeClass("wpbf-sub-menu-focus")}),i(document).on("focus",".wpbf-sub-menu a",o),e&&wp.customize.bind("preview-ready",function(){wp.customize.selectiveRefresh.bind("partial-content-rendered",function(e){t=parseInt(i(".wpbf-navigation").data("sub-menu-animation-duration"),10),s()})})}(jQuery),WpbfTheme.mobileMenu=function(i){var s,o=WpbfTheme.site.breakpoints;function e(){var e=document.querySelector(".wpbf-mobile-menu-hamburger");s=e?"hamburger":(e=document.querySelector(".wpbf-mobile-menu-default"),e?"default":"premium")}function a(e){var t;"premium"===e||(t=document.querySelector("#wpbf-mobile-menu-toggle"))&&t.classList.contains("active")&&(i(".wpbf-mobile-menu-container").removeClass("active").stop().slideUp(),t.classList.remove("active"),t.setAttribute("aria-expanded","false"),"hamburger"===e&&(t.classList.remove("wpbff-times"),t.classList.add("wpbff-hamburger")))}function t(e){var t="hamburger"===e?".wpbf-mobile-menu-hamburger .wpbf-submenu-toggle":".wpbf-mobile-menu-default .wpbf-submenu-toggle";i(document).on("click",t,function(e){var t;e.preventDefault(),((t=this).classList.contains("active")?u:n)(t)})}function n(e){i("i",e).removeClass("wpbff-arrow-down").addClass("wpbff-arrow-up"),e.classList.add("active"),e.setAttribute("aria-expanded","true"),i(e).siblings(".sub-menu").stop().slideDown(),function(e){if(!i(e).closest(".wpbf-navigation").hasClass("wpbf-mobile-sub-menu-auto-collapse"))return;i(e).closest(".menu-item-has-children").siblings(".menu-item-has-children").each(function(e,t){u(t.querySelector(".wpbf-submenu-toggle"))})}(e)}function u(e){i("i",e).removeClass("wpbff-arrow-up").addClass("wpbff-arrow-down"),e.classList.remove("active"),e.setAttribute("aria-expanded","false"),i(e).siblings(".sub-menu").stop().slideUp()}window.addEventListener("resize",function(e){o=WpbfTheme.site.breakpoints}),e(),i(document).on("click",".wpbf-mobile-menu a",function(){"premium"!==s&&(this.href.match("#")||this.href.match("/#"))&&(!this.parentNode.classList.contains("menu-item-has-children")||i(this).closest(".wpbf-mobile-mega-menu").length?a(s):function(e){var t=i(e).siblings(".wpbf-submenu-toggle");if(!t.length)return;((t=t[0]).classList.contains("active")?u:n)(t)}(this))}),i(document).on("click",".wpbf-mobile-menu-toggle",function(){e(),function(e){if("premium"===e)return;var t=document.querySelector("#wpbf-mobile-menu-toggle");if(!t)return;(t.classList.contains("active")?a:function(e){if("premium"===e)return;var t=document.querySelector("#wpbf-mobile-menu-toggle");if(!t)return;i(".wpbf-mobile-menu-container").addClass("active").stop().slideDown(),t.classList.add("active"),t.setAttribute("aria-expanded","true"),"hamburger"===e&&(t.classList.remove("wpbff-hamburger"),t.classList.add("wpbff-times"))})(e)}(s)}),i(window).resize(function(){var e=i(window).height(),t=i(window).width(),n=i(".wpbf-mobile-nav-wrapper").outerHeight();i(".wpbf-mobile-menu-container.active nav").css({"max-height":e-n}),t>o.desktop&&a(s)}),t("default"),t("hamburger")}(jQuery);