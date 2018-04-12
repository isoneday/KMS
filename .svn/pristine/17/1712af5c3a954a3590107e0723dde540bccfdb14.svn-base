/* Gtfw Function
 * Kumpulan Fungsi2 dan shortcut javascript untuk aplikasi Gtfw 
 * Version: 0.5 
 * Author: Apris Kiswandi 
 * Created on: 20 Nov 2011 
 * Updated: 01 Feb 2012 
 * 
 */
 var headers = new Object();
//show confirm delete
showConfirmDelete = function(url, msg, title) {
	if (typeof title == 'undefined' || title == null) {
		title = lang.confirm_delete;
	}
	if (typeof msg == 'undefined' || msg == null) {
		msg = lang.message_delete;
	}
	gtConfirm(msg, title, function(result) {
		if (result) {
			$.Gtfw.goToUrl(url);
		}
	});
}
//show popup
showGtPopup = function(url, title, width, height, container, modal) {
	var objpop;
	if (url == null) {
		alert(lang.wrong_url);
	} else {
		headers['X-GtfwXhrRequestSignature'] = new Date().toString();
		objpop = gtfwPopup('', title, width, height, container, modal);
		url += "&ascomponent=1";
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
            gtfwPopupSetContent(objpop, data);
			gtfwBind();
        })
        .fail(function(data, status, xhr) {
            console.log("error");
        })
        .always(function() {
            $('.busy-indicator').fadeOut();
        });
	}
	return objpop;
}
//close gtPopup
closeGtPopup = function(objPop) {
	objPop.find(".gtfw_popup_exit").trigger("click");
}
//gtPopBox
showGtPopBox = function(elemObj, title, width, height) {
	var objpopbox = gtfwPopbox('', title, width, height);
	//cek jika object di move ke popbox
	if (typeof elemObj != 'object' && elemObj.substr(0, 1) == '#') {
		elemObj = $(elemObj);
		var idpopbox = objpopbox.attr("id");
		var idn = idpopbox.replace("gtfw_popbox_", "");
		elemObj.before("<div class=\"popbox_temp\" id=\"pop_box_temp_" + idn + "\" style=\"display:none;\" ></div>");
		gtfwPopboxSetContent(objpopbox, elemObj);
		gtfwBind();
	} else if (typeof elemObj == 'object') {
		var idpopbox = objpopbox.attr("id");
		var idn = idpopbox.replace("gtfw_popbox_", "");
		elemObj.before("<div class=\"popbox_temp\" id=\"pop_box_temp_" + idn + "\" style=\"display:none;\" ></div>");
		gtfwPopboxSetContent(objpopbox, elemObj);
		gtfwBind();
	} else { //jika string langsung di set ke popbox
		gtfwPopboxSetStringContent(objpopbox, elemObj);
		gtfwBind();
	}
	return objpopbox;
}
//
closeGtPopBox = function(objPop) {
	objPop.find(".gtfw_popbox_exit").trigger("click");
}
// gt Notice
gtNotice = function(text, stay) {
	$.Gtfw.notice(text, stay);
}
//gt include JS
includeJs = function(jsFile) {
	if (jsFile != null) {
		//        var th = document.getElementsByTagName('head')[0];
		//        var s = document.createElement('script');
		//        s.setAttribute('type','text/javascript');
		//        s.setAttribute('src',jsFile);
		//        th.appendChild(s);
		//   document.write('<scr'+'ipt type="text/javascript" src="'+jsFile+'" ></scr'+'ipt>');         
		var script = "<script src='" + jsFile + "' type=\"text/javascript\"></script>";
		$(document).append($(script));
	}
}
//tinymce
setTinyMce = function(objElem, minimalMode, options) {
	if (objElem != null && typeof tinyMCE == 'object') {
		if (objElem.substr(0, 1) == '#') {
			objElem = objElem.replace("#", "");
		}
		if (typeof options != 'undefined' && options != null) {}
		if (minimalMode == null || typeof minimalMode == 'undefined' || minimalMode == false) {
			tinyMCE.init({
				mode: "exact",
				elements: objElem,
				theme: "modern",
				plugins: [
        "advlist autolink lists link image charmap print preview anchor","searchreplace visualblocks code fullscreen","insertdatetime media table contextmenu paste"],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
			});
		} else {
			tinyMCE.init({
				mode: "exact",
				elements: objElem,
				theme: "modern",
				theme_advanced_toolbar_location: "top"
			});
		}
	}
	if (typeof tinyMCE != 'object') {
		alert("tidak ditemukan library tiny mce");
	}
}
replaceContentWithUrl = function(dest, url) {
	var randomnumber = Math.floor(Math.random() * 11);
	var param = {
		url: url + '&unq=' + randomnumber,
		dest: dest
	}
	$.Gtfw.load(param);
	//$('#'+dest).fadeOut().load(url).fadeIn();
}