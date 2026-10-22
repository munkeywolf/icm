 <html>
 <body>

 <div class="modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myLoginModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">LOG IN USER</h4>
            </div>

            <div class="modal-body login-body">
                <div class="row">
                <hr>
                    <div class="col-md-6 searchForTransaction" >
                        <form  method="POST" class="searchStudent form-horintal" id="searchStudent">
                            <div class="form-group tae">
                                <label class="col-xs-2 control-label label1">STUDENT<br> NUMBER</label>
                                <div class="col-xs-9 for-search">
                                    <input type="text" class="form-control" id="search-field" name="search-field" placeholder="Search" pattern="^[0-9]{2}[\-]{1}[0-9]{1}[\-]{1}[0-9]{3,5}$" title="00-0-00000" required >
                                </div>
                                <div class="col-xs-1 submitGo">
                                    <button type="submit" id="GO" name="GO" class="btn btn-xs btn-primary">GO</button>
                                </div>
                            </div>
                               <!-- <hr/>   -->
                            <table class="table-bordered table-fixed search-table">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                    </tr>
                                </thead>
                                <tbody id="searchResult">  
                                </tbody> 
                            </table>
                        </form>
                    </div>
                    <div class="col-md-6" >
                        <div class="studentDetailsDiv">
                            <form  method="POST" class="studentDetailsForm" id="loginStudentTransactionForm">
                                <div id="realTime">
                                    <?php echo "<b>" . date("m/d/Y") . "</b>";  ?>
                                    <span id="curTime"></span>   
                                </div>
                                    <hr/>
                                <div class="studentDetails" id="studentDetails">
                                </div>
                                    <hr/>
                                    <!-- <br> -->
                                <div class="currentTerm" style="margin-top:10px;">
                                    <!-- <p class="btn-info" style="padding-left: 10px;">Current Term:&nbsp;<b style="color:black;" >First Semester 2017-2018</b></p> -->
                                </div>
                                <div class="balStatus" id="balStat">

                                </div>
                                    <hr>
                                <div class="computerNumber">
                                    <lable>Computer No: </lable>
                                    <select name="compNum" id="compNum"> 
                                     
                                    </select>
                                    <br/>
                                </div>
                                <div class="loginButton">
                                    <button type="submit" class="btn btn-sm btn-primary" id="loginSubmit"><i class="fa fa-sign-in fa-lg"></i>&nbsp;Login</button>
                                    <button type="button" class="btn btn-sm btn-danger" id="clearLogin">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- <div class="row"> -->
                        <div class="col-md-12 transactionHistory">
                            <div id="TL" ><label id="transactionLabel" ></label></div>
                                <table class="table table-bordered table-fixed table-hover transactionTable" id="transactionTable">
                                    <thead>
                                        <tr>
                                            <th>CompID</th>
                                            <th>LogINDate</th>
                                            <th>LogOUTDate</th>
                                            <th>Consumed(Time)</th>
                                            <th>Consumed(Bal)</th>
                                        </tr> 
                                    </thead>
                                    <tbody id="studentTransactionHistory">
                                    </tbody>
                                </table>                    
                            </div>
                        </div>
                    <!-- </div> -->

                </div>
            </div>
        </div>
    </div>
</div>