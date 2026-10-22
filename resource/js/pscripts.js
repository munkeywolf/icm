$(document).ready(function(){
    $('#byDate').datepicker({
        format: "yyyy-mm-dd",
        autoclose:true,
        todayHighlight:true,
        todayBtn: "linked",
        clearBtn:true
    });

/***************************************************************************************************************/

    $('#viewReport').submit(function(e){
    	e.preventDefault();
    	$("#printDiv").html('<div style="text-align:center;margin-top:50px;"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span>Loading...</span></div>');
    	
        //var no = document.getElementById("atSchoolYear");
        //var selOption = no.options[no.selectedIndex].text;
        var selOption = $('#atSchoolYear').children("option:selected").text();
    	var atSchYr = selOption.trim().split(/[-]/);
    	var schYr = atSchYr[0].trim();
        var bySem = $('input[name="bySem"]:checked').val();
        var byDate = $('#byDate').val().trim();
        var sID = $('#byStud').val();

        
        // var selSY = document.getElementById("atSchoolYear").value;
        // selSY = option;
        
        console.log(bySem+" sem");

        var sY = "School Year: "+selOption;
     
            if(bySem == 1){
                var sPer = "Semester: First Semester";
            }if(bySem == 2){
                var sPer = "Semester: Second Semester";
            }if(bySem == 3){
                var sPer = "Semester: Summer";
            }

        var reportHeader = '<p><b>Visayas State University</b></p><p><b>Department of Computer Science and Technology</b></p>'
                            +'<p><b>Internet Cafe Users</b></p>';

        if(bySem != undefined && byDate == '' && (sID == undefined || sID == ''))
        {
            var basicInfo = '<p id="sy"></p><p id="semest"></p>';
            var reportTable = '<table align="center" id="printTable">'
                    +'<thead>'
                        +'<tr>'
                        +'<th></th><th>StudentID</th><th>Name</th><th>Consumed</th>'
                        +'<th>Remaining Bal</th>'
                        +'</tr>'
                    +'</thead>'
                    +'<tbody>';

            $.ajax({
                type:'POST',
                url:'../controller/crudManager.php',
                data: 
                    {
                        action:"viewBySem",
                        schYr:schYr,
                        Sem:bySem
                    },
                    
                success:function(result)
                    {
                        var data = jQuery.parseJSON(result);

                        if(data.length > 0){
                            
                            var ctr = 1;

                            for(var i = 0;i<data.length;i++){
                                var name = nameChecker(data[i]['lastName'],data[i]['firstName'],data[i]['middleName']);    
                                reportTable = reportTable + '<tr><td>'+ctr+'</td><td>'+data[i]['studentID']+'</td>'
                                            +'<td>'+name.ln+", "+name.fn+" "+name.mi+'</td>'
                                            +'<td>'+data[i]['consumedTime']+'</td><td>'+data[i]['currentCredit']+'</td></tr>';
                                ctr++;
                            }

                            reportTable = reportTable + '</tbody></table>';
                            document.getElementById('printDiv').innerHTML = reportHeader + basicInfo + reportTable;
                            document.getElementById('sy').innerHTML = sY;
                            document.getElementById('semest').innerHTML = sPer;
                        }
                        else
                        {
                            reportTable = reportTable +'<tr><td colspan="5">No Transaction!</td></tr>'
                                                    +'</tbody></table>';
                            document.getElementById('printDiv').innerHTML = reportHeader + basicInfo + reportTable;
                            document.getElementById('sy').innerHTML = sY;
                            document.getElementById('semest').innerHTML = sPer;
                        }
                    }
            });                                      
        }
        else if(bySem != undefined && byDate != '' && (sID == undefined || sID == ''))
        {
            var basicInfo = '<p id="sy"></p><p id="semest"></p><p id="dated"></p>';
            var reportTable = '<table align="center" id="printTable">'
                                +'<thead>'
                                    +'<tr>'
                                    +'<th></th><th>StudentID</th><th>Name</th><th>Consumed</th>'
                                    +'<th>Remaining Bal</th>'
                                    +'</tr>'
                                +'</thead>'
                                +'<tbody>';

            $.ajax({
                type:'POST',
                url:'../controller/crudManager.php',
                data: 
                    {
                        action:"viewByDate",
                        schYr:schYr,
                        Sem:bySem,
                        Date:byDate
                    },
                    
                success:function(result)
                    {
                        var data = jQuery.parseJSON(result);

                        if(data.length > 0){
                            var ctr = 1;
                            
                            for(var i = 0;i<data.length;i++){
                                var name = nameChecker(data[i]['lastName'],data[i]['firstName'],data[i]['middleName']);    
                                reportTable = reportTable + '<tr><td>'+ctr+'</td><td>'+data[i]['studentID']+'</td>'
                                            +'<td>'+name.ln+", "+name.fn+" "+name.mi+'</td>'
                                            +'<td>'+data[i]['consumedTime']+'</td><td>'+data[i]['currentCredit']+'</td></tr>';
                                ctr++;
                            }

                            reportTable = reportTable + '</tbody></table>';
                            document.getElementById('printDiv').innerHTML = reportHeader + basicInfo + reportTable;
                            document.getElementById('sy').innerHTML = sY;
                            document.getElementById('semest').innerHTML = sPer;
                            document.getElementById('dated').innerHTML = byDate;
                        }   
                        else
                        {
                            reportTable = reportTable +'<tr><td colspan="5">No Transaction!</td></tr>'       
                                                +'</tbody></table>';
                            document.getElementById('printDiv').innerHTML = reportHeader + basicInfo + reportTable;
                            document.getElementById('sy').innerHTML = sY;
                            document.getElementById('semest').innerHTML = sPer;
                            document.getElementById('dated').innerHTML = byDate;
                        }                                 
                    }
            });
        }
        else if(bySem != undefined && byDate == '' && (sID != undefined || sID != ''))
        {
        	var basicInfo = '<div class="row userD"><div class="pull-left"><p id="stdName"></p><p id="stdID"></p></div><div class="pull-right"><p id="syd"></p><p id="semest"></p></div></div>';
            var reportTable = '<div class="row kin"><table align="center" id="byIDtable">'
                                +'<thead>'
                                    +'<tr>'
                                    +'<th></th><th id="y">Log In</th><th>Log Out</th><th>Consumed</th>'
                                    +'<th>Remaining Bal</th>'
                                    +'</tr>'
                                +'</thead>'
                                +'<tbody>';
            
            $.ajax({
                type:'POST',
                url:'../controller/crudManager.php',
                data:
                    {
                        action:"viewByID",
                        schYr:schYr,
                        Sem:bySem,
                        ID:sID
                    },
                success:function(result)
                    {
                        var data = jQuery.parseJSON(result);
                        var name = nameChecker(data[0]['lastName'],data[0]['firstName'],data[0]['middleName']);
                        var transact = data[1];

                        if(transact.length > 0)
                        {
                            var ctr = 1;
                            for(var a = 0; a < transact.length; a++)
                            {
                                reportTable = reportTable + '<tr>'
                                                +'<td>'+ctr+'</td>'
                                                +'<td>'+transact[a]['entryDate']+'</td>'
                                                +'<td>'+transact[a]['logoutDate']+'</td>'
                                                +'<td>'+transact[a]['consumedTime']+'</td>'
                                                +'<td>'+transact[a]['currentCredit']+'</td>'
                                                +'</tr>';
                                ctr++;
                            }

                            reportTable = reportTable + '</tbody></table></div>';
                            document.getElementById('printDiv').innerHTML = reportHeader + basicInfo + reportTable;
                            document.getElementById('stdName').innerHTML = name.ln+", "+name.fn+" "+name.mi;
                            document.getElementById('stdID').innerHTML = sID;
                            document.getElementById('syd').innerHTML = sY;
                            document.getElementById('semest').innerHTML = sPer;
                        }else
                        {
                            reportTable = reportTable +'<tr><td colspan="5">No Transaction!</td></tr>'       
                                                +'</tbody></table>';
                            document.getElementById('printDiv').innerHTML = reportHeader + basicInfo + reportTable;
                            document.getElementById('stdName').innerHTML = name.ln+", "+name.fn+" "+name.mi;
                            document.getElementById('stdID').innerHTML = sID;
                            document.getElementById('syd').innerHTML = sY;
                            document.getElementById('semest').innerHTML = sPer;
                        }
                    }
            });

        }


        else
        {
        	alert("Please Choose a Semester!");
        }


 

        
    });

/*******************************************************************************************************************/

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

    // $(document).on("click","#printDiv",function(){
       
    //     window.print();
    // });

});