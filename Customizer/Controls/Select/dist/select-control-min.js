window.wp.customize&&g(window.wp.customize);function g(l){l.controlConstructor["wpbf-select"]=l.Control.extend({$selectbox:void 0,initialize:function(t,e){l.Control.prototype.initialize.call(this,t,e);const o=this;function n(f){var r;o===f&&(o.destroy&&o.destroy(),(r=o.container)==null||r.remove(),l.control.unbind("removed",n))}l.control.bind("removed",n)},setNotificationContainer:function(t){this.notifications&&(this.notifications.container=jQuery(t),this.notifications.render())},renderContent:function(){var m,v,w,$,y,C;if(!this.params)return;const t=this.params,e=`
				<label class="customize-control-title" for="wpbf-control-input-${this.id}">
					<span className="customize-control-title">${t.label}</span>
				</label>
				`,o=`
				<div class="customize-control-description description">
					${t.description}
				</div>
				`,n=`
				<header clas="wpbf-control-header">
					${t.label?e:""}
					${t.description?o:""}
					<div class="customize-control-notifications-container"></div>
				</header>
				`,f=`
				<div class="wpbf-control-form">
					<select class="wpbf-select2"${t.isMulti?" multiple":""}></select>
				</div>
				`;let r=n+f;t.layoutStyle==="horizontal"&&(r=`
					<div class="wpbf-control-cols">
						<div class="wpbf-control-left-col wpbf-w50">
							${n}
						</div>
						<div class="wpbf-control-right-col wpbf-flex wpbf-content-end wpbf-w50">
							${f}
						</div>
					</div>
					`),(m=this.container)==null||m.html(r);const u=document.querySelector(`#customize-control-${this.id} .customize-control-notifications-container`);u&&u instanceof HTMLElement&&((v=this.setNotificationContainer)==null||v.call(this,u)),this.$selectbox=(w=this.container)==null?void 0:w.find(".wpbf-control-form .wpbf-select2"),($=this.$selectbox)==null||$.on("change.select2",h=>{var d,p;const a=(d=this.$selectbox)==null?void 0:d.select2("data"),i=a==null?void 0:a.map(x=>x.id);let s=null;i!=null&&i.length?s=t.isMulti?i:i[0]:s=t.isMulti?[]:"",(p=this.setting)==null||p.set(s)});const b=t.choicesGlobalVar,c=b?window[b]:void 0;if(c){const h=(y=this.setting)==null?void 0:y.get(),a=Array.isArray(h)?h:[h];c.forEach((i,s)=>{i.id&&a.includes(i.id)&&(c[s].selected=!0),i.children&&i.children.length&&i.children.forEach((d,p)=>{d.id&&a.includes(d.id)&&c[s].children&&(c[s].children[p].selected=!0)})})}(C=this.$selectbox)==null||C.select2({placeholder:t.placeholder,allowClear:t.isClearable,multiple:t.isMulti,maximumSelectionLength:t.isMulti?t.maxSelections:void 0,data:c??t.choices})},ready:function(){var t;(t=this.setting)==null||t.bind(e=>{var o;if(this.updateComponentState){let n=e;n===void 0&&(n=(o=this.params)!=null&&o.isMulti?[]:""),this.updateComponentState(n)}})},updateComponentState:function(t){var e;(e=this.$selectbox)==null||e.val(t)},destroy:function(){var e;this.$selectbox&&(this.$selectbox.off("change.select2"),this.$selectbox.select2("destroy"),this.$selectbox=void 0),(e=this.container)==null||e.html(""),l.Control.prototype.destroy&&l.Control.prototype.destroy.call(this)}})}
//# sourceMappingURL=select-control-min.js.map
