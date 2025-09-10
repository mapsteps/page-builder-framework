wp.hooks.addFilter("wpbfPostMessageStylesOutput","wpbf",(t,e,r,p)=>{if("wpbf-margin-padding"!==p||"string"==typeof e||"number"==typeof e||!e.top&&!e.right&&!e.bottom&&!e.left)return t;let f=p.replace("wpbf-","");for(let p in t+=r.element+"{",e)if(Object.hasOwnProperty.call(e,p)){let r=e[p];""!==r&&(t+=f+"-"+p+": "+r+";")}return t+"}"});
//# sourceMappingURL=margin-padding-preview-min.js.map
