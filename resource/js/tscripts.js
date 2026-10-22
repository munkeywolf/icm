$(document).ready(function(){
/********************************************************************************************************************************/
	showLoggedInStudents();
    // var interval = null;
// **********************************************************Search Student******************************************************
    $('#search-field').keypress(function(event){
        var code = (event.keyCode ? event.keyCode : event.which);
        if (!(
                    (code >= 48 && code <= 57) //numbers
                   || (code == 45)  || (code == 8) || (code ==37)|| (code ==39) || (code == 46)
            )
            ){
                event.preventDefault();
            }
        if(code == 13){
            event.preventDefault();
           
            var check = /^[\d]{2}[\-]{1}[\d]{1}[\-]{1}[\d]{3,5}$/;

            if(check.test($(this).val())){
            	$("#searchStudent").submit();
            }else{
            	alert("Invalid Student Number! Please check input!");
            }
        }
    });
                                        

    $('#searchStudent').submit(function(e){
            e.preventDefault();
            var searchID = $('#search-field').val();
            $('#compNum').val('');
        $.ajax({
            type:'POST',
            url: '../controller/crudManager.php',
            data: {
            	action:"findStudent",
            	searchID:searchID
            },
            
            success: function (result) {
                console.log(result);
                var datas = jQuery.parseJSON(result);
      
                $('#loginSubmit').prop('disabled',true);
                if(datas[0] == "enrol"){
                    var sData = datas[1];
                    var name = nameChecker(sData['lastName'],sData['firstName'],sData['middleName']);
                    var balFormat = balToTime(sData['balance']);
                    var credRem = balFormat.hr + " Hr | " + balFormat.min + " Min | " + balFormat.sec + " Sec";
                    var nameFormat = "<tr><td>"+sData['studentID']+"</td><td>"+name.ln+", "+name.fn+" "+name.mi+"</td></tr>";

                        var studDetails = '<input name="stdid" id="stdid" type="hidden" value='+sData['studentID']+'>'
                                        +'<input name="isconsumed" id="isconsumed" type="hidden" value='+sData['is_consumed']+'>'
                                        +'<input name="isonline" id="isonline" type="hidden" value='+sData['is_online']+'>'
                                        +'<p>'+sData['studentID']+'</p>'
                                        +'<p>'+name.ln+', '+name.fn+' '+name.mi+'</p>'
                                        +'<p>Credit Remaining: '+credRem+'</p>'
                                        //+'<input id="valid" type="hidden" value="1">';
                
                    document.getElementById('searchResult').innerHTML = nameFormat;                    
                    document.getElementById('studentDetails').innerHTML = studDetails;

                    if(sData['is_consumed'] == 0 && sData['is_online'] == 0){
                       $('.currentTerm').html($('<p></p>').attr({"class":"btn-success","style":"padding-left:10px"})
                            .text("Please Enjoy Your Free Internet!"));
                       // $('.modal-body').attr("style","height:565px");
                   
                    }else if(sData['is_consumed'] == 1 && sData['is_online'] == 0){
                        $('.currentTerm').html($('<p></p>').attr({"class":"btn-danger","style":"padding-left:10px"})
                            .text("Balance has been consumed for this semester!"));
                        //$('.modal-body').attr("style","height:565px");
                    }else{
                        $('.currentTerm').html($('<p></p>').attr({"class":"btn-warning","style":"padding-left:10px"})
                            .text("***This Student is Currently LOGGED IN!"));
                        //$('.modal-body').attr("style","height:565px");
                    }
                                   
                    transactionHistory(searchID,name);
                }   
                else if(datas[0] == "acc"){
                    var aData = datas[1];
                    var name = nameChecker(aData['lastName'],aData['firstName'],aData['middleName']);
                    var credRem = "00 Hr | 00 Min | 00 Sec";
                    //var cR = balToTime(aData['bal']);
                    //var credRemain = cR.hr + " Hr | " + cR.min + " Min | " + cR.sec + " Sec";
                    var nameFormat = "<tr><td>"+aData['studentID']+"</td><td>"+name.ln+", "+name.fn+" "+name.mi+"</td></tr>";
                    var studDetails = '<input name="stdid" id="stdid" type="hidden" value='+aData['studentID']+'>'
                                        +'<input type="hidden" value="">'
                                        +'<input type="hidden" value="">'
                                        +'<p>'+aData['studentID']+'<button type="button" class="btn btn-xs btn-primary" id="btnUpdateAccount">Update</button></p>'
                                        +'<p>'+name.ln+', '+name.fn+' '+name.mi+'</p>'
                                        +'<p>Credit Remaining: '+credRem+'</p>';

                    document.getElementById('searchResult').innerHTML = nameFormat;                    
                    document.getElementById('studentDetails').innerHTML = studDetails;
                    $('.currentTerm').html($('<p></p>').attr({"class":"btn-danger","style":"padding-left:10px"})
                        .text("This Student Is Currently Not Enrolled!"));    
                    //$('.modal-body').attr("style","height:565px");      

                    transactionHistory(searchID,name);       
                }   
                else{
                        document.getElementById('searchResult').innerHTML = '<tr><td colspan="2" style="color:red;">No Student Was Found</td></tr>';
                        document.getElementById('studentDetails').innerHTML = '';
                        document.getElementById('transactionLabel').innerHTML = '';
                        document.getElementById('studentTransactionHistory').innerHTML = '';
                        document.getElementById('balStat').innerHTML = ''  
                        //$('.modal-body').attr("style","height:535px");  
                }

            }//success
        });//go ajax
    });//submit go
/*************************************************************************************************************************************************/
   $('#loginStudentTransactionForm').submit(
       function(e){
        e.preventDefault();
        var stid = $('#stdid').val();
        var compno = $('#compNum').val();

            $.ajax({
                type:'POST',
                url:'../controller/crudManager.php',
                data:
                    {
                        action:"createTransaction",
                        id:stid,
                        compno:compno
                    },

                success:function(result)
                    {
                        if(result == 1){
                            $("#search-field").val('').focus();
                            clearAll();
                            showLoggedInStudents();
                            showPCList();
                            $('#loginSubmit').prop('disabled',true);
                        }else{
                            alert(result);
                        }
                    }
            });
        
   });
/*************************************************************************************************************************************************/
    function showLoggedInStudents()
    {
        $.ajax({
            type:'POST',
            url:'../controller/crudManager.php',
            data:
                {
                    action:"showLoggedIn",
                },
            success:function(result){
                var dataArr = jQuery.parseJSON(result);
                document.getElementById('count').innerHTML = dataArr.length;

                if(dataArr.length > 0)
                    {
                        var onlineList = '';

                        for(var i = 0;i<dataArr.length;i++)
                        {

                            var entryTimeExpire =  toReadableEntryAndExpire(dataArr[i]['entryDate'],dataArr[i]['balance']);
                                
                            var balfix = dataArr[i]['balance'];
                            var tostr = balfix.toString();
                            if(tostr.length == 1 || tostr.length == 2){
                                var substr = tostr+".00";    
                            }else{
                                var substr = tostr.substring(0,5);
                            }
                            var name = nameChecker(dataArr[i]['lastName'],dataArr[i]['firstName'],dataArr[i]['middleName']);
                            
                            onlineList += '<tr>'
                                            +'<td id="ocompID">'+dataArr[i]['compID']+'</td>'
                                            +'<td>'+dataArr[i]['studentID']+'</td>'
                                            +'<td>'+entryTimeExpire.entry+'</td>'
                                            +'<td id="hot">'+name.ln+', '+name.fn+' '+name.mi
                                                +'<a href="Javascript:void(0)" class="btn btn-xs btn-danger" id="logoutPopup" data-idstud="'+dataArr[i]['studentID']+'" data-toggle="modal" data-target="#logoutModal">'
                                                +'<i class="fa fa-sign-out fa-lg"></i>&nbsp;Log Out</a>'
                                            +'</td>'
                                            +'<td>'+substr+'</td>'
                                            +'<td id="toes"></td>'
                                            +'<td>'+entryTimeExpire.expire+'</td>'
                                        +'</tr>';
                            
                        }
                        document.getElementById('ONLINElist').innerHTML = onlineList;

                            $("[id=hot]").hover(function(){
                                var td = $(this);
                                $(this).css("font-size","18px");
                                
                            },function(){
                                var td = $(this);
                                $(this).css("font-size","16px");
                                
                            });
     

                            displayTimeleft();
                    }
                    else{
                        clearInterval(myInterval);
                        document.getElementById('ONLINEtable').rows[0].style.backgroundColor = "white";
                        document.getElementById('ONLINEtable').rows[0].style.color = "black";
                        document.getElementById('ONLINElist').innerHTML = '';
                    } 
            }
        });
    }
/*************************************************************************************************************************************************/

        var myInterval = setInterval(function(){displayTimeleft()},10000);
            function displayTimeleft(){
                $.ajax({
                    type:'POST',
                    url:'../controller/crudManager.php',
                    data:
                        {
                            action:"balanceAndEntry",
                        },
                        success:function(result)
                        {
                            var balent = jQuery.parseJSON(result);
                            var zero = false;  

                            var zeroBal = [];
                            if(balent.length > 0){    
                                var timeLeftArr = [];    

                                for(var j = 0; j<balent.length;j++){
                                   
                                    var dt = balent[j]['entryDate'].split(/[- :]/);

                                    var hrentry = (parseInt(dt[3],10) * 60) * 60;
                                    var minentry = parseInt(dt[4],10) * 60;
                                    var secentry = parseInt(dt[5],10);

                                    var entrySUM = hrentry + minentry + secentry;
                                    var entryFloat = (entrySUM / 60) / 60;

                                    var d = new Date();
                                    var newHR = (d.getHours() * 60) * 60;
                                    var newMIN = d.getMinutes() * 60;
                                    var newSEC = d.getSeconds();

                                    var timeSUM = newHR + newMIN + newSEC;
                                    var timeFloat = (timeSUM / 60) / 60;

                                    var balconsumed = timeFloat - entryFloat;
                                    var timeleft = balent[j]['balance'] - balconsumed;

                                    if(balconsumed >= balent[j]['balance']){
                                        timeleft = 0;
                                        zero = true;
                                        zeroBal.push(j);
                                    }

                                    var newtimeleft = timeleft.toString();

                                    timeLeftArr.push(newtimeleft.substring(0,7));
                                    
                                    document.getElementById("ONLINElist").rows[j].cells[5].innerHTML = timeLeftArr[j];  

                                    if(zero == true){
                                        for(var r = 0; r<zeroBal.length;r++){
                                            document.getElementById("ONLINElist").rows[zeroBal[r]].style.backgroundColor = "red";
                                            document.getElementById("ONLINElist").rows[zeroBal[r]].style.color = "white";
                                        }
                                        document.getElementById('ONLINEtable').rows[0].style.backgroundColor = "red";
                                        document.getElementById('ONLINEtable').rows[0].style.color = "white";
                                    }else{
                                         document.getElementById('ONLINEtable').rows[0].style.backgroundColor = "white";
                                         document.getElementById('ONLINEtable').rows[0].style.color = "black";
                                    }
                                    
                                } //for loop  
                                
                            }else{
                                clearInterval(myInterval);
                                document.getElementById('ONLINEtable').rows[0].style.backgroundColor = "white";
                                document.getElementById('ONLINEtable').rows[0].style.color = "black";
                            }            
                        }
                    });
                            
                            
            }//displayTimeleft()


        
/*************************************************************************************************************************************************/
            $(document).on("click", "#logoutPopup", function(){
                var stdidout = $(this).data('idstud');

                    $.ajax({
                        type: 'POST',
                        url: '../controller/crudManager.php',
                        data:{
                            action:"forLogoutInfo",
                            studid:stdidout
                        },
                        success: function(result){
                            var logData = jQuery.parseJSON(result);

                            $('#Ostid').val(logData['studentID']);
                            $('#Ocompid').val(logData['compID']);
                            $('#Ostudnum').val(logData['studentID']);
                            $('#OentryDate').val(logData['entryDate']);
                        
                            var ldt = logData['entryDate'].split(/[- :]/);
                            var name = nameChecker(logData['lastName'],logData['firstName'],logData['middleName']);
                            var ODayNight = "PM";
                                                        
                            if(ldt[3]<12){
                              ODayNight = "AM";
                            }
                                                       
                            $('#Ostudname').val(name.ln+", "+name.fn+" "+name.mi);
                            $('#Ologindate').val(logData['entryDate']+" "+ODayNight);

                            var now = new Date();
           
                            var lYear = now.getFullYear();
                            var lMonth = now.getMonth()+1;
                            var lDay = now.getDate();
                            var lHour = now.getHours();
                            var lMin = now.getMinutes();
                            var lSec = now.getSeconds();

                            if(lMonth < 10 && lMonth > 0)
                            {
                                lMonth = "0"+lMonth;
                            }
                            if(lDay < 10 && lDay > 0)
                            {
                                lDay = "0"+lDay;
                            }
                            if(lHour < 10 && lHour > 0)
                            {
                                lHour = "0"+lHour;
                            }
                            if(lMin < 10 && lMin > 0)
                            {                
                                lMin = "0"+lMin;
                            }
                            if(lSec < 10 && lSec > 0)
                            {                
                                lSec = "0"+lSec;
                            }

                            $('#timeout').val(lYear+"-"+lMonth+"-"+lDay+" "+lHour+":"+lMin+":"+lSec);

                            var tC = timeToBal(ldt[3],ldt[4],ldt[5],lHour,lMin,lSec);

                            var entryTimeBal = tC.eB;
                            var logoutTimeBal = tC.lB;

                            if(logoutTimeBal <= entryTimeBal)
                            {
                                var consumedBal = 0;                                                
                            }else
                            {
                                var consumedBal = logoutTimeBal - entryTimeBal;
                            }

                            var sBal = parseFloat(logData['balance']);

                            if(consumedBal > sBal)
                            {
                                consumedBal = sBal;
                            }
                            
                            $('#originalBal').val(logData['balance']);
                            $('#hiddenConsumedBal').val(consumedBal);

                            var ObalObj = balToTime(consumedBal);
                            var Obalfloor = ObalObj.hr;
                            var OMINfloor = ObalObj.min;
                            var OSECfloor = ObalObj.sec;

                            // if (Obalfloor <= 9 && Obalfloor >= 0)
                            // {
                            //     Obalfloor = "0"+Obalfloor;
                            // }
                            // if (OMINfloor <= 9 && OMINfloor >= 0)
                            // {
                            //     OMINfloor = "0"+OMINfloor;
                            // }
                            // if (OSECfloor <= 9 && OSECfloor >= 0)
                            // {
                            //     OSECfloor = "0"+OSECfloor;
                            // }

                            var consumedFormat = Obalfloor+" Hrs | "+OMINfloor+" Min | "+OSECfloor+" Sec";

                            document.getElementById('consumed').innerHTML = consumedFormat;

                            var consumedTime = Obalfloor+":"+OMINfloor+":"+OSECfloor;
                            $('#hiddenConsumedTime').val(consumedTime);

                            var remainingBal = sBal - consumedBal;

                                if(remainingBal <= 0){
                                    remainingBal = 0;
                                }

                            $('#hiddenRemaining').val(remainingBal);

                            var RbalObj = balToTime(remainingBal);
                            var Rbalfloor = RbalObj.hr;
                            var RMINfloor = RbalObj.min;
                            var RSECfloor = RbalObj.sec;

                                if (Rbalfloor <= 9 && Rbalfloor > 0) 
                                {
                                    Rbalfloor = "0"+Rbalfloor;
                                }

                            var remainingFormat = Rbalfloor+" Hrs | "+RMINfloor+" Min | "+RSECfloor+" Sec";
                            document.getElementById('BALleft').innerHTML = remainingFormat;          

                        }    
                    });                        
 
            });

/*************************************************************************************************************************************************/
    $('#logout-form').submit(function(e){
        e.preventDefault();
        var Oid = $('#Ostid').val();
        var Ocid = $('#Ocompid').val();
        var Oentry = $('#OentryDate').val();
        var OrigBal = $('#originalBal').val();
        var cBal = $('#hiddenConsumedBal').val();
        var hiddenC = $('#hiddenConsumedTime').val();
        var hiddenR = $('#hiddenRemaining').val();
        var timeOut = $('#timeout').val();

        $.ajax({
            type:'POST',
            url:'../controller/crudManager.php',
            data:{
                action:"logoutStudent",
                sID:Oid,
                cID:Ocid,
                entry:Oentry,
                origB:OrigBal,
                cBal:cBal,
                cTime:hiddenC,
                rBal:hiddenR,
                outTime:timeOut
            },
            success:function(result){
                console.log(result);
                // clearInterval(myInterval);
                showLoggedInStudents();
                showPCList();
                $('#logoutModal').modal('hide');    
                }
        });
    });
/*************************************************************************************************************************************************/
    $(document).on("click","#btnUpdateAccount",function(e)
    {
        e.preventDefault();
        var studIDd = $('#stdid').val();
            
            $.ajax({
                type:'POST',
                url:'../controller/crudManager.php',
                data:
                    {
                        action:"addToEnrolled",
                        studid:studIDd
                    },
                success:function(result)
                    {
                        console.log(result);
                        if(result == 1){
                            $('#searchStudent').submit();
                        }
                    },
                error:function(result){
                    alert("Error in button Update"+result);
                }
            });
    });

/*************************************************************************************************************************************************/

	function showPCList()
    {
		$.ajax({
			type:'POST',
			url:"../controller/crudManager.php",
			data:{
				action:"pcList"
			},

				success:function(result){
					$('#compNum').html(result);
				}
		});
	}
/*************************************************************************************************************************************************/
    $(document).on("change","#compNum",function(e)
    {
        e.preventDefault();
        if($(this).val() != '' && $('#isconsumed').val() != 1 && $('#isonline').val() != 1)
            {
                $('#loginSubmit').prop('disabled',false); 
            }
        else{
            $('#loginSubmit').prop('disabled',true); 
        }

    });
/*************************************************************************************************************************************************/
    $(document).on("click","#clearLogin",function(e)
    {
        e.preventDefault();
        $('#search-field').val('');
        clearAll();
        $('#compNum').val('');
        $('#loginSubmit').prop('disabled',true); 

    });
/*************************************************************************************************************************************************/

	$('#loginModal').on('shown.bs.modal', function () {

		$('#search-field').focus();
		$('.currentTerm').html($('<p></p>').attr({"class":"btn-info","style":"padding-left:10px"})
                            .text("Current Term: Summer 2017-2018"));
		showPCList();
		
        $('#loginSubmit').prop('disabled',true);
	});

	$('#loginModal').on("hidden.bs.modal", function () {
		$(this)
            .find("input,textarea,select")
                .val('')
                    .end();

        clearAll();
                    
	});

    $('#logoutModal').on("hidden.bs.modal",function(){
                    $('#Ostid').val('');
                    $('#Ocompid').val('');
                    $('#OentryDate').val('');
                    $('#Ostudnum').val('');
                    $('#Ostudname').val('');
                    $('#Ologindate').val('');
                    $('#timeout').val('');
                    $('#hiddenConsumedBal').val('');
                    $('#hiddenConsumedTime').val('');
                    $('#hiddenRemaining').val('');
                    $('#consumed').val('');
                    $('#BALleft').val('');
                    //getPClist();
    });

/*************************************************************************************************************************************************/



/*************************************************************************************************************************************************/
    function nameChecker(lname,fname,mname){
        var LN = (lname == null || lname == '')?'':lname;
        var FN = (fname == null || fname == '')?'':fname;
        var MI = (mname == null || mname == '')?'':mname.substring(0,1)+".";
        return {
            ln:LN,
            fn:FN,
            mi:MI
        };
    }
    function balToTime(bal){
        var BALfloor = Math.floor(bal);
        var HRtoSEC = (BALfloor * 60) * 60;
        var MINfraction = bal - BALfloor;
        var MINtoSEC = MINfraction * 60;
        var MINfloor = Math.floor(MINtoSEC);
        var SECfraction = MINtoSEC - MINfloor;
        var SEC = SECfraction * 60;
        var SECfloor = Math.floor(SEC);       

        if (BALfloor==0) BALfloor="0"+BALfloor;
        if (MINfloor<=9) MINfloor="0"+MINfloor;
        if (SECfloor<=9) SECfloor="0"+SECfloor;

        return {
                    hr : BALfloor,
                    min: MINfloor,
                    sec : SECfloor
                };
    }
    function timeToBal(hr,min,sec,hr2,min2,sec2){
        var EHr = (parseInt(hr) * 60) * 60;
        var EMin = parseInt(min) * 60;
        var ESec = parseInt(sec);
        var entrySum = parseInt(EHr) + parseInt(EMin) + parseInt(ESec);
        var entryBal = (entrySum / 60) / 60;

        var OHr = (parseInt(hr2) * 60) * 60;
        var OMin = parseInt(min2) * 60;
        var OSec = parseInt(sec2);
        var logoutSum = parseInt(OHr) + parseInt(OMin) + parseInt(OSec);
        var logoutBal = (logoutSum / 60) / 60;
    
        return {
            eB:entryBal,
            lB:logoutBal
        }
    }

    function toReadableEntryAndExpire(date, bal)
    {
        
        var dt = date.split(/[- :]/);

        var DayNight = "PM";
        
        var hourFIXED = parseInt(dt[3],10);
        dt[3] = hourFIXED;
        
        if(dt[3] > 0 && dt[3] < 12)
        {
            DayNight = "AM";
        }else if(dt[3] > 0 && dt[3] > 12 && hourFIXED > 12)
        {
            dt[3] = dt[3] - 12;
        }

        if(dt[3] > 0 && dt[3] < 10)
        {
            dt[3] = "0"+dt[3];
        }
        
        var entry = dt[1]+'/'+dt[2]+'/'+dt[0]+' '+dt[3]+':'+dt[4]+':'+dt[5]+' '+DayNight;
    
        var balObj = balToTime(bal);

        var HRexpire = hourFIXED + parseInt(balObj.hr,10);
        var MINexpire = parseInt(dt[4],10) + parseInt(balObj.min,10);
        var SECexpire = parseInt(dt[5],10) + parseInt(balObj.sec,10);

        var exDayNight = "PM";
        
        if(SECexpire >= 60){
            SECexpire = SECexpire - 60;
            MINexpire++;
        }

        if (MINexpire >= 60) {
            MINexpire = MINexpire - 60;
            HRexpire++;
        }

        if(HRexpire >= 24){
            HRexpire = HRexpire - 24;
        }

        if(HRexpire > 12 && HRexpire < 24){
            HRexpire = HRexpire - 12;
        }

        if(HRexpire < 12){
            exDayNight = "AM";
        }

        if(HRexpire == 0){
            HRexpire = 12;
        }

        if(HRexpire < 10 && HRexpire >= 0){
           
            HRexpire = "0"+HRexpire;
        }

        if (MINexpire < 10 && MINexpire >= 0) {
        
            MINexpire = "0"+MINexpire;
        }

        if (SECexpire < 10 && SECexpire >= 0) {
            
            SECexpire = "0"+SECexpire;
        }

        var timeExpire = HRexpire.toString() + ":" + MINexpire.toString() + ":" + SECexpire.toString() + " " + exDayNight;

        return {
                    entry:entry,
                    expire:timeExpire
                };
    }

    function clearAll(){
        document.getElementById('searchResult').innerHTML = '';
        document.getElementById('studentDetails').innerHTML = '';
        document.getElementById('balStat').innerHTML = '';
        document.getElementById('transactionLabel').innerHTML = '';
        document.getElementById('studentTransactionHistory').innerHTML = '';
		$('.currentTerm').html($('<p></p>').attr({"class":"btn-info","style":"padding-left:10px"})
                            .text("Current Term: Second Semester 2017-2018"));
        //$('.login-body').attr("style","height:535px");
    }

    function transactionHistory(id,name)
    {
        document.getElementById('transactionLabel').innerHTML = name.ln+", "+name.fn+"\'s Transaction History";
        $.ajax({
            type:'POST',
            url:"../controller/crudManager.php",
            data:
            {
                action:"transhistory",
                IDhist:id
            },

            success:function(result)
            {
                var trans = jQuery.parseJSON(result);
                
                if(trans.length >0)
                {
                    var translist = '';
                    for(var k = 0; k<trans.length;k++)
                    {   
                        translist += '<tr>'
                                    +'<td>'+trans[k]['compID']+'</td>'
                                    +'<td>'+trans[k]['entryDate']+'</td>'
                                    +'<td>'+trans[k]['logoutDate']+'</td>'
                                    +'<td>'+trans[k]['consumedTime']+'</td>'
                                    +'<td>'+trans[k]['consumedBal']+'</td>'
                                    +'</tr>';
                    }
                    document.getElementById('studentTransactionHistory').innerHTML = translist;
                }
                else
                {
                    document.getElementById('studentTransactionHistory').innerHTML = '<tr><td colspan="5" id="notrans" style="color:red;">No Transaction Was Found</td></tr>';
                }

            }
        });
    }

});

