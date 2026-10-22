		$(document).ready(function(){
            //console.log($.fn.jquery);
			$("#LISTNAME_search_txt").keypress(function(e){             
	            if(e.which == 13){//keyCode
	                e.preventDefault();
	                $("#LISTNAME_search_btn").click();
	            }
	        });
	        
	        $("#LISTNAME_search_btn").click(function(){showStudentList('');});
	        //--- start navigation btn
	        $("#nav_first").click(function(e){showStudentList('first');});
	        $("#nav_prev").click(function(e){showStudentList('prev');});
	        $("#nav_next").click(function(e){showStudentList('next');});
	        $("#nav_last").click(function(e){showStudentList('last');});

	        $("#nav_rowsPerPage").change(function(e){showStudentList('');});
	        $("#nav_currentPage").change(function(e){showStudentList('goto');});
	        //--- end navigation btn
	        //SHOW LIST WHEN CALLED BY OTHER BUTTON [ADD NEW ITEM, THEN RELOAD LIST]
			$("#LISTNAME_frm").submit(function(){showStudentList(); return false;});                     
	        //START SHOWING LIST                
	            
	             showStudentList('');                      
	        	// START LIST FUNCTION

				function showStudentList(navAction){
					$("#nav_info").html('<span><img src="../resource/images/loading.gif" width="16" />&nbsp;&nbsp;&nbsp;Loading...</span>');
					var searchKeyword=$("#LISTNAME_search_txt").val();
					var selectOption = $("#selectOption").val();
					var currentPage = $("#nav_currentPage").val();//($("#nav_currentPage").val() == null)?1:
                    if(currentPage === null){
                        currentPage = 1;
                    }else{
                        currentPage = parseInt(currentPage);
                    }
					var rowsPerPage = parseInt($("#nav_rowsPerPage").val());
				    //console.log(currentPage+" shit "+rowsPerPage);
                    //console.log(rowsPerPage);
					$.ajax({
						type:'POST',
						url:'../controller/crudManager.php',
						data:{keyword:searchKeyword,
                              searchOption:selectOption,
                                currentPage:currentPage,
                                rowsPerPage:rowsPerPage,
                                navAction:navAction,
                                tblCol:7,action:"studentList"},
						success:function(result){
							var datas = jQuery.parseJSON(result);
                            
							$("#LISTNAME_tbl tbody").html(datas.list);
                            //select or focus the target page
                            $("#nav_currentPage").val(datas.targetPage);
                            //check if action is refresh, then reload the GOTO list
                            if(navAction=='refresh' || navAction==''){
                                //empty the list
                                $('#nav_currentPage').empty();
                                //append option item with value to select list
                                $.each(datas.gotoSelectNum, 
                                    function(key, value) {   
                                        if(value === '' || value === null){
                                            delete sjonObj[key];
                                        }
                                        $('#nav_currentPage')
                                        .append($("<option></option>")
                                        .attr("value",value)
                                        .text(value)); 
                                });                                	
                            }
                            if(datas.totalPages==0){
                                $("#nav_info").html('<i class="fa fa-file-o"></i>&nbsp;&nbsp;&nbsp;List Empty');
                            }
                            else{
                                $("#nav_info").html('<i class="fa fa-file-o"></i>&nbsp;&nbsp;&nbsp;Page '+datas.targetPage+' of '+datas.totalPages);
                            } 

                            $.each(datas.nav_btn_disable,
	                            function (key, jdata) {
	                                if(jdata==1){
	                                    $("#"+key).prop('disabled',false);//.removeClass('disabled');
	                                }
	                                else{
	                                    $("#"+key).prop('disabled',true);//.addClass('disabled');
	                                }
                    		});  

						}
					});
				}
            //end showStudentList function

            $('#addStudentForm').submit(function(event){
                event.preventDefault();

                var lname = $('#add-lastname').val();
                var fname = $('#add-firstname').val();
                var mname = $('#add-mi').val();
                var studid = $('#add-studnum').val();
                var gender = $('#add-gender').val();
                var action = "addStudent";
                    $.ajax({
                        type:'POST',
                        url:'../controller/crudManager.php',
                        data:{action:action,lname:lname,fname:fname,mname:mname,studid:studid,gender:gender},

                        success:function(result){
                            var data = jQuery.parseJSON(result);

                            if(data[0] == 1 && data[1] == 1){
                                showStudentList('last');
                                $('#add-modal').modal('hide');
                            }
                        }
                    });

            });

            $('#add-modal').on("hidden.bs.modal", function () {
              $(this)
                .find("input,textarea,select")
                   .val('')
                   .end();
            });

            $(document).on("click","#btnEdit",function(){
                var stID = $(this).data('std');

                $.ajax({
                    type:'POST',
                    url:"../controller/crudManager.php",
                    data:{
                        sID:stID,
                        action:"studentInfoEdit"
                    },
                    success:function(result){
                        var data = jQuery.parseJSON(result);
                        $('#edit-id').val(data['studentID']);
                        $('#edit-lastname').val(data['lastName']);
                        $('#edit-firstname').val(data['firstName']);
                        $('#edit-mi').val((data['middleName'] == null)?'':data['middleName']);
                        $('#edit-studnum').val(data['studentID']);
                        $('#edit-gender').val(data['gender']);
                        $('#edit-balance').val(data['bal']);

                    }
                });
            });

            $('#editStudentForm').submit(function(event){
                event.preventDefault();
                var vid = $('#edit-id').val();
                var elname = $('#edit-lastname').val();
                var efname = $('#edit-firstname').val();
                var emname = $('#edit-mi').val();
                var estudnum = $('#edit-studnum').val();
                var egender = $('#edit-gender').val();

                $.ajax({
                    type:'POST',
                    url:'../controller/crudManager.php',
                    data:{action:"studentInfoUpdate", vid:vid, elname:elname, efname:efname, 
                            emname:emname, estudnum:estudnum, egender:egender},

                    success:function(result){
                        //console.log(result);
                        if(result == 1){
                            showStudentList('goto');
                            alert("Student Successfully Updated!");
                            $('#edit-modal').modal('hide');
                        }else{
                            $('#errorEdit').html($('<p></p>').attr("class","btn-danger").css({"width":"80%","text-align":"center"}).text(result));
                        }
                    }
                });
                
            });


            $('#edit-modal').on("hidden.bs.modal", function () {
                $(this)
                    .find("input,textarea,select")
                       .val('')
                            .end();
            });


            $(document).on("click","#btnDelete",function(){
                $('#confirmDel-id').val($(this).data('studid'));
            });

            $(document).on("submit","#confirmDel-form",function(e){
                e.preventDefault();
                var studID = $('#confirmDel-id').val();

                $.ajax({
                    type:'POST',
                    url:'../controller/crudManager.php',
                    data: {
                            studID:studID,
                            action:"deleteStudent"
                    },
                    success: function(data){
                        //console.log(data);
                        var res = jQuery.parseJSON(data);

                        if(res == 1) {
                            showStudentList('goto');
                            alert('Student Account Deleted');
                            $('#confirmDel').modal('hide');
                        }else{
                            alert("Error on Delete!");
                        }
                    }
                });
            });
            //
            //
            $('#confirmDel').on("hidden.bs.modal",function(){
                //$(this).find("#delete-id,#delete-lastname,#delete-firstname,#delete-mi,#delete-studnum,#delete-gender,#delete-balance").val('').end();
                $(this).find("#confirmDel-id").val('').end();
            });
            //
            //$(document).on("click","#btnModalDelete",function(e){
            //    e.preventDefault();
            //});
            //
            //$(document).on("click","#deleteConfirmed",function(e){
            //    e.preventDefault();
            //    var delID = $('#delete-id').val();
            //    //console.log(delID);
            //    $.ajax({
            //        type:'POST',
            //        url:'student-list/deleteStudent.php',
            //        data:{studID:delID},
            //        success:function(data){
            //            //console.log(data);
            //            showList('goto');
            //            $('#confirmDel').modal('hide');
            //            $('#delete-modal').modal('hide');
            //        }
            //    });
            //});

		});