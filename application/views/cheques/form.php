<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-8 col-12 mb-2">
            <h3 class="content-header-title mb-0 font-weight-bolder text-primary">
                <?= $mode == 'add' ? '✨ New Cheque Entry' : '📝 Edit Cheque Details' ?>
            </h3>
            <div class="grey-text mt-1">Manage your PDC, Incoming & Outgoing cheques with ease.</div>
        </div>
    </div>
    
    <div class="content-body">
        <section id="cheque-form">
            <div class="row">
                <div class="col-md-8 offset-md-2 col-12">
                    <div class="card border-0 shadow-lg" style="border-radius: 20px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
                        <div class="card-header border-0 pb-0 bg-transparent">
                            <h4 class="card-title font-weight-bold"><?= $mode == 'add' ? 'Record New Transaction' : 'Update Record' ?></h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <?php echo form_open($mode == 'add' ? 'ChequeManager/add' : 'ChequeManager/update', ['id' => 'cheque_entry_form', 'class' => 'form-horizontal']); ?>
                                
                                <?php if ($mode == 'edit'): ?>
                                    <input type="hidden" name="id" value="<?= $cheque['id'] ?>">
                                <?php endif; ?>
                                
                                <?php if (validation_errors()): ?>
                                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" style="border-radius: 12px;">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <?= validation_errors() ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Type Choice -->
                                <div class="form-group mb-3">
                                    <label class="label-heading mb-1 d-block font-weight-bold">Cheque Category <span class="text-danger">*</span></label>
                                    <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                                        <label class="btn btn-outline-success btn-lg flex-grow-1 py-1 <?= (isset($cheque) && strtolower($cheque['type']) == 'incoming') || !isset($cheque) ? 'active' : '' ?>" style="border-radius: 12px 0 0 12px;">
                                            <input type="radio" name="type" value="incoming" id="type_incoming" autocomplete="off" <?= (isset($cheque) && strtolower($cheque['type']) == 'incoming') || !isset($cheque) ? 'checked' : '' ?>> 
                                            <i class="fa fa-arrow-down mr-1"></i> Incoming (Receivable)
                                        </label>
                                        <label class="btn btn-outline-danger btn-lg flex-grow-1 py-1 <?= (isset($cheque) && strtolower($cheque['type']) == 'outgoing') ? 'active' : '' ?>" style="border-radius: 0 12px 12px 0;">
                                            <input type="radio" name="type" value="outgoing" id="type_outgoing" autocomplete="off" <?= (isset($cheque) && strtolower($cheque['type']) == 'outgoing') ? 'checked' : '' ?>> 
                                            <i class="fa fa-arrow-up mr-1"></i> Outgoing (Payable)
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Cheque Number -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="label-heading mb-1 font-weight-bold">Cheque Number <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0" style="border-radius: 12px 0 0 12px;"><i class="fa fa-hashtag"></i></span>
                                                </div>
                                                <input type="text" name="cheque_number" class="form-control custom-input border-left-0" 
                                                       value="<?= isset($cheque) ? $cheque['cheque_number'] : set_value('cheque_number') ?>" placeholder="CR-102938" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Amount -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="label-heading mb-1 font-weight-bold">Total Amount <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0" style="border-radius: 12px 0 0 12px;"><i class="fa fa-money"></i></span>
                                                </div>
                                                <input type="number" step="0.01" name="amount" class="form-control custom-input border-left-0" 
                                                       value="<?= isset($cheque) ? $cheque['amount'] : set_value('amount') ?>" placeholder="0.00" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Party Selection -->
                                <div class="form-group mb-3">
                                    <label class="label-heading mb-1 font-weight-bold">Business Partner <span class="text-danger">*</span></label>
                                    <select name="party_id" id="party_select" class="form-control select2 shadow-none" required>
                                        <option value="">Search Customer or Supplier...</option>
                                        <optgroup label="Customers" id="customer_group">
                                            <?php foreach ($customers as $customer): ?>
                                                <option value="<?= $customer['id'] ?>" data-type="customer"
                                                        <?= isset($cheque) && $cheque['party_id'] == $customer['id'] && strtolower($cheque['type']) == 'incoming' ? 'selected' : '' ?>>
                                                    👤 <?= $customer['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                        <optgroup label="Suppliers" id="supplier_group">
                                            <?php foreach ($suppliers as $supplier): ?>
                                                <option value="<?= $supplier['id'] ?>" data-type="supplier"
                                                        <?= isset($cheque) && $cheque['party_id'] == $supplier['id'] && strtolower($cheque['type']) == 'outgoing' ? 'selected' : '' ?>>
                                                    🏢 <?= $supplier['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="row">
                                    <!-- Bank -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="label-heading mb-1 font-weight-bold">Bank Name <span class="text-danger">*</span></label>
                                            <input type="text" name="bank" class="form-control custom-input" 
                                                   value="<?= isset($cheque) ? $cheque['bank'] : set_value('bank') ?>" 
                                                   placeholder="Bank of Ceylon / HNB" required>
                                        </div>
                                    </div>
                                    
                                    <!-- Branch -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="label-heading mb-1 font-weight-bold">Branch / Location</label>
                                            <select name="branch_id" class="form-control custom-input">
                                                <option value="0">Default Main Office</option>
                                                <?php foreach ($branches as $branch): ?>
                                                    <option value="<?= $branch['id'] ?>"
                                                            <?= isset($cheque) && $cheque['branch_id'] == $branch['id'] ? 'selected' : '' ?>>
                                                        📍 <?= $branch['cname'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Issue Date -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="label-heading mb-1 font-weight-bold">Issue Date <span class="text-danger">*</span></label>
                                            <input type="date" name="issue_date" class="form-control custom-input" 
                                                   value="<?= isset($cheque) ? $cheque['issue_date'] : (set_value('issue_date') ?: date('Y-m-d')) ?>" required>
                                        </div>
                                    </div>
                                    
                                    <!-- Clear Date -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="label-heading mb-1 font-weight-bold">Clearing (PDC) Date <span class="text-danger">*</span></label>
                                            <input type="date" name="clear_date" class="form-control custom-input" 
                                                   value="<?= isset($cheque) ? $cheque['clear_date'] : set_value('clear_date') ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notes -->
                                <div class="form-group mb-3">
                                    <label class="label-heading mb-1 font-weight-bold">Internal Observations</label>
                                    <textarea name="note" class="form-control custom-input" rows="3" placeholder="Add specific payment details or internal notes here..."><?= isset($cheque) ? $cheque['note'] : set_value('note') ?></textarea>
                                </div>

                                <div class="form-actions right pb-1">
                                    <a href="<?= base_url('chequemanager') ?>" class="btn btn-link text-muted mr-1 font-weight-bold">
                                        <i class="ft-x"></i> Dismiss
                                    </a>
                                    <button type="submit" class="btn btn-primary shadow-sm" style="border-radius: 12px; padding: 10px 30px; font-weight: 600;">
                                        <i class="fa fa-check-circle mr-1"></i> <?= $mode == 'add' ? 'Confirm & Save' : 'Update Cheque' ?>
                                    </button>
                                </div>
                                
                                <?php echo form_close(); ?>
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
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    .custom-input:focus {
        border-color: #626ed4;
        box-shadow: 0 0 0 0.2rem rgba(98, 110, 212, 0.15);
    }
    .select2-container--default .select2-selection--single {
        border-radius: 12px;
        border: 1px solid #e0e6ed;
        height: 48px;
        padding-top: 10px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px;
    }
    .label-heading {
        color: #495057;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .btn-group-toggle .btn {
        border-width: 2px !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85rem;
    }
    body.dark-layout .card {
        background: rgba(40, 48, 70, 0.9) !important;
    }
</style>

<script>
$(document).ready(function() {
    // Initialize select2
    $('.select2').each(function() {
        $(this).select2({
            dropdownParent: $(this).parent(),
            width: '100%'
        });
    });
    
    // Filter party dropdown based on type
    function updatePartyGroups() {
        var type = $('input[name="type"]:checked').val();
        console.log("Cheque Type Changed to: " + type);
        
        if (type == 'incoming') {
            $('#customer_group').show();
            $('#supplier_group').hide();
            // Clear selection if it was a supplier
            var selected = $('#party_select option:selected');
            if(selected.data('type') === 'supplier') {
                $('#party_select').val('').trigger('change');
            }
        } else if (type == 'outgoing') {
            $('#customer_group').hide();
            $('#supplier_group').show();
            // Clear selection if it was a customer
            var selected = $('#party_select option:selected');
            if(selected.data('type') === 'customer') {
                $('#party_select').val('').trigger('change');
            }
        }
    }

    $('input[name="type"]').on('change', function() {
        updatePartyGroups();
    });
    
    // Trigger on load
    updatePartyGroups();
    
    // Smooth appearance
    $('.card').hide().fadeIn(800);
});
</script>
