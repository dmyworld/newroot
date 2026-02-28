<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="content-header row mb-1">
        <div class="content-header-left col-md-8 col-12 mb-1">
            <h3 class="content-header-title mb-0 font-weight-bolder text-primary">⚡ Approve & Manage Cheque</h3>
            <div class="grey-text mt-1">Review the details and update the clearance status to post to the ledger.</div>
        </div>
    </div>
    
    <div class="content-body">
        <section id="cheque-edit">
            <div class="row">
                <div class="col-md-8 offset-md-2 col-12">
                    <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                        <div class="card-header border-0 pb-0 bg-transparent d-flex justify-content-between">
                            <h4 class="card-title font-weight-bold">Reference #<?php echo $cheque['cheque_number'] ?: $cheque['id']; ?></h4>
                            <span class="badge badge-pill badge-light-<?= strtolower($cheque['type']) == 'incoming' ? 'success' : 'danger' ?> px-2 py-1">
                                <?= strtoupper($cheque['type']) ?>
                            </span>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form method="post" action="<?php echo base_url('ChequeManager/update'); ?>" class="form-horizontal">
                                    <input type="hidden" name="id" value="<?php echo $cheque['id']; ?>">
                                    
                                    <!-- Summary View -->
                                    <div class="row bg-light rounded-lg p-2 mb-3 mx-0 shadow-sm border" style="border-radius: 15px;">
                                        <div class="col-md-6 mb-2 mb-md-0">
                                            <small class="text-uppercase text-muted font-weight-bold d-block mb-50">Business Partner</small>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-white p-50 mr-1 shadow-sm" style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-user text-primary"></i>
                                                </div>
                                                <h5 class="mb-0 font-weight-bolder"><?php echo ($cheque['type'] == 'Incoming' ? $cheque['customer_name'] : $cheque['supplier_name']) ?: $cheque['payee']; ?></h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <small class="text-uppercase text-muted font-weight-bold d-block mb-50">Clearing Amount</small>
                                            <h2 class="text-primary font-weight-bolder mb-0"><?php echo amountExchange($cheque['amount'], 0, $this->aauth->get_user()->loc); ?></h2>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Bank Info -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label class="font-weight-bold text-uppercase font-small-3">Bank Institution</label>
                                                <div class="p-1 border rounded bg-light" style="border-radius: 12px !important;">
                                                    <i class="fa fa-university mr-50 text-muted"></i> <?php echo $cheque['bank']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Dates -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label class="font-weight-bold text-uppercase font-small-3">Issue Date</label>
                                                <div class="p-1 border rounded bg-light" style="border-radius: 12px !important;">
                                                    <i class="fa fa-calendar-o mr-50 text-muted"></i> <?php echo dateformat($cheque['issue_date']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-2 border-light">

                                    <div class="row">
                                        <!-- Clearance Date -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label class="font-weight-bold text-uppercase font-small-3 text-primary">Updating Clearance Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control custom-input" name="clear_date" value="<?php echo $cheque['clear_date']; ?>" required>
                                            </div>
                                        </div>
                                        <!-- Status Selection -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label class="font-weight-bold text-uppercase font-small-3 text-primary">Action / Current Status <span class="text-danger">*</span></label>
                                                <select name="status" class="form-control custom-input font-weight-bold">
                                                    <option value="Pending" <?php if($cheque['status']=='Pending') echo 'selected'; ?>>🟡 PENDING (Reviewing)</option>
                                                    <option value="Signed" <?php if($cheque['status']=='Signed') echo 'selected'; ?>>🔵 SIGNED (Authorized)</option>
                                                    <option value="Issued" <?php if($cheque['status']=='Issued') echo 'selected'; ?>>🟣 ISSUED (External)</option>
                                                    <option value="Cleared" <?php if($cheque['status']=='Cleared') echo 'selected'; ?>>🟢 CLEARED (Post to Ledger)</option>
                                                    <option value="Bounced" <?php if($cheque['status']=='Bounced') echo 'selected'; ?>>🔴 BOUNCED (Returned)</option>
                                                    <option value="Void" <?php if($cheque['status']=='Void') echo 'selected'; ?>>⚪ VOID (Cancelled)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Notes -->
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold text-uppercase font-small-3">Remarks / Transaction Log</label>
                                        <textarea class="form-control custom-input" name="note" rows="3" placeholder="Enter any internal verification notes..."><?php echo $cheque['note']; ?></textarea>
                                    </div>

                                    <div class="alert alert-warning border-0 px-2 py-1 shadow-sm mb-3" style="border-radius: 12px; border-left: 5px solid #ff9f43 !important;">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-info-circle mr-1 font-large-1"></i>
                                            <div>
                                                <strong>Notice:</strong> Changing the status to <strong>CLEARED</strong> or <strong>ISSUED</strong> will trigger an automated transaction entry in your financial ledger.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions text-right pb-1">
                                        <a href="<?php echo base_url('ChequeManager'); ?>" class="btn btn-link text-muted font-weight-bold mr-1">
                                            <i class="ft-x"></i> Go Back
                                        </a>
                                        <button type="submit" class="btn btn-primary shadow-sm rounded-pill font-weight-bolder" style="padding: 12px 35px;">
                                            <i class="fa fa-save mr-1"></i> Update & Commit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<style>
    .custom-input {
        border-radius: 12px !important;
        border: 1px solid #e0e6ed;
        padding: 12px 15px;
        transition: all 0.3s ease;
        height: auto;
    }
    .custom-input:focus {
        border-color: #626ed4;
        box-shadow: 0 0 0 0.2rem rgba(98, 110, 212, 0.15);
    }
    .badge-light-success { background-color: #e3f9eb; color: #39da8a !important; }
    .badge-light-danger { background-color: #ffebf0; color: #ff5b5c !important; }
    .bg-light { background-color: #f8f9fb !important; }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        var initial_status = $('select[name="status"]').val();
        
        $('select[name="status"]').change(function() {
            var new_status = $(this).val();
            var warning_msg = '';
            var is_critical = false;

            if (new_status == 'Cleared') {
                warning_msg = '⚠️ CONFIRM ACTION:\n\nSet status to CLEARED?\n\nThis will POST this transaction to the financial ledger and update account balances.';
                is_critical = true;
            } else if (['Bounced', 'Void', 'Returned'].includes(new_status)) {
                warning_msg = '⛔ WARNING: ROLLBACK ACTION\n\nSet status to ' + new_status.toUpperCase() + '?\n\nThis will:\n1. REVERSE any existing financial transactions.\n2. UPDATE the Invoice/Purchase balance to DUE.\n\nAre you sure?';
                is_critical = true;
            }

            if (is_critical) {
                if(!confirm(warning_msg)) {
                    $(this).val(initial_status); // Revert if cancelled
                } else {
                    initial_status = new_status; // Update accepted status
                }
            }
        });
    });
</script>
