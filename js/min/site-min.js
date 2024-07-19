!function(){let e=window.WpbfUtils;!function(e){let t=e.dom,n=e.anim,i=t.getBreakpoints();function s(){let e=document.documentElement.clientWidth,t="";t=e>i.desktop?"wpbf-is-desktop":e>i.tablet?"wpbf-is-tablet":"wpbf-is-mobile",document.body.classList.remove("wpbf-is-desktop"),document.body.classList.remove("wpbf-is-tablet"),document.body.classList.remove("wpbf-is-mobile"),document.body.classList.add(t)}s(),function(){let e=document.querySelector(".scrolltop");if(!e||!(e instanceof HTMLElement))return;let i=e.dataset.scrolltopValue,s=i?parseFloat(i):0;window.addEventListener("scroll",function(t){window.scrollY>s?e.classList.add("is-visible"):e.classList.remove("is-visible")}),t.listenDocumentEvent("click",".scrolltop",function(e){document.body.tabIndex=-1,document.body.focus(),this.blur(),n.animateScrollTop(0,500)})}(),t.forEachEl(".wpcf7-form-control-wrap",function(e){e.addEventListener("mouseenter",function(){e.querySelectorAll(".wpcf7-not-valid-tip").forEach(function(e){e.classList.add("wpbf-fading"),e.classList.add("wpbf-fade-out"),e instanceof HTMLElement&&n.hideElAfterDelay(e,400)})})}),function(){let e=document.querySelector(".wpbf-page");if(!e||!(e instanceof HTMLElement))return;let t=window.getComputedStyle(e).marginTop;window.addEventListener("resize",function(){e.offsetWidth>=document.documentElement.clientWidth?(e.style.marginTop="0",e.style.marginBottom="0"):(e.style.marginTop=t,e.style.marginBottom=t)})}(),document.body.classList.add("wpbf-vanilla"),window.addEventListener("resize",function(e){s()}),window.addEventListener("load",function(){window.setTimeout(function(){t.forEachEl(".opacity",function(e){e.classList.add("is-visible")})},200),t.forEachEl(".display-none",function(e){e instanceof HTMLElement&&(e.style.display="block")}),window.dispatchEvent(new Event("resize")),window.dispatchEvent(new Event("scroll"))})}(e),function(e){let t=e.dom,n=e.anim,i=t.findHtmlEl(".wpbf-navigation");if(!i)return;let s=t.getAttrAsNumber(".wpbf-navigation","data-sub-menu-animation-duration");function o(){t.forEachEl(".wpbf-menu-item-search",function(e){if(!e.classList.contains("active"))return;let t=e.querySelector(".wpbf-menu-search");t&&(t.classList.remove("is-expanded"),setTimeout(function(){t.classList.remove("display-block")},250)),setTimeout(function(){e.classList.remove("active"),e.setAttribute("aria-expanded","false")},400)})}function a(){if(!document.querySelector(".wpbf-menu-centered"))return;let e=document.querySelectorAll(".wpbf-navigation .wpbf-menu-centered .wpbf-menu > li > a").length/2;e=Math.floor(e),t.forEachEl(".wpbf-menu-centered .logo-container",function(t){let n=document.querySelector(".wpbf-navigation .wpbf-menu-centered .wpbf-menu > li:nth-child("+e+")");n&&(n.after(t),t instanceof HTMLElement&&(t.style.display="block"))})}t.listenDocumentEvent("click",".wpbf-menu-item-search",function(e){e.stopPropagation(),this.classList.contains("active")||e.preventDefault(),function(e){Array.from(document.querySelectorAll(".wpbf-navigation .wpbf-menu > li")).slice(-3).forEach(function(e){e.classList.add("calculate-width")});let i=0;if(t.forEachEl(".calculate-width",function(e){e instanceof HTMLElement&&(i+=e.offsetWidth)}),i<200&&(i=250),!e.classList.contains("active")){e.classList.add("active"),e.setAttribute("aria-expanded","true");let t=e.querySelector(".wpbf-menu-search"),s=e.querySelector("input[type=search]");t&&t instanceof HTMLElement&&s&&s instanceof HTMLInputElement&&(n.writeElStyle(t,"search-field-anim",`
					.wpbf-menu-item-search .wpbf-menu-search.display-block {display: block;}
					.wpbf-menu-item-search .wpbf-menu-search.is-expanded {width: ${i}px;}
					`),t.classList.add("display-block"),setTimeout(function(){t.classList.add("is-expanded")},1),s.value="",s.focus())}}(this)}),window.addEventListener("click",function(e){o()}),document.addEventListener("keyup",function(e){if("Escape"===e.key||"Esc"===e.key){o();return}"Tab"===e.key&&e.target&&e.target instanceof HTMLElement&&!e.target.classList.contains("wpbff-search")&&o()}),a(),function(){let e="#navigation .wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",o="fade-anim";t.listenDocumentEvent("mouseenter",e,function(t){if(!i)return;let a=this.querySelector(".sub-menu");a&&a instanceof HTMLElement&&(a.classList.contains("is-shown")||(n.writeElStyle(i,"nested-submenu-anim",`
					${e} .sub-menu.${o}.display-block {display: block;}
					${e} .sub-menu.${o}.is-shown {opacity: 1;}
					${e} .sub-menu.${o} {opacity: 0; transition: opacity ${s}ms ease-in-out;}
					`),a.classList.add(o),a.classList.add("display-block"),setTimeout(function(){a.classList.add("is-shown")},1)))}),t.listenDocumentEvent("mouseleave",e,function(){let e=this.querySelector(".sub-menu");e&&e.classList.contains("is-shown")&&(e.classList.remove("is-shown"),setTimeout(function(){e.classList.remove("display-block"),e.classList.remove(o)},s))})}(),function(){let e=".wpbf-sub-menu-animation-fade > .menu-item-has-children",o="fade-anim";t.listenDocumentEvent("mouseenter",e,function(){if(!i)return;let t=this.querySelector(".sub-menu");t&&t instanceof HTMLElement&&(t.classList.contains("is-shown")||(n.writeElStyle(i,"submenu-anim",`
					${e} > .sub-menu.${o}.display-block {display:block;}
					${e} > .sub-menu.${o}.is-shown {opacity: 1;}
					${e} > .sub-menu.${o} {opacity: 0; transition: opacity ${s}ms ease-in-out;}
					`),t.classList.add(o),t.classList.add("display-block"),setTimeout(function(){t.classList.add("is-shown")},1)))}),t.listenDocumentEvent("mouseleave",e,function(e){let t=this.querySelector(".sub-menu");t&&t.classList.contains("is-shown")&&(t.classList.remove("is-shown"),setTimeout(function(){t.classList.remove("display-block"),t.classList.remove(o)},s))})}(),t.forEachEl(".menu-item-has-children",function(e){e.setAttribute("aria-haspopup","true")}),document.body.addEventListener("mousedown",function(){this.classList.add("using-mouse"),t.forEachEl(".menu-item-has-children",function(e){e.classList.remove("wpbf-sub-menu-focus")})}),document.body.addEventListener("keydown",function(){this.classList.remove("using-mouse")}),t.listenDocumentEvent("mouseenter",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-sub-menu-focus)",function(){document.body.classList.add("using-mouse"),t.forEachEl(".menu-item-has-children",function(e){e.classList.remove("wpbf-sub-menu-focus")});let e=t.directQuerySelector(this,"a");e&&e.focus()}),t.listenDocumentEvent("mouseleave",".wpbf-sub-menu > .menu-item-has-children.wpbf-sub-menu-focus",function(){this.classList.remove("wpbf-sub-menu-focus")}),t.listenDocumentEvent("focus",".wpbf-sub-menu a",function(){if(document.body.classList.contains("using-mouse"))return;t.forEachEl(".wpbf-sub-menu > .menu-item-has-children",function(e){e.classList.remove("wpbf-sub-menu-focus")}),t.forEachEl(".wpbf-sub-menu > .menu-item-has-children > .sub-menu",function(e){e instanceof HTMLElement&&(e.style.display="none")});let e=this;for(;e.parentNode&&e.parentNode instanceof HTMLElement;)e.classList.contains("menu-item-has-children")&&e.classList.add("wpbf-sub-menu-focus"),e=e.parentNode}),e.isInsideCustomizer()&&wp.customize.bind("preview-ready",function(){wp.customize.selectiveRefresh.bind("partial-content-rendered",function(e){s=t.getAttrAsNumber(".wpbf-navigation","data-sub-menu-animation-duration"),a()})})}(e),function(e){let t;let n=e.dom,i=e.anim,s=n.getBreakpoints();function o(){let e=document.querySelector(".wpbf-mobile-menu-hamburger");if(e){t="hamburger";return}if(e=document.querySelector(".wpbf-mobile-menu-default")){t="default";return}t="premium"}function a(e){let t=n.findHtmlEl("#mobile-navigation");t&&(t.style.overflow=e)}window.addEventListener("resize",function(e){s=n.getBreakpoints()}),o(),n.listenDocumentEvent("click",".wpbf-mobile-menu a",function(){if("premium"===t||!this.href.match("#")&&!this.href.match("/#"))return;let e=this.parentNode;e instanceof HTMLElement&&e.classList.contains("menu-item-has-children")?this.closest(".wpbf-mobile-mega-menu")?l(t):function(e){let t=n.getSiblings(e,".wpbf-submenu-toggle");if(!t.length)return;let i=t[0];i.classList.contains("active")?f(i):r(i)}(this):l(t)}),n.listenDocumentEvent("click",".wpbf-mobile-menu-toggle",function(){o(),function(e){if("premium"===e)return;let t=document.querySelector("#wpbf-mobile-menu-toggle");t&&(t.classList.contains("active")?l(e):function(e){if("premium"===e)return;let t=n.findHtmlEl("#wpbf-mobile-menu-toggle"),s=n.findHtmlEl(".wpbf-mobile-menu-container");s&&!s.classList.contains("active")&&(a("hidden"),i.slideToggle({el:s,direction:"down",callback:()=>{s.classList.add("active"),a("auto")},animScope:c})),t&&(t.classList.add("active"),t.setAttribute("aria-expanded","true"),"hamburger"===e&&(t.classList.remove("wpbff-hamburger"),t.classList.add("wpbff-times")))}(e))}(t)}),window.addEventListener("resize",function(){let e=document.documentElement.clientHeight,i=document.documentElement.clientWidth,o=document.querySelector(".wpbf-mobile-nav-wrapper"),a=o&&o instanceof HTMLElement?o.offsetHeight:0;n.forEachEl(".wpbf-mobile-menu-container.active nav",function(t){t instanceof HTMLElement&&(t.style.maxHeight=e-a+"px")}),i>s.desktop&&l(t)}),u("default"),u("hamburger");let c="mobile-menu-anim";function l(e){if("premium"===e)return;let t=n.findHtmlEl("#wpbf-mobile-menu-toggle");if(!t||!t.classList.contains("active"))return;let s=n.findHtmlEl(".wpbf-mobile-menu-container");s&&s.classList.contains("active")&&(a("hidden"),i.slideToggle({el:s,direction:"up",callback:()=>{s.classList.remove("active")},animScope:c})),t&&(t.classList.remove("active"),t.setAttribute("aria-expanded","false"),"hamburger"===e&&(t.classList.remove("wpbff-times"),t.classList.add("wpbff-hamburger")))}function u(e){n.listenDocumentEvent("click","hamburger"===e?".wpbf-mobile-menu-hamburger .wpbf-submenu-toggle":".wpbf-mobile-menu-default .wpbf-submenu-toggle",function(e){e.preventDefault(),this.classList.contains("active")?f(this):r(this)})}let m="mobile-submenu-anim";function r(e){e.querySelectorAll("i").forEach(function(e){e.classList.remove("wpbff-arrow-down"),e.classList.add("wpbff-arrow-up")}),e.classList.add("active"),e.setAttribute("aria-expanded","true"),n.getSiblings(e,".sub-menu").forEach(function(e){i.slideToggle({el:e,direction:"down",callback:()=>{},animScope:m})}),function(e){let t=e.closest(".wpbf-navigation");if(t&&!t.classList.contains("wpbf-mobile-sub-menu-auto-collapse"))return;let i=[],s=e.closest(".menu-item-has-children");s&&s instanceof HTMLElement&&(i=n.getSiblings(s,".menu-item-has-children")),i.forEach(function(e){let t=e.querySelector(".wpbf-submenu-toggle");t&&t instanceof HTMLElement&&f(t)})}(e)}function f(e){e.querySelectorAll("i").forEach(function(e){e.classList.remove("wpbff-arrow-up"),e.classList.add("wpbff-arrow-down")}),e.classList.remove("active"),e.setAttribute("aria-expanded","false"),n.getSiblings(e,".sub-menu").forEach(function(e){i.slideToggle({el:e,direction:"up",callback:()=>{},animScope:m})})}}(e),window.WpbfTheme={breakpoints:e.dom.getBreakpoints(),activeBreakpoint:e.dom.getActiveBreakpoint(),isInsideCustomizer:e.isInsideCustomizer()}}();
//# sourceMappingURL=site-min.js.map
