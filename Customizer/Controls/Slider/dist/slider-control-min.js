!function(){function t(t){return t&&t.__esModule?t.default:t}var e={};e=ReactDOM;var n={};function o(e){let{control:o,customizerSetting:r,choices:i}=e,a="",c=(0,n.useRef)(null),l=(0,n.useRef)(null);o.updateComponentState=t=>{"slider"===a?l&&l.current&&(l.current.textContent=t):"input"===a?c&&c.current&&(c.current.value=t):"reset"===a&&(l&&l.current&&(l.current.textContent=t),c&&c.current&&(c.current.value=t))};let s=`wpbf-control-input-${r.id}`,u=""!==e.value?e.value:0;return t(n).createElement("div",{className:"wpbf-control-form",tabIndex:1},t(n).createElement("label",{className:"wpbf-control-label",htmlFor:s},t(n).createElement("span",{className:"customize-control-title"},e.label),t(n).createElement("span",{className:"customize-control-description description",dangerouslySetInnerHTML:{__html:e.description}})),t(n).createElement("div",{className:"customize-control-notifications-container",ref:e.setNotificationContainer}),t(n).createElement("button",{type:"button",className:"wpbf-control-reset",onClick:function(t){""!==e.default&&void 0!==e.default?(c&&c.current&&(c.current.value=e.default),l&&l.current&&(l.current.textContent=e.default)):""!==e.value?(c&&c.current&&(c.current.value=e.value),l&&l.current&&(l.current.textContent=e.value)):(c&&c.current&&(c.current.value=i.min),l&&l.current&&(l.current.textContent="")),a="reset",c&&c.current&&r.set(c.current.value)}},t(n).createElement("i",{className:"dashicons dashicons-image-rotate"})),t(n).createElement("div",{className:"wpbf-control-cols"},t(n).createElement("div",{className:"wpbf-control-left-col"},t(n).createElement("input",{ref:c,type:"range",id:s,defaultValue:u,min:i.min,max:i.max,step:i.step,className:"wpbf-control-slider",onChange:function(t){let e=t.target;a="range"===e.type?"slider":"input";let n=e.value;n<i.min&&(n=i.min),n>i.max&&(n=i.max),"input"===a&&(e.value=n),r.set(n)}})),t(n).createElement("div",{className:"wpbf-control-right-col"},t(n).createElement("div",{className:"wpbf-control-value",ref:l},u))))}function r(){return(r=Object.assign?Object.assign.bind():function(t){for(var e=1;e<arguments.length;e++){var n=arguments[e];for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(t[o]=n[o])}return t}).apply(this,arguments)}n=React;let i=wp.customize.Control.extend({initialize:function(t,e){let n=this;n.setNotificationContainer=n.setNotificationContainer?.bind(n),wp.customize.Control.prototype.initialize.call(n,t,e),wp.customize.control.bind("removed",function t(e){n===e&&(n.destroy&&n.destroy(),n.container.remove(),wp.customize.control.unbind("removed",t))})},setNotificationContainer:function(t){this.notifications.container=jQuery(t),this.notifications.render()},renderContent:function(){(0,e.createRoot)(this.container[0]).render(t(n).createElement(o,r({},this.params,{control:this,customizerSetting:this.setting,setNotificationContainer:this.setNotificationContainer,value:this.params.value}))),!1!==this.params.choices.allowCollapse&&this.container.addClass("allowCollapse")},ready:function(){let t=this;t.setting&&t.setting.bind(e=>{t.updateComponentState?.(e)})},updateComponentState:t=>{},destroy:function(){t(e).unmountComponentAtNode(this.container[0]),wp.customize.Control.prototype.destroy&&wp.customize.Control.prototype.destroy.call(this)}});wp.customize.controlConstructor["wpbf-slider"]=i}();