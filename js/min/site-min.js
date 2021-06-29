"use strict";var WPBFSite=function(t){var e,n=!(!window.wp||!wp.customize),a={desktop:1024,tablet:768,mobile:480},s="desktop",i=t(".wpbf-navigation").data("sub-menu-animation-duration");function o(){var e=t(window).width(),n="";s=e>a.desktop?(n="wpbf-is-desktop","desktop"):e>a.tablet?(n="wpbf-is-tablet","tablet"):(n="wpbf-is-mobile","mobile"),document.body.classList.remove("wpbf-is-desktop"),document.body.classList.remove("wpbf-is-tablet"),document.body.classList.remove("wpbf-is-mobile"),document.body.classList.add(n)}function u(e){var n="wpbf-"+e+"-breakpoint-[\\w-]*\\b",n=t("body").attr("class").match(n);null!=n&&(a[e]=n.toString().match(/\d+/),a[e]=Array.isArray(a[e])?a[e][0]:a[e])}function r(){t(".wpbf-menu-item-search").hasClass("active")&&(t(".wpbf-menu-search").stop().animate({opacity:"0",width:"0px"},250,function(){t(this).css({display:"none"})}),setTimeout(function(){t(".wpbf-menu-item-search").removeClass("active").attr("aria-expanded","false")},400))}u("desktop"),u("tablet"),u("mobile"),o(),c(),n&&wp.customize.bind("preview-ready",function(){wp.customize.selectiveRefresh.bind("partial-content-rendered",function(e){i=t(".wpbf-navigation").data("sub-menu-animation-duration"),c()})}),window.addEventListener("resize",function(e){o()}),t(".scrolltop").length&&(e=t(".scrolltop").attr("data-scrolltop-value"),t(window).scroll(function(){t(this).scrollTop()>e?t(".scrolltop").fadeIn():t(".scrolltop").fadeOut()}),t(document).on("click",".scrolltop",function(){t("body").attr("tabindex","-1").focus(),t(this).blur(),t("body, html").animate({scrollTop:0},500)})),t(document).on("click",".wpbf-menu-item-search",function(e){e.stopPropagation(),t(".wpbf-navigation .wpbf-menu > li").slice(-3).addClass("calculate-width");var n=0;t(".calculate-width").each(function(){n+=t(this).outerWidth()}),n<200&&(n=250),this.classList.contains("active")||(t(this).addClass("active").attr("aria-expanded","true"),t(".wpbf-menu-search",this).stop().css({display:"block"}).animate({width:n,opacity:"1"},200),t("input[type=search]",this).val("").focus())}),window.addEventListener("click",function(e){r()}),document.addEventListener("keyup",function(e){"Escape"===e.key||"Esc"===e.key?r():"Tab"===e.key&&(e.target.classList.contains("wpbff-search")||r())}),t(".wpcf7-form-control-wrap").on("mouseenter",function(){t(".wpcf7-not-valid-tip",this).fadeOut()});var m=t(".wpbf-page").css("margin-top");function c(){var e;document.querySelector(".wpbf-menu-centered")&&(e=t(".wpbf-navigation .wpbf-menu-centered .wpbf-menu > li > a").length/2,e=(e=Math.floor(e))-1,t(".wpbf-menu-centered .logo-container").insertAfter(".wpbf-navigation .wpbf-menu-centered .wpbf-menu >li:eq("+e+")").css({display:"block"}))}return t(window).on("resize",function(){t(".wpbf-page").width()>=t(window).width()?t(".wpbf-page").css({"margin-top":"0","margin-bottom":"0"}):t(".wpbf-page").css({"margin-top":m,"margin-bottom":m})}),t(document).on("mouseenter",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",function(){t(".sub-menu",this).first().stop().css({display:"block"}).animate({opacity:"1"},i)}).on("mouseleave",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",function(){t(".sub-menu",this).first().stop().animate({opacity:"0"},i,function(){t(this).css({display:"none"})})}),t(document).on("mouseenter",".wpbf-sub-menu-animation-fade > .menu-item-has-children",function(){t(".sub-menu",this).first().stop().fadeIn(i)}).on("mouseleave",".wpbf-sub-menu-animation-fade > .menu-item-has-children",function(){t(".sub-menu",this).first().stop().fadeOut(i)}),t(".menu-item-has-children").each(function(){t(this).attr("aria-haspopup","true")}),t("body").mousedown(function(){t(this).addClass("using-mouse"),t(".menu-item-has-children").removeClass("wpbf-sub-menu-focus")}),t("body").keydown(function(){t(this).removeClass("using-mouse")}),t(document).on("mouseenter",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-sub-menu-focus)",function(){document.body.classList.add("using-mouse"),t(".menu-item-has-children").removeClass("wpbf-sub-menu-focus"),t(this).find("> a").focus()}).on("mouseleave",".wpbf-sub-menu > .menu-item-has-children.wpbf-sub-menu-focus",function(){t(this).removeClass("wpbf-sub-menu-focus")}),t(document).on("focus","#navigation a",function(){t("body").hasClass("using-mouse")||t("#navigation > ul").hasClass("wpbf-sub-menu")&&(t(".menu-item-has-children").removeClass("wpbf-sub-menu-focus"),t("#navigation > ul > .menu-item-has-children > .sub-menu").stop().hide(),t(this).parents(".menu-item-has-children").addClass("wpbf-sub-menu-focus"))}),t(window).on("load",function(){t(".opacity").delay(200).animate({opacity:"1"},200),t(".display-none").show(),t(window).trigger("resize"),t(window).trigger("scroll")}),{breakpoints:a,activeBreakpoint:s}}(jQuery),WPBFMobile=function(a){var s,i=WPBFSite.breakpoints;function e(){var e=document.querySelector(".wpbf-mobile-menu-hamburger");s=e?"hamburger":(e=document.querySelector(".wpbf-mobile-menu-default"),e?"default":"premium")}function n(e){var n;"premium"!==e&&((n=a(".wpbf-mobile-menu-toggle")).hasClass("active")?(a(".wpbf-mobile-menu-container").removeClass("active").slideUp(),n.removeClass("active"),("hamburger"===e?n.removeClass("wpbff-times").addClass("wpbff-hamburger"):n).attr("aria-expanded","false")):(a(".wpbf-mobile-menu-container").addClass("active").slideDown(),n.addClass("active"),("hamburger"===e?n.removeClass("wpbff-hamburger").addClass("wpbff-times"):n).attr("aria-expanded","true")))}function t(e){e="hamburger"===e?".wpbf-mobile-menu-hamburger .wpbf-submenu-toggle":".wpbf-mobile-menu-default .wpbf-submenu-toggle";a(document).on("click",e,function(e){e.preventDefault(),a(e=this).hasClass("active")?(a("i",e).removeClass("wpbff-arrow-up").addClass("wpbff-arrow-down"),a(e).removeClass("active").attr("aria-expanded","false").siblings(".sub-menu").slideUp()):(a("i",e).removeClass("wpbff-arrow-down").addClass("wpbff-arrow-up"),a(e).addClass("active").attr("aria-expanded","true").siblings(".sub-menu").slideDown())})}window.addEventListener("resize",function(e){i=WPBFSite.breakpoints}),e(),a(document).on("click",".wpbf-mobile-menu-toggle",function(){e(),n(s)}),a(document).on("click",".wpbf-mobile-menu a",function(){var e=this.parentNode.classList.contains("menu-item-has-children");(this.href.match("#")||this.href.match("/#"))&&(e?function(e){e=a(e).siblings(".wpbf-submenu-toggle");e.hasClass("active")?(a("i",e).removeClass("wpbff-arrow-up").addClass("wpbff-arrow-down"),e.removeClass("active").attr("aria-expanded","false").siblings(".sub-menu").slideUp()):(a("i",e).removeClass("wpbff-arrow-down").addClass("wpbff-arrow-up"),e.addClass("active").attr("aria-expanded","true").siblings(".sub-menu").slideDown())}(this):n(s))}),a(window).resize(function(){var e=a(window).height(),n=a(window).width(),t=a(".wpbf-mobile-nav-wrapper").outerHeight();a(".wpbf-mobile-menu-container.active nav").css({"max-height":e-t}),n>i.desktop&&(t=s,(n=a(".wpbf-mobile-menu-toggle")).hasClass("active")&&(a(".wpbf-mobile-menu-container").removeClass("active").slideUp(),n.removeClass("active"),("hamburger"===t?n.removeClass("wpbff-times").addClass("wpbff-hamburger"):n).attr("aria-expanded","false")))}),t("default"),t("hamburger")}(jQuery);