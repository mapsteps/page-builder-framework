!function(){function e(e){return e&&e.__esModule?e.default:e}var t={};t=_,wp.customize.controlConstructor["wpbf-image"]=wp.customize.wpbfDynamicControl.extend({initWpbfControl:function(i){let s=i||this,n=s.params,l=n.saveAs,d=n.defaultSrc,a=n.valueSrc,r=s.container[0].querySelector(".attachment-media-view"),u=r?.querySelector(".thumbnail")??null,c=r?.querySelector(".button-add-media")??null,o=r?.querySelector(".change-button")??null,m=r?.querySelector(".remove-button")??null,h=r?.querySelector(".default-button")??null;g();let f=a.url;function L(){let i=wp.media({multiple:!1}).open().on("select",function(){let n=i.state().get("selection").first().toJSON();a.id=n.id,a.url=n.url,a.width=n.width,a.height=n.height,f=n.url,/*@__PURE__*/e(t).isUndefined(n.sizes)||(a.url=n.sizes.full.url,f=n.sizes.full.url,/*@__PURE__*/e(t).isUndefined(n.sizes.medium)?/*@__PURE__*/e(t).isUndefined(n.sizes.thumbnail)||(f=n.sizes.thumbnail.url):f=n.sizes.medium.url),"array"===l?s.setting?.set(a):"id"===l?s.setting?.set(a.id):"url"===l&&s.setting?.set(a.url),u&&(u.innerHTML='<img class="attachment-thumb" src="'+f+'" alt="" />'),g()})}function g(){a.url?(u&&u.classList.remove("hidden"),m&&m.classList.remove("hidden"),c&&c.classList.add("hidden"),o&&o.classList.remove("hidden")):(u&&u.classList.add("hidden"),m&&m.classList.add("hidden"),c&&c.classList.remove("hidden"),o&&o.classList.add("hidden")),a.id===d.id?h&&h.classList.add("hidden"):h&&h.classList.remove("hidden")}u&&f&&(u.innerHTML='<img class="attachment-thumb" src="'+f+'" alt="" />'),c?.addEventListener("click",L),o?.addEventListener("click",L),m?.addEventListener("click",function(){a.id=0,a.url="",a.width=0,a.height=0,"array"===l?s.setting?.set(a):"id"===l?s.setting?.set(0):"url"===l&&s.setting?.set(""),u&&(u.innerHTML=wp.i18n.__("No image selected","wpbf")),g()}),h?.addEventListener("click",function(){s.setting?.set(d),u&&(u.innerHTML='<img class="attachment-thumb" src="'+s.params.default+'" alt="" />'),g()})}})}();
//# sourceMappingURL=image-control-min.js.map
