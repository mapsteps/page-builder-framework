!function(){function e(e){return e&&e.__esModule?e.default:e}var t={};function n(e){let t="",n=0;if(""!==e){let i=-1<(e=(e="string"!=typeof e?e.toString():e).trim()).indexOf("-")?"-":"";e=e.replace(i,"");""!==e&&(t=e.replace(/\d+/g,""),n=parseFloat(i+e.replace(t,"").trim()))}return{unit:t,number:n}}function i(e,t){let i={};for(let t=0;t<e.length;t++)i[e[t]]=e[t];for(let o in t){if(!e.includes(o)||!t.hasOwnProperty(o)||!i.hasOwnProperty(o))continue;let r=t[o];if(""!==r){let e=n(r);i[o]=e.number}}return i}function o(e,t){let n=function(e){if(""!==e&&e)try{return JSON.parse(e)}catch(e){return}}(t);return n?i(e,n):function(e){let t={};for(let n=0;n<e.length;n++)t[e[n]]="";return t}(e)}function r(r){let[s,a]=(0,t.useState)(()=>r.valueArray),l=""!==r.default&&void 0!==r.default;function c(e){if(r.saveAsJson){let t=function(e){try{return JSON.stringify(e)}catch(e){return""}}(i(r.dimensions,e));r.customizerSetting.set(t);return}let t=function(e,t,i){let o={};for(let t=0;t<e.length;t++)o[e[t]]=e[t];for(let r in i){if(!e.includes(r)||!o.hasOwnProperty(r))continue;let s=i[r];if(""!==s){let e=n(s);o[r]=e.number+t}}return o}(r.dimensions,r.unit,e);r.customizerSetting.set(t)}function u(e){let t=[];for(let n in s)if(s.hasOwnProperty(n)){if(!e){t.push({dimension:n,value:s[n]});continue}n.includes(e+"_")&&t.push({dimension:n,value:s[n]})}return t}function p(i,o){return e(t).createElement(e(t).Fragment,null,e(t).createElement("button",{type:"button",className:"wpbf-control-reset",onClick:e=>(function(e,t){let n=l?r.defaultArray:r.valueArray;if(!t){c(n);return}let i={...s};for(let e in i)i.hasOwnProperty(e)&&e.includes(t+"_")&&n.hasOwnProperty(e)&&(i[e]=n[e]);c(i)})(0,i)},e(t).createElement("i",{className:"dashicons dashicons-image-rotate"})),e(t).createElement("div",{className:`wpbf-control-cols ${f}`},e(t).createElement("div",{className:"wpbf-control-left-col"},e(t).createElement("div",{className:"wpbf-control-fields"},o.map(o=>{let l=`wpbf-control-input wpbf-control-input${i?`-${i}`:""}-${o.dimension}`,u=`_customize-input-${r.control.id}${i?`-${i}`:""}-${o.dimension}`,p=i?o.dimension.replace(i+"_",""):o.dimension;return e(t).createElement("div",{className:"wpbf-control-field"},e(t).createElement("input",{id:u,type:"number",value:o.value||0===o.value?o.value:"",className:l,onChange:e=>(function(e,t){if(!r.dimensions.includes(t)||!e.target)return;let i={...s};if(!i.hasOwnProperty(t))return;let o=n(e.target.value);i[t]=o.number,a(i),c(i)})(e,o.dimension)}),e(t).createElement("label",{className:"wpbf-control-sublabel",htmlFor:u},p))}))),e(t).createElement("div",{className:"wpbf-control-right-col"},e(t).createElement("span",{ref:d,className:"wpbf-control-unit"},r.unit))))}r.control.updateComponentState=e=>{a("string"==typeof e?o(r.dimensions,e):i(r.dimensions,e))};let m=`wpbf-control-input-${r.type}-top`,d=(0,t.useRef)(null),f=`wpbf-control-form ${r.isResponsive?"wpbf-responsive-padding-wrap":""}`;return e(t).createElement("div",{className:f,tabIndex:1},(r.label||r.description)&&e(t).createElement(e(t).Fragment,null,e(t).createElement("label",{className:"wpbf-control-label",htmlFor:m},r.label&&e(t).createElement("span",{className:"customize-control-title"},r.label),r.description&&e(t).createElement("span",{className:"customize-control-description description",dangerouslySetInnerHTML:{__html:r.description}})),e(t).createElement("div",{className:"customize-control-notifications-container",ref:r.setNotificationContainer})),r.isResponsive&&r.devices?e(t).createElement("ul",{className:"wpbf-responsive-options"},r.devices.map((n,i)=>{let o=`dashicons dashicons-${"mobile"===n?"smartphone":n}`;return e(t).createElement("li",{className:n},e(t).createElement("button",{type:"button",className:`preview-${n} ${0===i?"active":""}`,"data-device":n},e(t).createElement("i",{className:o})))})):e(t).createElement(e(t).Fragment,null),r.isResponsive&&r.devices&&r.devices.length?e(t).createElement(e(t).Fragment,null,r.devices.map((n,i)=>{let o=`wpbf-control-device wpbf-control-${n} ${0===i?"active":""}`;return e(t).createElement("div",{className:o},p(n,u(n)))})):p("",u()))}t=React;var s={};s=ReactDOM;let a=wp.customize.Control.extend({initialize:function(e,t){let n=this;n.setNotificationContainer=n.setNotificationContainer.bind(n),wp.customize.Control.prototype.initialize.call(n,e,t),wp.customize.control.bind("removed",function e(t){n===t&&(n.destroy(),n.container.remove(),wp.customize.control.unbind("removed",e))})},setNotificationContainer:function(e){this.notifications.container=jQuery(e),this.notifications.render()},renderContent:function(){let n=(0,s.createRoot)(this.container[0]),i=this.params,o="responsive-margin"===i.subtype||"responsive-padding"===i.subtype;n.render(e(t).createElement(r,{type:i.type,subtype:i.subtype,label:i.label,description:i.description,setNotificationContainer:this.setNotificationContainer,control:this,customizerSetting:this.setting,default:i.default,defaultArray:i.defaultArray,valueArray:i.valueArray,unit:i.unit,saveAsJson:i.saveAsJson,dimensions:i.dimensions,devices:i.devices,isResponsive:o})),o&&(this.container.addClass("wpbf-customize-control-margin-padding"),this.container.data("control-subtype",i.subtype)),i.allowCollapse&&this.container.addClass("allowCollapse")},ready:function(){let e=this;e.setting.bind(t=>{let n="string"==typeof t?o(e.params.dimensions,t):t;e.updateComponentState(n)})},updateComponentState:e=>{},destroy:function(){e(s).unmountComponentAtNode(this.container[0]),wp.customize.Control.prototype.destroy&&wp.customize.Control.prototype.destroy.call(this)}});wp.customize.controlConstructor["wpbf-margin-padding"]=a,wp.customize.controlConstructor["wpbf-responsive-margin-padding"]=a}();