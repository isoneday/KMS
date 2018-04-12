/* Gtfw Popup
* Popup Untuk Aplikasi Gtfw
* Version: 0.5 
* Author: Apris Kiswandi 
* Created on : Feb 22, 2012, 2:24:41 PM * 
*/

var imgloader='data:image/gif;base64,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';

(function($) {
    $.popup={        
        _show:function(content,title, width, height, container,modal){
            var d = new Date();
            var idpop=d.getTime();
            if($.trim(content)==''){
                content='<div style="text-align:center;padding-bottom:15px;padding-top:10px;"><img alt="" src="'+imgloader+'" /></div>';
            }
            if(typeof container !== 'undefined' || container == null){
                container =   'popup-subcontent';
            }
            var level=$("#"+container).length;
            if(level<1)level='';
            $("body").append(
                '<div class="gtfw_popup_container modal" id="gtfw_popup_'+idpop+'">' +
                '<div class="gtfw_popup_title modal-header"><button data-dismiss="modal" id="gtfw_popup_close_'+idpop+'" class="gtfw_popup_exit close" type="button">&times;</button><h4>'+title+'</h4></div>' +
                '<div class="gtfw_popup_content modal-body" id="'+container+level+'">' +
                content +
                '</div>' +
                '<!--<div class="modal-footer"></div>-->' +
                '</div>');
            var pos = 'fixed';

            $("#gtfw_popup_"+idpop).css({
                position: pos,
                zIndex: 100,
                padding: 0,
                margin: 0
            });

            if( modal == true && $(".gt_pop_lay").length < 1 ){
                var objoverlay=$('<div class="gt_pop_lay" id="gt-pop-lay-'+idpop+'" ></div>');
                objoverlay.css({
                    height: $(window).height(),
                    width: $(window).width(),
                    position: 'fixed',
                    left: 0,
                    top: 0,
                    zIndex: 99,

                });
                objoverlay.css("background-color","#000000").css("opacity","0.6");
                objoverlay.click(function(){
                    return false;
                })
                $("body").append(objoverlay);
            }

            $("#gtfw_popup_close_"+idpop).click(function(){
                $("#gtfw_popup_"+idpop).fadeOut("slow",function(){
                    $(this).remove(); 
                    $('#gt-pop-lay-'+idpop+'').remove();
                    if(typeof gtfwBind=='function'){
                        gtfwBind();
                    }
                });
            });

            if(height!=null){
                console.log('here');
                $("#gtfw_popup_"+idpop).css('height',height+'px').children(".gtfw_popup_content").css('height',(height)+'px');
            }

            if(width!=null){
                console.log('or here');
                $("#gtfw_popup_"+idpop).css('width',width+'px').children(".gtfw_popup_content").css('width',(width)+'px');

            }


            if( $.alerts.draggable ) {
                try {
                    $(".gtfw_popup_container").draggable({ handle: ".gtfw_popup_title"});
                    $(".gtfw_popup_title").css({
                        cursor: 'move'
                    });
                } catch(e) { /* Error jquery drag */ }
            }    
            $.popup._reposition($("#gtfw_popup_"+idpop));
            return $("#gtfw_popup_"+idpop);
        },
        _reposition:function(objPop){
            var top = (($(window).height() / 2) - (objPop.outerHeight() / 2)) + $.alerts.verticalOffset;
            var left = (($(window).width() / 2) - (objPop.outerWidth() / 2)) + $.alerts.horizontalOffset;

            if( top < 0 ) top = 0;
            if( left < 0 ) left = 0;

            if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();

            objPop.css({
                top: top + 'px',
                left: left + 'px'
            });                

        }

    }

    gtfwPopup = function(content, title, width,height,container,modal) {

        if(title == null){
            title='gtPopup';   
        }       

        return $.popup._show(content,title,width,height,container,modal);
    };    

    gtfwPopupSetContent=function(objPopup,content){
        objPopup.children(".gtfw_popup_content").html(content);
        $.popup._reposition(objPopup);        
    };



})(jQuery);

/* Gtfw Popbox
* Popbox Untuk Aplikasi Gtfw
* Version: 0.5 
* Author: Apris Kiswandi 
* Created on : Feb 22, 2012, 2:24:41 PM
* 
*/
(function($) {

    $.popbox={        
        _show:function(content,title, width, height){


            var d = new Date();
            var idpop=d.getTime();

            if($.trim(content)==''){
                content='<div style="text-align:center;"><img alt="" src="'+imgloader+'" /></div>';
            }
            var level=$("#popbox-subcontent").length;
            if(level<1)level='';
            $("body").append(
                '<div class="gtfw_popbox_container modal" id="gtfw_popbox_'+idpop+'">' +
                '<div class="gtfw_popbox_title modal-header"><button data-dismiss="modal" id="gtfw_popbox_close_'+idpop+'" class="gtfw_popup_exit close" type="button">&times;</button><h4>'+title+'</h4></div>' +
                '<div class="gtfw_popbox_content modal-body" id="popbox-subcontent'+level+'">' +
                content +
                '</div>' +
                '<!--<div class="modal-footer"></div>-->' +
                '</div>');
            var pos = 'fixed';

            $("#gtfw_popbox_"+idpop).css({
                position: pos,
                zIndex: 100,
                padding: 0,
                margin: 0
            });

            $("#gtfw_popbox_close_"+idpop).click(function(){
                $("#gtfw_popbox_"+idpop).fadeOut("slow",function(){
                    var elemObjRestore = $(this).find(".gtfw_popbox_content").children();
                    $("#pop_box_temp_"+idpop).after(elemObjRestore);
                    $(this).remove(); 
                    $("#pop_box_temp_"+idpop).remove();
                    if(typeof gtfwBind=='function'){
                        gtfwBind();
                    }
                });
            });

            if(height!=null){
                $("#gtfw_popbox_"+idpop).css('height',height+'px').children(".gtfw_popbox_content").css('height',(height)+'px');
            }

            if(width!=null){
                $("#gtfw_popbox_"+idpop).css('width',width+'px').children(".gtfw_popbox_content").css('width',(width)+'px');

            }


            if( $.alerts.draggable ) {
                try {
                    $(".gtfw_popbox_container").draggable();
                    $(".gtfw_popbox_title").css({
                        cursor: 'move'
                    });
                } catch(e) { /* Error jquery drag */ }
            }    
            $.popbox._reposition($("#gtfw_popbox_"+idpop));
            return $("#gtfw_popbox_"+idpop);
        },
        _reposition:function(objPop){
            var top = (($(window).height() / 2) - (objPop.outerHeight() / 2)) + $.alerts.verticalOffset;
            var left = (($(window).width() / 2) - (objPop.outerWidth() / 2)) + $.alerts.horizontalOffset;
            if( top < 0 ) top = 0;
            if( left < 0 ) left = 0;

            if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();

            objPop.css({
                top: top + 'px',
                left: left + 'px'
            });                

        }

    }

    gtfwPopbox = function(content, title, width,height) {

        if(title == null){
            title='gtPopbox';   
        }       

        return $.popbox._show(content,title,width,height);
    };    

    gtfwPopboxSetContent=function(objPopbox,elemObj){

        objPopbox.children(".gtfw_popbox_content").html("").append(elemObj);

        $.popbox._reposition(objPopbox);        
    };

    gtfwPopboxSetStringContent=function(objPopbox,elemObj){
        objPopbox.children(".gtfw_popbox_content").html(elemObj);
        $.popbox._reposition(objPopbox);        

    }

})(jQuery);