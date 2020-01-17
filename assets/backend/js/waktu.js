function xClock() {
	var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
	var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
	var date = new Date();
	var day = date.getDate();
	var month = date.getMonth();
	var thisDay = date.getDay(),
	    thisDay = myDays[thisDay];
	var yy = date.getYear();
	var year = (yy < 1000) ? yy + 1900 : yy;

	var a_p = "";
    var today = new Date();
    var curr_hour = today.getHours();
    var curr_minute = today.getMinutes();
    var curr_second = today.getSeconds();
    /* if (curr_hour < 12) {
        a_p = "AM";
    } else {
        a_p = "PM";
    }
    if (curr_hour == 0) {
        curr_hour = 12;
    }
    if (curr_hour > 12) {
        curr_hour = curr_hour - 12;
    } */
    curr_hour = checkTime(curr_hour);
    curr_minute = checkTime(curr_minute);
    curr_second = checkTime(curr_second);
	


	xV = (thisDay + ', ' + day + ' ' + months[month] + ' ' + year + ' - ' + curr_hour + ":" + curr_minute + ":" + curr_second + " " + a_p);

	document.getElementById("xClock").innerHTML = xV;
	setTimeout("xClock()", 1000);
}
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function vClock(v) {
	return (v > 9) ? "" + v : "0" + v;
}
function addLoadEvent(func) {
	var oldonload = window.onload;
	if (typeof window.onload != 'function') {
		window.onload = func;
	} else {
		window.onload = function () {
			if (oldonload) {
				oldonload();
			}
			func();
		}
	}
}
addLoadEvent(xClock);