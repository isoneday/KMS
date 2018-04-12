/* Gtfw Class
 * Kumpulan Utility class untuk gtfw Aplikasi
 * Version: 0.5 
 * Author: Apris Kiswandi 
 * Created on: 20 Nov 2011 
 * Updated: 01 Feb 2012 
 * 
 */

(function($) {
    var Gtfw = {
        go_to:function(url){
            $.history.load(url)
        },
        goToUrl:function(url){
            $.Gtfw.load(url)
        },        
        back:function(){
            history.back();
        },
        forward:function(){
            history.forward();
        },
        isInput:function(attr){
            var r;
            eval("r = Modernizr.input."+attr);
            if(typeof r == "undefined"){
                r=false;
            }
            return r;
        },        
        isInputType:function(type){
            var r;
            eval("r = Modernizr.inputtypes."+type);
            if(typeof r == "undefined"){
                r=false;
            }
            return r;
        },
        setDecimal:function(obj,val){
            obj.autoNumericSet(val);            
        },
        notice:function(text,stay){
            if(stay===null) stay=false;
            $.noticeAdd({
                text: text,
                stay: stay
            });            
        },
        getUrl:function(url){
            var vars = [], hash;
            if(typeof url=='undefined' || url==null || $.trim(url)==''){
                var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');            
            }else{
                var hashes = url.slice(url.indexOf('?') + 1).split('&');                        
            }

            $(hashes).each(function(key,val){
                hash = val.split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            });
            return vars;
        }
        ,
        load:function(urldest){
            var url=urldest['url'];
            var dest=urldest['dest'];

            $.history.dest=dest;            
            this.dest=dest;
            $.history.load(url);

        },
        beforeSubmit:function(){
			return true;
		}
    }
    if(typeof $.history=='object'){
        $.extend(self, $.history,Gtfw);        
    }else{
        $.extend(self, Gtfw);        
    }

    $.Gtfw=self;    
})(jQuery);
