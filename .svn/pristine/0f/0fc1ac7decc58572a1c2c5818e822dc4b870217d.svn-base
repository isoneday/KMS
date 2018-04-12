/**
gtNumber, untuk memformat input dengan type decimal
@example1 : <input type="decimal" name="namainput" />
@example2 : <input type="decimal" name="namainput" data-dec="." data-sep="," />
@copyright 2012
@author Apris Kiswandi
@email apris@gamaterchno.com
@modified by prima.noor @ 20120103
@modification : tidak lagi memanfaatkan gvFloat nya Gabri (sory sob), tapi memanfaatkan jquery.auto.input.js yang sudah di include kan oleh mas apris
*/
(function($){
    $.fn.gtnumber = function(options) { 
        return this.each(function(){ 
            var Obj=$(this).get(0);
            var dec=$.trim($(this).data("dec"));
            var sep=$.trim($(this).data("sep"));
			var min=$.trim($(this).data("min"));
			var max=$.trim($(this).data("max"));
            
            if (!dec) dec = '.';
            if (!sep) sep = ',';
            if (!min) min = '0.00';
            if (!max) max = '999999999999.99';
            
            $(Obj).autoNumeric(
            {
                aSep: sep,
                aDec: dec,
                vMin: min,
                vMax: max                
            }
            ).trigger('blur');
        });
    }
})(jQuery);
