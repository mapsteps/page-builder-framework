window.wp.customize?.bind("ready",()=>{setTimeout(()=>{window.wp.customize&&function(e,n){let t="customize-preview",o="builder-panel";function i(n){let i=e(`.${n}-${o}`);i.addClass("before-shown"),window.setTimeout(()=>{let o=i.outerHeight();i.removeClass("before-shown"),window.setTimeout(()=>{i.css("max-height",o??"auto"),e("#"+t).css("bottom",o??"auto")},0);let l=r(n);l&&l.classList.add("builder-is-shown")},0)}function l(n){e(`.${n}-${o}`).removeAttr("style"),e("#"+t).css("bottom",0);let i=r(n);i&&i.classList.remove("builder-is-shown")}function r(e){let n=document.querySelector(`.control-panel-content.${e}-control-panel`);if(n instanceof HTMLElement)return n}e("#customize-control-menu_logo_container_width").on("mousedown",function(){e("iframe").contents().find(".wpbf-navigation .wpbf-1-4").css("border-right","3px solid #0085ba")}).on("mouseup",function(){e("iframe").contents().find(".wpbf-navigation .wpbf-1-4").css("border-right","none")}),e("#customize-control-mobile_menu_logo_container_width").on("mousedown",function(){e("iframe").contents().find(".wpbf-navigation .wpbf-2-3").css("border-right","3px solid #0085ba")}).on("mouseup",function(){e("iframe").contents().find(".wpbf-navigation .wpbf-2-3").css("border-right","none")}),function(){let e=document.querySelectorAll("#customize-theme-controls .wpbf-builder-toggle");if(!e.length)return;let t=[];for(let o of e){if(!(o instanceof HTMLElement))return;let e=o.dataset.wpbfSetting;if(!e)return;let i=o.dataset.connectedBuilder;if(!i)return;n.control(e,function(o){if(!o)return;let l=o.section();n.section(l,function(n){let o=n.params.panel;o&&(n.container?.addClass(`builder-control-section ${i}-control-section`),t.push({panelId:o,toggleControlId:e,builderControlId:i}))})})}if(t.length)for(let e of t)n.panel(e.panelId,function(t){t.container?.addClass(`${e.builderControlId}-control-panel`),t.expanded.bind(function(t){t?n.control(e.toggleControlId,function(n){n?.setting?.get()&&i(e.builderControlId)}):l(e.builderControlId)})}),n.control(e.toggleControlId,function(t){t?.setting?.bind(function(o){o?n.panel(e.panelId,function(n){n.expanded()&&(t.container[0]&&t.container[0].classList.remove("disabled"),i(e.builderControlId))}):(t.container[0]&&t.container[0].classList.add("disabled"),l(e.builderControlId))})}),n.control(e.builderControlId,function(t){if(!t)return;let o=t.params.builder.availableWidgets;if(o.length)for(let t of o){let o=t.section;o&&n.section(o,function(n){n.expanded.bind(function(n){if(!function(e){let n=r(e);return!!n&&n.classList.contains("builder-is-shown")}(e.builderControlId))return;let o=document.querySelector(`.${e.builderControlId}-builder-panel`);if(o){let e=o.querySelector(`.widget-item[data-widget-key="${t.key}"]`);e&&(n?e.classList.add("connected-section-expanded"):e.classList.remove("connected-section-expanded"))}})})}})}()}(jQuery,window.wp.customize)},25)});
//# sourceMappingURL=customizer-min.js.map
