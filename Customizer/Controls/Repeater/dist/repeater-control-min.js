!function(){function e(e){return e&&e.__esModule?e.default:e}var t={};t=jQuery;class i{constructor(i,r,a,s){this.setRowIndex=e=>{this.rowIndex=e,this.container.attr("data-row",e),this.container.data("row",e),this.updateLabel()},this.toggleMinimize=()=>{this.container.toggleClass("minimized"),this.header.find(".dashicons").toggleClass("dashicons-arrow-up dashicons-arrow-down")},this.remove=()=>{this.container.slideUp(300,()=>{this.container.detach()}),this.container.trigger("row:remove",[this.rowIndex])},this.updateLabel=()=>{if("field"===this.label.type){let e=this.container[0].querySelector(`.repeater-field [data-field="${this.label.field}"]`);if(e&&e instanceof HTMLInputElement&&"string"==typeof e.value){let t=e.value;if(""!==t){if(this.control.params.fields[this.label.field]&&this.control.params.fields[this.label.field].type){if("select"===this.control.params.fields[this.label.field].type&&this.control.params.fields[this.label.field].choices&&this.control.params.fields[this.label.field].choices[t])t=this.control.params.fields[this.label.field].choices[t];else if(("radio"===this.control.params.fields[this.label.field].type||"radio-image"===this.control.params.fields[this.label.field].type)&&this.rowIndex>=0){let e=this.container.find(`${this.control.selector} [data-row="${this.rowIndex}"] .repeater-field [data-field="${this.label.field}"]:checked`)[0];e&&(t=e.value)}}this.header.find(".repeater-row-label").text(t);return}}}this.header.find(".repeater-row-label").text(`${this.label.value} ${this.rowIndex+1}`)},this.rowIndex=i,this.container=r,this.label=a,this.header=this.container.find(".repeater-row-header"),this.control=s,this.header.on("click",()=>this.toggleMinimize()),this.container.on("click",".repeater-row-remove",()=>this.remove()),this.header.on("mousedown",()=>this.container.trigger("row:start-dragging")),this.container.on("keyup change","input, select, textarea",i=>this.container.trigger("row:update",[this.rowIndex,e(t)(i.target).data("field"),i.target])),this.setRowIndex(this.rowIndex)}}var r={};r=_,wp.customize.controlConstructor["wpbf-repeater"]=wp.customize.Control.extend({ready:function(){this.initWpbfControl?.()},rows:[],currentIndex:0,repeaterFieldsContainer:void 0,settingField:void 0,repeaterTemplate:void 0,initWpbfControl:function(t){let i;let a=t||this,s=a.params.value;a.settingField=a.container.find("[data-customize-setting-link]").first(),a.setValue?.([],!1),a.repeaterFieldsContainer=a.container.find(".repeater-fields").first(),a.currentIndex=0,a.rows=[];let n=!1;if("number"==typeof a.params.limit&&(n=!(0>=a.params.limit)&&a.params.limit),a.container?.on("click","button.repeater-add",e=>{e.preventDefault(),!n||"number"==typeof a.currentIndex&&a.currentIndex<n?(i=a.addRow?.(),i?.toggleMinimize(),a.initColorPicker?.(),i&&a.initSelect?.(i)):jQuery(a.selector+" .limit").addClass("highlight")}),a.container?.on("click",".repeater-row-remove",function(){"number"==typeof a.currentIndex&&a.currentIndex--,(!n||"number"==typeof a.currentIndex&&a.currentIndex<n)&&jQuery(a.selector+" .limit").removeClass("highlight")}),a.container?.on("click keypress",".repeater-field-image .upload-button,.repeater-field-cropped_image .upload-button,.repeater-field-upload .upload-button",function(e){e.preventDefault(),a.$thisButton=jQuery(this),a.openFrame?.(e)}),a.container?.on("click keypress",".repeater-field-image .remove-button,.repeater-field-cropped_image .remove-button",function(e){e.preventDefault(),a.$thisButton=jQuery(this),a.removeImage?.(e)}),a.container?.on("click keypress",".repeater-field-upload .remove-button",function(e){e.preventDefault(),a.$thisButton=jQuery(this),a.removeFile?.(e)}),a.repeaterTemplate=e(r).memoize(function(){let t={evaluate:/<#([\s\S]+?)#>/g,interpolate:/\{\{\{([\s\S]+?)\}\}\}/g,escape:/\{\{([^\}]+?)\}\}(?!\})/g,variable:"data"};return function(i){return e(r).template(a.container.find(".customize-control-repeater-content").first().html(),t)(i)}}),s.length){let e=0;for(e=0;e<s.length;e++)i=a.addRow?.(s[e]),a.initColorPicker?.(),i&&a.initSelect?.(i,s[e])}a.repeaterFieldsContainer?.sortable({handle:".repeater-row-header",update:function(){a.sort?.()}})},openFrame:function(e){wp.customize.utils.isKeydownButNotEnterEvent(e)||(this.$thisButton?.closest(".repeater-field").hasClass("repeater-field-cropped_image")?this.initCropperFrame?.():this.initFrame?.(),this.frame.open())},initFrame:function(){let e=this.getMimeType();this.frame=wp.media({states:[new wp.media.controller.Library({library:wp.media.query({type:e}),multiple:!1,date:!1})]}),this.frame.on("select",this.onSelect,this)},initCropperFrame:function(){let t=this.$thisButton?.siblings("input.hidden-field").attr("data-field"),i=this.getMimeType();if(e(r).isString(t)&&""!==t&&e(r).isObject(this.params.fields[t])&&"cropped_image"===this.params.fields[t].type)for(let e of["width","height","flex_width","flex_height"])void 0!==this.params.fields[t][e]&&(this.params[e]=this.params.fields[t][e]);this.frame=wp.media({button:{text:"Select and Crop",close:!1},states:[new wp.media.controller.Library({library:wp.media.query({type:i}),multiple:!1,date:!1,suggestedWidth:this.params.width,suggestedHeight:this.params.height}),new wp.media.controller.CustomizeImageCropper({imgSelectOptions:this.calculateImageSelectOptions,control:this})]}),this.frame.on("select",this.onSelectForCrop,this),this.frame.on("cropped",this.onCropped,this),this.frame.on("skippedcrop",this.onSkippedCrop,this)},onSelect:function(){let e=this.frame.state().get("selection").first().toJSON();this.$thisButton?.closest(".repeater-field").hasClass("repeater-field-upload")?this.setFileInRepeaterField?.(e):this.setImageInRepeaterField?.(e)},onSelectForCrop:function(){let e=this.frame.state().get("selection").first().toJSON();this.params.width!==e.width||this.params.height!==e.height||this.params.flex_width||this.params.flex_height?this.frame.setState("cropper"):this.setImageInRepeaterField?.(e)},onCropped:function(e){this.setImageInRepeaterField?.(e)},calculateImageSelectOptions:function(e,t){let i,r;let a=t.get("control"),s=!!parseInt(a.params.flex_width,10),n=!!parseInt(a.params.flex_height,10),o=e.get("width"),l=e.get("height"),d=parseInt(a.params.width,10),h=parseInt(a.params.height,10),p=d/h;t.set("canSkipCrop",!a.mustBeCropped(s,n,d,h,o,l)),o/l>p?d=(h=l)*p:h=(d=o)/p,i=(o-d)/2,r=(l-h)/2;let c={handles:!0,keys:!0,instance:!0,persistent:!0,imageWidth:o,imageHeight:l,aspectRatio:"",maxHeight:!1,maxWidth:!1,x1:i,y1:r,x2:d+i,y2:h+r};return!1===n&&!1===s&&(c.aspectRatio=d+":"+h),!1===n&&(c.maxHeight=h),!1===s&&(c.maxWidth=d),c},mustBeCropped:function(e,t,i,r,a,s){return!(!0===e&&!0===t||!0===e&&r===s||!0===t&&i===a||i===a&&r===s||a<=i)},onSkippedCrop:function(){let e=this.frame.state().get("selection").first().toJSON();this.setImageInRepeaterField?.(e)},setImageInRepeaterField:function(e){let t=this.$thisButton?.closest(".repeater-field-image,.repeater-field-cropped_image");t?.find(".wpbf-image-attachment").html('<img src="'+e.url+'">').hide().slideDown("slow"),t?.find(".hidden-field").val(e.id),this.$thisButton?.text(this.$thisButton.data("alt-label")),t?.find(".remove-button").show(),t?.find("input, textarea, select").trigger("change"),this.frame.close()},setFileInRepeaterField:function(e){let t=this.$thisButton?.closest(".repeater-field-upload");t?.find(".wpbf-file-attachment").html('<span class="file"><span class="dashicons dashicons-media-default"></span> '+e.filename+"</span>").hide().slideDown("slow"),t?.find(".hidden-field").val(e.id),this.$thisButton?.text(this.$thisButton.data("alt-label")),t?.find(".upload-button").show(),t?.find(".remove-button").show(),t?.find("input, textarea, select").trigger("change"),this.frame.close()},getMimeType:function(){let t=this.$thisButton?.siblings("input.hidden-field").attr("data-field");return e(r).isString(t)&&""!==t&&e(r).isObject(this.params.fields[t])&&"upload"===this.params.fields[t].type&&void 0!==this.params.fields[t].mime_type?this.params.fields[t].mime_type:"image"},removeImage:function(e){if(wp.customize.utils.isKeydownButNotEnterEvent(e))return;let t=this.$thisButton?.closest(".repeater-field-image,.repeater-field-cropped_image,.repeater-field-upload"),i=t?.find(".upload-button");t?.find(".wpbf-image-attachment").slideUp("fast",function(){jQuery(this).show().html(jQuery(this).data("placeholder"))}),t?.find(".hidden-field").val(""),i?.text(i.data("label")),this.$thisButton?.hide(),t?.find("input, textarea, select").trigger("change")},removeFile:function(e){if(wp.customize.utils.isKeydownButNotEnterEvent(e))return;let t=this.$thisButton?.closest(".repeater-field-upload"),i=t?.find(".upload-button");t?.find(".wpbf-file-attachment").slideUp("fast",function(){jQuery(this).show().html(jQuery(this).data("placeholder"))}),t?.find(".hidden-field").val(""),i?.text(i.data("label")),this.$thisButton?.hide(),t?.find("input, textarea, select").trigger("change")},getValue:function(){let e=this.setting?.get();return JSON.parse(decodeURI(void 0===e||"string"!=typeof e?"":e))},setValue:function(e,t,i){let r=[];if(i){for(let e in this.params.fields)this.params.fields.hasOwnProperty(e)&&this.params.fields[e].type&&["image","cropped_image","upload"].includes(this.params.fields[e].type)&&r.push(e);jQuery.each(e,function(t,i){jQuery.each(r,function(r,a){void 0!==i[a]&&void 0!==i[a].id&&(e[t][a]=i[a].id)})})}this.setting?.set(encodeURI(JSON.stringify(e))),t&&this.settingField?.trigger("change")},addRow:function(e){let t=this,r=this.getValue?.(),a={},s=t.repeaterTemplate?.();if(s){let n,o=jQuery.extend(!0,{},t.params.fields);if(e){let t;for(t in e)e.hasOwnProperty(t)&&o.hasOwnProperty(t)&&(o[t].default=e[t])}s=s(o);let l=new i(t.currentIndex??0,jQuery(s).appendTo(t.repeaterFieldsContainer),t.params.rowLabel,t);for(n in l.container.on("row:remove",function(e,i){t.deleteRow?.(i)}),l.container.on("row:update",function(e,i,r,a){t.updateField?.call(t,e,i,r,a),l.updateLabel?.()}),void 0!==this.currentIndex&&void 0!==this.rows&&(this.rows[this.currentIndex]=l),o)o.hasOwnProperty(n)&&(a[n]=o[n].default);return void 0!==r&&(void 0!==this.currentIndex&&(r[this.currentIndex]=a),this.setValue?.(r,!0)),void 0!==this.currentIndex&&this.currentIndex++,l}},sort:function(){let e=this;if(!e.getValue)return;let t=this.repeaterFieldsContainer?.find(".repeater-row"),i=[],r=e.getValue(),a=[],s=[];t?.each(function(e,t){i.push(jQuery(t).data("row"))}),jQuery.each(i,function(t,i){e.rows&&(a[t]=e.rows[i]),a[t].setRowIndex(t),s[t]=r[i]}),e.rows=a,e.setValue?.(s)},deleteRow:function(e){if(void 0===this.rows||!this.getValue)return;let t=this.getValue();for(let i in t[e]&&this.rows[e]&&(delete t[e],delete this.rows[e],this.setValue?.(t,!0)),this.rows)this.rows.hasOwnProperty(i)&&this.rows[i]&&this.rows[i].updateLabel()},updateField:function(e,t,i,r){if(!this.getValue||void 0===this.rows||!this.rows[t]||!this.params.fields[i])return;let a=this.params.fields[i].type,s=this.rows[t],n=this.getValue(),o=jQuery(r);console.log(`updateField row.rowIndex: ${s.rowIndex}, fieldId: ${i}, element: ${o}, element.value: ${o.val()}`),void 0!==n[s.rowIndex][i]&&("checkbox"===a?n[s.rowIndex][i]=o.is(":checked"):n[s.rowIndex][i]=o.val(),this.setValue?.(n,!0))},initColorPicker:function(){let t=this,i=t.container?.find(".wpbf-classic-color-picker"),a=i?.data("field"),s={};void 0!==a&&void 0!==t.params.fields[a]&&void 0!==t.params.fields[a].palettes&&e(r).isObject(t.params.fields[a].palettes)&&(s.palettes=t.params.fields[a].palettes),s.change=(e,i)=>{if(!t.getValue)return;let r=jQuery(e.target),a=r.closest(".repeater-row").data("row"),s=t.getValue(),n=i.color._alpha<1?i.color.to_s():i.color.toString();s[a][r.data("field")]=n,t.setValue?.(s,!0),setTimeout(function(){e.target.value=n},50)},i&&i.length>0&&i.wpColorPicker(s)},initSelect:function(e,t){let i=this,r=e.container.find(".repeater-field select");if(0===r.length)return;let a=r.data("field");(t=t||{})[a]=t[a]||"",jQuery(r).val(t[a]||jQuery(r).val()),this.container.on("change",".repeater-field select",function(e){if(!i.getValue)return;let t=jQuery(e.target),r=t.closest(".repeater-row").data("row"),a=i.getValue();a[r][t.data("field")]=jQuery(this).val(),i.setValue?.(a)})}})}();
//# sourceMappingURL=repeater-control-min.js.map
