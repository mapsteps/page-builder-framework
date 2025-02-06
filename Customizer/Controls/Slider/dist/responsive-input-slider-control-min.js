!function(){function t(t,e,n,i){Object.defineProperty(t,e,{get:n,set:i,enumerable:!0,configurable:!0})}var e,n="undefined"!=typeof globalThis?globalThis:"undefined"!=typeof self?self:"undefined"!=typeof window?window:"undefined"!=typeof global?global:{},i={},r={},o=n.parcelRequire94c2;null==o&&((o=function(t){if(t in i)return i[t].exports;if(t in r){var e=r[t];delete r[t];var n={id:t,exports:{}};return i[t]=n,e.call(n.exports,n,n.exports),n.exports}var o=Error("Cannot find module '"+t+"'");throw o.code="MODULE_NOT_FOUND",o}).register=function(t,e){r[t]=e},n.parcelRequire94c2=o);var s=o.register;s("exqOy",function(t,e){t.exports=ReactJSXRuntime}),s("4sbVR",function(t,e){t.exports=ReactDOM}),s("cZYW6",function(t,e){t.exports=React}),s("9qF6j",function(e,n){t(e.exports,"makeValueForInput",function(){return s}),t(e.exports,"makeValueForSlider",function(){return a}),t(e.exports,"makeDevicesValue",function(){return u});var i=o("5CO2D"),r=o("6Q738");function s(t,e,n){let i=String(t).trim();if("-"===i)return"-";let o=i.endsWith(".");i=o?i.replace(".",""):i;let s=(0,r.makeLimitedNumberUnitPair)(t,e,n);if(""===s.number)return o?"0.":"";let a=String(s.number);return o?a+".":s.unit?a+(s.hasTrailingDotBeforeUnit?".":"")+s.unit:a}function a(t,e,n){let i=(0,r.makeLimitedNumberUnitPair)(t,e,n);return""===i.number?e:i.number}function u(t,e,n,r){let o="string"==typeof e?(0,i.parseJsonOrUndefined)(e):e;if(!o)return function(t){let e={};return t.forEach(t=>{e[t]=""}),e}(t);let a={};return t.forEach(t=>{if(!o.hasOwnProperty(t)){a[t]="";return}let e=s(o[t],n,r);a[t]="string"!=typeof e&&"number"!=typeof e?"":e}),a}}),s("5CO2D",function(e,n){function i(t){try{return JSON.stringify(t)}catch(t){return""}}function r(t){if(""!==t&&t){if("string"!=typeof t)return t;try{return JSON.parse(t)}catch(t){return}}}t(e.exports,"encodeJsonOrDefault",function(){return i}),t(e.exports,"parseJsonOrUndefined",function(){return r})}),s("6Q738",function(e,n){function i(t){return!!("string"!=typeof t&&"number"!=typeof t||"string"==typeof t&&isNaN(parseFloat(t)))}function r(t,e,n){if(""===t||i(t))return"";let r="string"==typeof t?parseFloat(t):t;return"number"==typeof e&&r<e&&(r=e),"number"==typeof n&&r>n&&(r=n),r}function o(t,e,n){let o=function(t){if(""===t||null===t||i(t))return{number:"",unit:""};let e=String(t).trim(),n=-1<e.indexOf("-")?"-":"",r=function(t){if(!t)return"";let e=String(t).match(/[a-z%]+$/i);return e?e[0]:""}(e=e.replace(n,"")),o=r?e.replace(r,""):e;if(""===(o=o.trim()))return{number:"",unit:r};let s=o.endsWith("."),a=parseFloat(o=n+o);return isNaN(a)?{number:"",unit:r}:{number:a,unit:r,hasTrailingDotBeforeUnit:!!r&&!!s}}(t);return""===o.number?o:{number:r(o.number,e,n),unit:o.unit,hasTrailingDotBeforeUnit:o.hasTrailingDotBeforeUnit}}t(e.exports,"limitNumber",function(){return r}),t(e.exports,"makeLimitedNumberUnitPair",function(){return o})});var a=o("exqOy"),u=o("4sbVR"),a=o("exqOy"),c=o("cZYW6"),a=o("exqOy");function l(t){return(0,a.jsx)("div",{className:"wpbf-device-buttons",children:t.devices.map((t,e)=>{let n=`dashicons dashicons-${"mobile"===t?"smartphone":t}`;return(0,a.jsx)("button",{type:"button",className:`wpbf-device-button wpbf-device-button-${t} ${0===e?" is-active":""}`,"data-wpbf-device":t,children:(0,a.jsx)("i",{className:n})},e)})})}var p=o("9qF6j"),d=o("5CO2D"),m=o("6Q738");function f(t){let e=(0,p.makeDevicesValue)(t.devices,t.default,t.min,t.max),[n,i]=(0,c.useState)((0,p.makeDevicesValue)(t.devices,t.value,t.min,t.max));function r(e){let n=t.saveAsJson?(0,d.encodeJsonOrDefault)(e):e;t.updateCustomizerSetting?.(n)}return t.overrideUpdateComponentStateFn?.(function(e){i((0,p.makeDevicesValue)(t.devices,e,t.min,t.max))}),(0,a.jsxs)(a.Fragment,{children:[(0,a.jsxs)("header",{className:"wpbf-control-header",children:[t.label&&(0,a.jsx)("label",{className:"customize-control-title",htmlFor:`wpbf-control-input-${t.id}`,children:(0,a.jsx)("span",{className:"customize-control-title",children:t.label})}),(0,a.jsx)(l,{devices:t.devices})]}),t.description&&(0,a.jsx)("span",{className:"customize-control-description description",dangerouslySetInnerHTML:{__html:t.description}}),(0,a.jsx)("div",{className:"customize-control-notifications-container",ref:t.setNotificationContainer}),(0,a.jsx)("div",{className:"wpbf-control-form",children:t.devices.map((i,o)=>{let s=0===o;return(0,a.jsx)("div",{className:`wpbf-control-device wpbf-control-${i} ${s?"is-active":""}`,"data-wpbf-device":i,children:n.hasOwnProperty(i)&&(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)("button",{type:"button",className:"wpbf-control-reset",onClick:t=>{n.hasOwnProperty(i)&&e.hasOwnProperty(i)&&(n[i]=e[i],r(n))},children:(0,a.jsx)("i",{className:"dashicons dashicons-image-rotate"})}),(0,a.jsxs)("div",{className:"wpbf-control-cols",children:[(0,a.jsx)("div",{className:"wpbf-control-left-col",children:(0,a.jsx)("input",{type:"range",id:`wpbf-control-input-${t.id}-${i}`,value:(0,p.makeValueForSlider)(n[i],t.min,t.max),min:t.min,max:t.max,step:t.step,className:"wpbf-control-input-slider wpbf-pro-control-input-slider",onChange:e=>(function(e,i){if(!n.hasOwnProperty(i))return;let o=(0,p.makeValueForSlider)(e.target.value,t.min,t.max),s=n[i];if(s===o)return;let a=(0,m.makeLimitedNumberUnitPair)(s,t.min,t.max);a.number!==o&&(n[i]=a.unit?o+a.unit:o,r(n))})(e,i)})}),(0,a.jsx)("div",{className:"wpbf-control-right-col",children:(0,a.jsx)("input",{type:"text",value:(0,p.makeValueForInput)(n[i],t.min,t.max),className:"wpbf-control-input",onChange:e=>(function(e,i){if(!n.hasOwnProperty(i))return;let o=(0,p.makeValueForInput)(e.target.value,t.min,t.max);n[i]=o,r(n)})(e,i)})})]})]})},o)})})]})}window.wp.customize&&(window.wp.customize.controlConstructor["wpbf-responsive-input-slider"]=(e=window.wp.customize).Control.extend({initialize:function(t,n){this.setNotificationContainer=this.setNotificationContainer?.bind(this),this.overrideUpdateComponentStateFn=this.overrideUpdateComponentStateFn?.bind(this),this.updateCustomizerSetting=this.updateCustomizerSetting?.bind(this),e.Control.prototype.initialize.call(this,t,n);let i=this;e.control.bind("removed",function t(n){i===n&&(i.destroy&&i.destroy(),i.container?.remove(),e.control.unbind("removed",t))})},setNotificationContainer:function(t){this.notifications&&(this.notifications.container=jQuery(t)),this.notifications?.render()},renderContent:function(){!this.root&&this.container&&(this.root=(0,u.createRoot)(this.container[0])),this.root?.render(a.jsx(f,{id:this.setting?.id??"",min:this.params?.min,max:this.params?.max,step:this.params?.step,label:this.params?.label,description:this.params?.description,default:this.params?.default??"",value:this.params?.value??"",overrideUpdateComponentStateFn:this.overrideUpdateComponentStateFn,updateCustomizerSetting:this.updateCustomizerSetting,setNotificationContainer:this.setNotificationContainer,devices:this.params?.devices,saveAsJson:this.params?.saveAsJson})),this.container?.addClass("allowCollapse")},ready:function(){this.setting?.bind(t=>{this.updateComponentState?.(t)})},updateCustomizerSetting:function(t){void 0!==t&&this.setting?.set(t)},updateComponentState:t=>{},overrideUpdateComponentStateFn:function(t){this.updateComponentState=t},destroy:function(){this.root?.unmount(),this.root=void 0,e.Control.prototype.destroy&&e.Control.prototype.destroy.call(this)}}))}();
//# sourceMappingURL=responsive-input-slider-control-min.js.map
