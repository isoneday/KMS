/* Gtfw Input
 * Handle Event2 input form aplikasi gtfw
 * Version: 0.5 
 * Author: Apris Kiswandi 
 * Created on: 20 Nov 2011 
 * Updated: 01 Feb 2012 
 * 
 */

jQuery(document).ready(function($) {
    //cek input type
    var ce = false;
    var nilnumber="";
    $("body").delegate("input",{
        keypress:function(event){
            var type = $(this).attr("type");
    
            if($.Gtfw.isInputType(type)==false){   
                switch(type){
                    case "number":
         
                        if ((event.which < 48 || event.which >57) && event.which !=8 && event.keyCode != 37 && event.keyCode != 39 && event.keyCode != 9 && event.keyCode != 46 && event.keyCode != 13) {
                            return false;                        
                        }
                        nilnumber=$(this).val();
                        break;
                }
            }            
        },
        keyup:function(event){
            var type = $(this).attr("type");
    
            if($.Gtfw.isInputType(type)==false){   
                switch(type){
                    case "number":
                        var val = parseInt($(this).val());
                        var min = $(this).attr('min');
                        var max = $(this).attr('max');
                        if(typeof min!="undefined" && typeof max!="undefined"){
                            min=parseInt(min);
                            max=parseInt(max);
                            if(typeof val=='number' && typeof min=='number' && typeof max=='number'){
                                if(val > max){
                                    $(this).val(nilnumber);
                                    return false;
                                }else if(val < min){
                                    $(this).val(nilnumber);
                                    return false;	
                                }
                            }
                        }
                        break;
                }
            }            
        },
        focusout:function(event){
            var type = $(this).attr("type");
            if($.Gtfw.isInputType(type)==false){   
                switch(type){
                    case "email":
                        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                        if (!filter.test($(this).val())){
                            $(this).css("background-color","red");                            
                        } else{
                            $(this).css("background-color","");
                        }
                        break;
                    case "number":
                        var val = parseInt($(this).val());
                        var min = $(this).attr('min');
                        var max = $(this).attr('max');
                        if(typeof min!="undefined" && typeof max!="undefined"){
                            min=parseInt(min);
                            max=parseInt(max);
                            if(typeof val=='number' && typeof min=='number' && typeof max=='number'){
                                if(val < min || val > max){
                                    $(this).css("background-color","red").focus();
                                }else{
                                    $(this).css("background-color","");
                                }
                            }
                        }
                        break;                        
                }
            }                        
        }
    });

   
    $("#content").delegate("input[rel=btnBack]","click",function(){
        $.Gtfw.go_to($(this).attr("rel-data"));
    });
   
});
    
gtfwBind = function(){
     
    $("input[type=decimal]").gtnumber();     

    var img_cal = "data:image/gif;base64,R0lGODlhEAAPAPQAAIyq7zlx3lqK5zFpznOe7/729fvh3/3y8e1lXt1jXO5tZe9zbLxeWfB6c6lbV/GDffKIgvKNh/OYkvSblvSinfWrp3dTUfawq/e1sf3r6v/8/P/9/f///////wAAAAAAACH5BAEAAB0ALAAAAAAQAA8AAAWK4GWJpDWN6KU8nNK+bsIxs3FdVUVRUhQ9wMUCgbhkjshbbkkpKnWSqC84rHA4kmsWu9lICgWHlQO5lsldSMEgrkAaknccQBAE4mKtfkPQaAIZFw4TZmZdAhoHAxkYg25wchABAQMDeIRYHF5gEkcSBo2YEGlgEEcQoI4SDRWrrayrFxCDDrW2t7ghADs=";        
    

       
    //    if(){   
    $("input[type=datetime]").each(function(){
        var objinput=$(this);
        if($.Gtfw.isInputType("datetime")==false || objinput.data("force")==true){
            if($.Gtfw.isInputType("datetime")==true ){
                var newinput = $(this).clone();
                newinput.attr("type","text");
                newinput.insertBefore(objinput);
                objinput.remove();
                objinput=newinput;
            } 
            var opsi=objinput.data("options");
            objinput.removeAttr("data-options");
            if(typeof opsi!="undefined" && opsi !=null){
                opsi=opsi.replace(/\'/g,"\"");
                eval("opsi="+opsi);                
                if(typeof opsi!="object"){
                    opsi={};
                }                
            }else{
                opsi={};
            }

            var optiondef={
                dateFormat: 'yy-mm-dd',
                showOn: "button",
                buttonImage: img_cal,
                buttonImageOnly: true,
                changeMonth: true,
                changeYear: true
            };
            var options = $.extend( opsi,optiondef); 
            if(objinput.val()==""){
                objinput.mask("9999-99-99 99:99");
            }else{
                var isi=objinput.val();
                objinput.val("");
                objinput.mask("9999-99-99 99:99").val(isi);
            }
            objinput.datetimepicker(options);
        }
    });
       

    //    }
    //   if($.Gtfw.isInputType("date")==false){   
    $("input[type=date]").each(function(){
        var objinput=$(this);
        if($.Gtfw.isInputType("date")==false || objinput.data("force")==true){
 
            if($.Gtfw.isInputType("date")==true ){
                
                var newinput = objinput.clone();
                newinput.attr("type","text");
                newinput.insertBefore(objinput);
                objinput.remove();
                objinput=newinput;
            } 
            var opsi=objinput.data("options");
            objinput.removeAttr("data-options");
            if(typeof opsi!="undefined" && opsi !=null){
                opsi=opsi.replace(/\'/g,"\"");
                eval("opsi="+opsi);                
                if(typeof opsi!="object"){
                    opsi={};
                }
            }else{
                opsi={};
            }

            var optionsdef={
                dateFormat: 'yy-mm-dd',
                showOn: "button",
                buttonImage: img_cal,
                buttonImageOnly: true, 
                changeMonth: true,
                changeYear: true
            };
            
            var options = $.extend(opsi,optionsdef); 

            if(objinput.val()==""){
                objinput.mask("9999-99-99"); 
            }else{
                var isi = objinput.val();
                objinput.val("");
                objinput.mask("9999-99-99").val(isi); 
            }
           
            objinput.datepicker(options);
        }
    });

            
                       
    //   }        
    // if($.Gtfw.isInputType("time")==false){   
        
    $("input[type=time]").each(function(){
        var objinput=$(this);
        if($.Gtfw.isInputType("time")==false || objinput.data("force")==true){
            if($.Gtfw.isInputType("time")==true ){
                var newinput = objinput.clone();
                newinput.attr("type","text");
                newinput.insertBefore(objinput);
                objinput.remove();
                objinput=newinput;
            } 
            if(objinput.val()==""){
                objinput.mask("99:99"); 
            }else{
                var isi = objinput.val();
                objinput.val("");
                objinput.mask("99:99").val(isi); 
            }
            objinput.timepicker({
                timeFormat: 'hh:mm',
                showOn: "button",
                buttonImage: img_cal,
                buttonImageOnly: true
            });

        }
    });
  
//   }        
        

};
