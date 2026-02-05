<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Cheque #<?php echo $cheque['id']; ?></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="post" action="<?php echo base_url('ChequeManager/update'); ?>">
                    <input type="hidden" name="id" value="<?php echo $cheque['id']; ?>">
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Payee Name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="<?php echo $cheque['payee']; ?>" readonly>
                            <small>For security, Payee cannot be changed after creation.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Amount</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="<?php echo $cheque['amount']; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Cheque Date</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" name="date" data-toggle="datepicker" value="<?php echo dateformat($cheque['date']); ?>" autocomplete="false">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Status (Action)</label>
                        <div class="col-sm-6">
                            <select name="status" class="form-control">
                                <option value="Pending" <?php if($cheque['status']=='Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Signed" <?php if($cheque['status']=='Signed') echo 'selected'; ?>>Signed (Authorized)</option>
                                <option value="Issued" <?php if($cheque['status']=='Issued') echo 'selected'; ?>>Issued (Sent)</option>
                                <option value="Cleared" <?php if($cheque['status']=='Cleared') echo 'selected'; ?>>Cleared (In Bank)</option>
                                <option value="Bounced" <?php if($cheque['status']=='Bounced') echo 'selected'; ?>>Bounced / Returned</option>
                                <option value="Void" <?php if($cheque['status']=='Void') echo 'selected'; ?>>Void</option>
                            </select>
                            <small class="text-danger font-weight-bold">
                                Note: Changing status to "Issued" (Outgoing) or "Cleared" (Incoming) will post a transaction to the Ledger.
                            </small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Note / Reference</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name="note" rows="3"><?php echo $cheque['note']; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success margin-bottom">
                                <i class="fa fa-check-circle"></i> Update & Approve
                            </button>
                            <a href="<?php echo base_url('ChequeManager'); ?>" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
