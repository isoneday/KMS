/* Gtfw Ajax
* Handle Ajax gtfw
* Version: 0.5 
* Author: Apris Kiswandi 
* Created on: 20 Nov 2011 
* Updated: 01 Feb 2012 
* 
*/
(function($){
    var headers = new Object();
    var load = function (url,dest) {
        //console.log('LOADDD');

        if(dest=='0'){
            dest='subcontent-element';
        }
        $('.busy-indicator').fadeIn("slow");

        if($.trim(url)!=''){
            headers['X-GtfwXhrRequestSignature'] = new Date().toString();
            url+="&ascomponent=1";
            $.ajax({
                url: url,
                headers: headers
                ,statusCode: {
                    401: function() {
                        if (url_login) {
                            window.location.href = url_login;
                        } else {
                            alert('Unauthorized or session expire, try refresh your page');
                        }
                    }
                }
            })
            .done(function(data, status, xhr) {
                if (isJsonString(data)) {
                    //console.log('JSON');
                    $.globalEval("result = " + data + ";");
                    if (result['exec']) {
                        $.globalEval(result['exec'] + ";");
                    }  
                } else {
                    //console.log('NOT JSON');
                    $('#'+dest).fadeOut().html(data).fadeIn();
                }
            })
            .fail(function(data, status, xhr) {
                console.log("error");
            })
            .always(function() {
                $('.busy-indicator').fadeOut();
            });
        } else{
            gtfwBind();
            $('.busy-indicator').hide();
        }
        return false;
    }    

    jQuery(document).ready(function($) {

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

$('body').delegate( 'form','submit',function(e) {	
    if (this.beenSubmitted){
        return false;
    }else{
        this.beenSubmitted = true;
    }
    var objForm = $(this);

    objForm.find('input[type=decimal]').each(function(){
        $(this).val($(this).autoNumericGet());
    });

    $('.busy-indicator').fadeIn("slow");
    var classHref = $(this).attr('class');
    if(typeof classHref!='undefined' && classHref!=null){        

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
            headers['X-GtfwXhrRequestSignature'] = new Date().toString();
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
                    },
                    headers: headers
                    ,statusCode: {
                        401: function() {
                            if (url_login) {
                                window.location.href = url_login;
                            } else {
                                alert('Unauthorized or session expire, try refresh your page');
                            }
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
                    },
                    headers: headers
                    ,statusCode: {
                        401: function() {
                            if (url_login) {
                                window.location.href = url_login;
                            } else {
                                alert('Unauthorized or session expire, try refresh your page');
                            }
                        }
                    }
                });            
            }
            return false; 
        }
    }
});

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
window.onerror=customHandler;
