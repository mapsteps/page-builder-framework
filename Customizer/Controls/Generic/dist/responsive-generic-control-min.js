!function(){function t(t,e,n){if(""===t||"string"!=typeof t&&"number"!=typeof t||isNaN(Number(t)))return"";let r="string"==typeof t?parseFloat(t):t;return"number"==typeof e&&"number"==typeof n?(r<e&&(r=e),r>n&&(r=n)):"number"==typeof e?r<e&&(r=e):"number"==typeof n&&r>n&&(r=n),r}function e(t){if(""===t||"string"!=typeof t&&"number"!=typeof t||isNaN(Number(t)))return{number:"",unit:""};let e="string"==typeof t?t:String(t),n=e.replace(/\d+/g,"")||"",r=n?e.replace(n,""):e;return""===r?{number:"",unit:""}:{number:parseFloat(r),unit:n}}wp.customize.controlConstructor["wpbf-responsive-generic"]=wp.customize.wpbfDynamicControl.extend({initWpbfControl:function(n){let r=(n=n||this).params;"wpbf-responsive-generic"===r.type&&(n.setting.bind(t=>{n.updateComponentState(t)}),n.container.find(".wpbf-control-form input, .wpbf-control-form textarea").on("input",function(i){let u=n.setting.get(),o="string"==typeof u?function(n,r,i,u){let o="string"==typeof r?function(t){if(""!==t&&t)try{return JSON.parse(t)}catch(t){return}}(r):r;if(!o)return function(t){let e={};return t.forEach(t=>{e[t]=""}),e}(n);let f={};return n.forEach(n=>{if(!o.hasOwnProperty(n)){f[n]="";return}let r=function(n,r,i){let u=e(n),o=u.number;return""===o||("number"==typeof r||"number"==typeof i)&&""===(o=t(o,r,i))?"":u.unit?String(o)+u.unit:Number(o)}(o[n],i,u);f[n]="string"!=typeof r&&"number"!=typeof r?"":r}),f}(r.devices,u,r.min,r.max):u,f=this.parentNode,p=f instanceof HTMLElement?f.dataset.wpbfDevice:void 0;if(!p||!o.hasOwnProperty(p))return;let s=this instanceof HTMLInputElement||this instanceof HTMLTextAreaElement?this.value:"";if("number"===r.subtype||"number-unit"===r.subtype){var m,a;r.max=(m=r.min,a=r.max,void 0===m||void 0===a||null===m||null===a?a:Math.max(m,a)),s="number"===r.subtype?t(s,r.min,r.max):function(n,r,i){if(""===n||"string"!=typeof n&&"number"!=typeof n||isNaN(Number(n)))return"";let u=e(n),o=u.number,f=u.unit;if(""===o)return"";let p=t(o,r,i);return f?`${p}${f}`:p}(s,r.min,r.max)}o[p]=s;let c=r.saveAsJson?function(t){try{return JSON.stringify(t)}catch(t){return""}}(o):o;n.setting.set(c)}))}})}();