!function(){function t(t){return!!("string"!=typeof t&&"number"!=typeof t||"string"==typeof t&&isNaN(parseFloat(t)))}function n(n,e,r){if(""===n||t(n))return"";let i="string"==typeof n?parseFloat(n):n;return"number"==typeof e&&i<e&&(i=e),"number"==typeof r&&i>r&&(i=r),i}wp.customize.controlConstructor["wpbf-generic"]=wp.customize.wpbfDynamicControl.extend({initWpbfControl:function(e){let r=(e=e||this).params;"wpbf-generic"===r.type&&e.container.find(".wpbf-control-form input, .wpbf-control-form textarea").on("input",function(){let i=this instanceof HTMLInputElement||this instanceof HTMLTextAreaElement?this.value:"";if("number"===r.subtype||"number-unit"===r.subtype){var u,o;r.max=(u=r.min,o=r.max,void 0===u||void 0===o||null===u||null===o?o:Math.max(u,o)),i="number"===r.subtype?n(i,r.min,r.max):function(e,r,i){if(""===e||t(e))return"";let u=function(n){if(""===n||null===n||t(n))return{number:"",unit:""};let e=String(n).trim(),r=-1<e.indexOf("-")?"-":"",i=function(t){if(!t)return"";let n=String(t).match(/[a-z%]+$/i);return n?n[0]:""}(e=e.replace(r,"")),u=i?e.replace(i,""):e;if(""===(u=u.trim()))return{number:"",unit:i};let o=u.endsWith("."),f=parseFloat(u=r+u);return isNaN(f)?{number:"",unit:i}:{number:f,unit:i,hasTrailingDotBeforeUnit:!!i&&!!o}}(e),o=u.number,f=u.unit;if(""===o)return"";let a=n(o,r,i);return f?`${a}${f}`:a}(i,r.min,r.max)}e.setting?.set(i)})}})}();
//# sourceMappingURL=generic-control-min.js.map
