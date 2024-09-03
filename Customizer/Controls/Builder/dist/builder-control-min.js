window.wp.customize&&(window.wp.customize.controlConstructor["wpbf-builder"]=window.wp.customize.wpbfDynamicControl.extend({isSaving:!1,form:void 0,draggableData:void 0,emptyWidgetItemMarkup:"<div class='widget-item empty-widget-item'>&nbsp;</div>",availableWidgetsPanel:void 0,builderPanel:void 0,initWpbfControl:function(e){(e=e||this)&&(e.setting?.bind(t=>{e.updateComponentState?.(t)}),e.buildAvailableWidgetsPanel?.(),e.buildBuilderPanel?.(),e.initDraggable?.(),e.initDroppable?.(),window.setTimeout(()=>{e.initSortable?.()},1))},isSortableEmpty:function(e){let t=e.querySelectorAll(".widget-item");if(!t.length)return!0;for(let e=0;e<t.length;e++){let i=t[e];if(!(!(i instanceof HTMLElement)||i.classList.contains("empty-widget-item")||i.classList.contains("ui-sortable-placeholder"))&&!i.classList.contains("ui-sortable-helper"))return!1}return!0},isWidgetActive:function(e){if(!this.params)return!1;let t=this.params.value;if(!t)return!1;for(let i in t){if(!t.hasOwnProperty(i))continue;let a=t[i];if(a&&Object.keys(a).length)for(let t in a){if(!a.hasOwnProperty(t))continue;let i=a[t];if(i&&i.length&&i.includes(e))return!0}}return!1},findWidgetByKey:function(e){if(!this.params)return;let t=this.params.builder.availableWidgets;if(t.length){for(let i of t)if(i.key===e)return i}},buildAvailableWidgetsPanel:function(){let e=this;if(!e.container)return;let t=e.params;if(!t)return;let i=e.container[0].querySelector(".available-widgets-panel");if(!(i instanceof HTMLElement))return;e.availableWidgetsPanel=i,jQuery(document.body).append('<div class="widget-drag-helper"></div>');let a=t.builder.availableWidgets,n=jQuery("<div></div>").addClass("builder-widgets available-widgets").appendTo(e.availableWidgetsPanel);a.forEach(t=>{let i=t.key;jQuery("<div></div>").addClass(`widget-item widget-item-${i} ${e.isWidgetActive?.(i)?"disabled":""}`).attr("data-widget-key",i).attr("draggable","true").html(`<span class="widget-label">${t.label}</span>`).on("click",function(i){e.handleWidgetClick?.(this,t)}).appendTo(n)})},buildBuilderPanel:function(){let e=this,t=e.params;if(!t)return;let i=t.builder.availableRows,a=t.builder.availableWidgets;if(!i||!a)return;let n=document.querySelector("#customize-preview");if(!(n instanceof HTMLElement))return;let l=jQuery("<div></div>").addClass(`wpbf-builder-panel ${t.id}-builder-panel`).attr("data-wpbf-builder-panel",t.id).insertAfter(n);i.forEach(i=>{let a=jQuery("<div></div>").addClass("builder-row").attr("data-row-key",i.key).appendTo(l),n=jQuery("<div></div>").addClass("builder-inner-row").appendTo(a);jQuery("<button></button>").addClass("row-setting-button").attr("data-row-key",i.key).html('<i class="dashicons dashicons-admin-generic"></i>').appendTo(a);let r=t.value[i.key];i.columns.forEach((t,a)=>{let l=0===a?"column-start":a===i.columns.length-1?"column-end":"column-middle",s=jQuery("<div></div>").addClass(`builder-widgets builder-column sortable-widgets ${l}`).attr("data-column-key",t.key).appendTo(n),d="empty-widget-list";if(!r||!Object.keys(r).length){s.addClass(d),s.html(e.emptyWidgetItemMarkup??"");return}let o=r[t.key];if(!o||!o.length){s.addClass(d),s.html(e.emptyWidgetItemMarkup??"");return}o.forEach(t=>{let i=e.createWidgetItem?.(t,!0);i&&s.append(i)})})}),e.builderPanel=l[0]},handleWidgetClick:function(e,t){if(!e.classList.contains("ui-sortable-handle")&&!e.classList.contains("disabled")||!t.section)return;let i=window.wp.customize?.section(t.section);i&&i.params&&i.expand(i.params)},initDraggable:function(){let e=this;if(!e.params||!e.availableWidgetsPanel||!e.builderPanel)return;let t=document.querySelector(".widget-drag-helper");if(!(t instanceof HTMLElement))return;let i=e.availableWidgetsPanel?.querySelectorAll(".widget-item");i&&i.length&&i.forEach(i=>{i instanceof HTMLElement&&(i.addEventListener("dragstart",function(a){if(!(a instanceof DragEvent))return;document.body.classList.add("is-dragging-widget"),i.classList.add("is-dragging"),t.classList.add("is-shown");let n=i.dataset.widgetKey;if(!n)return;e.draggableData={widgetKey:n},a.dataTransfer?.setData("text",JSON.stringify({widgetKey:n})),t.innerHTML=i.outerHTML;let l=i.getBoundingClientRect(),r=l.left,s=l.top;t.style.left=r+"px",t.style.top=s+"px";let d=t.querySelector(".widget-item"),o=d?.getBoundingClientRect(),u=o?.width||80;t.style.width=u+"px",a.dataTransfer?.setDragImage(t,0,0),window.setTimeout(()=>{t.classList.remove("is-shown")},10)}),i.addEventListener("dragend",function(a){a instanceof DragEvent&&(a.preventDefault(),i.classList.remove("is-dragging"),document.body.classList.remove("is-dragging-widget"),t.classList.remove("is-shown"),t.innerHTML="",t.removeAttribute("style"),e.draggableData=void 0)}))})},initDroppable:function(){let e=this;if(!e.params||!e.availableWidgetsPanel||!e.builderPanel)return;let t=e.builderPanel?.querySelectorAll(".builder-column");t&&t.length&&t.forEach(t=>{t instanceof HTMLElement&&(t.addEventListener("dragenter",function(e){e instanceof DragEvent&&(e.preventDefault(),t.classList.add("dragover"))}),t.addEventListener("dragover",function(e){e.preventDefault()}),t.addEventListener("dragleave",function(e){e instanceof DragEvent&&(e.preventDefault(),t.classList.remove("dragover"))}),t.addEventListener("drop",function(i){if(!(i instanceof DragEvent))return;i.preventDefault(),t.classList.remove("dragover");let a=e.getWidgetItemFromDraggableData?.(i);if(!a)return;let n=a.dataset.widgetKey;if(!n)return;let l=e.createWidgetItem?.(n,!0);if(!l)return;let r=t.querySelector(".ui-sortable-placeholder.from-available-widgets");r&&t.removeChild(r),t.classList.contains("column-end")?t.insertBefore(l,t.firstChild):t.appendChild(l);let s=t.querySelector(".empty-widget-item");s&&s.remove(),jQuery(t).sortable("refresh"),a.classList.add("disabled"),e.draggableData=void 0,e.updateCustomizerSetting?.()}))})},parseDraggableData:function(e){let t;let i=e.dataTransfer?.getData("text");if(i){try{t=JSON.parse(i)}catch(e){console.error("Error parsing JSON data:",e)}if(t)return t}},getWidgetItemFromDraggableData:function(e){if(!e.dataTransfer?.getData("text"))return;let t=this.parseDraggableData?.(e);if(!t)return;let i=t.widgetKey;if(!i)return;let a=this.availableWidgetsPanel?.querySelector(`.widget-item[data-widget-key="${i}"]`);if(a&&a instanceof HTMLElement)return a},createWidgetItem:function(e,t){let i=this,a=i.findWidgetByKey?.(e);if(!a)return;let n=i.availableWidgetsPanel?.querySelector(`.widget-item[data-widget-key="${e}"]`);if(!(n instanceof HTMLElement))return;let l=n.cloneNode(!0);if(l instanceof HTMLElement){if(l.classList.remove("disabled"),l.classList.remove("is-dragging"),l.removeAttribute("draggable"),t){let e=document.createElement("button");e.type="button",e.className="widget-button delete-widget-button",e.innerHTML='<i class="dashicons dashicons-no-alt"></i>',l.appendChild(e),e.addEventListener("click",function(e){e.preventDefault(),l.remove(),n.classList.remove("disabled")}),l.addEventListener("click",function(e){e.preventDefault(),i.handleWidgetClick?.(this,a)})}return l}},initSortable:function(){let e=this;e.params&&e.availableWidgetsPanel&&e.builderPanel&&(jQuery(".sortable-widgets").sortable({connectWith:".builder-column",placeholder:"widget-item",start:function(e,t){document.body.classList.add("is-sorting-widget");let i=t.item[0].querySelector(".widget-label");i instanceof HTMLElement&&t.placeholder[0].appendChild(i.cloneNode(!0))},update:function(t,i){let a=t.target;a instanceof HTMLElement&&(e.handleSortableSortout?.(a),e.updateCustomizerSetting?.())},stop:function(e,t){document.body.classList.remove("is-sorting-widget")}}),jQuery(".builder-column.column-middle").on("sortover",function(e,t){e.target.classList.remove("empty-widget-list")}),jQuery(".builder-column.column-middle").on("sortout",function(t,i){e.handleSortableSortout?.(t.target)}))},handleSortableSortout:function(e){let t="empty-widget-list";if(!this.availableWidgetsPanel||!this.builderPanel)return;let i=e.querySelector(".empty-widget-item");this.isSortableEmpty?.(e)?(e.classList.add(t),i||jQuery(e).append(this.emptyWidgetItemMarkup??"")):(e.classList.remove(t),i&&i.remove())},destroySortable:function(){this.availableWidgetsPanel&&this.builderPanel&&jQuery(".builder-column").sortable("destroy")},updateCustomizerSetting:function(){let e=this;e.isSaving||(e.isSaving=!0,setTimeout(()=>{let t=e.builderPanel?.querySelectorAll(".builder-row");if(!t||!t.length){e.isSaving=!1;return}let i={};t.forEach(e=>{if(!(e instanceof HTMLElement))return;let t=e.dataset.rowKey;if(!t)return;i[t]={};let a=e.querySelectorAll(".builder-column.sortable-widgets");a.length&&a.forEach(e=>{if(!(e instanceof HTMLElement))return;let a=e.dataset.columnKey;if(!a)return;i[t][a]=[];let n=e.querySelectorAll(".widget-item");n.length&&n.forEach(e=>{if(!(e instanceof HTMLElement)||e.classList.contains("empty-widget-item")||e.classList.contains("ui-sortable-placeholder"))return;let n=e.dataset.widgetKey;n&&i[t][a].push(n)})})}),e.setting?.set(i),e.isSaving=!1},1))},updateComponentState:function(e){}}));
//# sourceMappingURL=builder-control-min.js.map
