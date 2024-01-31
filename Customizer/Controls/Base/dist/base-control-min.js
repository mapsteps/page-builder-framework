!function(){function t(t){return t&&t.__esModule?t.default:t}var e,n={};n=_;var o={};o=jQuery,wp.customize.wpbfDynamicControl=wp.customize.Control.extend({initialize:function(e,i){i.type||(i.type="wpbf-generic");let s="";if(i.content){let t=i.content.split('class="');s=(t=t[1].split('"'))[0]}else s="customize-control customize-control-"+i.type;if(i.content){let r=t(o)(i.content);r.attr("id","customize-control-"+e.replace(/]/g,"").replace(/\[/g,"-")),r.attr("class",s);let c=i.wrapper_attrs??{};t(n).each(c,function(t,e){"class"===e&&(t=t.replace("{default_class}",s)),r.attr(e,t)}),i.content=r.prop("outerHTML")}this.propertyElements=[],wp.customize.Control.prototype.initialize.call(this,e,i),wp.hooks.doAction("wpbf.dynamicControl.init.after",e,this,i)},_setUpSettingRootLinks:function(){let e=this;e.container.find("[data-customize-setting-link]").each(function(){let n=t(o)(this);wp.customize(n.data("customizeSettingLink"),function(t){let o=wp.customize.Element(n);e.elements.push(o),o.sync(t),o.set(t())})})},_setUpSettingPropertyLinks:function(){let e=this;e.setting&&e.container.find("[data-customize-setting-property-link]").each(function(){let i;let s=t(o)(this),r=s.data("customizeSettingPropertyLink");i=wp.customize.Element(s),e.propertyElements.push(i),e.setting&&"function"==typeof e.setting&&(i.set(e.setting()[r]),i.bind(function(o){if(!e.setting||"function"!=typeof e.setting)return;let i=e.setting();o!==i[r]&&((i=t(n).clone(i))[r]=o,e.setting.set(i))}),e.setting.bind(function(t){t[r]!==i.get()&&i.set(t[r])}))})},ready:function(){let t=this;t._setUpSettingRootLinks?.(),t._setUpSettingPropertyLinks?.(),wp.customize.Control.prototype.ready.call(t),t.deferred.embedded.done(function(){t.initWpbfControl?.(),wp.hooks.doAction("wpbf.dynamicControl.ready.deferred.embedded.done",t)}),wp.hooks.doAction("wpbf.dynamicControl.ready.after",t)},embed:function(){let t=this,e=t.section();e&&(wp.customize.section(e,function(e){"wpbf-expanded"===e.params.type||e.expanded()||wp.customize.settings.autofocus.control===t.id?t.actuallyEmbed?.():e.expanded.bind(function(e){e&&t.actuallyEmbed?.()})}),wp.hooks.doAction("wpbf.dynamicControl.embed.after",t))},actuallyEmbed:function(){"resolved"!==this.deferred.embedded.state()&&(this.renderContent(),this.deferred.embedded.resolve(),wp.hooks.doAction("wpbf.dynamicControl.actuallyEmbed.after",this))},focus:function(t){this.actuallyEmbed?.(),wp.customize.Control.prototype.focus.call(this,t),wp.hooks.doAction("wpbf.dynamicControl.focus.after",this)},initWpbfControl:function(e){e=e??this,wp.hooks.doAction("wpbf.dynamicControl.initWpbfControl",this),e.container.on("change keyup paste click","input",function(){e?.setting&&"function"==typeof e?.setting&&e?.setting?.set(t(o)(this).val())})}}),function(){let t={};for(let e in wpbfCustomizerControlDependencies)if(wpbfCustomizerControlDependencies.hasOwnProperty(e))for(let n of wpbfCustomizerControlDependencies[e])t[n.id]||(t[n.id]=[]),t[n.id].push({dependantControlId:e,operator:n.operator,value:n.value});wp.customize.bind("ready",function(){for(let e in t)t.hasOwnProperty(e)&&function(e){wp.customize(e,function(n){let o=t[e],i=wpbfCustomizerControlDependencies[e];n.bind(function(t){for(let n of o){let o=function(t,e,n){switch(e){case"==":return t==n;case"===":return t===n;case"!=":return t!=n;case"!==":return t!==n;case">":return t>n;case">=":return t>=n;case"<":return t<n;case"<=":return t<=n}return!1}(t,n.operator,n.value);if(o||wp.customize.control(n.dependantControlId).deactivate(),1===i.length)wp.customize.control(n.dependantControlId).activate();else{for(let t of i)if(t.id!==e&&wp.customize(t.id).get()!==t.value){o=!1;break}wp.customize.control(n.dependantControlId).activate()}}})})}(e)})}(),(e=wp.customize).Value.prototype.set=function(e){let o=this._value;return e=this._setter.apply(this,arguments),null===(e=this.validate(e))||t(n).isEqual(o,e)||(this._value=e,this._dirty=!0,this.callbacks.fireWith(this,[e,o])),this},e.Value.prototype.get=function(){return this._value}}();