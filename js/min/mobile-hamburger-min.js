!function(e){function a(){e(".wpbf-mobile-menu-toggle").hasClass("active")?(e(".wpbf-mobile-menu-container").removeClass("active").slideUp(),e(".wpbf-mobile-menu-toggle").removeClass("active")):(e(".wpbf-mobile-menu-container").addClass("active").slideDown(),e(".wpbf-mobile-menu-toggle").addClass("active"),e(window).trigger("resize"))}e(".wpbf-mobile-menu-toggle").click(function(){a()}),e(".wpbf-mobile-menu a").click(function(){e(this).attr("href").match("^#")&&a()});var i=e("body").attr("class").match(/wpbf-desktop-breakpoint-[\w-]*\b/);if(null!==i)var s=i.toString(),n=s.match(/\d+/);else n="1024";e(window).resize(function(){var a=e(window).height(),i=e(window).width(),s=e(".wpbf-mobile-nav-wrapper").outerHeight();e(".wpbf-mobile-menu-container.active nav").css({"max-height":a-s}),i>n?(e(".wpbf-mobile-menu-toggle").hasClass("active")&&(e(".wpbf-mobile-menu-container").removeClass("active").css({display:"none"}),e(".wpbf-mobile-menu-toggle").removeClass("active")),e(".wpbf-mobile-mega-menu").length&&e(".wpbf-mobile-mega-menu").removeClass("wpbf-mobile-mega-menu").addClass("wpbf-mega-menu")):e(".wpbf-mega-menu").length&&e(".wpbf-mega-menu").removeClass("wpbf-mega-menu").addClass("wpbf-mobile-mega-menu")}),e(".wpbf-mobile-menu .menu-item-has-children").each(function(){e(this).append('<span class="wpbf-submenu-toggle"><i class="wpbff wpbff-arrow-down"></i></span>')}),e(".wpbf-submenu-toggle").click(function(a){a.preventDefault(),e(this).hasClass("active")?(e("i",this).removeClass("wpbff-arrow-up").addClass("wpbff-arrow-down"),e(this).removeClass("active").siblings(".sub-menu").slideUp()):(e("i",this).removeClass("wpbff-arrow-down").addClass("wpbff-arrow-up"),e(this).addClass("active").siblings(".sub-menu").slideDown())})}(jQuery);