!function(){window.wp.customize?.bind("ready",function(){var n;window.wp.customize&&(n=window.wp.customize,Array.isArray(wpbfTypographyControlIds)&&wpbfTypographyControlIds.forEach(i=>{n.control(i)&&n(i,function(n){t(i,void 0,void 0,void 0),n.bind(function(n){t(i,n,void 0,void 0)}),Array.isArray(wpbfFontProperties)&&wpbfFontProperties.forEach(n=>{let o=`${i}[${n}]`;window.wp.customize?.control(o)&&window.wp.customize?.(o,function(o){o.bind(function(o){t(i,void 0,n,o,!0)})})})})}))});function t(t,n,i,o,e){let a=window.wp.customize?.control(t);if(!a||!a.setting)return;let r={...n=n||a.setting.get()};if("string"!=typeof r["font-family"])return;("font-family"===i||"variant"===i)&&(r[i]=o);let l=void 0===r.variant?"regular":r.variant,f=window.wp.customize?.control(t+"[variant]"),p=f&&"wpbf-select"===f.params.type?f:void 0;if(-1!==l.indexOf("i")?r["font-style"]="italic":r["font-style"]="normal",r["font-weight"]="regular"===l||"italic"===l?400:parseInt(l,10),p&&(void 0===i||"font-family"===i)){let n=function(t,n){let i=n["font-family"];if(!i)return[];let o=function(t){if(wpbfGoogleFonts&&wpbfGoogleFonts.items[t])return wpbfGoogleFonts.items[t]}(i),e=[];if(o){if(!wpbfFontVariantOptions)return e;let t=o.variants,n=0;for(;n<wpbfFontVariantOptions.complete.length;++n)t.includes(wpbfFontVariantOptions.complete[n].value)&&e.push({text:wpbfFontVariantOptions.complete[n].label,id:wpbfFontVariantOptions.complete[n].value})}else{let i=t.replace(/]/g,"");i=i.replace(/\[/g,"_");let o=wpbfFieldsFontVariants&&wpbfFieldsFontVariants[i]?wpbfFieldsFontVariants[i]:void 0;if(o&&"object"==typeof o)for(let t in o){if(!o.hasOwnProperty(t)||n["font-family"]!==t)continue;let i=o[t];if(!i.length)continue;let a=0;for(;a<i.length;++a)e.push({text:i[a].label,id:i[a].value})}else{if(e.length=0,!wpbfFontVariantOptions)return e;let t=0;for(;t<wpbfFontVariantOptions.standard.length;++t)e.push({text:wpbfFontVariantOptions.standard[t].label,id:wpbfFontVariantOptions.standard[t].value})}}return e}(t,r);n.length>1&&a.active()?p.activate():p.deactivate();let i=n.some(t=>t.id==l)?l:"regular",o=p.container?.find(".wpbf-select2");o?.empty(),o?.append(n.map(t=>new Option(t.text,t.id,!1,!1))),o?.val(i),o?.trigger("change")}e&&(r.random=Date.now()),a.setting.set(r),window.wp.hooks.addAction("wpbf.dynamicControl.initWpbfControl","wpbf",function(t){p&&t.id})}}();
//# sourceMappingURL=typography-control-min.js.map
