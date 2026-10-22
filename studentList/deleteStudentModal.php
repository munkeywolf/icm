<html>

<body>

<div id="confirmDel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmDel-modal-label">
    <div class="modal-dialog confirmYes" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="confirmDel-form">
                <!-- dialog body -->
                <div class="modal-body">
                    <input type="hidden" id="confirmDel-id" value="" class="hidden" readonly>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    Are you sure you want to delete this data?
                </div>
                <!-- dialog buttons -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="btnDelConfirmed" >Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>