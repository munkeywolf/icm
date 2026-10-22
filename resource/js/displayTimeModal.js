DisplayTimeModal();

setInterval(function(){DisplayTimeModal()},1000);
function DisplayTimeModal(){
	var CurrentDate=new Date();
	var hours=CurrentDate.getHours();
	var minutes=CurrentDate.getMinutes();
	var seconds=CurrentDate.getSeconds();
	var DayNight="PM";
		if (hours<12) DayNight="AM";
		if (hours>12) hours=hours-12;
		if (hours==0) hours=12;
		if (minutes<=9) minutes="0"+minutes;
		if (seconds<=9) seconds="0"+seconds;
	var currentTime=hours+":"+minutes+":"+seconds+" "+DayNight;
	document.getElementById('curTime').innerHTML = "<b>"+currentTime+"</b>";
}