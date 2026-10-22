<html>
<body>

<div class="modal" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" >
    <div class="modal-dialog logout-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title logout-title" id="myModalLabel">Log Details</h4>
            </div>
            <div class="modal-body logout-body" >
                <!-- ********************************************************************************************************************************* -->    
                <form method="POST" class="logoutPop" id="logout-form">        
                    <div class="log-details">
                        <input name="Ostid" id="Ostid" type="hidden" >
                        <input name="Ocompid" id="Ocompid" type="hidden" >
                        <input name="OentryDate" id="OentryDate" type="hidden" >
                        <input type="text" id="Ostudnum" name="Ostudnum"  readonly ><br/>
                        <input type="text" id="Ostudname" name="Ostudname"  readonly ><br/>
                        <label>LogIn Time: </label>
                        <input type="text" id="Ologindate" name="Ologindate"  readonly><br/>
                    </div>
                    <div class="timeout">
                        <input id="timeout" name="timeout" type="text" >
					</div> 
            <div id="breakdown">
                <input name="originalBal" id="originalBal" type="hidden" >
                <input name="hiddenConsumedBal" id="hiddenConsumedBal" type="hidden">
                <input name="hiddenConsumedTime" id="hiddenConsumedTime" type="hidden"> 
                <input name="hiddenRemaining" id="hiddenRemaining" type="hidden">

                <table id="breakdown-table">
                    <tbody>
                        <tr>
                            <td>Consumed Time: </td>
                            <td id="consumed"></td>
                        </tr>
                        <tr>
                            <td>Remaining Balance: </td>
                            <td id="BALleft"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="logoutButtons">
                <button type="submit" class="btn btn-md btn-danger" id="logoutclick"><i class="fa fa-sign-out fa-lg"></i>&nbsp;Logout</button>
                <button type="button" class="btn btn-md btn-default" data-dismiss="modal" id="dismiss">Cancel</button>
            </div>
        </form>
        <!-- ********************************************************************************************************************************* -->
    </div> <!-- .modal-body -->

    </div>
</div>
</div> 