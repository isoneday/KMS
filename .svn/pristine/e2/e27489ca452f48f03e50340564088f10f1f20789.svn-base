/* Gtfw Ajax
 * Handle Ajax gtfw
 * Version: 0.5 
 * Author: Apris Kiswandi 
 * Created on: 20 Nov 2011 
 * Updated: 01 Feb 2012 
 * 
 */
(function($){
    var load = function (url,dest) {
        
        if(dest=='0'){
            dest='subcontent-element';
        }
        $('.busy-indicator').fadeIn("slow");

        if($.trim(url)!=''){
            url+="&ascomponent=1";
            $('#'+dest).fadeOut().load(url, function(){
                $(this).fadeIn(200);        
                gtfwBind();
                $('.busy-indicator').hide();
            });
        } else{
//            var url=window.location;
//            $.get(url,function(data){
//                var isi=$(data).find('#'+dest).html();
//                if($.trim(isi)!=''){
//                    $('#'+dest).fadeOut(200,function(){
//                        $('#'+dest).html(isi).fadeIn(200);   
                        gtfwBind();
                        $('.busy-indicator').hide();
//                    });
//                }
//            });                
        }
        return false;
    }    

    jQuery(document).ready(function($) {
        // start handle click
        
        if(typeof $.history=='object'){            
            $.Gtfw.init(function(url) {
                if(typeof $.history.dest=='undefined'){
                    load(url,'0');                            
                }else{
                    load(url,$.history.dest);                            
                }
            });
        }

        $('body').delegate('a','click', function(e) {        

            var url = $(this).attr('href');
            var classHref = $(this).attr('class');

            if(typeof classHref!='undefined' && classHref!=null){
                
                var patt_xhr = /\s*xhr\s+/i;
                var patt_dest = /\s*dest\_[a-z\-\_0-9]*\s*/i;
                var xhr = classHref.match(patt_xhr);
                var dest = classHref.match(patt_dest);
                xhr=$.trim(xhr);

                if(xhr == 'xhr' && dest !=null ){
                dest=$.trim(dest);
                    if(typeof url!='undefined' && url!=null){
                        url = url.replace(/^.*#/, '');   
                        if($.trim(url)==''){
                            return false;
                        }
                    }else{
                        return false;
                    }
                    var dt=new Date();
                    url = url+'&uniq='+dt.getTime();
                    dest = dest.replace("dest_","");
                    if(typeof $.history=='object'){
                        var param={
                            url:url,
                            dest:dest
                        }
                        if(typeof $.Gtfw.load=='function'){
                            $.Gtfw.load(param);                            
                        }else{
                            $.Gtfw.load(url);
                        }

                    }else{
                        load(url,dest);
                    }
                    return false;
                }
            }

        });
        // end handle click
   
        // start handle form submit
        $('body').delegate( 'form','submit',function(e) {	
            if (this.beenSubmitted){
					return false;
            }else{
                this.beenSubmitted = true;
            }
            var objForm=$(this);
            $('.busy-indicator').fadeIn("slow");
            var classHref = $(this).attr('class');
            if(typeof classHref!='undefined' && classHref!=null){        
                //var patt_xhr = /\s*xhr\_[a-z\-_]*\s+/i;
                var patt_xhr = /\s*xhr\s+/i;
                var patt_dest = /\s*dest\_[a-z\-\_0-9]*\s*/i;
                var patt_std = /\s*std\_[a-z\-_]*\s*/i;
				if(!$.Gtfw.beforeSubmit()){
					$('.busy-indicator').hide();
					this.beenSubmitted =false;
					gtfwBind();
					return false;
				}
                var std = classHref.match(patt_std);
                var xhr = classHref.match(patt_xhr);
                var dest = classHref.match(patt_dest);

                if((xhr !=null && dest !=null )||(std!=null)){
                    xhr = $.trim(xhr);
                    dest = $.trim(dest);
                    dest = dest.replace("dest_","");
                    if($.trim(dest)=='')dest='subcontent-element';
                    if(objForm.attr('enctype')=='multipart/form-data'){
                        objForm.ajaxSubmit({
                            url:objForm.attr('action')+'&ascomponent=1',
                            success: function(data){
                                data=unescape(data);                    
                                if (isJsonString(data)) {
                                    $.globalEval("result = " + data + ";");
                                    if (result['exec']) {
                                        $.globalEval(result['exec'] + ";");
                                    }  
                                    $('.busy-indicator').hide();
                                }
                                if($.trim(data)!=''){
                                    $('#'+dest).fadeOut(200,function(){
                                        $('#'+dest).html(data);
                                        $('#'+dest).fadeIn(200);        
                                        gtfwBind();
                                        $('.busy-indicator').hide();
                                    });
                                }               
                            }
                        });
                    }else{
                        $.ajax({
                            type: 'POST',
                            url: objForm.attr('action')+'&ascomponent=1',
                            data: objForm.serialize(),
                            success:  function(data){
                                if (isJsonString(data)) {
                                    $.globalEval("result = " + data + ";");
                                    if (result['exec']) {
                                        $.globalEval(result['exec'] + ";");
                                    }  
                                    $('.busy-indicator').hide();
                                } else if($.trim(data)!=''){
                                    $('#'+dest).fadeOut(200,function(){
                                        $('#'+dest).html(data);
                                        $('#'+dest).fadeIn(200);             
                                        gtfwBind();
                                        $('.busy-indicator').hide();
                                    });
                                }               
                            }
                        });            
                    }
                    return false; 
                }
            }
        });
    //end handle form submit

    //
    
//    $("body").delegate('input','click',function(){        
//        gtfwBind();
//    });

    }).ajaxStop(function() {
        setTimeout(gtfwBind, 1000);
    });
})(jQuery);

function isJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}


//handle error
customHandler = function (desc,page,line,chr)  {
    $('.busy-indicator').hide();    
    alert(
        'Gtfw Javascript Error Reporting. \n'
        + 'error occurred! \n'
        +'\nError description: \t'+desc
        +'\nPage address:      \t'+page
        +'\nLine number:       \t'+line
  //      + '\nChr :             \t'+chr
        ,'Gtfw Javascript Error Reporting')
    return true;
}
//badVariable=badObject.badProperty;
window.onerror=customHandler;
