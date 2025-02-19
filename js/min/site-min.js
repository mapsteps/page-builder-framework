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
					`),t.classList.add(o),t.classList.add("display-block"),setTimeout(function(){t.classList.add("is-shown")},1)))}),t.listenDocumentEvent("mouseleave",e,function(e){let t=this.querySelector(".sub-menu");t&&t.classList.contains("is-shown")&&(t.classList.remove("is-shown"),setTimeout(function(){t.classList.remove("display-block"),t.classList.remove(o)},s))})}(),t.forEachEl(".menu-item-has-children",function(e){e.setAttribute("aria-haspopup","true")}),document.body.addEventListener("mousedown",function(){this.classList.add("using-mouse"),t.forEachEl(".menu-item-has-children",function(e){e.classList.remove("wpbf-sub-menu-focus")})}),document.body.addEventListener("keydown",function(){this.classList.remove("using-mouse")}),t.listenDocumentEvent("mouseenter",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-sub-menu-focus)",function(){document.body.classList.add("using-mouse"),t.forEachEl(".menu-item-has-children",function(e){e.classList.remove("wpbf-sub-menu-focus")});let e=t.directQuerySelector(this,"a");e&&e.focus()}),t.listenDocumentEvent("mouseleave",".wpbf-sub-menu > .menu-item-has-children.wpbf-sub-menu-focus",function(){this.classList.remove("wpbf-sub-menu-focus")}),t.listenDocumentEvent("focus",".wpbf-sub-menu a",function(){if(document.body.classList.contains("using-mouse"))return;t.forEachEl(".wpbf-sub-menu > .menu-item-has-children",function(e){e.classList.remove("wpbf-sub-menu-focus")}),t.forEachEl(".wpbf-sub-menu > .menu-item-has-children > .sub-menu",function(e){e instanceof HTMLElement&&(e.style.display="none")});let e=this;for(;e.parentNode&&e.parentNode instanceof HTMLElement;)e.classList.contains("menu-item-has-children")&&e.classList.add("wpbf-sub-menu-focus"),e=e.parentNode}),e.isInsideCustomizer()&&wp.customize.bind("preview-ready",function(){wp.customize.selectiveRefresh.bind("partial-content-rendered",function(e){s=t.getAttrAsNumber(".wpbf-navigation","data-sub-menu-animation-duration"),a()})})}(e),function(e){let t;let n=e.dom,i=e.anim,s=!!n.findHtmlEl(".wpbf-navigation.use-header-builder"),o=n.getBreakpoints();function a(){if(s&&n.findHtmlEl(".wpbf-mobile-menu-dropdown")){t="dropdown";return}if(n.findHtmlEl(".wpbf-mobile-menu-hamburger")){t="hamburger";return}if(n.findHtmlEl(".wpbf-mobile-menu-default")){t="default";return}t="premium"}function l(e){let t=n.findHtmlEl("#mobile-navigation");t&&(t.style.overflowY=e)}window.addEventListener("resize",function(e){o=n.getBreakpoints()}),a(),n.listenDocumentEvent("click",".wpbf-mobile-menu a",function(){if("premium"===t||!this.href.match("#")&&!this.href.match("/#"))return;let e=this.parentNode;e instanceof HTMLElement&&e.classList.contains("menu-item-has-children")?this.closest(".wpbf-mobile-mega-menu")?u(t):function(e){let t=n.getSiblings(e,".wpbf-submenu-toggle");if(!t.length)return;let i=t[0];i.classList.contains("active")?d(i):f(i)}(this):u(t)}),n.listenDocumentEvent("click",".wpbf-mobile-menu-toggle",function(){a(),function(e){if("premium"===e)return;let t=n.findHtmlEl("#wpbf-mobile-menu-toggle");t&&(t.classList.contains("active")?u(e):function(e){if("premium"===e)return;let t=n.findHtmlEl("#wpbf-mobile-menu-toggle"),o=n.findHtmlEl(".wpbf-mobile-menu-container");if(o&&!o.classList.contains("active")&&(l("hidden"),i.slideToggle({el:o,direction:"down",callback:()=>{o.classList.add("active"),l("auto")},animScope:c})),t&&(t.classList.add("active"),t.setAttribute("aria-expanded","true"),"hamburger"===e||"dropdown"===e)){if(s){let e=t.querySelector(".menu-trigger-button-svg");e instanceof SVGElement&&(e.style.display="none");let n=t.querySelector(".menu-trigger-button-text");n instanceof HTMLElement&&(n.style.display="none"),t.classList.add("wpbff")}else t.classList.remove("wpbff-hamburger");t.classList.add("wpbff-times")}}(e))}(t)}),window.addEventListener("resize",function(){let e=document.documentElement.clientHeight,i=document.documentElement.clientWidth,s=n.findHtmlEl(".wpbf-mobile-nav-wrapper"),a=s&&s instanceof HTMLElement?s.offsetHeight:0;n.forEachEl(".wpbf-mobile-menu-container.active nav",function(t){t instanceof HTMLElement&&(t.style.maxHeight=e-a+"px")}),i>o.desktop&&u(t)}),m("default"),m("hamburger");let c="mobile-menu-anim";function u(e){if("premium"===e)return;let t=n.findHtmlEl("#wpbf-mobile-menu-toggle");if(!t||!t.classList.contains("active"))return;let o=n.findHtmlEl(".wpbf-mobile-menu-container");if(o&&o.classList.contains("active")&&(l("hidden"),i.slideToggle({el:o,direction:"up",callback:()=>{o.classList.remove("active")},animScope:c})),t.classList.remove("active"),t.setAttribute("aria-expanded","false"),"hamburger"===e||"dropdown"===e){if(s){let e=t.querySelector(".menu-trigger-button-text");e instanceof HTMLElement&&!e.classList.contains("wpbf-is-hidden")&&(e.style.display="inline-block");let n=t.querySelector(".menu-trigger-button-svg");n instanceof SVGElement&&(n.style.display="inline-block"),t.classList.remove("wpbff")}else t.classList.add("wpbff-hamburger");t.classList.remove("wpbff-times")}}function m(e){n.listenDocumentEvent("click","hamburger"===e?".wpbf-mobile-menu-hamburger .wpbf-submenu-toggle":".wpbf-mobile-menu-default .wpbf-submenu-toggle",function(e){e.preventDefault(),this.classList.contains("active")?d(this):f(this)})}let r="mobile-submenu-anim";function f(e){e.querySelectorAll("i").forEach(function(e){e.classList.remove("wpbff-arrow-down"),e.classList.add("wpbff-arrow-up")}),e.classList.add("active"),e.setAttribute("aria-expanded","true"),n.getSiblings(e,".sub-menu").forEach(function(e){i.slideToggle({el:e,direction:"down",callback:()=>{},animScope:r})}),function(e){let t=e.closest(".wpbf-navigation");if(t&&!t.classList.contains("wpbf-mobile-sub-menu-auto-collapse"))return;let i=[],s=e.closest(".menu-item-has-children");s&&s instanceof HTMLElement&&(i=n.getSiblings(s,".menu-item-has-children")),i.forEach(function(e){let t=e.querySelector(".wpbf-submenu-toggle");t&&t instanceof HTMLElement&&d(t)})}(e)}function d(e){e.querySelectorAll("i").forEach(function(e){e.classList.remove("wpbff-arrow-up"),e.classList.add("wpbff-arrow-down")}),e.classList.remove("active"),e.setAttribute("aria-expanded","false"),n.getSiblings(e,".sub-menu").forEach(function(e){i.slideToggle({el:e,direction:"up",callback:()=>{},animScope:r})})}}(e),window.WpbfTheme={breakpoints:e.dom.getBreakpoints(),activeBreakpoint:e.dom.getActiveBreakpoint(),isInsideCustomizer:e.isInsideCustomizer()}}();
//# sourceMappingURL=site-min.js.map
