!function(){function t(t,e,n){if(""===t||"string"!=typeof t&&"number"!=typeof t||isNaN(Number(t)))return"";let r="string"==typeof t?parseFloat(t):t;return"number"==typeof e&&"number"==typeof n?(r<e&&(r=e),r>n&&(r=n)):"number"==typeof e?r<e&&(r=e):"number"==typeof n&&r>n&&(r=n),r}function e(t){if(""===t||"string"!=typeof t&&"number"!=typeof t||isNaN(Number(t)))return{number:"",unit:""};let e="string"==typeof t?t:String(t),n=e.replace(/\d+/g,"")||"",r=n?e.replace(n,""):e;return""===r?{number:"",unit:""}:{number:parseFloat(r),unit:n}}function n(n,r,i,o){let u="string"==typeof r?function(t){if(""!==t&&t)try{return JSON.parse(t)}catch(t){return}}(r):r;if(!u)return function(t){let e={};return t.forEach(t=>{e[t]=""}),e}(n);let f={};return n.forEach(n=>{if(!u.hasOwnProperty(n)){f[n]="";return}let r=function(n,r,i){let o=e(n),u=o.number;return""===u||("number"==typeof r||"number"==typeof i)&&""===(u=t(u,r,i))?"":o.unit?String(u)+o.unit:Number(u)}(u[n],i,o);f[n]="string"!=typeof r&&"number"!=typeof r?"":r}),f}wp.customize.controlConstructor["wpbf-responsive-generic"]=wp.customize.wpbfDynamicControl.extend({initWpbfControl:function(r){let i=(r=r||this).params;"wpbf-responsive-generic"===i.type&&(r.setting.bind(t=>{console.log("setting.bind",t),r.updateComponentState(t)}),r.container.find(".wpbf-control-form input, .wpbf-control-form textarea").on("input",function(o){let u=r.setting.get(),f="string"==typeof u?n(i.devices,u,i.min,i.max):u,p=this.parentNode,s=p instanceof HTMLElement?p.dataset.wpbfDevice:void 0;if(!s||!f.hasOwnProperty(s))return;let a=this instanceof HTMLInputElement||this instanceof HTMLTextAreaElement?this.value:"";if("number"===i.subtype||"number-unit"===i.subtype){var m,c;i.max=(m=i.min,c=i.max,void 0===m||void 0===c||null===m||null===c?c:Math.max(m,c)),a="number"===i.subtype?t(a,i.min,i.max):function(n,r,i){if(""===n||"string"!=typeof n&&"number"!=typeof n||isNaN(Number(n)))return"";let o=e(n),u=o.number,f=o.unit;if(""===u)return"";let p=t(u,r,i);return f?`${p}${f}`:p}(a,i.min,i.max)}f[s]=a;let l=i.saveAsJson?function(t){try{return JSON.stringify(t)}catch(t){return""}}(f):f;r.setting.set(l)}))},updateComponentState:function(t){let e=this.params;console.log("updateComponentState","string"==typeof t?n(e.devices,t,e.min,e.max):t)}})}();