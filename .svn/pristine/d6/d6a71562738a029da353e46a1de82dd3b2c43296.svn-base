/**
 * Description of Plugin Jquery gtUpload
 *
 * @author apriskiswandi
 */
(function($){
    $.fn.gtupload = function(options) { 
        var defaults = { 
            url:"", //default url
            urlimage:"",
            multi:false, // multi upload
            auto:true,// auto upload
            waitupload:false,// form tidak bisa disubmit, menunggu upload selesai
            blext:"php,html,htm,exe,js,css,asp,pl,txt,", //defaultnya
            wlext:"jpg,png,jpeg,gif,pdf",
            maxsize:2097152, // 2MB,
            preview:false,
            noajax:false           	
        }; 
        var options = $.extend(defaults, options); 
        if($.trim(options.url)==''){
            return false;		  
        }         
        $.fn.getoptions=function(){
            var opsi=$(this).data("options");
            $(this).removeAttr("data-options");
            if(typeof opsi!="undefined" && opsi !=null){
                opsi=opsi.replace(/\'/g,"\"");
                eval("opsi="+opsi);  
                if(typeof opsi=="object"){
                    return opsi;
                }
            }
            return opsi={};
				
        }
        var btnupd = '<div class="gt-button-upd" style="cursor:pointer;"><button type="button" name="" value="" class="btn">'+lang.select_file+'</button></div>';
        return this.each(function(){ 
            var formObj=$(this);
            formObj.find("input[type=file]").each(function(){
                if($(this).getoptions().noajax==true){
                    return;
                }
                var objinput=$(this);
                var idinput=objinput.attr("id");
                var objcont=$('<div class="gt-upd-cont" id="gt-cont-'+idinput+'"></div>');
                objinput.before(objcont);
                objinput.change(function(){
                    selectfile($(this));
                });
                objinput.appendTo(objcont).attr("style","position:absolute; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; cursor: hand; opacity: 0; ");
                objcont.append(btnupd);
            });	
			
            formObj.delegate(".gt-button-upd","click",function(){
                var objbuttonupd=$(this);
                objbuttonupd.prev().click();
            });
            			
            var selectfile = function(objinp){
                var file = infofile(objinp);
                if(typeof objinp.getoptions().maxsize!="undefined" ){
                    if(file.sizeorig > objinp.getoptions().maxsize){
                        alert(lang.maximum_file_size + " " +hitfilesize(objinp.getoptions().maxsize));
                        return false;
                    }
                }else
                if(file.sizeorig > options.maxsize) {
                    alert(lang.maximum_file_size + " " + hitfilesize(options.maxsize));
                    return false;
                }

                if(typeof objinp.getoptions().wlext!="undefined" ){
                    if(!checkext(objinp.getoptions().wlext,file.ext)){
                        alert(lang.forbidden_filetype);
                        return false;
                    }
                }else
                    
                var extinline=objinp.data('ext');
                if(extinline!=null && typeof extinline !='undefined' && extinline!=''){
                    
                    var extallow=extinline;
                    objinp.removeAttr('data-ext');
                }else{
                    var extallow=options.wlext;
                }
            
                    
                if(!checkext(extallow,file.ext)){
                    alert(lang.forbidden_filetype);
                    return false;
                }
                objinp.before('<div class="gt-file-info"><div class="gt-file-info-name">'+file.name+';</div><div> '+file.size+'</div><div> <a class="gt-btn-upd-cancel" href="#">'+lang.cancel+'</a><a style="display:none;" class="gt-btn-upd-remove" href="#">'+lang.remove+'</a></div></div><div style="clear:both;"></div>');
                objinp.parent().children(".gt-button-upd").hide();
                objinp.hide().after('<progress id="gt-progress-'+objinp.attr('id')+'" class="gt-upd-progress" value="0" max="100">'+lang.progress+' : </progress><span class="gt-progress-number" style="padding-left:5px" id="gt-progress-number-'+objinp.attr('id')+'"></span>');	
                if(options.auto){
                    uploadFile(objinp);
                }
            }
            var checkext=function(listwlext,ext){
                var wlext=listwlext.split(',');
                for(var i=0; i<wlext.length; i++) {
                    if ($.trim(wlext[i]) == $.trim(ext)) return true;
                }
                return false;
            }
            var uploadFile = function(objinp) {
                var idinp=objinp.attr("id");
                var fd = new FormData();
                fd.append(objinp.attr("name"), objinp[0].files[0]);
                var xhr = new XMLHttpRequest();
					
                objinp.parent().delegate('.gt-btn-upd-cancel','click',function(){
                    xhr.abort();
                    return false;
                });
                formObj.find("input[type=reset]").click(function(){
                    xhr.abort();
                    return false;
                });
                xhr.upload.addEventListener("progress", function(evt){
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round(evt.loaded * 100 / evt.total);
                        $("#gt-progress-number-"+idinp).html(percentComplete.toString() + '%');
                        $("#gt-progress-"+idinp).val(percentComplete);
                    }
                    else {
                        $("#gt-progress-number-"+idinp).html(lang.unable_to_compute);
                    }		
                    if(options.waitupload){
                        formObj.find("input[type=submit],button[type=submit]").attr("disabled","disabled");
                    }
                }, false);
                xhr.addEventListener("load", function(evt){
                    $("#gt-progress-"+idinp).val(100);
                    var res = evt.target.responseText;
                    var sta = $.parseJSON(res);
                    if($.trim(sta.status)=='ok'){
                        $("#gt-progress-number-"+idinp).html(evt.target.responseText);				
                        objinp.parent().find('.gt-upd-progress').remove();
                        objinp.parent().find('.gt-progress-number').remove();
                        objinp.parent().find('.gt-file-info').css("color","green").css("font-height","450");
                        objinp.parent().find('.gt-btn-upd-cancel').hide().next('.gt-btn-upd-remove').show();
                        var objinpnew = $('<input style="'+objinp.attr('style')+'" type="text" name="'+objinp.attr('name')+'" value="'+objinp.val()+'" id="'+objinp.attr('id')+'" />');
                        if(options.preview){
                            //$.get(options.urlimage+"&t="+sta.t,function(dataimage){
                            //  var imgres=$.parseJSON(dataimage);
                            if($.trim(sta.data)!='err' && typeof sta.data!="undefined" && typeof sta.w!="undefined"&& typeof sta.h!="undefined"){
                                var strimg="<img class=\"gt-img-view\" src=\""+sta.data+"\" />";
                                var imgobj=$(strimg);
                                var w=sta.w+"px";
                                var h=sta.h+"px";
                                if(sta.w > 200){
                                    imgobj.css("width","200px");
                                }
                                if(sta.h > 160){
                                    imgobj.css("height","160px");
                                }
                                imgobj
                                .css("border","1px solid #000")
                                .css("cursor","pointer")
                                .click(function(){
                                    var objpop=popimage(strimg,sta.w,sta.h);
                                    return false;
                                });
                                if(objinp.parent().find('.gt-file-info').html()==null){
                                    objinpnew.parent().find('.gt-file-info').before(imgobj);
                                }else{
                                    objinp.parent().find('.gt-file-info').before(imgobj);
                                }

                            }
                        // });
                        }
                        objinp.after(objinpnew);
                        objinp.remove();
                        objinpnew.parent().delegate('.gt-btn-upd-remove','click',function(){
                            removefile(objinpnew);
                            return false;
                        });						                              
                    }else{
                        $("#gt-progress-number-"+idinp).html(sta.msg);	
                        objinp.parent().find('.gt-upd-progress').remove();
                        objinp.parent().find('.gt-progress-number').remove();
                        objinp.parent().find('.gt-file-info').remove();
                        objinp.show().val('');
                        objinp.parent().find('.gt-button-upd').show();                        
                    }
                    restoresubmitbtn();					      
                }, false);
                xhr.addEventListener("error", function(evt){
                    $("#gt-progress-number-"+idinp).html(lang.upload_canceled+'..').css('color','red');
                    restoresubmitbtn();					      
                }, false);
                xhr.addEventListener("abort", function(evt){
                    $("#gt-progress-number-"+idinp).html(lang.aborting+'...!!');
                    objinp.parent().find('.gt-upd-progress').remove();
                    objinp.parent().find('.gt-progress-number').remove();
                    objinp.parent().find('.gt-file-info').remove();
                    objinp.show().val('');
                    objinp.parent().find('.gt-button-upd').show();
                    restoresubmitbtn();
					    
                }, false);
                xhr.open("POST", options.url);
                xhr.send(fd);
            }
            var restoresubmitbtn=function(){
                if(options.waitupload){
                    formObj.find("input[type=submit],button[type=submit]").removeAttr("disabled");
                }					      
			    
            }
            var popimage=function(strimg,w,h){
                if(typeof gtfwPopbox=="function"){

                    if(w>700){
                        w=700;
                    }else{
                        w=300;
                    }

                    return gtfwPopbox(strimg,lang.image_preview);
                }else{
                    return false;
                }
            }
            var removefile=function(objinp){
                var objinpnew = $('<input style="'+objinp.attr('style')+'" type="file" name="'+objinp.attr('name')+'" value="'+objinp.val()+'" id="'+objinp.attr('id')+'" />');
                objinp.after(objinpnew);
                objinp.remove();			      
                objinpnew.parent().find('.gt-upd-progress').remove();
                objinpnew.parent().find('.gt-progress-number').remove();
                objinpnew.parent().find('.gt-file-info').remove();
                objinpnew.parent().find('.gt-img-view').remove();
                objinpnew.show();
                objinpnew.parent().find('.gt-button-upd').show();	
                objinpnew.change(function(){
                    selectfile($(this));
                });			      
                return false;
			    
            }
            var hitfilesize = function(size){
                var fileSize = 0;
                if (size > 1024 * 1024){
                    fileSize = (Math.round(size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
                }else{
                    fileSize = (Math.round(size * 100 / 1024) / 100).toString() + 'KB';
                }
                return fileSize;
            }
            var infofile = function (objfile){
                var file = objfile[0].files[0];
                var filename=file.name;
                if (file) {
                    var fileSize = hitfilesize(file.size);

                    var result={
                        name:filename,
                        size:fileSize,
                        sizeorig:file.size,
                        type:file.type,
                        ext:((filename.split('.').pop()==filename)?'':filename.split('.').pop())
                    }
                    return result;
                }
                return null;
            }
        });
    }
})(jQuery);
