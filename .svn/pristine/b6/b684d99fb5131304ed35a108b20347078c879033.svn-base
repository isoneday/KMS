
$.showLoading=function(status){
    if(status==true){
        $("#msg").html("<img src=\"images/loadanim.gif\" />")
    }else{
        $("#msg").html("");
    }
}
$.setMsg=function(msg){
    $("#msg").html("").html(msg).addClass("failed");
}

$(document).ready(function(){
    $("input").removeAttr("disabled");
   
    $("#loginform").submit(function(){
        $.showLoading(true);
        $.ajax({
            url:$(this).attr("action"),
            type:"POST",
            timeout:10000,
            data:$(this).serialize(),
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $.setMsg("request timeout");
            },
            success:function(data){
                var result=$.parseJSON(data);
                if(!result.result){
                    $.setMsg(result.msg);
                }else{
                    window.location=result.url;
                }
            }
          
        });
        return false;
    });
});

