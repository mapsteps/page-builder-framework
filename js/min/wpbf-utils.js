!function(){/*! MIT License © Sindre Sorhus */class e extends Error{response;request;options;constructor(e,t,r){let o=e.status||0===e.status?e.status:"",s=e.statusText||"",n=`${o} ${s}`.trim();super(`Request failed with ${n?`status code ${n}`:"an unknown error"}: ${t.method} ${t.url}`),this.name="HTTPError",this.response=e,this.request=t,this.options=r}}class t extends Error{request;constructor(e){super(`Request timed out: ${e.method} ${e.url}`),this.name="TimeoutError",this.request=e}}let r=e=>null!==e&&"object"==typeof e,o=(...e)=>{for(let t of e)if((!r(t)||Array.isArray(t))&&void 0!==t)throw TypeError("The `options` argument must be an object");return a({},...e)},s=(e={},t={})=>{let r=new globalThis.Headers(e),o=t instanceof globalThis.Headers;for(let[e,s]of new globalThis.Headers(t).entries())o&&"undefined"===s||void 0===s?r.delete(e):r.set(e,s);return r};function n(e,t,r){return Object.hasOwn(t,r)&&void 0===t[r]?[]:a(e[r]??[],t[r]??[])}let i=(e={},t={})=>({beforeRequest:n(e,t,"beforeRequest"),beforeRetry:n(e,t,"beforeRetry"),afterResponse:n(e,t,"afterResponse"),beforeError:n(e,t,"beforeError")}),a=(...e)=>{let t={},o={},n={};for(let l of e)if(Array.isArray(l))Array.isArray(t)||(t=[]),t=[...t,...l];else if(r(l)){for(let[e,o]of Object.entries(l))r(o)&&e in t&&(o=a(t[e],o)),t={...t,[e]:o};r(l.hooks)&&(n=i(n,l.hooks),t.hooks=n),r(l.headers)&&(o=s(o,l.headers),t.headers=o)}return t},l=(()=>{let e=!1,t=!1,r="function"==typeof globalThis.Request;if("function"==typeof globalThis.ReadableStream&&r)try{t=new globalThis.Request("https://empty.invalid",{body:new globalThis.ReadableStream,method:"POST",get duplex(){return e=!0,"half"}}).headers.has("Content-Type")}catch(e){if(e instanceof Error&&"unsupported BodyInit type"===e.message)return!1;throw e}return e&&!t})(),u="function"==typeof globalThis.AbortController,f="function"==typeof globalThis.ReadableStream,c="function"==typeof globalThis.FormData,d=["get","post","put","patch","head","delete"],h={json:"application/json",text:"text/*",formData:"multipart/form-data",arrayBuffer:"*/*",blob:"*/*"},p=Symbol("stop"),m={json:!0,parseJson:!0,stringifyJson:!0,searchParams:!0,prefixUrl:!0,retry:!0,timeout:!0,hooks:!0,throwHttpErrors:!0,onDownloadProgress:!0,fetch:!0},y={method:!0,headers:!0,body:!0,mode:!0,credentials:!0,cache:!0,redirect:!0,referrer:!0,referrerPolicy:!0,integrity:!0,keepalive:!0,signal:!0,window:!0,dispatcher:!0,duplex:!0,priority:!0},g=e=>d.includes(e)?e.toUpperCase():e,b={limit:2,methods:["get","put","head","delete","options","trace"],statusCodes:[408,413,429,500,502,503,504],afterStatusCodes:[413,429,503],maxRetryAfter:Number.POSITIVE_INFINITY,backoffLimit:Number.POSITIVE_INFINITY,delay:e=>.3*2**(e-1)*1e3},_=(e={})=>{if("number"==typeof e)return{...b,limit:e};if(e.methods&&!Array.isArray(e.methods))throw Error("retry.methods must be an array");if(e.statusCodes&&!Array.isArray(e.statusCodes))throw Error("retry.statusCodes must be an array");return{...b,...e}};async function w(e,r,o,s){return new Promise((n,i)=>{let a=setTimeout(()=>{o&&o.abort(),i(new t(e))},s.timeout);s.fetch(e,r).then(n).catch(i).then(()=>{clearTimeout(a)})})}async function T(e,{signal:t}){return new Promise((r,o)=>{function s(){clearTimeout(n),o(t.reason)}t&&(t.throwIfAborted(),t.addEventListener("abort",s,{once:!0}));let n=setTimeout(()=>{t?.removeEventListener("abort",s),r()},e)})}let E=(e,t)=>{let r={};for(let o in t)o in y||o in m||o in e||(r[o]=t[o]);return r};class S{static create(t,r){let o=new S(t,r),s=async()=>{if("number"==typeof o._options.timeout&&o._options.timeout>0x7fffffff)throw RangeError("The `timeout` option cannot be greater than 2147483647");await Promise.resolve();let t=await o._fetch();for(let e of o._options.hooks.afterResponse){let r=await e(o.request,o._options,o._decorateResponse(t.clone()));r instanceof globalThis.Response&&(t=r)}if(o._decorateResponse(t),!t.ok&&o._options.throwHttpErrors){let r=new e(t,o.request,o._options);for(let e of o._options.hooks.beforeError)r=await e(r);throw r}if(o._options.onDownloadProgress){if("function"!=typeof o._options.onDownloadProgress)throw TypeError("The `onDownloadProgress` option must be a function");if(!f)throw Error("Streams are not supported in your environment. `ReadableStream` is missing.");return o._stream(t.clone(),o._options.onDownloadProgress)}return t},n=o._options.retry.methods.includes(o.request.method.toLowerCase())?o._retry(s):s();for(let[e,t]of Object.entries(h))n[e]=async()=>{o.request.headers.set("accept",o.request.headers.get("accept")||t);let s=(await n).clone();if("json"===e){if(204===s.status||0===(await s.clone().arrayBuffer()).byteLength)return"";if(r.parseJson)return r.parseJson(await s.text())}return s[e]()};return n}request;abortController;_retryCount=0;_input;_options;constructor(e,t={}){if(this._input=e,this._options={...t,headers:s(this._input.headers,t.headers),hooks:i({beforeRequest:[],beforeRetry:[],beforeError:[],afterResponse:[]},t.hooks),method:g(t.method??this._input.method),prefixUrl:String(t.prefixUrl||""),retry:_(t.retry),throwHttpErrors:!1!==t.throwHttpErrors,timeout:t.timeout??1e4,fetch:t.fetch??globalThis.fetch.bind(globalThis)},"string"!=typeof this._input&&!(this._input instanceof URL||this._input instanceof globalThis.Request))throw TypeError("`input` must be a string, URL, or Request");if(this._options.prefixUrl&&"string"==typeof this._input){if(this._input.startsWith("/"))throw Error("`input` must not begin with a slash when using `prefixUrl`");this._options.prefixUrl.endsWith("/")||(this._options.prefixUrl+="/"),this._input=this._options.prefixUrl+this._input}if(u){this.abortController=new globalThis.AbortController;let e=this._options.signal??this._input.signal;e?.addEventListener("abort",()=>{this.abortController.abort(e.reason)}),this._options.signal=this.abortController.signal}if(l&&(this._options.duplex="half"),void 0!==this._options.json&&(this._options.body=this._options.stringifyJson?.(this._options.json)??JSON.stringify(this._options.json),this._options.headers.set("content-type",this._options.headers.get("content-type")??"application/json")),this.request=new globalThis.Request(this._input,this._options),this._options.searchParams){let e="string"==typeof this._options.searchParams?this._options.searchParams.replace(/^\?/,""):new URLSearchParams(this._options.searchParams).toString(),t=this.request.url.replace(/(?:\?.*?)?(?=#|$)/,"?"+e);(c&&this._options.body instanceof globalThis.FormData||this._options.body instanceof URLSearchParams)&&!(this._options.headers&&this._options.headers["content-type"])&&this.request.headers.delete("content-type"),this.request=new globalThis.Request(new globalThis.Request(t,{...this.request}),this._options)}}_calculateRetryDelay(r){if(this._retryCount++,this._retryCount>this._options.retry.limit||r instanceof t)throw r;if(r instanceof e){if(!this._options.retry.statusCodes.includes(r.response.status))throw r;let e=r.response.headers.get("Retry-After")??r.response.headers.get("RateLimit-Reset")??r.response.headers.get("X-RateLimit-Reset")??r.response.headers.get("X-Rate-Limit-Reset");if(e&&this._options.retry.afterStatusCodes.includes(r.response.status)){let t=1e3*Number(e);Number.isNaN(t)?t=Date.parse(e)-Date.now():t>=Date.parse("2024-01-01")&&(t-=Date.now());let r=this._options.retry.maxRetryAfter??t;return t<r?t:r}if(413===r.response.status)throw r}let o=this._options.retry.delay(this._retryCount);return Math.min(this._options.retry.backoffLimit,o)}_decorateResponse(e){return this._options.parseJson&&(e.json=async()=>this._options.parseJson(await e.text())),e}async _retry(e){try{return await e()}catch(r){let t=Math.min(this._calculateRetryDelay(r),0x7fffffff);if(this._retryCount<1)throw r;for(let e of(await T(t,{signal:this._options.signal}),this._options.hooks.beforeRetry))if(await e({request:this.request,options:this._options,error:r,retryCount:this._retryCount})===p)return;return this._retry(e)}}async _fetch(){for(let e of this._options.hooks.beforeRequest){let t=await e(this.request,this._options);if(t instanceof Request){this.request=t;break}if(t instanceof Response)return t}let e=E(this.request,this._options),t=this.request;return(this.request=t.clone(),!1===this._options.timeout)?this._options.fetch(t,e):w(t,e,this.abortController,this._options)}_stream(e,t){let r=Number(e.headers.get("content-length"))||0,o=0;return 204===e.status?(t&&t({percent:1,totalBytes:r,transferredBytes:o},new Uint8Array),new globalThis.Response(null,{status:e.status,statusText:e.statusText,headers:e.headers})):new globalThis.Response(new globalThis.ReadableStream({async start(s){let n=e.body.getReader();async function i(){let{done:e,value:a}=await n.read();if(e){s.close();return}t&&(o+=a.byteLength,t({percent:0===r?0:o/r,transferredBytes:o,totalBytes:r},a)),s.enqueue(a),await i()}t&&t({percent:0,transferredBytes:0,totalBytes:r},new Uint8Array),await i()}}),{status:e.status,statusText:e.statusText,headers:e.headers})}}let R=e=>{let t=(t,r)=>S.create(t,o(e,r));for(let r of d)t[r]=(t,s)=>S.create(t,o(e,s,{method:r}));return t.create=e=>R(o(e)),t.extend=t=>("function"==typeof t&&(t=t(e??{})),R(o(e,t))),t.stop=p,t},L=R(),q=Object.getPrototypeOf,A,x,H,C,k={isConnected:1},P,$={},M=q(k),N=q(q),U,I=(e,t,r,o)=>(e??(setTimeout(r,o),new Set)).add(t),V=(e,t,r)=>{let o=H;H=t;try{return e(r)}catch(e){return console.error(e),r}finally{H=o}},j=e=>e.filter(e=>e._dom?.isConnected),D=e=>P=I(P,e,()=>{for(let e of P)e._bindings=j(e._bindings),e._listeners=j(e._listeners);P=U},1e3),B={get val(){return H?._getters?.add(this),this.rawVal},get oldVal(){return H?._getters?.add(this),this._oldVal},set val(v){H?._setters?.add(this),v!==this.rawVal&&(this.rawVal=v,this._bindings.length+this._listeners.length?(x?.add(this),A=I(A,this,Q)):this._oldVal=v)}},O=e=>({__proto__:B,rawVal:e,_oldVal:e,_bindings:[],_listeners:[]}),F=(e,t)=>{let r={_getters:new Set,_setters:new Set},o={f:e},s=C;C=[];let n=V(e,r,t);for(let e of(n=(n??document).nodeType?n:new Text(n),r._getters))r._setters.has(e)||(D(e),e._bindings.push(o));for(let e of C)e._dom=n;return C=s,o._dom=n},W=(e,t=O(),r)=>{let o={_getters:new Set,_setters:new Set},s={f:e,s:t};for(let n of(s._dom=r??C?.push(s)??k,t.val=V(e,o,t.rawVal),o._getters))o._setters.has(n)||(D(n),n._listeners.push(s));return t},J=(e,...t)=>{for(let r of t.flat(1/0)){let t=q(r??0),o=t===B?F(()=>r.val):t===N?F(r):r;o!=U&&e.append(o)}return e},Y=(e,t,...r)=>{let[o,...s]=q(r[0]??0)===M?r:[{},...r],n=e?document.createElementNS(e,t):document.createElement(t);for(let[e,r]of Object.entries(o)){let o=t=>t?Object.getOwnPropertyDescriptor(t,e)??o(q(t)):U,s=t+","+e,i=$[s]??=o(q(n))?.set??0,a=e.startsWith("on")?(t,r)=>{let o=e.slice(2);n.removeEventListener(o,r),n.addEventListener(o,t)}:i?i.bind(n):n.setAttribute.bind(n,e),l=q(r??0);e.startsWith("on")||l===N&&(r=W(r),l=B),l===B?F(()=>(a(r.val,r._oldVal),n)):a(r)}return J(n,s)},X=e=>({get:(t,r)=>Y.bind(U,e,r)}),z=(e,t)=>t?t!==e&&e.replaceWith(t):e.remove(),Q=()=>{let e=0,t=[...A].filter(e=>e.rawVal!==e._oldVal);do for(let e of(x=new Set,new Set(t.flatMap(e=>e._listeners=j(e._listeners)))))W(e.f,e.s,e._dom),e._dom=U;while(++e<100&&(t=[...x]).length)let r=[...A].filter(e=>e.rawVal!==e._oldVal);for(let e of(A=U,new Set(r.flatMap(e=>e._bindings=j(e._bindings)))))z(e._dom,F(e.f,e._dom)),e._dom=U;for(let e of r)e._oldVal=e.rawVal};var G={tags:new Proxy(e=>new Proxy(Y,X(e)),X()),hydrate:(e,t)=>z(e,F(t,e)),add:J,state:O,derive:W};function K(e,t){let r=e instanceof HTMLElement?e:document.querySelector(e);return r&&r.getAttribute&&t&&r.getAttribute(t)||""}let Z={desktop:1024,tablet:768,mobile:480};function ee(e){let t=Z[e]||0,r=document.body.className.match("wpbf-"+e+"-breakpoint-[\\w-]*\\b");if(!r)return t;let o=r.toString().match(/\d+/);return Array.isArray(o)?parseInt(o[0],10):0}function et(){return Z.desktop=ee("desktop"),Z.tablet=ee("tablet"),Z.mobile=ee("mobile"),Z}function er(e){if(!e)return 0;e.style.opacity="0",e.style.display="block";let t=window.getComputedStyle(e),r=e.offsetHeight-parseFloat(t.paddingTop)-parseFloat(t.paddingBottom)-parseFloat(t.borderTopWidth)-parseFloat(t.borderBottomWidth),o=e.getAttribute("style");return o&&(o=(o=o.replace(/display\s*:\s*block\s*;/,"")).replace(/opacity\s*:\s*0\s*;/,""),e.setAttribute("style",o)),r}function eo(e,t,r){let o=e.id?e.id:"wpbf-"+Math.random().toString(36).substring(2,9);e.id||(e.id=o);let s=`wpbf-style-${o}`,n=t?document.querySelector(`#${s}[data-scope="${t}"]`):document.querySelector(`#${s}`);if(n&&n instanceof HTMLStyleElement)return r&&(n.innerHTML=r),n;let i=document.createElement("style");return i.id=`wpbf-style-${o}`,t&&(i.dataset.scope=t),r&&(i.innerHTML=r),document.head.appendChild(i),i}function es(e,t){return eo(e,t,void 0).id}window.WpbfUtils={isInsideCustomizer:()=>!!window.wp&&!!window.wp.customize,dom:{findHtmlEl:function(e){let t=document.querySelector(e);return t instanceof HTMLElement?t:null},getHtmlEls:function(e){let t=document.querySelectorAll(e),r=[];for(let e=0;e<t.length;e++){let o=t[e];o instanceof HTMLElement&&r.push(o)}return r},getParentHtmlEl:function(e){let t=e.parentNode;return t instanceof HTMLElement?t:null},getSiblings:function(e,t){if(!e.parentNode)return[];let r=[],o=e.parentNode.firstChild;for(;o;)1===o.nodeType&&o instanceof HTMLElement&&o!==e&&(!t||o.matches(t))&&r.push(o),o=o.nextSibling;return r},getSiblingHtmlEl:function(e){let t=e.nextElementSibling;return t instanceof HTMLElement?t:null},getNextElsUntil:function(e,t,r){let o=e instanceof Element?e:document.querySelector(e);if(!o)return[];let s=[],n=o.nextElementSibling;for(;n&&!n.matches(t);)r&&n.matches(r)&&s.push(n),n=n.nextElementSibling;return s},getPrevElsUntil:function(e,t,r){let o=e instanceof Element?e:document.querySelector(e);if(!o)return[];let s=[],n=o.previousElementSibling;for(;n&&!n.matches(t);)r&&n.matches(r)&&s.push(n),n=n.previousElementSibling;return s},getLastHtmlEl:function(e){let t=document.querySelectorAll(e),r=t[t.length-1];return r instanceof HTMLElement?r:null},directQuerySelector:function(e,t){let r=e.className;r=(r=r.replace(/^\s+|\s+$/g,"")).replace(/\s/g,".");let o=e.parentNode;if(!o)return null;let s=o.querySelectorAll(`.${r} > ${t}`);if(!s.length)return null;let n=null;for(let t=0;t<s.length;t++){if(s[t].parentNode!=e)continue;let r=s[t];if(r instanceof HTMLElement){n=r;break}}return n},forEachEl:function(e,t){if(!(e instanceof NodeList)&&!Array.isArray(e)&&"string"!=typeof e||"function"!=typeof t)return;let r=e instanceof NodeList||Array.isArray(e)?e:document.querySelectorAll(e);if(r.length)for(let e=0;e<r.length;e++){let o=r[e];o instanceof HTMLElement&&t(o)}},listenDocumentEvent:function(e,t,r){if("string"!=typeof e||"function"!=typeof r)return;let o=e;switch(e){case"mouseenter":o="mouseover";break;case"mouseleave":o="mouseout"}document.addEventListener(o,function(e){if(!e.target||!(e.target instanceof Element))return;let s=e.target;if(t){let r=e.target.closest(t);if(!r)return;r instanceof Element&&(s=r)}s&&"mouseout"===o&&e instanceof MouseEvent&&e.relatedTarget instanceof Node&&s.contains(e.relatedTarget)||r.call(s,e)})},getAttr:K,getAttrAsNumber:function(e,t){let r=K(e,t);return r?parseInt(r,10):0},getActiveBreakpoint:function(){let e=et(),t=document.documentElement.clientWidth,r="desktop";return t>e.desktop?r:r=t>e.tablet?"tablet":"mobile"},getBreakpoints:et,updateElSrc:function(e,t){(e instanceof HTMLImageElement||e instanceof HTMLVideoElement||e instanceof HTMLEmbedElement||e instanceof HTMLAudioElement||e instanceof HTMLSourceElement||e instanceof HTMLIFrameElement)&&(e.src=t)},getOffset:function(e){let t=e.getBoundingClientRect();return{top:t.top+window.scrollY-document.documentElement.clientTop,left:t.left+window.scrollX-document.documentElement.clientLeft}},getWindowScrollTop:function(){return document.documentElement?document.documentElement.scrollTop:document.body.scrollTop},getPureHeight:er,builder:G},anim:{hideElAfterDelay:function(e,t){e&&"number"==typeof t&&setTimeout(function(){e.style.display="none"},t)},writeElStyle:eo,getElStyleId:es,getElStyleTag:function(e,t){return eo(e,t,void 0)},animateScrollTop:function(e,t){let r=window.scrollY,o=e-r,s=performance.now();requestAnimationFrame(function e(n){let i=n-s;window.scrollTo(0,r+o/2-o/2*Math.cos(Math.PI*i/t)),i<t&&requestAnimationFrame(e)})},slideToggle:function(e){let t=e.el,r=e.direction,o=e.duration??400,s=e.easing??"ease-in-out",n=e.callback,i=e.animScope,a=er(t),l=es(t,i).replace("wpbf-style-",""),u="slide-anim",f="is-expanded",c="is-collapsed";if(eo(t,i,`
		#${l}.${u}.${c} {height: 0;}
		#${l}.${u}.${f} {height: ${a}px;}
		#${l}.${u} {display: block; overflow: hidden; transition: height ${o}ms ${s};}
		`),"down"===r){t.classList.add(c),t.classList.add(u),setTimeout(function(){t.classList.add(f),t.classList.remove(c),setTimeout(()=>{t.classList.remove(f),n?.()},o)},1);return}t.classList.add(f),t.classList.add(u),setTimeout(function(){t.classList.add(c),t.classList.remove(f),setTimeout(function(){t.classList.remove(u),t.classList.remove(c),n?.()},o)},1)}},fetch:L,url:{addUrlParams:function(e,t){let r=new URL(e);for(let e in t)r.searchParams.set(e,t[e]);return r.toString()}}}}();
//# sourceMappingURL=wpbf-utils.js.map
