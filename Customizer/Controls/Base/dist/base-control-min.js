!function(){function t(t){return t&&t.__esModule?t.default:t}var n,e="undefined"!=typeof globalThis?globalThis:"undefined"!=typeof self?self:"undefined"!=typeof window?window:"undefined"!=typeof global?global:{},i={},o={},r=e.parcelRequire94c2;null==r&&((r=function(t){if(t in i)return i[t].exports;if(t in o){var n=o[t];delete o[t];var e={id:t,exports:{}};return i[t]=e,n.call(e.exports,e,e.exports),e.exports}var r=Error("Cannot find module '"+t+"'");throw r.code="MODULE_NOT_FOUND",r}).register=function(t,n){o[t]=n},e.parcelRequire94c2=r);var a=r.register;a("aexpI",function(t,n){t.exports=_}),a("62vR5",function(n,e){Object.defineProperty(n.exports,"default",{get:function(){return a},set:void 0,enumerable:!0,configurable:!0});var i=r("4RLYt"),o=r("aexpI");function a(n){n.wpbfDynamicControl=n.Control.extend({initialize:function(e,r){r.type||(r.type="wpbf-generic");var a="";if(r.content){var l=r.content.split('class="');a=(l=l[1].split('"'))[0]}else a="customize-control customize-control-"+r.type;if(r.content){var c,s=t(i)(r.content);s.attr("id","customize-control-"+e.replace(/]/g,"").replace(/\[/g,"-")),s.attr("class",a);var d=null!==(c=r.wrapperAttrs)&&void 0!==c?c:{};t(o).each(d,function(t,n){"class"===n&&(t=t.replace("{default_class}",a)),s.attr(n,t)}),r.content=s.prop("outerHTML")}this.propertyElements=[],n.Control.prototype.initialize.call(this,e,r),window.wp.hooks.doAction("wpbf.dynamicControl.init.after",e,this,r)},_setUpSettingRootLinks:function(){var e=this;e.container.find("[data-customize-setting-link]").each(function(o,r){var a=t(i)(this),l=this.dataset.customizeSettingLink;l&&n(l,function(t){var i=new n.Element(a);e.elements.push(i),i.sync(t),i.set(t())})})},_setUpSettingPropertyLinks:function(){var e=this;e.setting&&e.container.find("[data-customize-setting-property-link]").each(function(){var r,a=t(i)(this),l=a.data("customizeSettingPropertyLink");r=new n.Element(a),e.propertyElements.push(r),e.setting&&"function"==typeof e.setting&&(r.set(e.setting()[l]),r.bind(function(n){if(e.setting&&"function"==typeof e.setting){var i=e.setting();n!==i[l]&&((i=t(o).clone(i))[l]=n,e.setting.set(i))}}),e.setting.bind(function(t){t[l]!==r.get()&&r.set(t[l])}))})},ready:function(){var t,e,i,o=this;null===(t=this._setUpSettingRootLinks)||void 0===t||t.call(this),null===(e=this._setUpSettingPropertyLinks)||void 0===e||e.call(this),n.Control.prototype.ready.call(this),null===(i=this.deferred)||void 0===i||i.embedded.done(function(){var t;null===(t=o.initWpbfControl)||void 0===t||t.call(o),window.wp.hooks.doAction("wpbf.dynamicControl.ready.deferred.embedded.done",o)}),window.wp.hooks.doAction("wpbf.dynamicControl.ready.after",this)},embed:function(){var t,e=this,i=null===(t=this.section)||void 0===t?void 0:t.call(this);i&&(n.section(i,function(t){var i;"wpbf-expanded"===t.params.type||t.expanded()||n.settings.autofocus.control===e.id?null===(i=e.actuallyEmbed)||void 0===i||i.call(e):t.expanded.bind(function(t){var n;t&&(null===(n=e.actuallyEmbed)||void 0===n||n.call(e))})}),window.wp.hooks.doAction("wpbf.dynamicControl.embed.after",this))},actuallyEmbed:function(){var t,n,e,i;"resolved"!==(null===(n=this.deferred)||void 0===n?void 0:null===(t=n.embedded)||void 0===t?void 0:t.state())&&(null===(e=this.renderContent)||void 0===e||e.call(this),null===(i=this.deferred)||void 0===i||i.embedded.resolve(),window.wp.hooks.doAction("wpbf.dynamicControl.actuallyEmbed.after",this))},focus:function(t){var e;null===(e=this.actuallyEmbed)||void 0===e||e.call(this),n.Control.prototype.focus.call(this,t),window.wp.hooks.doAction("wpbf.dynamicControl.focus.after",this)},initWpbfControl:function(n){var e,o=this;window.wp.hooks.doAction("wpbf.dynamicControl.initWpbfControl",this),null===(e=this.container)||void 0===e||e.on("change input paste click","input",function(){o.setting&&"function"==typeof o.setting&&o.setting.set(t(i)(o).val())})},destroy:function(){var t;null===(t=this.container)||void 0===t||t.off("change input paste click","input")},updateCustomizerSetting:function(t){var n;null===(n=this.setting)||void 0===n||n.set(t)},findHtmlEl:function(t,n){if(t){if("string"==typeof t){var e=document.querySelector(t);return e instanceof HTMLElement?e:void 0}if(n){var i=t.querySelector(n);return i instanceof HTMLElement?i:void 0}}},findHtmlEls:function(t,n){return t?"string"==typeof t?Array.from(document.querySelectorAll(t)).filter(function(t){return t instanceof HTMLElement}):n?Array.from(t.querySelectorAll(n)).filter(function(t){return t instanceof HTMLElement}):[]:[]}})}}),a("4RLYt",function(t,n){t.exports=jQuery});var l=r("aexpI"),c=r("62vR5");function s(t,n,e){switch(n=n.trim().toLowerCase()){case"==":return t==e;case"===":return t===e;case"!=":return t!=e;case"!==":return t!==e;case">":return t>e;case">=":return t>=e;case"<":return t<e;case"<=":return t<=e;case"in":return d(t,e);case"not in":return!d(t,e)}return!1}function d(n,e){if(Array.isArray(e)){var i=!1;if(Array.isArray(n)){for(var o=0;o<n.length;++o)if(e.includes(n[o])){i=!0;break}}else e.includes(n)&&(i=!0);return i}if(Array.isArray(n))return n.includes(e);if(t(l).isObject(n)){if(!t(l).isUndefined(n[e]))return!0;for(var r in n)if(n.hasOwnProperty(r)&&n[r]===e)return!0}return"string"==typeof n&&("string"==typeof e?-1<e.indexOf(n)&&-1<n.indexOf(e):-1<e.indexOf(n))}var l=(r("aexpI"),r("aexpI"));function u(n){t(l).each(wpbfCustomizerTooltips,function(t){if(t.id===n.id&&!n.container.find(".tooltip-content").length){var e=document.querySelector("#customize-control-"+t.id+" .customize-control-title");if(e){e.classList.add("wpbf-tooltip-wrapper");var i=document.createElement("span");i.classList.add("tooltip-trigger"),i.innerHTML='<span class="dashicons dashicons-editor-help"></span>';var o=document.createElement("span");o.classList.add("tooltip-content"),o.innerHTML=t.content,e.appendChild(i),e.appendChild(o)}}})}(n=window.wp.customize)&&((0,c.default)(n),n.bind("ready",function(){!function(t){var n=[];t.control.each(function(e){n.includes(e.section())||n.push(e.section()),t.section(e.section(),function(n){n.expanded()||t.settings.autofocus.control===e.id?u(e):n.expanded.bind(function(t){t&&u(e)})})});var e=document.createElement("style"),i=document.querySelector(".wp-full-overlay-sidebar-content");e.classList.add("wpbf-tooltip-inline-styles"),document.head.appendChild(e),n.forEach(function(n){i&&t.section(n,function(t){t.expanded.bind(function(n){n&&(t.contentContainer&&t.contentContainer[0].scrollHeight>i.clientHeight?e.innerHTML=".wpbf-tooltip-wrapper span.tooltip-content {min-width: 258px;}":e.innerHTML="")})})})}(n)}),window.wpbfCustomizerControlDependencies&&function(t){if(window.wp.customize){var n={};for(var e in t)if(t.hasOwnProperty(e)){var i=t[e],o=!0,r=!1,a=void 0;try{for(var l,c=i[Symbol.iterator]();!(o=(l=c.next()).done);o=!0){var d=l.value,u=d.setting;!u&&d.id&&(u=d.id),u&&(n[u]||(n[u]=[]),n[u].push({dependantControlId:e,operator:d.operator,value:d.value}))}}catch(t){r=!0,a=t}finally{try{o||null==c.return||c.return()}finally{if(r)throw a}}}var f=window.wp.customize;f.bind("ready",function(){for(var t in n)n.hasOwnProperty(t)&&function(t){f(t,function(e){var i=n[t];p(t,e.get(),i),e.bind(function(n){p(t,n,i)})})}(t)})}function p(n,e,i){var o=!0,r=!1,a=void 0;try{for(var l,c=i[Symbol.iterator]();!(o=(l=c.next()).done);o=!0){var d=l.value;if(!s(e,d.operator,d.value)){v(d.dependantControlId);continue}var u=t[d.dependantControlId];if(u.length<2){h(d.dependantControlId);continue}var p=!0,y=!0,w=!1,m=void 0;try{for(var b,g=u[Symbol.iterator]();!(y=(b=g.next()).done);y=!0){var C=b.value,x=C.setting;if(!x&&C.id&&(x=C.id),x&&x!==n){var L=f(x).get();if(!s(L,C.operator,C.value)){p=!1;break}}}}catch(t){w=!0,m=t}finally{try{y||null==g.return||g.return()}finally{if(w)throw m}}p?h(d.dependantControlId):v(d.dependantControlId)}}catch(t){r=!0,a=t}finally{try{o||null==c.return||c.return()}finally{if(r)throw a}}}function v(t){var n,e,i,o,r;(r=null===(n=f.control(t))||void 0===n?void 0:n.container[0])&&r.dataset.wpbfParentTabId&&r.classList.contains("wpbf-tab-item-hidden")&&(null===(i=f.control(t))||void 0===i||i.container.removeClass("wpbf-tab-item-hidden"),null===(o=f.control(t))||void 0===o||o.container.addClass("wpbf-tab-item-invisible")),null===(e=f.control(t))||void 0===e||e.onChangeActive(!1,{completeCallback:function(){var n,e,i;(null===(n=f.control(t))||void 0===n?void 0:n.container.hasClass("wpbf-tab-item-invisible"))&&(null===(e=f.control(t))||void 0===e||e.container.removeClass("wpbf-tab-item-invisible"),null===(i=f.control(t))||void 0===i||i.container.addClass("wpbf-tab-item-hidden"))}})}function h(t){var n;null===(n=f.control(t))||void 0===n||n.onChangeActive(!0,{})}}(window.wpbfCustomizerControlDependencies),n.Value.prototype.set=function(n){var e=this._value;return n=this._setter.apply(this,arguments),null===(n=this.validate(n))||t(l).isEqual(e,n)||(this._value=n,this._dirty=!0,this.callbacks.fireWith(this,[n,e])),this},n.Value.prototype.get=function(){return this._value})}();
//# sourceMappingURL=base-control-min.js.map
