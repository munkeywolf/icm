<html>
<body>

<div class="modal" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="add-modal-label" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="addStudentForm">
                
                <div class="modal-header" style="border-top: 5px solid #5cb85c;border-radius: 5px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="add-modal-label">Add Student Account</h4>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" id="add-id" value="" class="hidden" readonly>
                    
                    <div class="form-group">
                        <label for="add-lastname" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="add-lastname" name="add-lastname" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="add-firstname" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="add-firstname" name="add-firstname" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="add-mi" class="col-sm-3 control-label">Middle Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="add-mi" name="add-mi" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="add-studnum" class="col-sm-3 control-label">Student Number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="add-studnum" name="add-studnum" maxlength="10" pattern="[0-9]{2}[\-]+[0-9]{1}[\-]+[0-9]{3,5}" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="add-gender" class="col-sm-3 control-label">Gender</label>
                        <div class="col-sm-9">
                            <select name="add-gender" class="form-control" id="add-gender" required>
                                <option value=""></option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnAddStudModal">Add Student</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            
            </form>
        
        </div>
    </div>
</div>