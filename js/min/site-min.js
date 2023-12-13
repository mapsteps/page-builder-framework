!function(){function e(e,t){if((e instanceof NodeList||"string"==typeof e)&&"function"==typeof t){var n=e instanceof NodeList?e:document.querySelectorAll(e);if(n.length)for(var i=0;i<n.length;i++)t(n[i])}}function t(e,t,n){if("string"==typeof e&&"function"==typeof n){var i=e;switch(e){case"mouseenter":i="mouseover";break;case"mouseleave":i="mouseout"}document.addEventListener(i,(function(e){var i=e.target;if(t){if(!e.target||!e.target.closest)return;if(!(i=e.target.closest(t)))return}n.call(i,e)}))}}function n(e,t){var n=e instanceof HTMLElement?e:document.querySelector(e);return n&&n.getAttribute&&t?n.getAttribute(t):""}function i(e,t){var i=n(e,t);return i?parseInt(i,10):0}function s(){return!(!window.wp||!wp.customize)}var o={desktop:1024,tablet:768,mobile:480};function a(e){var t=o[e]||0,n="wpbf-"+e+"-breakpoint-[\\w-]*\\b",i=document.body.className.match(n);if(!i)return t;var s=i.toString().match(/\d+/),a=Array.isArray(s)?s[0]:s;return parseInt(a,10)||0}function u(){var e=o;return e.desktop=a("desktop"),e.tablet=a("tablet"),e.mobile=a("mobile"),e}function r(){var e=u(),t=document.documentElement.clientWidth,n="desktop";return t>e.desktop?n:n=t>e.tablet?"tablet":"mobile"}function c(e,t){if(!e.parentNode)return[];for(var n=[],i=e.parentNode.firstChild;i;)1===i.nodeType&&i!==e&&(t&&!i.matches(t)||n.push(i)),i=i.nextSibling;return n}function l(e){if(!e)return 0;var t=window.getComputedStyle(e);return e.offsetHeight-parseFloat(t.paddingTop)-parseFloat(t.paddingBottom)-parseFloat(t.borderTopWidth)-parseFloat(t.borderBottomWidth)}function m(e){var t=e.getAttribute("style");(function(e){var t=e.getAttribute("style");if(!t)return!1;var n=new RegExp("width\\s*:\\s*(\\d+\\w+)\\s*;"),i=t.match(n);return!!i&&i[1]})(e)&&e.setAttribute("style",t.replace(/width\s*:\s*(\d+\w+)\s*;/,""))}function d(e,t){var n=e.id?e.id:Math.random().toString(36).substring(2,9);e.id||(e.id=n);var i="aura-style-".concat(n),s=document.querySelector("#".concat(i));return s?(s.innerHTML=t,s):((s=document.createElement("style")).id="aura-style-".concat(n),s.innerHTML=t,document.head.appendChild(s),s)}function f(e,t){var n=window.scrollY,i=e-n,s=performance.now();requestAnimationFrame((function e(o){var a,u,r,c=o-s;window.scrollTo(0,(a=c,r=t,n+(u=i)/2-u/2*Math.cos(Math.PI*a/r))),c<t&&requestAnimationFrame(e)}))}function b(){var n=i(".wpbf-navigation","sub-menu-animation-duration");function o(){e(".wpbf-menu-item-search",(function(e){if(e.classList.contains("active")){var t=e.querySelector(".wpbf-menu-search");t&&(m(t),t.classList.remove("is-visible"),setTimeout((function(){t.classList.add("is-hidden")}),250)),setTimeout((function(){e.classList.remove("active"),e.setAttribute("aria-expanded","false")}),400)}}))}function a(){if(document.querySelector(".wpbf-menu-centered")){var t=document.querySelectorAll(".wpbf-navigation .wpbf-menu-centered .wpbf-menu > li > a").length/2;t=Math.floor(t),t-=1,e(".wpbf-menu-centered .logo-container",(function(e){var n=document.querySelector(".wpbf-navigation .wpbf-menu-centered .wpbf-menu > li:nth-child("+t+")");n&&(n.parentNode.insertBefore(e,n.nextSibling),e.style.display="block")}))}}function u(){if(!document.body.classList.contains("using-mouse")){e(".wpbf-sub-menu > .menu-item-has-children",(function(e){e.classList.remove("wpbf-sub-menu-focus")})),e(".wpbf-sub-menu > .menu-item-has-children > .sub-menu",(function(e){e.style.display="none"}));for(var t=this;t.parentNode;)t.classList.contains("menu-item-has-children")&&t.classList.add("wpbf-sub-menu-focus"),t=t.parentNode}}t("click",".wpbf-menu-item-search",(function(t){t.stopPropagation(),this.classList.contains("active")||t.preventDefault(),function(t){var n=document.querySelectorAll(".wpbf-navigation .wpbf-menu > li");Array.from(n).slice(-3).forEach((function(e){e.classList.add("calculate-width")}));var i=0;if(e(".calculate-width",(function(e){i+=e.offsetWidth})),i<200&&(i=250),!t.classList.contains("active")){t.classList.add("active"),t.setAttribute("aria-expanded","true");var s=t.querySelector(".wpbf-menu-search"),o=t.querySelector("input[type=search]");s&&o&&(d(s,".wpbf-menu-item-search .wpbf-menu-search.is-visible {width: ".concat(i,"px;}")),s.classList.remove("is-hidden"),setTimeout((function(){s.classList.add("is-visible")}),1),o.value="",o.focus())}}(this)})),window.addEventListener("click",(function(e){o()})),document.addEventListener("keyup",(function(e){"Escape"!==e.key&&"Esc"!==e.key?"Tab"===e.key&&(e.target.classList.contains("wpbff-search")||o()):o()})),a(),t("mouseenter",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",(function(e){var t=this.querySelector(".sub-menu");if(t.length){var i=t[0],s=d(i,".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children .sub-menu.is-visible {transition-duration: ".concat(n,"ms;}"));i.classList.add(".is-visible"),setTimeout((function(){s.parentNode.removeChild(s)}),n)}})),t("mouseleave",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",(function(){var e=this.querySelector(".sub-menu");e.length&&e[0].classList.remove(".is-visible")})),t("mouseenter",".wpbf-sub-menu-animation-fade > .menu-item-has-children",(function(){var e=this.querySelector(".sub-menu");if(e.length){var t=e[0],i=d(t,"\n\t\t\t\t\t.wpbf-sub-menu-animation-fade > .menu-item-has-children > .sub-menu {opacity: 0; transition: opacity ".concat(n,"ms ease-in-out;}\n\t\t\t\t\t"));t.classList.add("is-visible"),setTimeout((function(){i.parentNode.removeChild(i)}),n)}})),t("mouseleave",".wpbf-sub-menu-animation-fade > .menu-item-has-children",(function(){var e=this.querySelector(".sub-menu");if(e.length){var t=e[0],n=d(t,"\n\t\t\t\t\t.wpbf-sub-menu-animation-fade > .menu-item-has-children > .sub-menu {display:block; opacity: 0; transition: opacity 400ms ease-in-out;}\n\t\t\t\t\t");t.classList.remove("is-visible"),setTimeout((function(){n.parentNode.removeChild(n)}),400)}})),e(".menu-item-has-children",(function(e){e.setAttribute("aria-haspopup","true")})),document.body.addEventListener("mousedown",(function(){this.classList.add("using-mouse"),e(".menu-item-has-children",(function(e){e.classList.remove("wpbf-sub-menu-focus")}))})),document.body.addEventListener("keydown",(function(){this.classList.remove("using-mouse")})),t("mouseenter",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-sub-menu-focus)",(function(){document.body.classList.add("using-mouse"),e(".menu-item-has-children",(function(e){e.classList.remove("wpbf-sub-menu-focus")}));var t=function(e,t){var n=e.className;n=(n=n.replace(/^\s+|\s+$/g,"")).replace(/\s/g,".");var i=e.parentNode.querySelectorAll(".".concat(n," > ").concat(t));if(!i.length)return null;for(var s=null,o=0;o<i.length;o++)if(i[o].parentNode==e){s=i[o];break}return s}(this,"a");t&&t.focus()})),t("mouseleave",".wpbf-sub-menu > .menu-item-has-children.wpbf-sub-menu-focus",(function(){this.classList.remove("wpbf-sub-menu-focus")})),t("focus",".wpbf-sub-menu a",u),s()&&wp.customize.bind("preview-ready",(function(){wp.customize.selectiveRefresh.bind("partial-content-rendered",(function(e){n=i(".wpbf-navigation","sub-menu-animation-duration"),a()}))}))}function p(){var n,i=u();function s(){var e=document.querySelector(".wpbf-mobile-menu-hamburger");e?n="hamburger":(e=document.querySelector(".wpbf-mobile-menu-default"),n=e?"default":"premium")}function o(e){if("premium"!==e){var t=document.querySelector("#wpbf-mobile-menu-toggle");if(t&&t.classList.contains("active")){var n=document.querySelector(".wpbf-mobile-menu-container");n&&(n.classList.remove("active"),n.classList.remove("is-expanded"),setTimeout((function(){n.classList.add("is-hidden")}),400)),t.classList.remove("active"),t.setAttribute("aria-expanded","false"),"hamburger"===e&&(t.classList.remove("wpbff-times"),t.classList.add("wpbff-hamburger"))}}}function a(e){t("click","hamburger"===e?".wpbf-mobile-menu-hamburger .wpbf-submenu-toggle":".wpbf-mobile-menu-default .wpbf-submenu-toggle",(function(e){var t;e.preventDefault(),(t=this).classList.contains("active")?m(t):r(t)}))}function r(e){e.querySelectorAll("i").forEach((function(e){e.classList.remove("wpbff-arrow-down"),e.classList.add("wpbff-arrow-up")})),e.classList.add("active"),e.setAttribute("aria-expanded","true"),c(e,".sub-menu").forEach((function(e){var t=l(e);d(e,".wpbf-mobile-menu .sub-menu.aura-slide-anim.is-expanded {\n\t\t\t\t\theight: ".concat(t,"px;\n\t\t\t\t}")),e.classList.add("aura-slide-anim"),e.classList.remove("is-hidden"),e.classList.add("is-expanded")})),function(e){var t=e.closest(".wpbf-navigation");if(t&&!t.classList.contains("wpbf-mobile-sub-menu-auto-collapse"))return;var n=[],i=e.closest(".menu-item-has-children");i&&(n=c(i,".menu-item-has-children"));n.forEach((function(e){var t=e.querySelector(".wpbf-submenu-toggle");t&&m(t)}))}(e)}function m(e){e.querySelectorAll("i").forEach((function(e){e.classList.remove("wpbff-arrow-up"),e.classList.add("wpbff-arrow-down")})),e.classList.remove("active"),e.setAttribute("aria-expanded","false"),c(e,".sub-menu").forEach((function(e){e.classList.remove("is-expanded"),setTimeout((function(){e.classList.add("is-hidden")}),400)}))}window.addEventListener("resize",(function(e){i=u()})),s(),t("click",".wpbf-mobile-menu a",(function(){"premium"!==n&&(this.href.match("#")||this.href.match("/#"))&&(this.parentNode.classList.contains("menu-item-has-children")?this.closest(".wpbf-mobile-mega-menu")?o(n):function(e){if(c(e,".wpbf-submenu-toggle").length){var t=t[0];t.classList.contains("active")?m(t):r(t)}}(this):o(n))})),e(".wpbf-mobile-menu-container",(function(e){e.classList.add("is-hidden")})),t("click",".wpbf-mobile-menu-toggle",(function(){s(),function(e){if("premium"!==e){var t=document.querySelector("#wpbf-mobile-menu-toggle");t&&(t.classList.contains("active")?o(e):function(e){if("premium"!==e){var t=document.querySelector("#wpbf-mobile-menu-toggle");if(t){var n=document.querySelector(".wpbf-mobile-menu-container");if(n){n.classList.add("active");var i=l(n);d(n,".wpbf-mobile-menu-container.is-expanded {\n\t\t\t\t\theight: ".concat(i,"px;\n\t\t\t\t}")),n.classList.remove("is-hidden"),n.classList.add("is-expanded")}t.classList.add("active"),t.setAttribute("aria-expanded","true"),"hamburger"===e&&(t.classList.remove("wpbff-hamburger"),t.classList.add("wpbff-times"))}}}(e))}}(n)})),window.addEventListener("resize",(function(){var t=document.documentElement.clientHeight,s=document.documentElement.clientWidth,a=document.querySelector(".wpbf-mobile-nav-wrapper"),u=a?a.offsetHeight:0;e(".wpbf-mobile-menu-container.active nav",(function(e){e.style.maxHeight=t-u+"px"})),s>i.desktop&&o(n)})),a("default"),a("hamburger")}function v(){var n=u();function i(){var e=document.documentElement.clientWidth,t="";t=e>n.desktop?"wpbf-is-desktop":e>n.tablet?"wpbf-is-tablet":"wpbf-is-mobile",document.body.classList.remove("wpbf-is-desktop"),document.body.classList.remove("wpbf-is-tablet"),document.body.classList.remove("wpbf-is-mobile"),document.body.classList.add(t)}i(),function(){var n=document.querySelector(".scrolltop");if(n){var i=n.dataset.scrolltopValue;window.addEventListener("scroll",(function(t){window.scrollY>i?e(".scrolltop",(function(e){e.classList.add(".is-visible")})):e(".scrolltop",(function(e){e.classList.remove(".is-visible")}))})),t("click",".scrolltop",(function(e){document.body.tabIndex=-1,document.body.focus(),this.blur(),f(0,500)}))}}(),e(".wpcf7-form-control-wrap",(function(e){e.addEventListener("mouseenter",(function(){e.querySelectorAll(".wpcf7-not-valid-tip").forEach((function(e){e.classList.add("wpbf-fading"),e.classList.add("wpbf-fade-out"),function(e,t){e&&"number"==typeof t&&setTimeout((function(){e.style.display="none"}),t)}(e,400)}))}))})),function(){var e=document.querySelector(".wpbf-page");if(e){var t=window.getComputedStyle(e).marginTop;window.addEventListener("resize",(function(){e.offsetWidth>=document.documentElement.clientWidth?(e.style.marginTop="0",e.style.marginBottom="0"):(e.style.marginTop=t,e.style.marginBottom=t)}))}}(),window.addEventListener("resize",(function(e){i()})),window.addEventListener("load",(function(){window.setTimeout((function(){e(".opacity",(function(e){e.classList.add("is-visible")}))}),200),e(".display-none",(function(e){e.style.display="block"})),window.dispatchEvent(new Event("resize")),window.dispatchEvent(new Event("scroll"))}))}v(),b(),p();var h={getBreakpoints:u,getActiveBreakpoint:r,isInsideCustomizer:s,forEachEl:e,listenDocumentEvent:t,getAttr:n,getAttrAsNumber:i};window.Aura=h,window.Wpbf={site:{breakpoints:u(),activeBreakpoint:r(),isInsideCustomizer:s()}}}();