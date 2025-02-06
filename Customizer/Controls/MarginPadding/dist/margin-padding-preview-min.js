wp.hooks.addFilter("wpbfPostMessageStylesOutput","wpbf",function(t,e,r,p){if("wpbf-margin-padding"!==p||"string"==typeof e||"number"==typeof e||!e.top&&!e.right&&!e.bottom&&!e.left)return t;var f=p.replace("wpbf-","");for(var n in t+=r.element+"{",e)if(Object.hasOwnProperty.call(e,n)){var o=e[n];""!==o&&(t+=f+"-"+n+": "+o+";")}return t+"}"});
//# sourceMappingURL=margin-padding-preview-min.js.map
