!function(){wp.customize.bind("ready",function(){Array.isArray(wpbfTypographyControlIds)&&wpbfTypographyControlIds.forEach(n=>{wp.customize.control(n)&&(t(n),Array.isArray(wpbfFontProperties)&&wpbfFontProperties.forEach(t=>{if("font-family"!==t&&"variant"!==t)return;let e=`${n}[${t}]`;wp.customize.control(e)&&wp.customize(e,function(e){e.bind(function(e){let o=wp.customize(n).get()||{};o[t]=e,wp.customize.control(n)?.setting?.set(o),console.log(`"${t}" new value is: ${e}, and "${n}" new value is:`,wp.customize(n).get())})})}),wp.customize(n,function(e){e.bind(function(e){t(n,e)})}))})});function t(t,n){let e=wp.customize.control(t);if(!e||!e.setting||void 0===(n=n||e.setting.get())||"string"!=typeof n["font-family"])return;let o=void 0===n.variant?"regular":n.variant,i=wp.customize.control(t+"[variant]"),a=i&&"wpbf-select"===i.params.type?i:void 0,r=function(t){if(wpbfGoogleFonts&&wpbfGoogleFonts.items[t])return wpbfGoogleFonts.items[t]}(n["font-family"]),l=[];if(r){if(!wpbfFontVariantOptions)return l;let t=r.variants,n=0;for(;n<wpbfFontVariantOptions.complete.length;++n)t.includes(wpbfFontVariantOptions.complete[n].value)&&l.push({l:wpbfFontVariantOptions.complete[n].label,v:wpbfFontVariantOptions.complete[n].value})}else{let n=t.replace(/]/g,"");n=n.replace(/\[/g,"_");let e=wpbfFieldsFontVariants&&wpbfFieldsFontVariants[n]?wpbfFieldsFontVariants[n]:void 0;if(e&&e.length){let t=0;for(;t<e.length;++t)l.push({l:e[t].label,v:e[t].value})}else{if(l.length=0,!wpbfFontVariantOptions)return l;let t=0;for(;t<wpbfFontVariantOptions.standard.length;++t)l.push({l:wpbfFontVariantOptions.standard[t].label,v:wpbfFontVariantOptions.standard[t].value})}}-1!==o.indexOf("i")?n["font-style"]="italic":n["font-style"]="normal",n["font-weight"]="regular"===o||"italic"===o?400:parseInt(o,10),a&&((l.length>1&&e.active()?a.activate():a.deactivate(),a.parseSelectChoices?.(l),a.destroy?.(),l.some(t=>t.v===o))?a.doSelectAction?.("selectOption",o):a.doSelectAction?.("selectOption","regular")),wp.customize(t).set(n),wp.hooks.addAction("wpbf.dynamicControl.initKirkiControl","wpbf",function(t){a&&t.id})}}();
//# sourceMappingURL=typography-control-min.js.map
