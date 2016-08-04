"use strict";
//assumes url is properly encoded
function CURLJSON(method, url, cb) {
	var xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = function() {
	    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	        var data = JSON.parse(xmlhttp.responseText);
	       	cb(data);
	    }
	};
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
}


