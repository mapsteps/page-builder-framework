!function(s){var t={};function e(){var i=document.querySelector(".wpbf-activation-notice.is-dismissible");i&&i.querySelector(".notice-dismiss").addEventListener("click",t.saveDismissal)}t.saveDismissal=function(i){s.ajax({url:ajaxurl,type:"post",data:{action:"wpbf_activation_notice_dismissal",nonce:wpbfOpts.activationNotice.dismissalNonce,dismiss:1}}).always(function(i){i.success&&console.log(i.data)})},window.addEventListener("load",function(i){setTimeout(e,1e3)})}(jQuery);