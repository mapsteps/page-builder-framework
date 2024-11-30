!function(){function t(t){return t&&t.__esModule?t.default:t}var e,n,o={};o=_;var i={};function r(t,e,n){switch(e=e.trim().toLowerCase()){case"==":return t==n;case"===":return t===n;case"!=":return t!=n;case"!==":return t!==n;case">":return t>n;case">=":return t>=n;case"<":return t<n;case"<=":return t<=n;case"in":return s(t,n);case"not in":return!s(t,n)}return!1}function s(e,n){if(Array.isArray(n)){let t=!1;if(Array.isArray(e)){for(let o=0;o<e.length;++o)if(n.includes(e[o])){t=!0;break}}else n.includes(e)&&(t=!0);return t}if(Array.isArray(e))return e.includes(n);if(/*@__PURE__*/t(o).isObject(e)){if(!/*@__PURE__*/t(o).isUndefined(e[n]))return!0;for(let t in e)if(e.hasOwnProperty(t)&&e[t]===n)return!0}return"string"==typeof e&&("string"==typeof n?-1<n.indexOf(e)&&-1<e.indexOf(n):-1<n.indexOf(e))}function c(e){/*@__PURE__*/t(o).each(wpbfCustomizerTooltips,function(t){if(t.id!==e.id||e.container.find(".tooltip-content").length)return;let n=document.querySelector("#customize-control-"+t.id+" .customize-control-title");if(!n)return;n.classList.add("wpbf-tooltip-wrapper");let o=document.createElement("span");o.classList.add("tooltip-trigger"),o.innerHTML='<span class="dashicons dashicons-editor-help"></span>';let i=document.createElement("span");i.classList.add("tooltip-content"),i.innerHTML=t.content,n.appendChild(o),n.appendChild(i)})}i=jQuery,window.wp.customize&&((e=window.wp.customize).wpbfDynamicControl=e.Control.extend({initialize:function(n,r){r.type||(r.type="wpbf-generic");let s="";if(r.content){let t=r.content.split('class="');s=(t=t[1].split('"'))[0]}else s="customize-control customize-control-"+r.type;if(r.content){let e=/*@__PURE__*/t(i)(r.content);e.attr("id","customize-control-"+n.replace(/]/g,"").replace(/\[/g,"-")),e.attr("class",s);let c=r.wrapperAttrs??{};/*@__PURE__*/t(o).each(c,function(t,n){"class"===n&&(t=t.replace("{default_class}",s)),e.attr(n,t)}),r.content=e.prop("outerHTML")}this.propertyElements=[],e.Control.prototype.initialize.call(this,n,r),window.wp.hooks.doAction("wpbf.dynamicControl.init.after",n,this,r)},_setUpSettingRootLinks:function(){let n=this;n.container.find("[data-customize-setting-link]").each(function(o,r){let s=/*@__PURE__*/t(i)(this),c=this.dataset.customizeSettingLink;c&&e(c,function(t){let o=new e.Element(s);n.elements.push(o),o.sync(t),o.set(t())})})},_setUpSettingPropertyLinks:function(){let n=this;n.setting&&n.container.find("[data-customize-setting-property-link]").each(function(){let r;let s=/*@__PURE__*/t(i)(this),c=s.data("customizeSettingPropertyLink");r=new e.Element(s),n.propertyElements.push(r),n.setting&&"function"==typeof n.setting&&(r.set(n.setting()[c]),r.bind(function(e){if(!n.setting||"function"!=typeof n.setting)return;let i=n.setting();e!==i[c]&&((i=/*@__PURE__*/t(o).clone(i))[c]=e,n.setting.set(i))}),n.setting.bind(function(t){t[c]!==r.get()&&r.set(t[c])}))})},ready:function(){let t=this;t._setUpSettingRootLinks?.(),t._setUpSettingPropertyLinks?.(),e.Control.prototype.ready.call(t),t.deferred.embedded.done(function(){t.initWpbfControl?.(),window.wp.hooks.doAction("wpbf.dynamicControl.ready.deferred.embedded.done",t)}),window.wp.hooks.doAction("wpbf.dynamicControl.ready.after",t)},embed:function(){let t=this,n=t.section();n&&(e.section(n,function(n){"wpbf-expanded"===n.params.type||n.expanded()||e.settings.autofocus.control===t.id?t.actuallyEmbed?.():n.expanded.bind(function(e){e&&t.actuallyEmbed?.()})}),window.wp.hooks.doAction("wpbf.dynamicControl.embed.after",t))},actuallyEmbed:function(){"resolved"!==this.deferred.embedded.state()&&(this.renderContent(),this.deferred.embedded.resolve(),window.wp.hooks.doAction("wpbf.dynamicControl.actuallyEmbed.after",this))},focus:function(t){this.actuallyEmbed?.(),e.Control.prototype.focus.call(this,t),window.wp.hooks.doAction("wpbf.dynamicControl.focus.after",this)},initWpbfControl:function(e){e=e||this,window.wp.hooks.doAction("wpbf.dynamicControl.initWpbfControl",this),e.container.on("change keyup paste click","input",function(){e?.setting&&"function"==typeof e?.setting&&e?.setting?.set(/*@__PURE__*/t(i)(this).val())})},findHtmlEl:function(t,e){if(!t)return;if("string"==typeof t){let e=document.querySelector(t);return e instanceof HTMLElement?e:void 0}if(!e)return;let n=t.querySelector(e);return n instanceof HTMLElement?n:void 0},findHtmlEls:function(t,e){return t?"string"==typeof t?Array.from(document.querySelectorAll(t)).filter(t=>t instanceof HTMLElement):e?Array.from(t.querySelectorAll(e)).filter(t=>t instanceof HTMLElement):[]:[]}}),window.wp.customize.bind("ready",()=>{window.wp.customize&&function(t){let e=[];t.control.each(function(n){e.includes(n.section())||e.push(n.section()),t.section(n.section(),function(e){e.expanded()||t.settings.autofocus.control===n.id?c(n):e.expanded.bind(function(t){t&&c(n)})})});let n=document.createElement("style"),o=document.querySelector(".wp-full-overlay-sidebar-content");n.classList.add("wpbf-tooltip-inline-styles"),document.head.appendChild(n),e.forEach(function(e){o&&t.section(e,function(t){t.expanded.bind(function(e){e&&(t.contentContainer&&t.contentContainer[0].scrollHeight>o.clientHeight?n.innerHTML=".wpbf-tooltip-wrapper span.tooltip-content {min-width: 258px;}":n.innerHTML="")})})})}(window.wp.customize)})),window.wpbfCustomizerControlDependencies&&function(t){if(!window.wp.customize)return;let e={};for(let n in t)if(t.hasOwnProperty(n))for(let o of t[n]){let t=o.setting;!t&&o.id&&(t=o.id),t&&(e[t]||(e[t]=[]),e[t].push({dependantControlId:n,operator:o.operator,value:o.value}))}let n=window.wp.customize;function o(e,o,c){for(let l of c){if(!r(o,l.operator,l.value)){i(l.dependantControlId);continue}let c=t[l.dependantControlId];if(c.length<2){s(l.dependantControlId);continue}let a=!0;for(let t of c){let o=t.setting;if(!o&&t.id&&(o=t.id),o&&o!==e&&!r(n(o).get(),t.operator,t.value)){a=!1;break}}a?s(l.dependantControlId):i(l.dependantControlId)}}function i(t){var e;(e=n.control(t)?.container[0])&&e.dataset.wpbfParentTabId&&e.classList.contains("wpbf-tab-item-hidden")&&(n.control(t)?.container.removeClass("wpbf-tab-item-hidden"),n.control(t)?.container.addClass("wpbf-tab-item-invisible")),n.control(t)?.onChangeActive(!1,{completeCallback:()=>{n.control(t)?.container.hasClass("wpbf-tab-item-invisible")&&(n.control(t)?.container.removeClass("wpbf-tab-item-invisible"),n.control(t)?.container.addClass("wpbf-tab-item-hidden"))}})}function s(t){n.control(t)?.onChangeActive(!0,{})}n.bind("ready",function(){for(let t in e)e.hasOwnProperty(t)&&function(t){n(t,function(n){let i=e[t];o(t,n.get(),i),n.bind(function(e){o(t,e,i)})})}(t)})}(window.wpbfCustomizerControlDependencies),(n=window.wp.customize)&&(n.Value.prototype.set=function(e){let n=this._value;return e=this._setter.apply(this,arguments),null===(e=this.validate(e))||/*@__PURE__*/t(o).isEqual(n,e)||(this._value=e,this._dirty=!0,this.callbacks.fireWith(this,[e,n])),this},n.Value.prototype.get=function(){return this._value})}();
//# sourceMappingURL=base-control-min.js.map
