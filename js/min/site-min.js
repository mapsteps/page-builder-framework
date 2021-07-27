"use strict";var WPBFSite=function(n){var e,t=!(!window.wp||!wp.customize),s={desktop:1024,tablet:768,mobile:480},i="desktop",a=n(".wpbf-navigation").data("sub-menu-animation-duration");function o(){var e=n(window).width(),t="";i=e>s.desktop?(t="wpbf-is-desktop","desktop"):e>s.tablet?(t="wpbf-is-tablet","tablet"):(t="wpbf-is-mobile","mobile"),document.body.classList.remove("wpbf-is-desktop"),document.body.classList.remove("wpbf-is-tablet"),document.body.classList.remove("wpbf-is-mobile"),document.body.classList.add(t)}function u(e){var t="wpbf-"+e+"-breakpoint-[\\w-]*\\b",t=n("body").attr("class").match(t);null!=t&&(s[e]=t.toString().match(/\d+/),s[e]=Array.isArray(s[e])?s[e][0]:s[e])}function c(){n(".wpbf-menu-item-search").hasClass("active")&&(n(".wpbf-menu-search").stop().animate({opacity:"0",width:"0px"},250,function(){n(this).css({display:"none"})}),setTimeout(function(){n(".wpbf-menu-item-search").removeClass("active").attr("aria-expanded","false")},400))}u("desktop"),u("tablet"),u("mobile"),o(),r(),t&&wp.customize.bind("preview-ready",function(){wp.customize.selectiveRefresh.bind("partial-content-rendered",function(e){a=n(".wpbf-navigation").data("sub-menu-animation-duration"),r()})}),window.addEventListener("resize",function(e){o()}),n(".scrolltop").length&&(e=n(".scrolltop").attr("data-scrolltop-value"),n(window).scroll(function(){n(this).scrollTop()>e?n(".scrolltop").fadeIn():n(".scrolltop").fadeOut()}),n(document).on("click",".scrolltop",function(){n("body").attr("tabindex","-1").focus(),n(this).blur(),n("body, html").animate({scrollTop:0},500)})),n(document).on("click",".wpbf-menu-item-search",function(e){e.stopPropagation(),n(".wpbf-navigation .wpbf-menu > li").slice(-3).addClass("calculate-width");var t=0;n(".calculate-width").each(function(){t+=n(this).outerWidth()}),t<200&&(t=250),this.classList.contains("active")||(n(this).addClass("active").attr("aria-expanded","true"),n(".wpbf-menu-search",this).stop().css({display:"block"}).animate({width:t,opacity:"1"},200),n("input[type=search]",this).val("").focus())}),window.addEventListener("click",function(e){c()}),document.addEventListener("keyup",function(e){"Escape"===e.key||"Esc"===e.key?c():"Tab"===e.key&&(e.target.classList.contains("wpbff-search")||c())}),n(".wpcf7-form-control-wrap").on("mouseenter",function(){n(".wpcf7-not-valid-tip",this).fadeOut()});var m=n(".wpbf-page").css("margin-top");function r(){var e;document.querySelector(".wpbf-menu-centered")&&(e=n(".wpbf-navigation .wpbf-menu-centered .wpbf-menu > li > a").length/2,e=(e=Math.floor(e))-1,n(".wpbf-menu-centered .logo-container").insertAfter(".wpbf-navigation .wpbf-menu-centered .wpbf-menu >li:eq("+e+")").css({display:"block"}))}return n(window).on("resize",function(){n(".wpbf-page").width()>=n(window).width()?n(".wpbf-page").css({"margin-top":"0","margin-bottom":"0"}):n(".wpbf-page").css({"margin-top":m,"margin-bottom":m})}),n(document).on("mouseenter",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",function(){n(".sub-menu",this).first().stop().css({display:"block"}).animate({opacity:"1"},a)}).on("mouseleave",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",function(){n(".sub-menu",this).first().stop().animate({opacity:"0"},a,function(){n(this).css({display:"none"})})}),n(document).on("mouseenter",".wpbf-sub-menu-animation-fade > .menu-item-has-children",function(){n(".sub-menu",this).first().stop().fadeIn(a)}).on("mouseleave",".wpbf-sub-menu-animation-fade > .menu-item-has-children",function(){n(".sub-menu",this).first().stop().fadeOut(a)}),n(".menu-item-has-children").each(function(){n(this).attr("aria-haspopup","true")}),n("body").mousedown(function(){n(this).addClass("using-mouse"),n(".menu-item-has-children").removeClass("wpbf-sub-menu-focus")}),n("body").keydown(function(){n(this).removeClass("using-mouse")}),n(document).on("mouseenter",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-sub-menu-focus)",function(){document.body.classList.add("using-mouse"),n(".menu-item-has-children").removeClass("wpbf-sub-menu-focus"),n(this).find("> a").focus()}).on("mouseleave",".wpbf-sub-menu > .menu-item-has-children.wpbf-sub-menu-focus",function(){n(this).removeClass("wpbf-sub-menu-focus")}),n(document).on("focus",".wpbf-sub-menu a",function(){n("body").hasClass("using-mouse")||(n(".wpbf-sub-menu > .menu-item-has-children").removeClass("wpbf-sub-menu-focus"),n(".wpbf-sub-menu > .menu-item-has-children > .sub-menu").stop().hide(),n(this).parents(".menu-item-has-children").addClass("wpbf-sub-menu-focus"))}),n(window).on("load",function(){n(".opacity").delay(200).animate({opacity:"1"},200),n(".display-none").show(),n(window).trigger("resize"),n(window).trigger("scroll")}),{breakpoints:s,activeBreakpoint:i}}(jQuery),WPBFMobile=function(s){var i,a=WPBFSite.breakpoints;function e(){var e;i=(e=document.querySelector(".wpbf-mobile-menu-hamburger"))?"hamburger":(e=document.querySelector(".wpbf-mobile-menu-default"),e?"default":"premium")}function t(e){var t;"premium"!==e&&((t=s(".wpbf-mobile-menu-toggle")).hasClass("active")?(s(".wpbf-mobile-menu-container").removeClass("active").slideUp(),t.removeClass("active"),("hamburger"===e?t.removeClass("wpbff-times").addClass("wpbff-hamburger"):t).attr("aria-expanded","false")):(s(".wpbf-mobile-menu-container").addClass("active").slideDown(),t.addClass("active"),("hamburger"===e?t.removeClass("wpbff-hamburger").addClass("wpbff-times"):t).attr("aria-expanded","true")))}function n(e){e="hamburger"===e?".wpbf-mobile-menu-hamburger .wpbf-submenu-toggle":".wpbf-mobile-menu-default .wpbf-submenu-toggle";s(document).on("click",e,function(e){e.preventDefault(),((e=this).classList.contains("active")?u:o)(e)})}function o(e){s("i",e).removeClass("wpbff-arrow-down").addClass("wpbff-arrow-up"),e.classList.add("active"),e.setAttribute("aria-expanded","true"),s(e).siblings(".sub-menu").stop().slideDown(),s(e).closest(".menu-item-has-children").siblings(".menu-item-has-children").each(function(e,t){u(t.querySelector(".wpbf-submenu-toggle"))})}function u(e){s("i",e).removeClass("wpbff-arrow-up").addClass("wpbff-arrow-down"),e.classList.remove("active"),e.setAttribute("aria-expanded","false"),s(e).siblings(".sub-menu").stop().slideUp()}window.addEventListener("resize",function(e){a=WPBFSite.breakpoints}),e(),s(document).on("click",".wpbf-mobile-menu-toggle",function(){e(),t(i)}),s(document).on("click",".wpbf-mobile-menu a",function(){var e=this.parentNode.classList.contains("menu-item-has-children");(this.href.match("#")||this.href.match("/#"))&&(e?s(this).closest(".wpbf-mobile-mega-menu").length||function(e){e=s(e).siblings(".wpbf-submenu-toggle");e.length&&((e=e[0]).classList.contains("active")?u:o)(e)}(this):t(i))}),s(window).resize(function(){var e=s(window).height(),t=s(window).width(),n=s(".wpbf-mobile-nav-wrapper").outerHeight();s(".wpbf-mobile-menu-container.active nav").css({"max-height":e-n}),t>a.desktop&&(n=i,(t=s(".wpbf-mobile-menu-toggle")).hasClass("active")&&(s(".wpbf-mobile-menu-container").removeClass("active").slideUp(),t.removeClass("active"),("hamburger"===n?t.removeClass("wpbff-times").addClass("wpbff-hamburger"):t).attr("aria-expanded","false")))}),n("default"),n("hamburger")}(jQuery);