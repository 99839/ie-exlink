//main javascript
(function( $ ) {

ieExternal = (function() {

    var opts = {};

    initialize = function(options) {

        var defaults = {
            protocols: ['http', 'https'],
            hostCompare: true,
            noFollow: false,
            showUrl: true,
            linkWarning: true,
            linkWarningBody: 'You are about to leave this website and navigate to the link below. Would you like to continue?',
            dialogCancelButton: 'Cancel',
            dialogConfirmButton: 'Continue',
            externalColor: '',
        }

       opts = $.extend(true,{}, defaults, options);

       $('body').on('click','.external',function(event){
            event.preventDefault();

            if(event.handled != true) {
                catchClick(event);
            }

            event.handled = true;
        });

        var self = this;

        if(opts.hostCompare) {
            targetByHost();
        } else {
            targetByProtocol();
        }

        $('.external').css('color', opts.externalColor);
    };

    targetByProtocol = function() {

        var self = this;

        jQuery.each(opts.protocols, function(key, value) {
            if(opts.noFollow) {
                $('a[href^="'+value+'://"]').attr('rel', 'nofollow');
            } else {
                $('a[href^="'+value+'://"]');
            }
        });

    };

    targetByHost = function() {

        var self = this;

        var hostname = new RegExp(location.host);

        $('a').each(function() {

            if(hostname.test($(this).attr('href')) === false) {
                if(opts.noFollow) {
                    $(this).attr('rel', 'nofollow');
                } else {
                    $(this);
                }
            }
        });
    };

    catchClick = function(obj) {

        if($(obj.target).is('.external')) {
            if(opts.linkWarning) {

                if($(obj.target).is('a')) {
                    var href = obj.target.href;
                } else {
                    var href = $(obj.target).closest('a').attr('href');
                }

                showLinkWarning(href);

            } else {
                if($(obj.target).is('a')) {
                    var href = obj.target.href;
                } else {
                    var href = $(obj.target).closest('a').attr('href');
                }

                window.open(href, '_blank');

            }
        }

        window.lastObj = obj;

    };

    showLinkWarning = function(href) {

        $('body').append('<div class="modal-overlay"><div class="modal-dialog"><div class="modal-content"><span class="modal-description">'+opts.linkWarningBody+'</span></div><div class="modal-footer"><span class="externalCancel" onclick="ieExternal.closeModal();">'+opts.dialogCancelButton+'</span><span class="externalContinue" onclick="ieExternal.navigate(&quot;'+href+'&quot;);">'+opts.dialogConfirmButton+'</span></div></div></div>');

        if(opts.showUrl) {
            $( '.modal-content' ).append( '<span class="modal-url">'+href+'</span>' );
        }

        $('.modal-dialog').fadeIn(500);

    };

    closeModal = function() {
        $('.modal-overlay, .modal-dialog').remove();
    };

    navigateLocation = function(href) {
        window.open(href, '_blank');
        $('.modal-overlay, .modal-dialog').remove();
    };

    //inline style, you can delete it and use the style in style.css
    var style = document.createElement('style');
    style.setAttribute("type","text/css");
    style.setAttribute("id","modal_style");
    style.innerHTML =
    `.modal-overlay{position:fixed;width:100%;height:100%;left:0;top:0;background-color:rgba(0,0,0,.4);z-index:99999}.modal-dialog{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background-color:rgba(255,255,255 ,1);border-radius:10px;width:468px;padding:20px;font-size:16px;}.modal-content{display:flex;flex-direction:column;line-height:1.5}.modal-description{padding-bottom:6px}.modal-url{color:rgba(252,85,49,1);overflow: hidden;text-overflow: ellipsis;white-space: nowrap;}.modal-footer{display:flex;justify-content:flex-end;padding-top:5px}.externalCancel,.externalContinue{border-radius:3px;font-size:14px;padding:5px 9px;text-decoration:none;text-align:center;margin-right:15px;cursor:pointer}.externalCancel:hover{text-decoration:underline}.externalContinue{border-radius:3px;outline:0;background-color:rgba(252,85,49,1);color:rgba(255,255,255,1);margin-right:0}`;
    //end inline style

    document.head.appendChild(style);

    return {
        init: initialize,
        closeModal: closeModal,
        navigate: navigateLocation
    };

})();
})(jQuery);

//init javascript
jQuery(document).ready(function($){
    ieExternal .init({
    linkWarning: iexlink.linkwarning,
    noFollow: iexlink.nofollow,
    showUrl: iexlink.showurl,
    linkWarningBody: iexlink.message,
    dialogCancelButton: iexlink.cancel,
    dialogConfirmButton: iexlink.continue,
    externalColor: iexlink.color,
 });
});