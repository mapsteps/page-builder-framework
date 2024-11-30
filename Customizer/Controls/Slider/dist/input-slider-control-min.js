!function(){function t(t){return t&&t.__esModule?t.default:t}var e={};e=ReactDOM;var n={};function i(t){return!!("string"!=typeof t&&"number"!=typeof t||"string"==typeof t&&isNaN(parseFloat(t)))}function r(t,e,n){if(""===t||i(t))return"";let r="string"==typeof t?parseFloat(t):t;return"number"==typeof e&&r<e&&(r=e),"number"==typeof n&&r>n&&(r=n),r}function o(t,e,n){let o=function(t){if(""===t||null===t||i(t))return{number:"",unit:""};let e=String(t).trim(),n=-1<e.indexOf("-")?"-":"",r=function(t){if(!t)return"";let e=String(t).match(/[a-z%]+$/i);return e?e[0]:""}(e=e.replace(n,"")),o=r?e.replace(r,""):e;if(""===(o=o.trim()))return{number:"",unit:r};let a=o.endsWith("."),l=parseFloat(o=n+o);return isNaN(l)?{number:"",unit:r}:{number:l,unit:r,hasTrailingDotBeforeUnit:!!r&&!!a}}(t);return""===o.number?o:{number:r(o.number,e,n),unit:o.unit,hasTrailingDotBeforeUnit:o.hasTrailingDotBeforeUnit}}function a(t,e,n){let i=String(t).trim();if("-"===i)return"-";let r=i.endsWith(".");i=r?i.replace(".",""):i;let a=o(t,e,n);if(""===a.number)return r?"0.":"";let l=String(a.number);return r?l+".":a.unit?l+(a.hasTrailingDotBeforeUnit?".":"")+a.unit:l}function l(t,e,n){let i=o(t,e,n);return""===i.number?e:i.number}function u(t){return"string"==typeof t?t:t.toString()}function s(e){let i="";e.control.updateComponentState=t=>{"slider"===i?m(a(t,e.min,e.max)):"input"===i?f(l(t,e.min,e.max)):"reset"===i&&(f(t),m(t))};let s=(0,n.useRef)(null),c=(0,n.useRef)(null);function m(t){c&&c.current&&(c.current.value=u(t))}function f(t){s&&s.current&&(s.current.value=u(t))}let p=`wpbf-control-input-${e.customizerSetting?.id}`,d=l(e.value,e.min,e.max),b=a(e.value,e.min,e.max);return /*#__PURE__*//*@__PURE__*/t(n).createElement("div",{className:"wpbf-control-form",tabIndex:1},e.label||e.description?/*#__PURE__*//*@__PURE__*/t(n).createElement("label",{className:"wpbf-control-label",htmlFor:p},e.label&&/*#__PURE__*//*@__PURE__*/t(n).createElement("span",{className:"customize-control-title"},e.label),e.description&&/*#__PURE__*//*@__PURE__*/t(n).createElement("span",{className:"customize-control-description description",dangerouslySetInnerHTML:{__html:e.description}})):null,/*#__PURE__*//*@__PURE__*/t(n).createElement("div",{className:"customize-control-notifications-container",ref:e.setNotificationContainer}),/*#__PURE__*//*@__PURE__*/t(n).createElement("button",{type:"button",className:"wpbf-control-reset",onClick:function(t){""!==e.default&&void 0!==e.default?(f(e.default),m(e.default)):""!==e.value?(f(e.value),m(e.value)):(f(e.min),m("")),i="reset",s&&s.current&&e.customizerSetting?.set(s.current.value)}},/*#__PURE__*//*@__PURE__*/t(n).createElement("i",{className:"dashicons dashicons-image-rotate"})),/*#__PURE__*//*@__PURE__*/t(n).createElement("div",{className:"wpbf-control-cols"},/*#__PURE__*//*@__PURE__*/t(n).createElement("div",{className:"wpbf-control-left-col"},/*#__PURE__*//*@__PURE__*/t(n).createElement("input",{ref:s,type:"range",id:p,defaultValue:d,min:e.min,max:e.max,step:e.step,className:"wpbf-control-input-slider wpbf-pro-control-input-slider",onChange:function(t){i="slider";let n=r(parseFloat(t.target.value),e.min,e.max);if(!c||!c.current)return;let a=o(c.current.value,e.min,e.max),l=String(n)+a.unit;e.customizerSetting?.set(l)}})),/*#__PURE__*//*@__PURE__*/t(n).createElement("div",{className:"wpbf-control-right-col"},/*#__PURE__*//*@__PURE__*/t(n).createElement("input",{ref:c,type:"text",defaultValue:b,className:"wpbf-control-input",onChange:function(t){i="input",e.customizerSetting?.set(a(t.target.value,e.min,e.max))}}))))}n=React;let c=wp.customize.Control.extend({initialize:function(t,e){let n=this;n.setNotificationContainer=n.setNotificationContainer?.bind(n),wp.customize.Control.prototype.initialize.call(n,t,e),wp.customize.control.bind("removed",function t(e){n===e&&(n.destroy&&n.destroy(),n.container.remove(),wp.customize.control.unbind("removed",t))})},setNotificationContainer:function(t){this.notifications.container=jQuery(t),this.notifications.render()},renderContent:function(){let i=this.params;!this.root&&this.container&&(this.root=(0,e.createRoot)(this.container[0])),this.root?.render(/*#__PURE__*//*@__PURE__*/t(n).createElement(s,{control:this,customizerSetting:this.setting??void 0,setNotificationContainer:this.setNotificationContainer,label:i.label,description:i.description,min:i.min,max:i.max,step:i.step,default:i.default,value:i.value})),this.params.allowCollapse&&this.container.addClass("allowCollapse")},ready:function(){let t=this;t.setting&&t.setting.bind(e=>{t.updateComponentState?.(e)})},updateComponentState:t=>{},destroy:function(){this.root?.unmount(),this.root=void 0,wp.customize.Control.prototype.destroy&&wp.customize.Control.prototype.destroy.call(this)}});wp.customize.controlConstructor["wpbf-input-slider"]=c}();
//# sourceMappingURL=input-slider-control-min.js.map
