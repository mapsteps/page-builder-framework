(()=>{function r(r){return"number"==typeof r||"string"==typeof r&&!isNaN(parseFloat(r))}wp.hooks.addFilter("wpbfPostMessageStylesOutput","wpbf",function(e,s,t,a){let p,o,n,h,f,y;if("wpbf-color"!==a||"string"==typeof s||"number"==typeof s)return e;let l=t.prefix?t.prefix:"",w=t.suffix?t.suffix:"";return e+(t.element+"{"+t.property+": "+l+(p=!1,o="",n=0,h=0,f=0,y=0,s.hasOwnProperty("r")&&s.hasOwnProperty("g")&&s.hasOwnProperty("b")?(p="rgba"==(o=s.hasOwnProperty("a")?"rgba":"rgb")||p,n=s.r,h=s.g,f=s.b,y="rgba"===o?s.a??1:1):s.hasOwnProperty("h")&&s.hasOwnProperty("s")&&(n=s.h,s.hasOwnProperty("l")?(o=s.hasOwnProperty("a")?"hsla":"hsl",h=r(s.l)?s.l+"%":s.l):s.hasOwnProperty("v")&&(o=s.hasOwnProperty("a")?"hsva":"hsv",h=r(s.v)?s.v+"%":s.v),p="hsla"===o||"hsva"===o||p,f=r(s.s)?s.s+"%":s.s,y=p?s.a??1:1),p?o+"("+n+", "+h+", "+f+", "+y+")":o+"("+n+", "+h+", "+f+")")+w)+";		}"})})();