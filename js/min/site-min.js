!function(){function e(e,t){if((e instanceof NodeList||"string"==typeof e)&&"function"==typeof t){var n=e instanceof NodeList?e:document.querySelectorAll(e);if(n.length)for(var i=0;i<n.length;i++)t(n[i])}}function t(e,t,n){if("string"==typeof e&&"function"==typeof n){var i=e;switch(e){case"mouseenter":i="mouseover";break;case"mouseleave":i="mouseout"}document.addEventListener(i,(function(e){var s=e.target;if(t){if(!e.target||!e.target.closest)return;if(!(s=e.target.closest(t)))return}"mouseout"===i&&s.contains(e.relatedTarget)||n.call(s,e)}))}}function n(e,t){var n=e instanceof HTMLElement?e:document.querySelector(e);return n&&n.getAttribute&&t?n.getAttribute(t):""}function i(e,t){var i=n(e,t);return i?parseInt(i,10):0}function s(){return!(!window.wp||!wp.customize)}var a={desktop:1024,tablet:768,mobile:480};function o(e){var t=a[e]||0,n="wpbf-"+e+"-breakpoint-[\\w-]*\\b",i=document.body.className.match(n);if(!i)return t;var s=i.toString().match(/\d+/),o=Array.isArray(s)?s[0]:s;return parseInt(o,10)||0}function c(){var e=a;return e.desktop=o("desktop"),e.tablet=o("tablet"),e.mobile=o("mobile"),e}function r(){var e=c(),t=document.documentElement.clientWidth,n="desktop";return t>e.desktop?n:n=t>e.tablet?"tablet":"mobile"}function u(e,t){if(!e.parentNode)return[];for(var n=[],i=e.parentNode.firstChild;i;)1===i.nodeType&&i!==e&&(t&&!i.matches(t)||n.push(i)),i=i.nextSibling;return n}function l(e){if(!e)return 0;e.style.opacity="0",e.style.display="block";var t=window.getComputedStyle(e),n=e.offsetHeight-parseFloat(t.paddingTop)-parseFloat(t.paddingBottom)-parseFloat(t.borderTopWidth)-parseFloat(t.borderBottomWidth),i=e.getAttribute("style");return i&&(e.setAttribute("style",i.replace(/display\s*:\s*block\s*;/,"")),e.setAttribute("style",i.replace(/opacity\s*:\s*0\s*;/,""))),n}function d(e,t){var n=e.id?e.id:Math.random().toString(36).substring(2,9);e.id||(e.id=n);var i="aura-style-".concat(n),s=document.querySelector("#".concat(i));return s?(t&&(s.innerHTML=t),s):((s=document.createElement("style")).id="aura-style-".concat(n),t&&(s.innerHTML=t),document.head.appendChild(s),s)}function m(e){return d(e).id}function f(e,t){var n=window.scrollY,i=e-n,s=performance.now();requestAnimationFrame((function e(a){var o,c,r,u=a-s;window.scrollTo(0,(o=u,r=t,n+(c=i)/2-c/2*Math.cos(Math.PI*o/r))),u<t&&requestAnimationFrame(e)}))}function p(){var n=i(".wpbf-navigation","data-sub-menu-animation-duration");function a(){e(".wpbf-menu-item-search",(function(e){if(e.classList.contains("active")){var t=e.querySelector(".wpbf-menu-search");t&&(t.classList.remove("is-expanded"),setTimeout((function(){t.classList.remove("display-block")}),250)),setTimeout((function(){e.classList.remove("active"),e.setAttribute("aria-expanded","false")}),400)}}))}function o(){if(document.querySelector(".wpbf-menu-centered")){var t=document.querySelectorAll(".wpbf-navigation .wpbf-menu-centered .wpbf-menu > li > a").length/2;t=Math.floor(t),t-=1,e(".wpbf-menu-centered .logo-container",(function(e){var n=document.querySelector(".wpbf-navigation .wpbf-menu-centered .wpbf-menu > li:nth-child("+t+")");n&&(n.parentNode.insertBefore(e,n.nextSibling),e.style.display="block")}))}}function c(){if(!document.body.classList.contains("using-mouse")){e(".wpbf-sub-menu > .menu-item-has-children",(function(e){e.classList.remove("wpbf-sub-menu-focus")})),e(".wpbf-sub-menu > .menu-item-has-children > .sub-menu",(function(e){e.style.display="none"}));for(var t=this;t.parentNode;)t.classList.contains("menu-item-has-children")&&t.classList.add("wpbf-sub-menu-focus"),t=t.parentNode}}t("click",".wpbf-menu-item-search",(function(t){t.stopPropagation(),this.classList.contains("active")||t.preventDefault(),function(t){var n=document.querySelectorAll(".wpbf-navigation .wpbf-menu > li");Array.from(n).slice(-3).forEach((function(e){e.classList.add("calculate-width")}));var i=0;if(e(".calculate-width",(function(e){i+=e.offsetWidth})),i<200&&(i=250),!t.classList.contains("active")){t.classList.add("active"),t.setAttribute("aria-expanded","true");var s=t.querySelector(".wpbf-menu-search"),a=t.querySelector("input[type=search]");s&&a&&(d(s,"\n\t\t\t\t\t.wpbf-menu-item-search .wpbf-menu-search.display-block {display: block;}\n\t\t\t\t\t.wpbf-menu-item-search .wpbf-menu-search.is-expanded {width: ".concat(i,"px;}\n\t\t\t\t\t")),s.classList.add("display-block"),setTimeout((function(){s.classList.add("is-expanded")}),1),a.value="",a.focus())}}(this)})),window.addEventListener("click",(function(e){a()})),document.addEventListener("keyup",(function(e){"Escape"!==e.key&&"Esc"!==e.key?"Tab"===e.key&&(e.target.classList.contains("wpbff-search")||a()):a()})),o(),t("mouseenter",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",(function(e){var t=this.querySelector(".sub-menu");if(t&&!t.classList.contains("is-shown")){var i=m(t).replace("aura-style-","");d(t,"\n\t\t\t\t\t#".concat(i,".display-block {display: block;}\n\t\t\t\t\t#").concat(i,".is-shown {opacity: 1;}\n\t\t\t\t\t#").concat(i," {opacity: 0; transition-duration: ").concat(n,"ms;}\n\t\t\t\t\t")),t.classList.add("display-block"),setTimeout((function(){t.classList.add("is-shown")}),1)}})),t("mouseleave",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",(function(){var e=this.querySelector(".sub-menu");e&&e.classList.contains("is-shown")&&(e.classList.remove("is-shown"),setTimeout((function(){e.classList.remove("display-block")}),n))})),t("mouseenter",".wpbf-sub-menu-animation-fade > .menu-item-has-children",(function(){var e=this.querySelector(".sub-menu");if(e&&!e.classList.contains("is-shown")){var t=m(e).replace("aura-style-","");d(e,"\n\t\t\t\t\t#".concat(t,".display-block {display:block;}\n\t\t\t\t\t#").concat(t,".is-shown {opacity: 1;}\n\t\t\t\t\t#").concat(t," {opacity: 0; transition: opacity ").concat(n,"ms ease-in-out;}\n\t\t\t\t\t")),e.classList.add("display-block"),setTimeout((function(){e.classList.add("is-shown")}),1)}})),t("mouseleave",".wpbf-sub-menu-animation-fade > .menu-item-has-children",(function(e){var t=this.querySelector(".sub-menu");t&&t.classList.contains("is-shown")&&(t.classList.remove("is-shown"),setTimeout((function(){t.classList.remove("display-block")}),n))})),e(".menu-item-has-children",(function(e){e.setAttribute("aria-haspopup","true")})),document.body.addEventListener("mousedown",(function(){this.classList.add("using-mouse"),e(".menu-item-has-children",(function(e){e.classList.remove("wpbf-sub-menu-focus")}))})),document.body.addEventListener("keydown",(function(){this.classList.remove("using-mouse")})),t("mouseenter",".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-sub-menu-focus)",(function(){document.body.classList.add("using-mouse"),e(".menu-item-has-children",(function(e){e.classList.remove("wpbf-sub-menu-focus")}));var t=function(e,t){var n=e.className;n=(n=n.replace(/^\s+|\s+$/g,"")).replace(/\s/g,".");var i=e.parentNode.querySelectorAll(".".concat(n," > ").concat(t));if(!i.length)return null;for(var s=null,a=0;a<i.length;a++)if(i[a].parentNode==e){s=i[a];break}return s}(this,"a");t&&t.focus()})),t("mouseleave",".wpbf-sub-menu > .menu-item-has-children.wpbf-sub-menu-focus",(function(){this.classList.remove("wpbf-sub-menu-focus")})),t("focus",".wpbf-sub-menu a",c),s()&&wp.customize.bind("preview-ready",(function(){wp.customize.selectiveRefresh.bind("partial-content-rendered",(function(e){n=i(".wpbf-navigation","data-sub-menu-animation-duration"),o()}))}))}function b(){var n,i=c();function s(){var e=document.querySelector(".wpbf-mobile-menu-hamburger");e?n="hamburger":(e=document.querySelector(".wpbf-mobile-menu-default"),n=e?"default":"premium")}function a(e){if("premium"!==e){var t=document.querySelector("#wpbf-mobile-menu-toggle");if(t&&t.classList.contains("active")){var n=document.querySelector(".wpbf-mobile-menu-container");n&&n.classList.contains("active")&&(n.classList.remove("active"),n.classList.remove("is-expanded"),setTimeout((function(){n.classList.remove("aura-slide-anim")}),400)),t.classList.remove("active"),t.setAttribute("aria-expanded","false"),"hamburger"===e&&(t.classList.remove("wpbff-times"),t.classList.add("wpbff-hamburger"))}}}function o(e){t("click","hamburger"===e?".wpbf-mobile-menu-hamburger .wpbf-submenu-toggle":".wpbf-mobile-menu-default .wpbf-submenu-toggle",(function(e){var t;e.preventDefault(),(t=this).classList.contains("active")?f(t):r(t)}))}function r(e){e.querySelectorAll("i").forEach((function(e){e.classList.remove("wpbff-arrow-down"),e.classList.add("wpbff-arrow-up")})),e.classList.add("active"),e.setAttribute("aria-expanded","true"),u(e,".sub-menu").forEach((function(e){var t=l(e),n=m(e).replace("aura-style-","");d(e,"#".concat(n,".aura-slide-anim {display: block; height: 0;}"),"#".concat(n,".aura-slide-anim.is-expanded {height: ").concat(t,"px;}")),e.classList.add("aura-slide-anim"),setTimeout((function(){e.classList.add("is-expanded")}),1)})),function(e){var t=e.closest(".wpbf-navigation");if(t&&!t.classList.contains("wpbf-mobile-sub-menu-auto-collapse"))return;var n=[],i=e.closest(".menu-item-has-children");i&&(n=u(i,".menu-item-has-children"));n.forEach((function(e){var t=e.querySelector(".wpbf-submenu-toggle");t&&f(t)}))}(e)}function f(e){e.querySelectorAll("i").forEach((function(e){e.classList.remove("wpbff-arrow-up"),e.classList.add("wpbff-arrow-down")})),e.classList.remove("active"),e.setAttribute("aria-expanded","false"),u(e,".sub-menu").forEach((function(e){e.classList.remove("is-expanded"),setTimeout((function(){e.classList.remove("aura-slide-anim")}),400)}))}window.addEventListener("resize",(function(e){i=c()})),s(),t("click",".wpbf-mobile-menu a",(function(){"premium"!==n&&(this.href.match("#")||this.href.match("/#"))&&(this.parentNode.classList.contains("menu-item-has-children")?this.closest(".wpbf-mobile-mega-menu")?a(n):function(e){if(u(e,".wpbf-submenu-toggle").length){var t=t[0];t.classList.contains("active")?f(t):r(t)}}(this):a(n))})),t("click",".wpbf-mobile-menu-toggle",(function(){s(),function(e){if("premium"!==e){var t=document.querySelector("#wpbf-mobile-menu-toggle");t&&(t.classList.contains("active")?a(e):function(e){if("premium"!==e){var t=document.querySelector("#wpbf-mobile-menu-toggle");if(t){var n=document.querySelector(".wpbf-mobile-menu-container");if(n&&!n.classList.contains("active")){n.classList.add("active");var i=l(n),s=m(n).replace("aura-style-","");d(n,"\n\t\t\t\t#".concat(s,".aura-slide-anim {display: block; height: 0;}\n\t\t\t\t#").concat(s,".aura-slide-anim.is-expanded {height: ").concat(i,"px;}\n\t\t\t\t")),n.classList.add("aura-slide-anim"),setTimeout((function(){n.classList.add("is-expanded")}),1)}t.classList.add("active"),t.setAttribute("aria-expanded","true"),"hamburger"===e&&(t.classList.remove("wpbff-hamburger"),t.classList.add("wpbff-times"))}}}(e))}}(n)})),window.addEventListener("resize",(function(){var t=document.documentElement.clientHeight,s=document.documentElement.clientWidth,o=document.querySelector(".wpbf-mobile-nav-wrapper"),c=o?o.offsetHeight:0;e(".wpbf-mobile-menu-container.active nav",(function(e){e.style.maxHeight=t-c+"px"})),s>i.desktop&&a(n)})),o("default"),o("hamburger")}function w(){var n=c();function i(){var e=document.documentElement.clientWidth,t="";t=e>n.desktop?"wpbf-is-desktop":e>n.tablet?"wpbf-is-tablet":"wpbf-is-mobile",document.body.classList.remove("wpbf-is-desktop"),document.body.classList.remove("wpbf-is-tablet"),document.body.classList.remove("wpbf-is-mobile"),document.body.classList.add(t)}i(),function(){var n=document.querySelector(".scrolltop");if(n){var i=n.dataset.scrolltopValue;window.addEventListener("scroll",(function(t){window.scrollY>i?e(".scrolltop",(function(e){e.classList.add(".is-visible")})):e(".scrolltop",(function(e){e.classList.remove(".is-visible")}))})),t("click",".scrolltop",(function(e){document.body.tabIndex=-1,document.body.focus(),this.blur(),f(0,500)}))}}(),e(".wpcf7-form-control-wrap",(function(e){e.addEventListener("mouseenter",(function(){e.querySelectorAll(".wpcf7-not-valid-tip").forEach((function(e){e.classList.add("wpbf-fading"),e.classList.add("wpbf-fade-out"),function(e,t){e&&"number"==typeof t&&setTimeout((function(){e.style.display="none"}),t)}(e,400)}))}))})),function(){var e=document.querySelector(".wpbf-page");if(e){var t=window.getComputedStyle(e).marginTop;window.addEventListener("resize",(function(){e.offsetWidth>=document.documentElement.clientWidth?(e.style.marginTop="0",e.style.marginBottom="0"):(e.style.marginTop=t,e.style.marginBottom=t)}))}}(),window.addEventListener("resize",(function(e){i()})),window.addEventListener("load",(function(){window.setTimeout((function(){e(".opacity",(function(e){e.classList.add("is-visible")}))}),200),e(".display-none",(function(e){e.style.display="block"})),window.dispatchEvent(new Event("resize")),window.dispatchEvent(new Event("scroll"))}))}w(),p(),b();var v={getBreakpoints:c,getActiveBreakpoint:r,isInsideCustomizer:s,forEachEl:e,listenDocumentEvent:t,getAttr:n,getAttrAsNumber:i};window.Aura=v,window.Wpbf={site:{breakpoints:c(),activeBreakpoint:r(),isInsideCustomizer:s()}}}();