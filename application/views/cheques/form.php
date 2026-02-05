<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $mode == 'add' ? 'Add New Cheque' : 'Edit Cheque' ?></h1>
    </section>
    
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Cheque Details</h3>
            </div>
            
            <?php echo form_open($mode == 'add' ? 'cheque manager/add' : 'chequemanager/update', ['class' => 'form-horizontal']); ?>
            
            <?php if ($mode == 'edit'): ?>
                <input type="hidden" name="id" value="<?= $cheque['id'] ?>">
            <?php endif; ?>
            
            <div class="box-body">
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <?= validation_errors() ?>
                    </div>
                <?php endif; ?>
                
                <!-- Type -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Type *</label>
                    <div class="col-sm-4">
                        <select name="type" id="cheque_type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="incoming" <?= isset($cheque) && $cheque['type'] == 'incoming' ? 'selected' : '' ?>>Incoming (PDC In - Receivable)</option>
                            <option value="outgoing" <?= isset($cheque) && $cheque['type'] == 'outgoing' ? 'selected' : '' ?>>Outgoing (PDC Out - Payable)</option>
                        </select>
                    </div>
                </div>
                
                <!-- Cheque Number -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Cheque Number *</label>
                    <div class="col-sm-4">
                        <input type="text" name="cheque_number" class="form-control" 
                               value="<?= isset($cheque) ? $cheque['cheque_number'] : set_value('cheque_number') ?>" required>
                    </div>
                </div>
                
                <!-- Amount -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Amount *</label>
                    <div class="col-sm-4">
                        <input type="number" step="0.01" name="amount" class="form-control" 
                               value="<?= isset($cheque) ? $cheque['amount'] : set_value('amount') ?>" required>
                    </div>
                </div>
                
                <!-- Bank -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Bank *</label>
                    <div class="col-sm-4">
                        <input type="text" name="bank" class="form-control" 
                               value="<?= isset($cheque) ? $cheque['bank'] : set_value('bank') ?>" 
                               placeholder="e.g., Bank of Ceylon, Commercial Bank" required>
                    </div>
                </div>
                
                <!-- Party (Customer/Supplier) -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Party *</label>
                    <div class="col-sm-4">
                        <select name="party_id" id="party_select" class="form-control select2" required>
                            <option value="">Select Party</option>
                            <optgroup label="Customers" id="customer_group">
                                <?php foreach ($customers as $customer): ?>
                                    <option value="<?= $customer['id'] ?>" data-type="customer"
                                            <?= isset($cheque) && $cheque['party_id'] == $customer['id'] && $cheque['type'] == 'incoming' ? 'selected' : '' ?>>
                                        <?= $customer['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="Suppliers" id="supplier_group">
                                <?php foreach ($suppliers as $supplier): ?>
                                    <option value="<?= $supplier['id'] ?>" data-type="supplier"
                                            <?= isset($cheque) && $cheque['party_id'] == $supplier['id'] && $cheque['type'] == 'outgoing' ? 'selected' : '' ?>>
                                        <?= $supplier['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>
                </div>
                
                <!-- Issue Date -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Issue Date *</label>
                    <div class="col-sm-4">
                        <input type="date" name="issue_date" class="form-control" 
                               value="<?= isset($cheque) ? $cheque['issue_date'] : set_value('issue_date') ?>" required>
                    </div>
                </div>
                
                <!-- Clear Date -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Clear Date *</label>
                    <div class="col-sm-4">
                        <input type="date" name="clear_date" class="form-control" 
                               value="<?= isset($cheque) ? $cheque['clear_date'] : set_value('clear_date') ?>" required>
                    </div>
                </div>
                
                <!-- Branch -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Branch</label>
                    <div class="col-sm-4">
                        <select name="branch_id" class="form-control">
                            <option value="0">All Branches</option>
                            <?php foreach ($branches as $branch): ?>
                                <option value="<?= $branch['id'] ?>"
                                        <?= isset($cheque) && $cheque['branch_id'] == $branch['id'] ? 'selected' : '' ?>>
                                    <?= $branch['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <!-- Notes -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Notes</label>
                    <div class="col-sm-6">
                        <textarea name="note" class="form-control" rows="3"><?= isset($cheque) ? $cheque['note'] : set_value('note') ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="box-footer">
                <a href="<?= base_url('chequemanager') ?>" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-primary pull-right">
                    <i class="fa fa-save"></i> <?= $mode == 'add' ? 'Add Cheque' : 'Update Cheque' ?>
                </button>
            </div>
            
            <?php echo form_close(); ?>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    // Initialize select2
    $('.select2').select2();
    
    // Filter party dropdown based on type
    $('#cheque_type').on('change', function() {
        var type = $(this).val();
        if (type == 'incoming') {
            $('#customer_group').show();
            $('#supplier_group').hide();
        } else if (type == 'outgoing') {
            $('#customer_group').hide();
            $('#supplier_group').show();
        } else {
            $('#customer_group').show();
            $('#supplier_group').show();
        }
    });
    
    // Trigger on load
    $('#cheque_type').trigger('change');
});
</script>
