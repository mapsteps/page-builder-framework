!function(){function e(e){return e&&e.__esModule?e.default:e}var t={};t=ReactJSXRuntime;var r={};r=React;var o={grad:.9,turn:360,rad:360/(2*Math.PI)},n=function(e){return"string"==typeof e?e.length>0:"number"==typeof e},a=function(e,t,r){return void 0===t&&(t=0),void 0===r&&(r=Math.pow(10,t)),Math.round(r*e)/r+0},i=function(e,t,r){return void 0===t&&(t=0),void 0===r&&(r=1),e>r?r:e>t?e:t},s=function(e){return(e=isFinite(e)?e%360:0)>0?e:e+360},l=function(e){return{r:i(e.r,0,255),g:i(e.g,0,255),b:i(e.b,0,255),a:i(e.a)}},c=function(e){return{r:a(e.r),g:a(e.g),b:a(e.b),a:a(e.a,3)}},u=/^#([0-9a-f]{3,8})$/i,f=function(e){var t=e.toString(16);return t.length<2?"0"+t:t},d=function(e){var t=e.r,r=e.g,o=e.b,n=e.a,a=Math.max(t,r,o),i=a-Math.min(t,r,o),s=i?a===t?(r-o)/i:a===r?2+(o-t)/i:4+(t-r)/i:0;return{h:60*(s<0?s+6:s),s:a?i/a*100:0,v:a/255*100,a:n}},h=function(e){var t=e.h,r=e.s,o=e.v,n=e.a;t=t/360*6,r/=100,o/=100;var a=Math.floor(t),i=o*(1-r),s=o*(1-(t-a)*r),l=o*(1-(1-t+a)*r),c=a%6;return{r:255*[o,s,i,i,l,o][c],g:255*[l,o,o,s,i,i][c],b:255*[i,i,l,o,o,s][c],a:n}},p=function(e){return{h:s(e.h),s:i(e.s,0,100),l:i(e.l,0,100),a:i(e.a)}},g=function(e){return{h:a(e.h),s:a(e.s),l:a(e.l),a:a(e.a,3)}},v=function(e){var t,r;return h((t=e.s,{h:e.h,s:(t*=((r=e.l)<50?r:100-r)/100)>0?2*t/(r+t)*100:0,v:r+t,a:e.a}))},b=function(e){var t,r,o,n;return{h:(t=d(e)).h,s:(n=(200-(r=t.s))*(o=t.v)/100)>0&&n<200?r*o/100/(n<=100?n:200-n)*100:0,l:n/2,a:t.a}},m=/^hsla?\(\s*([+-]?\d*\.?\d+)(deg|rad|grad|turn)?\s*,\s*([+-]?\d*\.?\d+)%\s*,\s*([+-]?\d*\.?\d+)%\s*(?:,\s*([+-]?\d*\.?\d+)(%)?\s*)?\)$/i,C=/^hsla?\(\s*([+-]?\d*\.?\d+)(deg|rad|grad|turn)?\s+([+-]?\d*\.?\d+)%\s+([+-]?\d*\.?\d+)%\s*(?:\/\s*([+-]?\d*\.?\d+)(%)?\s*)?\)$/i,k=/^rgba?\(\s*([+-]?\d*\.?\d+)(%)?\s*,\s*([+-]?\d*\.?\d+)(%)?\s*,\s*([+-]?\d*\.?\d+)(%)?\s*(?:,\s*([+-]?\d*\.?\d+)(%)?\s*)?\)$/i,w=/^rgba?\(\s*([+-]?\d*\.?\d+)(%)?\s+([+-]?\d*\.?\d+)(%)?\s+([+-]?\d*\.?\d+)(%)?\s*(?:\/\s*([+-]?\d*\.?\d+)(%)?\s*)?\)$/i,x={string:[[function(e){var t=u.exec(e);return t?(e=t[1]).length<=4?{r:parseInt(e[0]+e[0],16),g:parseInt(e[1]+e[1],16),b:parseInt(e[2]+e[2],16),a:4===e.length?a(parseInt(e[3]+e[3],16)/255,2):1}:6===e.length||8===e.length?{r:parseInt(e.substr(0,2),16),g:parseInt(e.substr(2,2),16),b:parseInt(e.substr(4,2),16),a:8===e.length?a(parseInt(e.substr(6,2),16)/255,2):1}:null:null},"hex"],[function(e){var t=k.exec(e)||w.exec(e);return t?t[2]!==t[4]||t[4]!==t[6]?null:l({r:Number(t[1])/(t[2]?100/255:1),g:Number(t[3])/(t[4]?100/255:1),b:Number(t[5])/(t[6]?100/255:1),a:void 0===t[7]?1:Number(t[7])/(t[8]?100:1)}):null},"rgb"],[function(e){var t,r,n=m.exec(e)||C.exec(e);return n?v(p({h:(t=n[1],void 0===(r=n[2])&&(r="deg"),Number(t)*(o[r]||1)),s:Number(n[3]),l:Number(n[4]),a:void 0===n[5]?1:Number(n[5])/(n[6]?100:1)})):null},"hsl"]],object:[[function(e){var t=e.r,r=e.g,o=e.b,a=e.a;return n(t)&&n(r)&&n(o)?l({r:Number(t),g:Number(r),b:Number(o),a:Number(void 0===a?1:a)}):null},"rgb"],[function(e){var t=e.h,r=e.s,o=e.l,a=e.a;return n(t)&&n(r)&&n(o)?v(p({h:Number(t),s:Number(r),l:Number(o),a:Number(void 0===a?1:a)})):null},"hsl"],[function(e){var t,r=e.h,o=e.s,a=e.v,l=e.a;return n(r)&&n(o)&&n(a)?h({h:s((t={h:Number(r),s:Number(o),v:Number(a),a:Number(void 0===l?1:l)}).h),s:i(t.s,0,100),v:i(t.v,0,100),a:i(t.a)}):null},"hsv"]]},y=function(e,t){for(var r=0;r<t.length;r++){var o=t[r][0](e);if(o)return[o,t[r][1]]}return[null,void 0]},H=function(e,t){var r=b(e);return{h:r.h,s:i(r.s+100*t,0,100),l:r.l,a:r.a}},N=function(e){return(299*e.r+587*e.g+114*e.b)/1e3/255},S=function(e,t){var r=b(e);return{h:r.h,s:r.s,l:i(r.l+100*t,0,100),a:r.a}},P=function(){function e(e){this.parsed=("string"==typeof e?y(e.trim(),x.string):"object"==typeof e&&null!==e?y(e,x.object):[null,void 0])[0],this.rgba=this.parsed||{r:0,g:0,b:0,a:1}}return e.prototype.isValid=function(){return null!==this.parsed},e.prototype.brightness=function(){return a(N(this.rgba),2)},e.prototype.isDark=function(){return .5>N(this.rgba)},e.prototype.isLight=function(){return N(this.rgba)>=.5},e.prototype.toHex=function(){var e,t,r,o,n,i;return t=(e=c(this.rgba)).r,r=e.g,o=e.b,i=(n=e.a)<1?f(a(255*n)):"","#"+f(t)+f(r)+f(o)+i},e.prototype.toRgb=function(){return c(this.rgba)},e.prototype.toRgbString=function(){var e,t,r,o,n;return t=(e=c(this.rgba)).r,r=e.g,o=e.b,(n=e.a)<1?"rgba("+t+", "+r+", "+o+", "+n+")":"rgb("+t+", "+r+", "+o+")"},e.prototype.toHsl=function(){return g(b(this.rgba))},e.prototype.toHslString=function(){var e,t,r,o,n;return t=(e=g(b(this.rgba))).h,r=e.s,o=e.l,(n=e.a)<1?"hsla("+t+", "+r+"%, "+o+"%, "+n+")":"hsl("+t+", "+r+"%, "+o+"%)"},e.prototype.toHsv=function(){var e;return{h:a((e=d(this.rgba)).h),s:a(e.s),v:a(e.v),a:a(e.a,3)}},e.prototype.invert=function(){var e;return j({r:255-(e=this.rgba).r,g:255-e.g,b:255-e.b,a:e.a})},e.prototype.saturate=function(e){return void 0===e&&(e=.1),j(H(this.rgba,e))},e.prototype.desaturate=function(e){return void 0===e&&(e=.1),j(H(this.rgba,-e))},e.prototype.grayscale=function(){return j(H(this.rgba,-1))},e.prototype.lighten=function(e){return void 0===e&&(e=.1),j(S(this.rgba,e))},e.prototype.darken=function(e){return void 0===e&&(e=.1),j(S(this.rgba,-e))},e.prototype.rotate=function(e){return void 0===e&&(e=15),this.hue(this.hue()+e)},e.prototype.alpha=function(e){var t;return"number"==typeof e?j({r:(t=this.rgba).r,g:t.g,b:t.b,a:e}):a(this.rgba.a,3)},e.prototype.hue=function(e){var t=b(this.rgba);return"number"==typeof e?j({h:e,s:t.s,l:t.l,a:t.a}):a(t.h)},e.prototype.isEqual=function(e){return this.toHex()===j(e).toHex()},e}(),j=function(e){return e instanceof P?e:new P(e)};function R(e){let{colors:r,onClick:o}=e;return(0,t.jsx)("div",{className:`wpbf-color-swatches${r&&r.length<7?" no-stretch":""}`,children:r.map((e,r)=>{let n="string"==typeof e?e:e&&e.color?e.color:"";return(0,t.jsx)("button",{type:"button",className:"wpbf-color-swatch","data-wpbf-color":n,style:{backgroundColor:n},onClick:()=>o(n)},r.toString())})})}let _="data:image/webp;base64,UklGRjIAAABXRUJQVlA4TCUAAAAvE8AEAA9w7/97/9/7f/7jAYraNmI6AJQ/1xvvMojof2BSvVEBAA==";function E(e){let t=0;return(t=(t=("number"==typeof e?0:"string"!=typeof e?1:isNaN(parseFloat(e)))?"object"==typeof e&&"h"in e?e.h:"number"!=typeof e?j(e).toHsl().h:0:Number(e))<0?0:t)>360?360:t}function M(e){let{onChange:o,pickerComponent:n,useHueMode:a}=e,[i,s]=(0,r.useState)(()=>e.color);(0,r.useEffect)(()=>{s(e.color)},[e.color]);let l=(0,r.useCallback)(e=>{let t=e.target,r=t?.value??"";2===r.length?r.includes("#")||r.includes("rg")||r.includes("hs")||(r="#"+r):3!==r.length&&6!==r.length||r.includes("#")||r.includes("rg")||r.includes("hs")||(r="#"+r),r=r.toLowerCase();let n=new RegExp(/(?:#|0x)(?:[a-f0-9]{3}|[a-f0-9]{6}|[a-f0-9]{8})\b|(?:rgb|hsl)a?\([^)]*\)/);(""===r||n.test(r))&&o(r),s(r)},[o]),c=["RgbaColorPicker","RgbaStringColorPicker","HslaColorPicker","HslaStringColorPicker","HsvaColorPicker","HsvaStringColorPicker"].includes(n)?`url("${_}")`:"none";return(0,t.jsx)("div",{className:"wpbf-color-input-wrapper",children:(0,t.jsxs)("div",{className:"wpbf-color-input-control",children:[!a&&(0,t.jsx)("div",{className:"wpbf-color-preview-wrapper",style:{backgroundImage:c},children:(0,t.jsx)("button",{type:"button",className:"wpbf-color-preview",style:{backgroundColor:a||"number"==typeof i?"transparent":i??"transparent"}})}),(0,t.jsx)("input",{type:"text",value:i??"",className:"wpbf-color-input",spellCheck:"false",onChange:l})]})})}function z(e,t){(0,r.useEffect)(()=>{let r=r=>{e.current&&(e.current.contains(r.target)||t())};return document.addEventListener("focus",r,!0),()=>{document.removeEventListener("focus",r,!0)}},[e,t])}function O(e,t,o){(0,r.useEffect)(()=>{let r=!1,n=!1,a=a=>{!(!r||n||!t.current||t.current.contains(a.target))&&(!e.current||e.current.contains(a.target)||o())},i=o=>{r=t.current&&e.current,n=t.current&&t.current.contains(o.target)||e.current&&e.current.contains(o.target)};return document.addEventListener("mousedown",i),document.addEventListener("touchstart",i),document.addEventListener("click",a),()=>{document.removeEventListener("mousedown",i),document.removeEventListener("touchstart",i),document.removeEventListener("click",a)}},[t,e,o])}function I(){return(I=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var o in r)Object.prototype.hasOwnProperty.call(r,o)&&(e[o]=r[o])}return e}).apply(this,arguments)}function L(e,t){if(null==e)return{};var r,o,n={},a=Object.keys(e);for(o=0;o<a.length;o++)t.indexOf(r=a[o])>=0||(n[r]=e[r]);return n}function A(e){var t=(0,r.useRef)(e),o=(0,r.useRef)(function(e){t.current&&t.current(e)});return t.current=e,o.current}var $=function(e,t,r){return void 0===t&&(t=0),void 0===r&&(r=1),e>r?r:e<t?t:e},q=function(e){return"touches"in e},B=function(e){return e&&e.ownerDocument.defaultView||self},T=function(e,t,r){var o=e.getBoundingClientRect(),n=q(t)?function(e,t){for(var r=0;r<e.length;r++)if(e[r].identifier===t)return e[r];return e[0]}(t.touches,r):t;return{left:$((n.pageX-(o.left+B(e).pageXOffset))/o.width),top:$((n.pageY-(o.top+B(e).pageYOffset))/o.height)}},F=function(e){q(e)||e.preventDefault()},D=e(r).memo(function(t){var o=t.onMove,n=t.onKey,a=L(t,["onMove","onKey"]),i=(0,r.useRef)(null),s=A(o),l=A(n),c=(0,r.useRef)(null),u=(0,r.useRef)(!1),f=(0,r.useMemo)(function(){var e=function(e){F(e),(q(e)?e.touches.length>0:e.buttons>0)&&i.current?s(T(i.current,e,c.current)):r(!1)},t=function(){return r(!1)};function r(r){var o=u.current,n=B(i.current),a=r?n.addEventListener:n.removeEventListener;a(o?"touchmove":"mousemove",e),a(o?"touchend":"mouseup",t)}return[function(e){var t=e.nativeEvent,o=i.current;if(o&&(F(t),(!u.current||q(t))&&o)){if(q(t)){u.current=!0;var n=t.changedTouches||[];n.length&&(c.current=n[0].identifier)}o.focus(),s(T(o,t,c.current)),r(!0)}},function(e){var t=e.which||e.keyCode;t<37||t>40||(e.preventDefault(),l({left:39===t?.05:37===t?-.05:0,top:40===t?.05:38===t?-.05:0}))},r]},[l,s]),d=f[0],h=f[1],p=f[2];return(0,r.useEffect)(function(){return p},[p]),e(r).createElement("div",I({},a,{onTouchStart:d,onMouseDown:d,className:"react-colorful__interactive",ref:i,onKeyDown:h,tabIndex:0,role:"slider"}))}),V=function(e){return e.filter(Boolean).join(" ")},J=function(t){var o=t.color,n=t.left,a=t.top,i=V(["react-colorful__pointer",t.className]);return e(r).createElement("div",{className:i,style:{top:100*(void 0===a?.5:a)+"%",left:100*n+"%"}},e(r).createElement("div",{className:"react-colorful__pointer-fill",style:{backgroundColor:o}}))},Q=function(e,t,r){return void 0===t&&(t=0),void 0===r&&(r=Math.pow(10,t)),Math.round(r*e)/r},K={grad:.9,turn:360,rad:360/(2*Math.PI)},X=function(e){return"#"===e[0]&&(e=e.substring(1)),e.length<6?{r:parseInt(e[0]+e[0],16),g:parseInt(e[1]+e[1],16),b:parseInt(e[2]+e[2],16),a:4===e.length?Q(parseInt(e[3]+e[3],16)/255,2):1}:{r:parseInt(e.substring(0,2),16),g:parseInt(e.substring(2,4),16),b:parseInt(e.substring(4,6),16),a:8===e.length?Q(parseInt(e.substring(6,8),16)/255,2):1}},U=function(e,t){return void 0===t&&(t="deg"),Number(e)*(K[t]||1)},Y=function(e){var t=/hsla?\(?\s*(-?\d*\.?\d+)(deg|rad|grad|turn)?[,\s]+(-?\d*\.?\d+)%?[,\s]+(-?\d*\.?\d+)%?,?\s*[/\s]*(-?\d*\.?\d+)?(%)?\s*\)?/i.exec(e);return t?G({h:U(t[1],t[2]),s:Number(t[3]),l:Number(t[4]),a:void 0===t[5]?1:Number(t[5])/(t[6]?100:1)}):{h:0,s:0,v:0,a:1}},G=function(e){var t=e.s,r=e.l;return{h:e.h,s:(t*=(r<50?r:100-r)/100)>0?2*t/(r+t)*100:0,v:r+t,a:e.a}},W=function(e){var t=e.s,r=e.v,o=e.a,n=(200-t)*r/100;return{h:Q(e.h),s:Q(n>0&&n<200?t*r/100/(n<=100?n:200-n)*100:0),l:Q(n/2),a:Q(o,2)}},Z=function(e){var t=W(e);return"hsl("+t.h+", "+t.s+"%, "+t.l+"%)"},ee=function(e){var t=W(e);return"hsla("+t.h+", "+t.s+"%, "+t.l+"%, "+t.a+")"},et=function(e){var t=e.h,r=e.s,o=e.v,n=e.a;t=t/360*6,r/=100,o/=100;var a=Math.floor(t),i=o*(1-r),s=o*(1-(t-a)*r),l=o*(1-(1-t+a)*r),c=a%6;return{r:Q(255*[o,s,i,i,l,o][c]),g:Q(255*[l,o,o,s,i,i][c]),b:Q(255*[i,i,l,o,o,s][c]),a:Q(n,2)}},er=function(e){var t=/hsva?\(?\s*(-?\d*\.?\d+)(deg|rad|grad|turn)?[,\s]+(-?\d*\.?\d+)%?[,\s]+(-?\d*\.?\d+)%?,?\s*[/\s]*(-?\d*\.?\d+)?(%)?\s*\)?/i.exec(e);return t?es({h:U(t[1],t[2]),s:Number(t[3]),v:Number(t[4]),a:void 0===t[5]?1:Number(t[5])/(t[6]?100:1)}):{h:0,s:0,v:0,a:1}},eo=function(e){var t=/rgba?\(?\s*(-?\d*\.?\d+)(%)?[,\s]+(-?\d*\.?\d+)(%)?[,\s]+(-?\d*\.?\d+)(%)?,?\s*[/\s]*(-?\d*\.?\d+)?(%)?\s*\)?/i.exec(e);return t?ei({r:Number(t[1])/(t[2]?100/255:1),g:Number(t[3])/(t[4]?100/255:1),b:Number(t[5])/(t[6]?100/255:1),a:void 0===t[7]?1:Number(t[7])/(t[8]?100:1)}):{h:0,s:0,v:0,a:1}},en=function(e){var t=e.toString(16);return t.length<2?"0"+t:t},ea=function(e){var t=e.r,r=e.g,o=e.b,n=e.a,a=n<1?en(Q(255*n)):"";return"#"+en(t)+en(r)+en(o)+a},ei=function(e){var t=e.r,r=e.g,o=e.b,n=e.a,a=Math.max(t,r,o),i=a-Math.min(t,r,o),s=i?a===t?(r-o)/i:a===r?2+(o-t)/i:4+(t-r)/i:0;return{h:Q(60*(s<0?s+6:s)),s:Q(a?i/a*100:0),v:Q(a/255*100),a:n}},es=function(e){return{h:Q(e.h),s:Q(e.s),v:Q(e.v),a:Q(e.a,2)}},el=e(r).memo(function(t){var o=t.hue,n=t.onChange,a=V(["react-colorful__hue",t.className]);return e(r).createElement("div",{className:a},e(r).createElement(D,{onMove:function(e){n({h:360*e.left})},onKey:function(e){n({h:$(o+360*e.left,0,360)})},"aria-label":"Hue","aria-valuenow":Q(o),"aria-valuemax":"360","aria-valuemin":"0"},e(r).createElement(J,{className:"react-colorful__hue-pointer",left:o/360,color:Z({h:o,s:100,v:100,a:1})})))}),ec=e(r).memo(function(t){var o=t.hsva,n=t.onChange,a={backgroundColor:Z({h:o.h,s:100,v:100,a:1})};return e(r).createElement("div",{className:"react-colorful__saturation",style:a},e(r).createElement(D,{onMove:function(e){n({s:100*e.left,v:100-100*e.top})},onKey:function(e){n({s:$(o.s+100*e.left,0,100),v:$(o.v-100*e.top,0,100)})},"aria-label":"Color","aria-valuetext":"Saturation "+Q(o.s)+"%, Brightness "+Q(o.v)+"%"},e(r).createElement(J,{className:"react-colorful__saturation-pointer",top:1-o.v/100,left:o.s/100,color:Z(o)})))}),eu=function(e,t){if(e===t)return!0;for(var r in e)if(e[r]!==t[r])return!1;return!0},ef=function(e,t){return e.replace(/\s/g,"")===t.replace(/\s/g,"")};function ed(e,t,o){var n=A(o),a=(0,r.useState)(function(){return e.toHsva(t)}),i=a[0],s=a[1],l=(0,r.useRef)({color:t,hsva:i});return(0,r.useEffect)(function(){if(!e.equal(t,l.current.color)){var r=e.toHsva(t);l.current={hsva:r,color:t},s(r)}},[t,e]),(0,r.useEffect)(function(){var t;eu(i,l.current.hsva)||e.equal(t=e.fromHsva(i),l.current.color)||(l.current={hsva:i,color:t},n(t))},[i,e,n]),[i,(0,r.useCallback)(function(e){s(function(t){return Object.assign({},t,e)})},[])]}var eh,ep="undefined"!=typeof window?r.useLayoutEffect:r.useEffect,eg=new Map,ev=function(e){ep(function(){var t=e.current?e.current.ownerDocument:document;if(void 0!==t&&!eg.has(t)){var r=t.createElement("style");r.innerHTML='.react-colorful{position:relative;display:flex;flex-direction:column;width:200px;height:200px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;cursor:default}.react-colorful__saturation{position:relative;flex-grow:1;border-color:transparent;border-bottom:12px solid #000;border-radius:8px 8px 0 0;background-image:linear-gradient(0deg,#000,transparent),linear-gradient(90deg,#fff,hsla(0,0%,100%,0))}.react-colorful__alpha-gradient,.react-colorful__pointer-fill{content:"";position:absolute;left:0;top:0;right:0;bottom:0;pointer-events:none;border-radius:inherit}.react-colorful__alpha-gradient,.react-colorful__saturation{box-shadow:inset 0 0 0 1px rgba(0,0,0,.05)}.react-colorful__alpha,.react-colorful__hue{position:relative;height:24px}.react-colorful__hue{background:linear-gradient(90deg,red 0,#ff0 17%,#0f0 33%,#0ff 50%,#00f 67%,#f0f 83%,red)}.react-colorful__last-control{border-radius:0 0 8px 8px}.react-colorful__interactive{position:absolute;left:0;top:0;right:0;bottom:0;border-radius:inherit;outline:none;touch-action:none}.react-colorful__pointer{position:absolute;z-index:1;box-sizing:border-box;width:28px;height:28px;transform:translate(-50%,-50%);background-color:#fff;border:2px solid #fff;border-radius:50%;box-shadow:0 2px 4px rgba(0,0,0,.2)}.react-colorful__interactive:focus .react-colorful__pointer{transform:translate(-50%,-50%) scale(1.1)}.react-colorful__alpha,.react-colorful__alpha-pointer{background-color:#fff;background-image:url(\'data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill-opacity=".05"><path d="M8 0h8v8H8zM0 8h8v8H0z"/></svg>\')}.react-colorful__saturation-pointer{z-index:3}.react-colorful__hue-pointer{z-index:2}',eg.set(t,r);var o=eh||("undefined"!=typeof __webpack_nonce__?__webpack_nonce__:void 0);o&&r.setAttribute("nonce",o),t.head.appendChild(r)}},[])},eb=function(t){var o=t.className,n=t.colorModel,a=t.color,i=void 0===a?n.defaultColor:a,s=t.onChange,l=L(t,["className","colorModel","color","onChange"]),c=(0,r.useRef)(null);ev(c);var u=ed(n,i,s),f=u[0],d=u[1],h=V(["react-colorful",o]);return e(r).createElement("div",I({},l,{ref:c,className:h}),e(r).createElement(ec,{hsva:f,onChange:d}),e(r).createElement(el,{hue:f.h,onChange:d,className:"react-colorful__last-control"}))},em={defaultColor:"000",toHsva:function(e){return ei(X(e))},fromHsva:function(e){return ea(et({h:e.h,s:e.s,v:e.v,a:1}))},equal:function(e,t){return e.toLowerCase()===t.toLowerCase()||eu(X(e),X(t))}},eC=function(t){return e(r).createElement(eb,I({},t,{colorModel:em}))},ek=function(t){var o=t.className,n=t.hsva,a=t.onChange,i={backgroundImage:"linear-gradient(90deg, "+ee(Object.assign({},n,{a:0}))+", "+ee(Object.assign({},n,{a:1}))+")"},s=V(["react-colorful__alpha",o]),l=Q(100*n.a);return e(r).createElement("div",{className:s},e(r).createElement("div",{className:"react-colorful__alpha-gradient",style:i}),e(r).createElement(D,{onMove:function(e){a({a:e.left})},onKey:function(e){a({a:$(n.a+e.left)})},"aria-label":"Alpha","aria-valuetext":l+"%","aria-valuenow":l,"aria-valuemin":"0","aria-valuemax":"100"},e(r).createElement(J,{className:"react-colorful__alpha-pointer",left:n.a,color:ee(n)})))},ew=function(t){var o=t.className,n=t.colorModel,a=t.color,i=void 0===a?n.defaultColor:a,s=t.onChange,l=L(t,["className","colorModel","color","onChange"]),c=(0,r.useRef)(null);ev(c);var u=ed(n,i,s),f=u[0],d=u[1],h=V(["react-colorful",o]);return e(r).createElement("div",I({},l,{ref:c,className:h}),e(r).createElement(ec,{hsva:f,onChange:d}),e(r).createElement(el,{hue:f.h,onChange:d}),e(r).createElement(ek,{hsva:f,onChange:d,className:"react-colorful__last-control"}))},ex={defaultColor:{h:0,s:0,l:0,a:1},toHsva:G,fromHsva:W,equal:eu},ey=function(t){return e(r).createElement(ew,I({},t,{colorModel:ex}))},eH={defaultColor:"hsla(0, 0%, 0%, 1)",toHsva:Y,fromHsva:ee,equal:ef},eN=function(t){return e(r).createElement(ew,I({},t,{colorModel:eH}))},eS={defaultColor:{h:0,s:0,l:0},toHsva:function(e){return G({h:e.h,s:e.s,l:e.l,a:1})},fromHsva:function(e){var t;return{h:(t=W(e)).h,s:t.s,l:t.l}},equal:eu},eP=function(t){return e(r).createElement(eb,I({},t,{colorModel:eS}))},ej={defaultColor:"hsl(0, 0%, 0%)",toHsva:Y,fromHsva:Z,equal:ef},eR=function(t){return e(r).createElement(eb,I({},t,{colorModel:ej}))},e_={defaultColor:{h:0,s:0,v:0,a:1},toHsva:function(e){return e},fromHsva:es,equal:eu},eE=function(t){return e(r).createElement(ew,I({},t,{colorModel:e_}))},eM={defaultColor:"hsva(0, 0%, 0%, 1)",toHsva:er,fromHsva:function(e){var t=es(e);return"hsva("+t.h+", "+t.s+"%, "+t.v+"%, "+t.a+")"},equal:ef},ez=function(t){return e(r).createElement(ew,I({},t,{colorModel:eM}))},eO={defaultColor:{h:0,s:0,v:0},toHsva:function(e){return{h:e.h,s:e.s,v:e.v,a:1}},fromHsva:function(e){var t=es(e);return{h:t.h,s:t.s,v:t.v}},equal:eu},eI=function(t){return e(r).createElement(eb,I({},t,{colorModel:eO}))},eL={defaultColor:"hsv(0, 0%, 0%)",toHsva:er,fromHsva:function(e){var t=es(e);return"hsv("+t.h+", "+t.s+"%, "+t.v+"%)"},equal:ef},eA=function(t){return e(r).createElement(eb,I({},t,{colorModel:eL}))},e$={defaultColor:{r:0,g:0,b:0,a:1},toHsva:ei,fromHsva:et,equal:eu},eq=function(t){return e(r).createElement(ew,I({},t,{colorModel:e$}))},eB={defaultColor:"rgba(0, 0, 0, 1)",toHsva:eo,fromHsva:function(e){var t=et(e);return"rgba("+t.r+", "+t.g+", "+t.b+", "+t.a+")"},equal:ef},eT=function(t){return e(r).createElement(ew,I({},t,{colorModel:eB}))},eF={defaultColor:{r:0,g:0,b:0},toHsva:function(e){return ei({r:e.r,g:e.g,b:e.b,a:1})},fromHsva:function(e){var t;return{r:(t=et(e)).r,g:t.g,b:t.b}},equal:eu},eD=function(t){return e(r).createElement(eb,I({},t,{colorModel:eF}))},eV={defaultColor:"rgb(0, 0, 0)",toHsva:eo,fromHsva:function(e){var t=et(e);return"rgb("+t.r+", "+t.g+", "+t.b+")"},equal:ef},eJ=function(t){return e(r).createElement(eb,I({},t,{colorModel:eV}))};function eQ(e){let{pickerComponent:r,value:o,onChange:n}=e;switch(r){case"HexColorPicker":default:return(0,t.jsx)(eC,{color:o,onChange:n});case"RgbColorPicker":return(0,t.jsx)(eD,{color:o,onChange:n});case"RgbStringColorPicker":return(0,t.jsx)(eJ,{color:o,onChange:n});case"RgbaColorPicker":return(0,t.jsx)(eq,{color:o,onChange:n});case"RgbaStringColorPicker":return(0,t.jsx)(eT,{color:o,onChange:n});case"HueColorPicker":case"HslColorPicker":return(0,t.jsx)(eP,{color:o,onChange:n});case"HslStringColorPicker":return(0,t.jsx)(eR,{color:o,onChange:n});case"HslaColorPicker":return(0,t.jsx)(ey,{color:o,onChange:n});case"HslaStringColorPicker":return(0,t.jsx)(eN,{color:o,onChange:n});case"HsvColorPicker":return(0,t.jsx)(eI,{color:o,onChange:n});case"HsvStringColorPicker":return(0,t.jsx)(eA,{color:o,onChange:n});case"HsvaColorPicker":return(0,t.jsx)(eE,{color:o,onChange:n});case"HsvaStringColorPicker":return(0,t.jsx)(ez,{color:o,onChange:n})}}function eK(e){let{isPopupOpen:r,tooltip:o,resetRef:n,onResetButtonClick:a,onToggleButtonClick:i}=e,s=`url("${_}")`;return(0,t.jsxs)(t.Fragment,{children:[n&&a&&(0,t.jsx)("button",{type:"button",ref:n,className:`wpbf-control-reset${r?" is-shown":""}`,onClick:a,children:(0,t.jsx)("i",{className:"dashicons dashicons-image-rotate"})}),(0,t.jsxs)("div",{className:"wpbf-trigger-circle-wrapper",children:[o&&(0,t.jsx)("div",{className:"wpbf-label-tooltip",children:o}),(0,t.jsx)("button",{type:"button",className:"wpbf-trigger-circle",onClick:i,style:{backgroundImage:s},children:(0,t.jsx)("div",{className:"wpbf-color-preview",style:{backgroundColor:e.color?e.color:"transparent"}})})]})]})}function eX(e){let{label:r,description:o,setNotificationContainer:n}=e;return(0,t.jsxs)(t.Fragment,{children:[r||o?(0,t.jsxs)("label",{className:"wpbf-control-label",children:[r&&(0,t.jsx)("span",{className:"customize-control-title",dangerouslySetInnerHTML:{__html:r}}),o&&(0,t.jsx)("span",{className:"description customize-control-description",dangerouslySetInnerHTML:{__html:o}})]}):"",(0,t.jsx)("div",{className:"customize-control-notifications-container",ref:n})]})}function eU(e){let{label:r,description:o,labelStyle:n,setNotificationContainer:a}=e;function i(){return(0,t.jsx)(eX,{label:r,description:o,setNotificationContainer:a})}function s(o){return void 0===e.inputValue||void 0===e.isPopupOpen?(0,t.jsx)(t.Fragment,{}):(0,t.jsx)("div",{className:"wpbf-buttons",children:(0,t.jsx)(eK,{color:String(e.useHueMode?j({h:E(e.inputValue),s:100,l:50}).toHex():e.inputValue),isPopupOpen:e.isPopupOpen,resetRef:e.resetRef,onToggleButtonClick:e.togglePicker,onResetButtonClick:e.onResetButtonClick,tooltip:o&&!e.isPopupOpen?r:void 0})})}switch(n){case"tooltip":return(0,t.jsx)(t.Fragment,{children:s(!0)});case"top":return(0,t.jsxs)(t.Fragment,{children:[i(),s()]});case"label_only":return i();case"none":return s();default:return(0,t.jsx)(t.Fragment,{children:(0,t.jsxs)("div",{className:"wpbf-control-cols",children:[(0,t.jsx)("div",{className:"wpbf-control-left-col",children:i()}),(0,t.jsx)("div",{className:"wpbf-control-right-col",children:s()})]})})}}function eY(e,t,r,o){let n,a,i;if(""===e)return"";if(t)return String(E(e));if("number"==typeof e)return"";switch(r){case"HexColorPicker":i="string"==typeof e&&e.includes("#")?e:j(e).toHex();break;case"RgbColorPicker":i="string"==typeof e&&e.includes("rgb(")?e:j(e).toRgbString();break;case"RgbStringColorPicker":i="string"==typeof e&&e.includes("rgba")?e:j(e).toRgbString();break;case"RgbaColorPicker":j(e).toRgb().a<1?i="string"==typeof e&&e.includes("rgba")?e:j(e).toRgbString():(i=j(e).toRgbString()).includes("rgb")&&!i.includes("rgba")&&(i=(i=i.replace("rgb","rgba")).replace(")",", 1)"));break;case"RgbaStringColorPicker":1!=j(e).toRgb().a||o?(i=j(e).toRgbString()).includes("rgb")&&!i.includes("rgba")&&(i=(i=i.replace("rgb","rgba")).replace(")",", 1)")):i="string"==typeof e&&e.includes("#")?e:j(e).toHex();break;case"HslColorPicker":case"HslStringColorPicker":i="string"==typeof e&&e.includes("hsl(")?e:j(e).toHslString();break;case"HslaColorPicker":case"HslaStringColorPicker":(i=j(e).toHslString()).includes("hsl")&&!i.includes("hsla")&&(i=(i=i.replace("hsl","hsla")).replace(")",", 1)"));break;case"HsvColorPicker":case"HsvStringColorPicker":i="hsv("+(n=j(e).toHsv()).h+", "+n.s+"%, "+n.v+"%)";break;case"HsvaColorPicker":case"HsvaStringColorPicker":i="hsva("+(a=j(e).toHsv()).h+", "+a.s+"%, "+a.v+"%, "+a.a+")";break;default:i=j(e).toHex()}return i.replace(";","")}function eG(e,t,r){let o;if(t)return{h:E(e),s:100,l:50};switch("number"==typeof e&&(e="#000000"),r){case"HexColorPicker":default:o=j(e).toHex();break;case"RgbColorPicker":o={r:(o=j(e).toRgb()).r,g:o.g,b:o.b};break;case"RgbStringColorPicker":o=j(e).toRgbString();break;case"RgbaColorPicker":o=j(e).toRgb();break;case"RgbaStringColorPicker":(o=j(e).toRgbString()).includes("rgb")&&!o.includes("rgba")&&(o=(o=o.replace("rgb","rgba")).replace(")",", 1)"));break;case"HslColorPicker":o={h:(o=j(e).toHsl()).h,s:o.s,l:o.l};break;case"HslStringColorPicker":o=j(e).toHslString();break;case"HslaColorPicker":o=j(e).toHsl();break;case"HslaStringColorPicker":(o=j(e).toHslString()).includes("hsl")&&!o.includes("hsla")&&(o=(o=o.replace("hsl","hsla")).replace(")",", 1)"));break;case"HsvColorPicker":o={h:(o=j(e).toHsv()).h,s:o.s,v:o.v};break;case"HsvStringColorPicker":let n=j(e).toHsv();o="hsv("+n.h+", "+n.s+"%, "+n.v+"%)";break;case"HsvaColorPicker":o=j(e).toHsv();break;case"HsvaStringColorPicker":let a=j(e).toHsv();o="hsva("+a.h+", "+a.s+"%, "+a.v+"%, "+a.a+")"}return o}function eW(e){var o;let{control:n,container:a,useHueMode:i,pickerComponent:s,formComponent:l,label:c,description:u,labelStyle:f,useExternalPopupToggle:d}=e,[h,p]=(0,r.useState)(()=>eY(e.value,i,s,l)),[g,v]=(0,r.useState)(()=>eG(e.value,i,s)),b=h,m=g;n.updateColorPicker=function(e){let t=eY(e,i,s,l);("string"==typeof t||i?t!==h:JSON.stringify(t)!==JSON.stringify(b))&&p(t);let r=eG(e,i,s);("string"==typeof r||i?r!==g:JSON.stringify(r)!==JSON.stringify(m))&&v(r)};let C=""!==e.default&&void 0!==e.default?e.default:e.value,k=(0,r.useRef)(null),w=(0,r.useRef)(null),x=(0,r.useRef)(null),[y,H]=(0,r.useState)(e.isPopupOpen??!1);n.params&&"wpbf-multicolor"===n.params.type&&((0,r.useEffect)(()=>{p(eY(e.value,i,s,l)),v(eG(e.value,i,s))},[e.value]),(0,r.useEffect)(()=>{H(e.isPopupOpen??!1)},[e.isPopupOpen]));let[N,S]=(0,r.useState)({}),P=()=>{let e={};if("default"===f)return e;let t=2*parseInt(window.getComputedStyle(a.parentNode).paddingLeft,10);e.width=a.parentNode.getBoundingClientRect().width-t;let r=-((a.offsetLeft-9)*1);return e.left=r+"px",e};function _(){"string"==typeof h&&4===h.length&&h.includes("#")&&p(j(h).toHex())}function E(){y&&(H(!1),setTimeout(_,200))}o=function(){S(P())},(0,r.useEffect)(()=>{let e=e=>{o()};return window.addEventListener("resize",e,!0),()=>{window.removeEventListener("resize",e,!0)}},[o]),d||(z(k,E),O(w,x,E));let I=e.colorSwatches;if(jQuery.wp&&jQuery.wp.wpColorPicker){let e=jQuery.wp.wpColorPicker.prototype.options.palettes;if(Array.isArray(e)){if(e.length<8)for(let t=e.length;t<8;t++)e[t]&&e.push(I[t]);I=e}}return(0,t.jsx)(t.Fragment,{children:(0,t.jsxs)("div",{className:`wpbf-control-form ${i?"use-hue-mode":""} has-${f}-label-style`,ref:k,tabIndex:1,children:[!e.removeHeader&&(0,t.jsx)(eU,{label:c,description:u,labelStyle:f,pickerComponent:s,useHueMode:i,inputValue:h,isPopupOpen:y,togglePicker:function(){d||(y?E():y||(S(P()),_(),H(!0)))},resetRef:x,onResetButtonClick:()=>{C||(b="",m=""),e.onReset?.()},setNotificationContainer:e.setNotificationContainer}),(0,t.jsxs)("div",{ref:w,className:`${s} colorPickerContainer ${y?"is-open":""}`,style:N,children:[!i&&(0,t.jsx)(R,{colors:I,onClick:t=>{e.onChange?.(t)}}),(0,t.jsx)(eQ,{pickerComponent:s,value:g,onChange:t=>{m=t,e.onChange?.(t)}}),(0,t.jsx)(M,{pickerComponent:s,useHueMode:i,color:h,onChange:t=>{b=t,e.onChange?.(t)}})]})]})})}var eZ={};function e0(e,t,r,o){let n,a,i;if(""===e)return"";if(t)return E(e);if("number"==typeof e)return"";switch(r){case"HexColorPicker":default:i="string"==typeof e&&e.includes("#")?e:j(e).toHex();break;case"RgbColorPicker":i={r:(i=j(e).toRgb()).r,g:i.g,b:i.b};break;case"RgbStringColorPicker":i="string"==typeof e&&e.includes("rgb(")?e:j(e).toRgbString();break;case"RgbaColorPicker":i=j(e).toRgb();break;case"RgbaStringColorPicker":j(e).toRgb().a<1?i="string"==typeof e&&e.includes("rgba")?e:j(e).toRgbString():o?(i=j(e).toRgbString()).includes("rgb")&&!i.includes("rgba")&&(i=(i=i.replace("rgb","rgba")).replace(")",", 1)")):i="string"==typeof e&&e.includes("#")?e:j(e).toHex();break;case"HslColorPicker":i={h:(i=j(e).toHsl()).h,s:i.s,l:i.l};break;case"HslStringColorPicker":i="string"==typeof e&&e.includes("hsl(")?e:j(e).toHslString();break;case"HslaColorPicker":i=j(e).toHsl();break;case"HslaStringColorPicker":(i=j(e).toHslString()).includes("hsl")&&!i.includes("hsla")&&(i=(i=i.replace("hsl","hsla")).replace(")",", 1)"));break;case"HsvColorPicker":i={h:(i=j(e).toHsv()).h,s:i.s,v:i.v};break;case"HsvStringColorPicker":i="hsv("+(n=j(e).toHsv()).h+", "+n.s+"%, "+n.v+"%)";break;case"HsvaColorPicker":i=j(e).toHsv();break;case"HsvaStringColorPicker":i="hsva("+(a=j(e).toHsv()).h+", "+a.s+"%, "+a.v+"%, "+a.a+")"}return i}eZ=ReactDOM;let e1=window.wp.customize?.Control.extend({root:void 0,initialize:function(e,t){let r=this;this.setNotificationContainer=this.setNotificationContainer?.bind(r),window.wp.customize?.Control.prototype.initialize.call(r,e,t),window.wp.customize?.control.bind("removed",function e(t){r===t&&(r.destroy&&r.destroy(),r.container?.remove(),window.wp.customize?.control.unbind("removed",e))})},setNotificationContainer:function(e){this.notifications&&(this.notifications.container=jQuery(e),this.notifications.render())},renderContent:function(){let e=this.params;if(!e||!this.container||!this.container.length)return;let r=e.mode,o="hue"===r,n=e.formComponent,a="";a=n||("alpha"===r?"RgbaStringColorPicker":"HexColorPicker"),a=o?"HueColorPicker":a,!this.root&&this.container&&(this.root=eZ.createRoot(this.container[0])),this.root?.render(t.jsx(eW,{control:this,container:this.container[0],label:e.label,description:e.description,useHueMode:o,formComponent:n,pickerComponent:a,labelStyle:e.labelStyle,colorSwatches:e.colorSwatches,value:e.value,default:e.default,setNotificationContainer:this.setNotificationContainer,onChange:e=>this.onChange?.(e),onReset:()=>this.onReset?.()}))},ready:function(){let e=this;this.setting?.bind(t=>{e.updateComponentState?.(t)})},updateCustomizerSetting:function(e){if(void 0===e)return;let t=this.params;if(!t)return;let r=t.mode,o=t.formComponent,n="";n=o||("alpha"===r?"RgbaStringColorPicker":"HexColorPicker"),this.setting?.set(e0(e,"hue"===r,n,o))},onChange:function(e){this.updateCustomizerSetting?.(e)},onReset:function(){let e=this.params;if(!e)return;let t=""!==e.default&&void 0!==e.default?e.default:e.value;this.updateCustomizerSetting?.(t)},updateColorPicker:function(e){},updateComponentState:function(e){this.updateColorPicker?.(e)},destroy:function(){this.root?.unmount(),this.root=void 0,window.wp.customize?.Control.prototype.destroy&&window.wp.customize.Control.prototype.destroy.call(this)}});function e2(e){let{control:o,container:n,choices:a,setNotificationContainer:i,useHueMode:s,pickerComponent:l,formComponent:c,label:u,description:f}=e,[d,h]=(0,r.useState)(e.value),[p,g]=(0,r.useState)(void 0);function v(){g(void 0)}o.updateColorPickers=function(e){h(e)};let b=(0,r.useRef)(null),m=(0,r.useRef)(null),C=(0,r.useRef)(null);return z(b,v),O(m,C,v),(0,t.jsx)(t.Fragment,{children:(0,t.jsxs)("div",{className:"wpbf-multicolor",ref:b,children:[(0,t.jsxs)("div",{className:"wpbf-control-cols",children:[(0,t.jsx)("div",{className:"wpbf-control-left-col",children:(0,t.jsx)(eX,{label:u,description:f,setNotificationContainer:i})}),(0,t.jsx)("div",{className:"wpbf-control-right-col",children:(0,t.jsxs)("div",{className:"wpbf-buttons",children:[(0,t.jsx)("button",{type:"button",ref:C,className:`wpbf-control-reset${p?" is-shown":""}`,title:"Reset colors set",onClick:()=>o.onReset?.(),children:(0,t.jsx)("i",{className:"dashicons dashicons-image-rotate"})}),e.keys.map((e,r)=>{let o=eY(d[e]??"",s,l,c);return(0,t.jsx)(eK,{color:o,isPopupOpen:p===e,tooltip:a[e]??void 0,onToggleButtonClick:()=>{p?g(void 0):g(e)}},`${e}-${r}`)})]})})]}),(0,t.jsx)("div",{ref:m,className:"wpbf-color-picker-popup",children:e.keys.map((r,a)=>(0,t.jsx)(eW,{control:o,container:n,label:e.label,description:e.description,useHueMode:s,formComponent:c,pickerComponent:l,labelStyle:"none",colorSwatches:e.colorSwatches,value:d[r]??"",default:e.default[r],setNotificationContainer:e.setNotificationContainer,removeHeader:!0,isPopupOpen:p===r,useExternalPopupToggle:!0,onChange:e=>{let t={...d};t[r]=e,o.onChange?.(t)}},`${r}-${a}`))})]})})}let e5=window.wp.customize?.Control.extend({root:void 0,initialize:function(e,t){let r=this;this.setNotificationContainer=this.setNotificationContainer?.bind(r),window.wp.customize?.Control.prototype.initialize.call(r,e,t),window.wp.customize?.control.bind("removed",function e(t){r===t&&(r.destroy&&r.destroy(),r.container?.remove(),window.wp.customize?.control.unbind("removed",e))})},setNotificationContainer:function(e){this.notifications&&(this.notifications.container=jQuery(e),this.notifications.render())},renderContent:function(){let e=this.params;if(!e||!this.container||!this.container.length)return;let r=e.mode,o="hue"===r,n=e.formComponent,a="";a=n||("alpha"===r?"RgbaStringColorPicker":"HexColorPicker"),a=o?"HueColorPicker":a,!this.root&&this.container&&(this.root=eZ.createRoot(this.container[0])),this.root?.render(t.jsx(e2,{control:this,container:this.container[0],choices:e.choices,keys:Object.keys(e.choices),label:e.label,description:e.description,useHueMode:o,formComponent:n,pickerComponent:a,labelStyle:e.labelStyle,colorSwatches:e.colorSwatches,value:e.value,default:e.default,setNotificationContainer:this.setNotificationContainer}))},ready:function(){let e=this;this.setting?.bind(t=>{e.updateComponentState?.(t)})},onChange:function(e){this.updateCustomizerSetting?.(e)},onReset:function(){let e=this.params;if(!e)return;let t=void 0!==e.default&&Object.keys(e.default).length>0?e.default:e.value;this.updateCustomizerSetting?.(t)},updateCustomizerSetting:function(e){if(void 0===e)return;let t=this.params;if(!t)return;let r=t.mode,o="hue"===r,n=t.formComponent,a="";a=n||("alpha"===r?"RgbaStringColorPicker":"HexColorPicker");let i={};for(let t in e)e.hasOwnProperty(t)&&(i[t]=e0(e[t],o,a,n));this.setting?.set(i)},updateColorPickers:e=>{},updateComponentState:function(e){this.updateColorPickers?.(e)},destroy:function(){this.root?.unmount(),this.root=void 0,window.wp.customize?.Control.prototype.destroy&&window.wp.customize?.Control.prototype.destroy.call(this)}});window.wp.customize&&(e1&&(window.wp.customize.controlConstructor["wpbf-color"]=e1),e5&&(window.wp.customize.controlConstructor["wpbf-multicolor"]=e5))}();
//# sourceMappingURL=color-control-min.js.map
