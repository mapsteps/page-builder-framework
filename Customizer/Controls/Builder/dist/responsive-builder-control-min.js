!function(){let e=["desktop","mobile"];window.wp.customize&&(window.wp.customize.controlConstructor["wpbf-responsive-builder"]=window.wp.customize.wpbfDynamicControl.extend({isSaving:!1,draggableData:void 0,emptyWidgetItemMarkup:"<div class='widget-item empty-widget-item'>&nbsp;</div>",availableWidgetsPanels:{desktop:void 0,mobile:void 0},builderPanel:void 0,initWpbfControl:function(e){let t=e??this;t&&(t.setting?.bind(e=>{t.updateComponentState?.(e)}),t.buildAvailableWidgetsPanel?.(),t.buildBuilderPanel?.(),t.initDraggable?.(),t.initDroppable?.(),window.setTimeout(()=>{t.initSortable?.()},1))},isSortableEmpty:function(e){let t=this.findHtmlEls?.(e,".widget-item");if(!t||!t.length)return!0;for(let e=0;e<t.length;e++){let i=t[e];if(!(i.classList.contains("empty-widget-item")||i.classList.contains("ui-sortable-placeholder"))&&!i.classList.contains("ui-sortable-helper"))return!1}return!0},isWidgetActive:function(e,t){if(!this.params||!t||"desktop"!==t&&"mobile"!==t)return!1;let i=this.params.builder[t].activeWidgetKeys;return!!i.length&&i.includes(e)},findWidgetByKey:function(e,t){if(!this.params||!t||"desktop"!==t&&"mobile"!==t)return;let i=this.params.builder[t].availableWidgets;if(i.length){for(let t of i)if(t.key===e)return t}},buildAvailableWidgetsPanel:function(){if(!this.container)return;let e=this.params;if(!e)return;let t=this.findHtmlEl?.(this.container[0],".wpbf-control-form");if(!t)return;let i=this;for(let a in e.builder){if(!e.builder.hasOwnProperty(a)||"desktop"!==a&&"mobile"!==a||!e.builder[a].availableWidgets.length)continue;let n=jQuery("<div></div>").addClass("available-widgets-panel").attr("data-device",a).appendTo(t);if(!this.availableWidgetsPanels)continue;this.availableWidgetsPanels[a]=n[0];let l=jQuery("<div></div>").addClass("builder-widgets available-widgets").appendTo(this.availableWidgetsPanels[a]);e.builder[a].availableWidgets.forEach(e=>{let t=e.key;jQuery("<div></div>").addClass(`widget-item widget-item-${t} ${i.isWidgetActive?.(t)?"disabled":""}`).attr("data-widget-key",t).attr("draggable","true").html(`<span class="widget-label">${e.label}</span>`).on("click",function(t){i.handleWidgetClick?.(this,e)}).appendTo(l)})}jQuery(document.body).append('<div class="widget-drag-helper"></div>')},buildBuilderPanel:function(){let e=this,t=e.params;if(!t)return;let i=e.findHtmlEl?.("#customize-preview");if(!i)return;let a=jQuery("<div></div>").addClass(`wpbf-builder-panel ${t.id}-builder-panel`).attr("data-wpbf-builder-panel",t.id).insertAfter(i),n="empty-widget-list";for(let i in t.builder){let l;if(!t.builder.hasOwnProperty(i)||"desktop"!==i&&"mobile"!==i||!t.builder[i].availableWidgets.length)continue;let s=jQuery("<div></div>").addClass("wpbf-builder-slots").attr("data-device",i).appendTo(a);if(!t.builder[i].availableWidgets.length)return;if("mobile"===i&&t.builder[i].availableSlots.sidebar){s.addClass("wpbf-flex wpbf-content-center");let a=jQuery("<div></div>").addClass("builder-sidebar").appendTo(s),n=jQuery("<div></div>").addClass("builder-inner-sidebar").appendTo(a);jQuery("<button></button>").attr("type","button").addClass("row-setting-button").html(`<i class="dashicons dashicons-admin-generic"></i><span class="button-label">${t.builder[i].availableSlots.sidebar.label}</span>`).on("click",()=>e.handleRowSettingClick?.(t.builder[i].availableSlots.sidebar.key)).appendTo(n);let d=jQuery("<div></div>").addClass("builder-widgets active-widgets").appendTo(n);t.value&&t.value[i].sidebar.forEach(t=>{let a=e.createWidgetItem?.(t,!0,i);a&&d.append(a)}),l=jQuery("<div></div>").addClass("builder-rows").appendTo(s)}let d=t.builder[i].availableSlots;if(!d.rows.length)continue;let r="mobile"===i&&l?l:s;d.rows.forEach(a=>{let l=jQuery("<div></div>").addClass("builder-row").attr("data-row-key",a.key).appendTo(r),s=jQuery("<div></div>").addClass("builder-inner-row").appendTo(l);jQuery("<div></div>").addClass("row-label").attr("data-row-key",a.key).text(a.label).appendTo(l),jQuery("<button></button>").addClass("row-setting-button").attr("type","button").attr("data-row-key",a.key).html('<i class="dashicons dashicons-admin-generic"></i>').on("click",()=>e.handleRowSettingClick?.(a.key)).appendTo(l);let d=t.value?t.value[i].rows[a.key]:void 0;a.columns.forEach((t,l)=>{let r="";t.key.endsWith("_start")?r="wpbf-content-start":t.key.endsWith("_end")?r="wpbf-content-end":0!==l&&l!==a.columns.length-1&&(r="wpbf-content-center column-middle"),0===l?r+=" column-start wpbf-content-start":l===a.columns.length-1&&(r+=" column-end wpbf-content-end");let o=jQuery("<div></div>").addClass(`builder-column builder-widgets active-widgets wpbf-flex ${r}`).attr("data-column-key",t.key).appendTo(s);if(!d||!Object.keys(d).length){o.addClass(n),o.html(e.emptyWidgetItemMarkup??"");return}let u=d[t.key];if(!u||!u.length){o.addClass(n),o.html(e.emptyWidgetItemMarkup??"");return}u.forEach(t=>{let a=e.createWidgetItem?.(t,!0,i);a&&o.append(a)})}),e.bindCustomizeSection?.(a.key)})}e.builderPanel=a[0]},handleRowSettingClick:function(e){window.wp.customize?.section(`wpbf_header_builder_${e}_section`,function(e){e.expand(e.params)})},bindCustomizeSection:function(e){window.wp.customize?.section(`wpbf_header_builder_${e}_section`,function(t){t.expanded.bind(function(t){let i=document.querySelector(`.builder-row[data-row-key="${e}"]`);i&&(t?i.classList.add("is-active"):i.classList.remove("is-active"))})})},handleWidgetClick:function(e,t){if(!e.classList.contains("ui-sortable-handle")&&!e.classList.contains("disabled")||!t.section)return;let i=window.wp.customize?.section(t.section);i&&i.params&&i.expand(i.params)},initDraggable:function(){if(!this.params||!this.container||!this.builderPanel)return;let e=this.findHtmlEl?.(".widget-drag-helper");if(!e)return;let t=this.findHtmlEls?.(this.container[0],".widget-item");if(!t||!t.length)return;let i=this;t.forEach(t=>{t instanceof HTMLElement&&(t.addEventListener("dragstart",a=>{if(!(a instanceof DragEvent))return;document.body.classList.add("is-dragging-widget"),t.classList.add("is-dragging"),e.classList.add("is-shown");let n=t.dataset.widgetKey;if(!n)return;i.draggableData={widgetKey:n},a.dataTransfer?.setData("text",JSON.stringify({widgetKey:n})),e.innerHTML=t.outerHTML;let l=t.getBoundingClientRect(),s=l.left,d=l.top;e.style.left=s+"px",e.style.top=d+"px";let r=i.findHtmlEl?.(e,".widget-item"),o=r?.getBoundingClientRect(),u=o?.width||80;e.style.width=u+"px",a.dataTransfer?.setDragImage(e,0,0),window.setTimeout(()=>{e.classList.remove("is-shown")},10)}),t.addEventListener("dragend",a=>{a instanceof DragEvent&&(a.preventDefault(),t.classList.remove("is-dragging"),document.body.classList.remove("is-dragging-widget"),e.classList.remove("is-shown"),e.innerHTML="",e.removeAttribute("style"),i.draggableData=void 0)}))})},initDroppable:function(){if(!this.builderPanel)return;let e=this.findHtmlEls?.(this.builderPanel,".active-widgets");if(!e||!e.length)return;let t=this;e.forEach(e=>{e.addEventListener("dragenter",t=>{t instanceof DragEvent&&(t.preventDefault(),e.classList.add("dragover"))}),e.addEventListener("dragover",e=>{e.preventDefault()}),e.addEventListener("dragleave",t=>{t instanceof DragEvent&&(t.preventDefault(),e.classList.remove("dragover"))}),e.addEventListener("drop",i=>{if(!(i instanceof DragEvent))return;i.preventDefault(),e.classList.remove("dragover");let a=t.getWidgetItemFromDraggableData?.(i);if(!a)return;let n=a.dataset.widgetKey;if(!n)return;let l=e.closest(".wpbf-builder-slots");if(!(l instanceof HTMLElement))return;let s=l.dataset.device;if(!s||"desktop"!==s&&"mobile"!==s)return;let d=t.createWidgetItem?.(n,!0,s);if(!d)return;let r=e.querySelector(".ui-sortable-placeholder.from-available-widgets");r&&e.removeChild(r),e.classList.contains("column-end")?e.insertBefore(d,e.firstChild):e.appendChild(d);let o=e.querySelector(".empty-widget-item");o&&o.remove(),jQuery(e).sortable("refresh"),a.classList.add("disabled"),t.draggableData=void 0,t.updateCustomizerSetting?.()})})},parseDraggableData:function(e){let t;let i=e.dataTransfer?.getData("text");if(i){try{t=JSON.parse(i)}catch(e){console.error("Error parsing JSON data:",e)}if(t)return t}},getWidgetItemFromDraggableData:function(e){if(!e.dataTransfer?.getData("text")||!this.container)return;let t=this.parseDraggableData?.(e);if(!t)return;let i=t.widgetKey;if(i)return this.findHtmlEl?.(this.container[0],`.widget-item[data-widget-key="${i}"]`)},createWidgetItem:function(e,t,i){if(!this.container)return;let a=this.findWidgetByKey?.(e,i);if(!a)return;let n=this,l=this.findHtmlEl?.(this.container[0],`.widget-item[data-widget-key="${e}"]`);if(!l)return;let s=l.cloneNode(!0);if(s instanceof HTMLElement){if(s.classList.remove("disabled"),s.classList.remove("is-dragging"),s.removeAttribute("draggable"),t){let e=document.createElement("button");e.type="button",e.className="widget-button delete-widget-button",e.innerHTML='<i class="dashicons dashicons-no-alt"></i>',s.appendChild(e),e.addEventListener("click",e=>{e.preventDefault(),e.stopPropagation(),n.handleDeleteActiveWidget?.(s,l)}),s.addEventListener("click",function(e){e.preventDefault(),n.handleWidgetClick?.(this,a)})}return s}},initSortable:function(){let e=this;jQuery(".active-widgets").sortable({connectWith:".active-widgets",placeholder:"widget-item",start:function(t,i){document.body.classList.add("is-sorting-widget");let a=e.findHtmlEl?.(i.item[0],".widget-label");a&&i.placeholder[0].appendChild(a.cloneNode(!0))},update:function(t,i){let a=t.target;a instanceof HTMLElement&&(e.checkSortableContent?.(a),e.updateCustomizerSetting?.())},stop:function(e,t){document.body.classList.remove("is-sorting-widget")}}),jQuery(".builder-column.column-middle").on("sortover",function(e,t){e.target.classList.remove("empty-widget-list")}),jQuery(".builder-column.column-middle").on("sortout",function(t,i){e.checkSortableContent?.(t.target)})},handleDeleteActiveWidget:function(e,t){t?.classList.remove("disabled");let i=e.closest(".active-widgets");e.remove(),i instanceof HTMLElement&&this.checkSortableContent?.(i),i&&jQuery(i).sortable("refresh"),this.updateCustomizerSetting?.()},checkSortableContent:function(e){let t="empty-widget-list",i=e.querySelector(".empty-widget-item");this.isSortableEmpty?.(e)?(e.classList.add(t),i||jQuery(e).append(this.emptyWidgetItemMarkup??"")):(e.classList.remove(t),i&&i.remove())},destroySortable:function(){this.builderPanel&&jQuery(".wpbf-builder-panel .active-widgets").sortable("destroy")},updateCustomizerSetting:function(){let t=this;t.isSaving||(t.isSaving=!0,setTimeout(()=>{if(!t.availableWidgetsPanels)return;let i={desktop:{rows:{}},mobile:{sidebar:[],rows:{}}};for(let a of e){if(!t.availableWidgetsPanels.hasOwnProperty(a)||"desktop"!==a&&"mobile"!==a)continue;if("mobile"===a){let e=t.findHtmlEl?.(".builder-sidebar.active-widgets"),n=t.findHtmlEls?.(e,".widget-item");n?.forEach(e=>{if(e.classList.contains("empty-widget-item")||e.classList.contains("ui-sortable-placeholder"))return;let t=e.dataset.widgetKey;t&&i[a].sidebar.push(t)})}let e=t.findHtmlEls?.(t.availableWidgetsPanels[a],".builder-row");e&&e.length&&e.forEach(e=>{let n=e.dataset.rowKey;if(!n)return;let l=t.findHtmlEls?.(e,".active-widgets");l&&l.length&&l.forEach(e=>{let l=e.dataset.columnKey;if(!l)return;i[a].rows[n][l]=[];let s=t.findHtmlEls?.(e,".widget-item");s&&s.length&&s.forEach(e=>{if(e.classList.contains("empty-widget-item")||e.classList.contains("ui-sortable-placeholder"))return;let t=e.dataset.widgetKey;t&&i[a].rows[n][l].push(t)})})})}t.setting?.set(i),t.isSaving=!1},1))},updateComponentState:function(e){}}))}();
//# sourceMappingURL=responsive-builder-control-min.js.map
