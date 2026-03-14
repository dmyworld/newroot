<!-- Change Plan Modal -->
<div id="planModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h5 class="modal-title">Change Subscription Plan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="planForm">
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="edit_user_id">
                    <p>Change plan for: <strong id="edit_username"></strong></p>
                    <div class="form-group mt-2">
                        <label>Select New Plan</label>
                        <select name="plan_id" id="edit_plan_id" class="form-control">
                            <option value="1">Free (3% Commission)</option>
                            <option value="2">Pro (15,000 LKR / Month)</option>
                            <option value="3">Ultimate (25,000 LKR / Month)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Plan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirm Modal -->
<div id="deleteModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger white">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <i class="fa fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                <h5>Are you sure?</h5>
                <p>This will terminate the subscription for <strong id="del_username"></strong>. They will no longer have system access until they re-register or you manually reactivate them.</p>
                <input type="hidden" id="del_user_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Yes, Terminate</button>
            </div>
        </div>
    </div>
</div>

<!-- Settle Payment Modal -->
<div id="settleModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success white">
                <h5 class="modal-title">Confirm Settlement</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <i class="fa fa-money fa-3x text-success mb-3"></i>
                <h5>Confirm Collection?</h5>
                <p>Have you received <strong id="settle_amount_display"></strong> from <strong id="settle_username"></strong>?</p>
                <p class="text-muted small">This will record the payment in the system ledger and reset their outstanding balance.</p>
                <input type="hidden" id="settle_user_id">
                <input type="hidden" id="settle_amount">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmSettle">Confirm & Settle</button>
            </div>
        </div>
    </div>
</div>
