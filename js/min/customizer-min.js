!function(){function o(o){return"boolean"==typeof o||"string"==typeof o?o:String(o)}let e="customize-preview",t="builder-panel";function n(o,e,t){t?wp.customize?.panel(o.togglePanelId,function(t){t.expanded()&&(e.container[0]&&e.container[0].classList.remove("disabled"),i(o.builderControlId))}):(e.container[0]&&e.container[0].classList.add("disabled"),r(o.builderControlId))}function i(o){let n=jQuery(`.${o}-${t}`);n.addClass("before-shown");let i=n.outerHeight();window.setTimeout(()=>{n.removeClass("before-shown"),window.setTimeout(()=>{n.css("max-height",i??"auto"),jQuery("#"+e).css("bottom",i??"auto")},0);let t=l(o);t&&t.classList.add("builder-is-shown")},0)}function r(o){jQuery(`.${o}-${t}`).removeAttr("style"),jQuery("#"+e).css("bottom",0);let n=l(o);n&&n.classList.remove("builder-is-shown")}function l(o){let e=document.querySelector(`.control-panel-content.${o}-control-panel`);if(e instanceof HTMLElement)return e}window.wp.customize?.bind("ready",()=>{setTimeout(()=>{jQuery("#customize-control-menu_logo_container_width").on("mousedown",function(){jQuery("iframe").contents().find(".wpbf-navigation .wpbf-1-4").css("border-right","3px solid #0085ba")}).on("mouseup",function(){jQuery("iframe").contents().find(".wpbf-navigation .wpbf-1-4").css("border-right","none")}),jQuery("#customize-control-mobile_menu_logo_container_width").on("mousedown",function(){jQuery("iframe").contents().find(".wpbf-navigation .wpbf-2-3").css("border-right","3px solid #0085ba")}).on("mouseup",function(){jQuery("iframe").contents().find(".wpbf-navigation .wpbf-2-3").css("border-right","none")}),function(){let o=document.querySelectorAll("#customize-theme-controls .wpbf-builder-toggle");if(!o.length)return;let e=[];for(let t of o){if(!(t instanceof HTMLElement))return;let o=t.dataset.wpbfSetting;if(!o)return;let n=t.dataset.connectedBuilder;if(!n)return;wp.customize?.control(o,function(t){if(!t)return;let i=t.section();wp.customize?.section(i,function(t){let i=t.params.panel;i&&(t.container?.addClass(`builder-control-section ${n}-control-section`),e.push({togglePanelId:i,toggleControlId:o,builderControlId:n}))})})}if(e.length)for(let o of e)(function(o){wp.customize?.panel(o.togglePanelId,function(e){e.container?.addClass(`${o.builderControlId}-control-panel`),e.expanded.bind(function(e){e?wp.customize?.control(o.toggleControlId,function(e){e?.setting?.get()&&i(o.builderControlId)}):r(o.builderControlId)})})})(o),function(o){wp.customize?.control(o.toggleControlId,e=>{e&&(n(o,e,e.setting?.get()),e.setting?.bind(function(t){n(o,e,t)}))})}(o),function(o){wp.customize?.control(o,e=>{if(!e)return;let t=e.params.builder.availableWidgets;if(t.length)for(let e of t){let t=e.section;t&&wp.customize?.section(t,function(t){t.expanded.bind(function(t){if(!function(o){let e=l(o);return!!e&&e.classList.contains("builder-is-shown")}(o))return;let n=document.querySelector(`.${o}-builder-panel`);if(n){let o=n.querySelector(`.widget-item[data-widget-key="${e.key}"]`);o&&(t?o.classList.add("connected-section-expanded"):o.classList.remove("connected-section-expanded"))}})})}})}(o.builderControlId)}(),function(e){for(let o=0;o<e.sections.length;o++){let t=e.sections[o];for(let o=0;o<t.controlsToMove.length;o++){let e=t.controlsToMove[o],n=window.wp.customize?.control(e.id);n&&(e.label&&!e.label.from&&(e.label.from=n.params.label),e.prio&&!e.prio.from&&(e.prio.from=n.priority()),t.controlsToMove[o]=e,n.actuallyEmbed?.())}e.sections[o]=t}let t="number"==typeof e.dependency.moveForwardWhenValueIs?String(e.dependency.moveForwardWhenValueIs):e.dependency.moveForwardWhenValueIs;function n(o){for(let t=0;t<e.sections.length;t++){let n=e.sections[t];for(let e=0;e<n.controlsToMove.length;e++){let t=n.controlsToMove[e],i=window.wp.customize?.control(t.id);if(!i)continue;t.label&&(i.params.label=o?t.label.to:t.label.from),t.prio&&i.priority(o?t.prio.to:t.prio.from??0),i.initWpbfControl&&t.label&&i.container.find(".customize-control-title").html(o?t.label.to:t.label.from??"");let r=o?n.to:n.from;i.container.attr("data-wpbf-parent-tab-id",r),i.section(r)}}}window.wp.customize?.(e.dependency.settingId,e=>{n(o(e.get())===t),e.bind(e=>{n(o(e)===t)})})}({dependency:{settingId:"wpbf_enable_header_builder",moveForwardWhenValueIs:!0},sections:[{from:"wpbf_pre_header_options",to:"wpbf_header_builder_row_1_section",controlsToMove:[{id:"pre_header_width",label:{from:void 0,to:"Container Width"},prio:{from:void 0,to:10}},{id:"pre_header_height",label:{from:void 0,to:"Vertical Padding"},prio:{from:void 0,to:15}},{id:"pre_header_bg_color",prio:{from:void 0,to:200}},{id:"pre_header_font_color",prio:{from:void 0,to:205}},{id:"pre_header_accent_colors",prio:{from:void 0,to:210}},{id:"pre_header_font_size",prio:{from:void 0,to:220}}]},{from:"wpbf_menu_options",to:"wpbf_header_builder_row_2_section",controlsToMove:[{id:"menu_width",label:{from:void 0,to:"Container Width"},prio:{from:void 0,to:10}},{id:"menu_height",label:{from:void 0,to:"Vertical Padding"},prio:{from:void 0,to:15}}]},{from:"wpbf_menu_options",to:"wpbf_header_builder_row_2_section",controlsToMove:[{id:"menu_bg_color",prio:{from:void 0,to:200}},{id:"menu_font_colors",prio:{from:void 0,to:205}},{id:"menu_font_size",prio:{from:void 0,to:210}}]}]})},25)})}();
//# sourceMappingURL=customizer-min.js.map
