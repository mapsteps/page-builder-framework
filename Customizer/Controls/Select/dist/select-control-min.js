var t;window.wp.customize&&((t=window.wp.customize).controlConstructor["wpbf-enhanced-select"]=t.Control.extend({initialize:function(e,i){let o=this;t.Control.prototype.initialize.call(o,e,i),t.control.bind("removed",function e(i){o===i&&(o?.destroy?.(),o.container?.remove(),t.control.unbind("removed",e))})},setNotificationContainer:function(t){this.notifications&&(this.notifications.container=jQuery(t),this.notifications.render())},renderContent:function(){if(!this.params)return;let t=this.params,e=`
				<label class="customize-control-title" for="wpbf-control-input-${this.id}">
					<span className="customize-control-title">${t.label}</span>
				</label>
				`,i=`
				<div class="customize-control-description description">
					${t.description}
				</div>
				`,o=`
				<header clas="wpbf-control-header">
					${t.label?e:""}
					${t.description?i:""}
					<div class="customize-control-notifications-container"></div>
				</header>
				`,n=`
				<div class="wpbf-control-form">
					<select class="wpbf-select2"${t.multiple?" multiple":""}></select>
				</div>
				`,l=o+n;"horizontal"===t.layoutStyle&&(l=`
					<div class="wpbf-control-cols">
						<div class="wpbf-control-left-col wpbf-w50">
							${o}
						</div>
						<div class="wpbf-control-right-col wpbf-flex wpbf-content-end wpbf-w50">
							${n}
						</div>
					</div>
					`),this.container?.html(l);let c=document.querySelector(`#customize-control-${this.id} .customize-control-notifications-container`);c&&c instanceof HTMLElement&&this.setNotificationContainer?.(c);let s=this.container?.find(".wpbf-select2");s?.on("change.select2",e=>{let i=s?.select2("data"),o=i?.map(t=>t.id),n=null;n=o?.length?t.multiple?o:o[0]:t.multiple?[]:"",this.setting?.set(n)});let r=t.choicesGlobalVar,a=r&&r in window?window[r]:void 0;if(a){let t=this.setting?.get(),e=Array.isArray(t)?t:[t];a.forEach((t,i)=>{t.id&&e.includes(t.id)&&(a[i].selected=!0),t.children&&t.children.length&&t.children.forEach((t,o)=>{t.id&&e.includes(t.id)&&a[i].children&&(a[i].children[o].selected=!0)})})}s?.select2({placeholder:t.placeholder,allowClear:t.clearable,multiple:t.multiple,maximumSelectionLength:t.multiple?t.maxSelections:void 0,data:a??t.choices})},ready:function(){this.setting?.bind(t=>{if(this.updateComponentState){let e=t;void 0===e&&(e=this.params?.multiple?[]:""),this.updateComponentState(e)}})},updateComponentState:function(t){let e=this.container?.find(".wpbf-select2");e?.val(t)},destroy:function(){let e=this.container?.find(".wpbf-select2");e?.off("change.select2"),e?.select2("destroy"),this.container?.html(""),t.Control.prototype.destroy&&t.Control.prototype.destroy.call(this)}}));
//# sourceMappingURL=select-control-min.js.map
