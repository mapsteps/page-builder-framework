!function(){function t(t,n,e,i){Object.defineProperty(t,n,{get:e,set:i,enumerable:!0,configurable:!0})}var n,e="undefined"!=typeof globalThis?globalThis:"undefined"!=typeof self?self:"undefined"!=typeof window?window:"undefined"!=typeof global?global:{},i={},r={},o=e.parcelRequire94c2;null==o&&((o=function(t){if(t in i)return i[t].exports;if(t in r){var n=r[t];delete r[t];var e={id:t,exports:{}};return i[t]=e,n.call(e.exports,e,e.exports),e.exports}var o=Error("Cannot find module '"+t+"'");throw o.code="MODULE_NOT_FOUND",o}).register=function(t,n){r[t]=n},e.parcelRequire94c2=o);var a=o.register;a("5FyZT",function(t,n){t.exports=ReactJSXRuntime}),a("4oMEk",function(t,n){t.exports=ReactDOM}),a("fXClA",function(t,n){t.exports=React}),a("mAzNr",function(n,e){t(n.exports,"makeValueForInput",function(){return a}),t(n.exports,"makeValueForSlider",function(){return s}),t(n.exports,"makeDevicesValue",function(){return u});var i=o("lzUob"),r=o("cASlb");function a(t,n,e){var i=String(t).trim();if("-"===i)return"-";var o=i.endsWith(".");i=o?i.replace(".",""):i;var a=(0,r.makeLimitedNumberUnitPair)(t,n,e);if(""===a.number)return o?"0.":"";var s=String(a.number);return o?s+".":a.unit?s+(a.hasTrailingDotBeforeUnit?".":"")+a.unit:s}function s(t,n,e){var i=(0,r.makeLimitedNumberUnitPair)(t,n,e);return""===i.number?n:i.number}function u(t,n,e,r){var o,s="string"==typeof n?(0,i.parseJsonOrUndefined)(n):n;if(!s)return o={},t.forEach(function(t){o[t]=""}),o;var u={};return t.forEach(function(t){if(!s.hasOwnProperty(t)){u[t]="";return}var n=a(s[t],e,r);u[t]="string"!=typeof n&&"number"!=typeof n?"":n}),u}}),a("lzUob",function(n,e){function i(t){try{return JSON.stringify(t)}catch(t){return""}}function r(t){if(""!==t&&t){if("string"!=typeof t)return t;try{return JSON.parse(t)}catch(t){return}}}t(n.exports,"encodeJsonOrDefault",function(){return i}),t(n.exports,"parseJsonOrUndefined",function(){return r})}),a("cASlb",function(n,e){function i(t){return!!("string"!=typeof t&&"number"!=typeof t||"string"==typeof t&&isNaN(parseFloat(t)))}function r(t,n,e){if(""===t||i(t))return"";var r="string"==typeof t?parseFloat(t):t;return"number"==typeof n&&r<n&&(r=n),"number"==typeof e&&r>e&&(r=e),r}function o(t,n,e){var o=function(t){if(""===t||null===t||i(t))return{number:"",unit:""};var n=String(t).trim(),e=-1<n.indexOf("-")?"-":"",r=function(t){if(!t)return"";var n=String(t).match(/[a-z%]+$/i);return n?n[0]:""}(n=n.replace(e,"")),o=r?n.replace(r,""):n;if(""===(o=o.trim()))return{number:"",unit:r};var a=o.endsWith("."),s=parseFloat(o=e+o);return isNaN(s)?{number:"",unit:r}:{number:s,unit:r,hasTrailingDotBeforeUnit:!!r&&!!a}}(t);return""===o.number?o:{number:r(o.number,n,e),unit:o.unit,hasTrailingDotBeforeUnit:o.hasTrailingDotBeforeUnit}}t(n.exports,"limitNumber",function(){return r}),t(n.exports,"makeLimitedNumberUnitPair",function(){return o})});var s=o("5FyZT"),u=o("4oMEk");function l(t,n){(null==n||n>t.length)&&(n=t.length);for(var e=0,i=Array(n);e<n;e++)i[e]=t[e];return i}var s=o("5FyZT"),c=o("fXClA"),s=o("5FyZT");function d(t){return(0,s.jsx)("div",{className:"wpbf-device-buttons",children:t.devices.map(function(t,n){var e="dashicons dashicons-".concat("mobile"===t?"smartphone":t);return(0,s.jsx)("button",{type:"button",className:"wpbf-device-button wpbf-device-button-".concat(t," ").concat(0===n?" is-active":""),"data-wpbf-device":t,children:(0,s.jsx)("i",{className:e})},n)})})}var f=o("mAzNr"),p=o("lzUob"),m=o("cASlb");function v(t){var n,e,i=(0,f.makeDevicesValue)(t.devices,t.default,t.min,t.max),r=function(t){if(Array.isArray(t))return t}(n=(0,c.useState)((0,f.makeDevicesValue)(t.devices,t.value,t.min,t.max)))||function(t,n){var e,i,r=null==t?null:"undefined"!=typeof Symbol&&t[Symbol.iterator]||t["@@iterator"];if(null!=r){var o=[],a=!0,s=!1;try{for(r=r.call(t);!(a=(e=r.next()).done)&&(o.push(e.value),2!==o.length);a=!0);}catch(t){s=!0,i=t}finally{try{a||null==r.return||r.return()}finally{if(s)throw i}}return o}}(n,2)||function(t,n){if(t){if("string"==typeof t)return l(t,2);var e=Object.prototype.toString.call(t).slice(8,-1);if("Object"===e&&t.constructor&&(e=t.constructor.name),"Map"===e||"Set"===e)return Array.from(e);if("Arguments"===e||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(e))return l(t,2)}}(n,2)||function(){throw TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}(),o=r[0],a=r[1];function u(n){var e,i=t.saveAsJson?(0,p.encodeJsonOrDefault)(n):n;null===(e=t.updateCustomizerSetting)||void 0===e||e.call(t,i)}return null===(e=t.overrideUpdateComponentStateFn)||void 0===e||e.call(t,function(n){a((0,f.makeDevicesValue)(t.devices,n,t.min,t.max))}),(0,s.jsxs)(s.Fragment,{children:[(0,s.jsxs)("header",{className:"wpbf-control-header",children:[t.label&&(0,s.jsx)("label",{className:"customize-control-title",htmlFor:"wpbf-control-input-".concat(t.id),children:(0,s.jsx)("span",{className:"customize-control-title",children:t.label})}),(0,s.jsx)(d,{devices:t.devices})]}),t.description&&(0,s.jsx)("span",{className:"customize-control-description description",dangerouslySetInnerHTML:{__html:t.description}}),(0,s.jsx)("div",{className:"customize-control-notifications-container",ref:t.setNotificationContainer}),(0,s.jsx)("div",{className:"wpbf-control-form",children:t.devices.map(function(n,e){var r=0===e;return(0,s.jsx)("div",{className:"wpbf-control-device wpbf-control-".concat(n," ").concat(r?"is-active":""),"data-wpbf-device":n,children:o.hasOwnProperty(n)&&(0,s.jsxs)(s.Fragment,{children:[(0,s.jsx)("button",{type:"button",className:"wpbf-control-reset",onClick:function(t){o.hasOwnProperty(n)&&i.hasOwnProperty(n)&&(o[n]=i[n],u(o))},children:(0,s.jsx)("i",{className:"dashicons dashicons-image-rotate"})}),(0,s.jsxs)("div",{className:"wpbf-control-cols",children:[(0,s.jsx)("div",{className:"wpbf-control-left-col",children:(0,s.jsx)("input",{type:"range",id:"wpbf-control-input-".concat(t.id,"-").concat(n),value:(0,f.makeValueForSlider)(o[n],t.min,t.max),min:t.min,max:t.max,step:t.step,className:"wpbf-control-input-slider wpbf-pro-control-input-slider",onChange:function(e){return function(n,e){if(o.hasOwnProperty(e)){var i=(0,f.makeValueForSlider)(n.target.value,t.min,t.max),r=o[e];if(r!==i){var a=(0,m.makeLimitedNumberUnitPair)(r,t.min,t.max);a.number!==i&&(o[e]=a.unit?i+a.unit:i,u(o))}}}(e,n)}})}),(0,s.jsx)("div",{className:"wpbf-control-right-col",children:(0,s.jsx)("input",{type:"text",value:(0,f.makeValueForInput)(o[n],t.min,t.max),className:"wpbf-control-input",onChange:function(e){return function(n,e){if(o.hasOwnProperty(e)){var i=(0,f.makeValueForInput)(n.target.value,t.min,t.max);o[e]=i,u(o)}}(e,n)}})})]})]})},e)})})]})}window.wp.customize&&(window.wp.customize.controlConstructor["wpbf-responsive-input-slider"]=(n=window.wp.customize).Control.extend({initialize:function(t,e){this.setNotificationContainer=null===(i=this.setNotificationContainer)||void 0===i?void 0:i.bind(this),this.overrideUpdateComponentStateFn=null===(r=this.overrideUpdateComponentStateFn)||void 0===r?void 0:r.bind(this),this.updateCustomizerSetting=null===(o=this.updateCustomizerSetting)||void 0===o?void 0:o.bind(this),n.Control.prototype.initialize.call(this,t,e);var i,r,o,a=this;n.control.bind("removed",function t(e){var i;a===e&&(a.destroy&&a.destroy(),null===(i=a.container)||void 0===i||i.remove(),n.control.unbind("removed",t))})},setNotificationContainer:function(t){var n;this.notifications&&(this.notifications.container=jQuery(t)),null===(n=this.notifications)||void 0===n||n.render()},renderContent:function(){var t,n,e,i,r,o,a,l,c,d,f,p,m,h,b;!this.root&&this.container&&(this.root=(0,u.createRoot)(this.container[0])),null===(f=this.root)||void 0===f||f.render((0,s.jsx)(v,{id:null!==(m=null===(t=this.setting)||void 0===t?void 0:t.id)&&void 0!==m?m:"",min:null===(n=this.params)||void 0===n?void 0:n.min,max:null===(e=this.params)||void 0===e?void 0:e.max,step:null===(i=this.params)||void 0===i?void 0:i.step,label:null===(r=this.params)||void 0===r?void 0:r.label,description:null===(o=this.params)||void 0===o?void 0:o.description,default:null!==(h=null===(a=this.params)||void 0===a?void 0:a.default)&&void 0!==h?h:"",value:null!==(b=null===(l=this.params)||void 0===l?void 0:l.value)&&void 0!==b?b:"",overrideUpdateComponentStateFn:this.overrideUpdateComponentStateFn,updateCustomizerSetting:this.updateCustomizerSetting,setNotificationContainer:this.setNotificationContainer,devices:null===(c=this.params)||void 0===c?void 0:c.devices,saveAsJson:null===(d=this.params)||void 0===d?void 0:d.saveAsJson})),null===(p=this.container)||void 0===p||p.addClass("allowCollapse")},ready:function(){var t,n=this;null===(t=this.setting)||void 0===t||t.bind(function(t){var e;null===(e=n.updateComponentState)||void 0===e||e.call(n,t)})},updateCustomizerSetting:function(t){var n;void 0!==t&&(null===(n=this.setting)||void 0===n||n.set(t))},updateComponentState:function(t){},overrideUpdateComponentStateFn:function(t){this.updateComponentState=t},destroy:function(){var t,e;null===(t=this.root)||void 0===t||t.unmount(),this.root=void 0,null===(e=n.Control.prototype.destroy)||void 0===e||e.call(this)}}))}();
//# sourceMappingURL=responsive-input-slider-control-min.js.map
