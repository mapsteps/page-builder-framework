!function(){function e(e){return e&&e.__esModule?e.default:e}var t={};function n(e,t,n){switch(t=t.trim().toLowerCase()){case"==":return e==n;case"===":return e===n;case"!=":return e!=n;case"!==":return e!==n;case">":return e>n;case">=":return e>=n;case"<":return e<n;case"<=":return e<=n;case"in":return i(e,n);case"not in":return!i(e,n)}return!1}function i(n,i){if(Array.isArray(i)){let e=!1;if(Array.isArray(n)){for(let t=0;t<n.length;++t)if(i.includes(n[t])){e=!0;break}}else i.includes(n)&&(e=!0);return e}if(Array.isArray(n))return n.includes(i);if(/*@__PURE__*/e(t).isObject(n)){if(!/*@__PURE__*/e(t).isUndefined(n[i]))return!0;for(let e in n)if(n.hasOwnProperty(e)&&n[e]===i)return!0}return"string"==typeof n&&("string"==typeof i?-1<i.indexOf(n)&&-1<n.indexOf(i):-1<i.indexOf(n))}t=_,window.wp.customize?.bind("ready",()=>{if(window.wp.customize){var n;(n=window.wp.customize).section.each(function(e){let t=jQuery("#sub-accordion-section-"+e.id),n=jQuery("#accordion-section-"+e.id);n.hasClass("control-section-wpbf-expanded")&&t.appendTo(n)}),n.sectionConstructor["wpbf-link"]=n.Section.extend({attachEvents:function(){},isContextuallyActive:function(){return!0}}),function(n){n.bind("pane-contents-reflowed",function(){let e=[];n.section.each(function(t){"wpbf-nested"===t.params.type&&t.params.parentId&&e.push(t)}),e.sort(n.utils.prioritySort).reverse(),jQuery.each(e,function(e,t){t.headContainer&&jQuery("#sub-accordion-section-"+t.params.parentId).children(".section-meta").after(t.headContainer)})});let i=n.Section.prototype.embed,a=n.Section.prototype.isContextuallyActive,r=n.Section.prototype.attachEvents;n.Section=n.Section.extend({attachEvents:function(){let e=this;if("wpbf-nested"!==e.params.type||!e.params.parentId){r.call(e);return}r.call(e),e.expanded.bind(function(t){if(!e.params.parentId)return;let i=n.section(e.params.parentId);t?i.contentContainer?.addClass("current-section-parent"):i.contentContainer?.removeClass("current-section-parent")}),e.container?.find(".customize-section-back").off("click keydown").on("click keydown",function(t){!n.utils.isKeydownButNotEnterEvent(t)&&(t.preventDefault(),e.params.parentId&&e.expanded()&&n.section(e.params.parentId).expand(e.params))})},embed:function(){if("wpbf-nested"!==this.params.type||!this.params.parentId){i.call(this);return}i.call(this);let e=jQuery("#sub-accordion-section-"+this.params.parentId);this.headContainer&&e.append(this.headContainer)},isContextuallyActive:function(){let i=this;if("wpbf-nested"!==i.params.type)return a.call(this);let r=0,o=i._children("section","control");return n.section.each(function(e){e.params.parentId&&e.params.parentId===i.id&&o.push(e)}),o.sort(n.utils.prioritySort),/*@__PURE__*/e(t)(o).each(function(e){void 0!==e.isContextuallyActive?e.active()&&e.isContextuallyActive()&&(r+=1):e.active()&&(r+=1)}),0!==r}})}(n),function(){let e=document.querySelectorAll("[data-wpbf-parent-tab-id]"),t=[];function n(e,t){jQuery('[data-wpbf-tab-id="'+e+'"] .wpbf-tab-menu-item').removeClass("is-active");let n=document.querySelector('[data-wpbf-tab-id="'+e+'"] [data-wpbf-tab-menu-id="'+t+'"]');n&&n.classList.add("is-active"),document.querySelectorAll('[data-wpbf-parent-tab-id="'+e+'"]').forEach(function(e){e instanceof HTMLElement&&(e.dataset.wpbfParentTabItem===t?e.classList.remove("wpbf-tab-item-hidden"):e.classList.add("wpbf-tab-item-hidden"))})}e.forEach(function(e){if(!(e instanceof HTMLElement))return;let n=e.dataset.wpbfParentTabId;n&&!t.includes(n)&&t.push(n)}),jQuery(document).on("click",".wpbf-tab-menu-item a",function(e){if(e.preventDefault(),!(this instanceof HTMLElement))return;let t=this.parentElement;if(!t)return;let i=t.parentElement?.parentElement;if(!i)return;let a=i.dataset.wpbfTabId;if(!a)return;let r=t.dataset.wpbfTabMenuId;r&&n(a,r)}),t.forEach(function(e){window.wp.customize?.section(e,function(t){t.expanded.bind(function(t){if(t){let t=document.querySelector('[data-wpbf-tab-id="'+e+'"] .wpbf-tab-menu-item.is-active');if(t instanceof HTMLElement){let i=t.dataset.wpbfTabMenuId;i&&n(e,i)}}})})})}()}}),window.wp.customize&&window.wpbfCustomizerSectionDependencies&&function(e,t){if(!window.wp.customize)return;let i={};for(let e in t)if(t.hasOwnProperty(e))for(let n of t[e]){let t=n.setting;!t&&n.id&&(t=n.id),t&&(i[t]||(i[t]=[]),i[t].push({dependantSectionId:e,operator:n.operator,value:n.value}))}function a(t){for(let n in i)i.hasOwnProperty(n)&&function(t,n){e(t,function(e){let a=i[t];r(t,e.get(),a),n&&e.bind(function(e){r(t,e,a)})})}(n,t)}function r(i,a,r){for(let s of r){if(!n(a,s.operator,s.value)){c(s.dependantSectionId);continue}let r=t[s.dependantSectionId];if(r.length<2){o(s.dependantSectionId);continue}let d=!0;for(let t of r){let a=t.setting;if(!a&&t.id&&(a=t.id),a&&a!==i&&!n(e(a).get(),t.operator,t.value)){d=!1;break}}d?o(s.dependantSectionId):c(s.dependantSectionId)}}function o(t){e.section(t).activate()}function c(t){e.section(t).deactivate()}e.bind("ready",function(){a(!0)}),window.addEventListener("load",function(){a(!1)})}(window.wp.customize,window.wpbfCustomizerSectionDependencies)}();
//# sourceMappingURL=sections-min.js.map