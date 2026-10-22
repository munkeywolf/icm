<html>
<body>

<div class="modal" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            <form class="form-horizontal" id="editStudentForm" data-toggle="validator" role="form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="edit-modal-label">Edit Student Account</h4>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" id="edit-id" value="" class="hidden" readonly>
                    
                    <div class="form-group">
                        <label for="edit-lastname" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-lastname" name="edit-lastname" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit-firstname" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-firstname" name="edit-firstname" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit-mi" class="col-sm-3 control-label">Middle Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-mi" name="edit-mi" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit-studnum" class="col-sm-3 control-label">Student Number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-studnum" name="edit-studnum" maxlength="10" pattern="[0-9]{2}[\-]+[0-9]{1}[\-]+[0-9]{3,5}" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit-gender" class="col-sm-3 control-label">Gender</label>
                        
                        <div class="col-sm-9">
                            <!-- <input type="text" class="form-control" id="edit-gender" name="edit-gender" > -->
                            <select name="edit-gender" class="form-control" id="edit-gender" required>
                                <option value=""></option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>  
                    </div>

                    <div class="form-group" id="errorEdit" style="padding-left: 20%;">
                        
                    </div>
                    
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnSaveEdit">Save changes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            
            </form>
        
        </div>
    </div>
</div>