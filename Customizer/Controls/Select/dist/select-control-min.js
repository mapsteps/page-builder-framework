!function(){let t=wp.customize.Control.extend({$selectbox:void 0,initialize:function(t,e){let o=this;wp.customize.Control.prototype.initialize.call(o,t,e),wp.customize.control.bind("removed",function t(e){o===e&&(o.destroy&&o.destroy(),o.container.remove(),wp.customize.control.unbind("removed",t))})},setNotificationContainer:function(t){this.notifications.container=jQuery(t),this.notifications.render()},renderContent:function(){let t=this,e=t.params,o=`
		<header clas="wpbf-control-header">
			${e.label?`<label
						class="customize-control-title"
						for=wpbf-control-input-${t.id}
					>
						<span className="customize-control-title">${e.label}</span>
					</label>`:""}

			${e.description?`<div
						class="customize-control-description description"
					>
						${e.description}
					</div>`:""}
		</header>

		<div class="customize-control-notifications-container"></div>

		<div class="wpbf-control-form">
			<select class="wpbf-select2"${e.isMulti?" multiple":""}></select>
		</div>
		`;t.container.html(o);let i=document.querySelector(`#customize-control-${t.id} .customize-control-notifications-container`);i&&i instanceof HTMLElement&&this.setNotificationContainer?.(i),this.$selectbox=t.container.find(".wpbf-control-form .wpbf-select2"),this.$selectbox.on("change.select2",o=>{let i=t.$selectbox?.select2("data"),n=i?.map(t=>t.id),l=null;l=n?.length?e.isMulti?n:n[0]:e.isMulti?[]:"",t.setting?.set(l)}),this.$selectbox.select2({placeholder:e.placeholder,allowClear:e.isClearable,multiple:e.isMulti,maximumSelectionLength:e.isMulti?e.maxSelections:void 0,data:e.choices})},ready:function(){let t=this;t.setting?.bind(e=>{if(t.updateComponentState){let o=e;void 0===o&&(o=t.params.isMulti?[]:""),t.updateComponentState(o)}})},updateComponentState:function(t){this.$selectbox?.val(t)},destroy:function(){this.$selectbox&&(this.$selectbox.off("change.select2"),this.$selectbox.select2("destroy"),this.$selectbox=void 0),this.container.html(""),wp.customize.Control.prototype.destroy&&wp.customize.Control.prototype.destroy.call(this)}});wp.customize.controlConstructor["wpbf-select"]=t}();
//# sourceMappingURL=select-control-min.js.map
