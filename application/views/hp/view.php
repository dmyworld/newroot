<style>
    .hp-view-body { padding: 1.5rem; background: #f4f7fa; }
    .glass-card {
        background: #fff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .card-header-luxury {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 1.5rem 2rem;
        color: #fff;
        border: none;
    }
    .card-header-luxury h5 { color: #fff; font-weight: 700; margin: 0; }
    
    .detail-item {
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .detail-item label { color: #718096; font-weight: 600; margin: 0; }
    .detail-item span { color: #2d3748; font-weight: 700; }

    .badge-status {
        padding: 4px 12px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    .table thead th {
        background: #f8fafc;
        color: #4a5568;
        font-weight: 700;
        border-bottom: 2px solid #e2e8f0;
    }

    .btn-pay-luxury {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border: none;
        color: #fff;
        font-weight: 700;
        border-radius: 8px;
        padding: 5px 15px;
        box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
        transition: all 0.3s ease;
    }
    .btn-pay-luxury:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(79, 172, 254, 0.4);
        color: #fff;
    }

    .modal-content-luxury {
        border-radius: 20px;
        border: none;
        overflow: hidden;
    }
    .modal-header-luxury {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: #fff;
    }
</style>

<div class="content-body hp-view-body">
    <div class="row">
        <!-- Contract Summary -->
        <div class="col-lg-4">
            <div class="glass-card">
                <div class="card-header card-header-luxury">
                    <h5><i class="ft-file-text"></i> Summary</h5>
                </div>
                <div class="card-body">
                    <div class="detail-item">
                        <label>Customer</label>
                        <span><?= $contract->name ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Agreed Amount</label>
                        <span><?= amountExchange($contract->total_amount, 0, $this->aauth->get_user()->loc) ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Down Payment</label>
                        <span><?= amountExchange($contract->down_payment, 0, $this->aauth->get_user()->loc) ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Interest Rate</label>
                        <span><?= $contract->interest_rate ?>%</span>
                    </div>
                    <div class="detail-item">
                        <label>Installment</label>
                        <span class="text-primary"><?= amountExchange($contract->installment_amount, 0, $this->aauth->get_user()->loc) ?></span>
                    </div>
                    <div class="detail-item border-0">
                        <label>Status</label>
                        <span class="badge-status st-<?= $contract->status ?>"><?= $contract->status ?></span>
                    </div>
                </div>
            </div>

            <div class="glass-card">
                <div class="card-header bg-light">
                    <h6 class="mb-0 font-weight-bold"><i class="ft-shield"></i> Guarantor Information</h6>
                </div>
                <div class="card-body">
                    <?php if($guarantor) { ?>
                        <div class="detail-item"><label>Name</label><span><?= $guarantor->name ?></span></div>
                        <div class="detail-item"><label>NIC</label><span><?= $guarantor->nic ?></span></div>
                        <div class="detail-item"><label>Phone</label><span><?= $guarantor->phone ?></span></div>
                        <div class="detail-item border-0"><label>Address</label><span class="text-right small"><?= $guarantor->address ?></span></div>
                    <?php } else { echo "<p class='text-muted text-center'>No guarantor records found.</p>"; } ?>
                </div>
            </div>
        </div>

        <!-- Schedule -->
        <div class="col-lg-8">
            <div class="glass-card">
                <div class="card-header card-header-luxury">
                    <h5><i class="ft-calendar"></i> Repayment Schedule</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($installments as $row) { ?>
                                <tr>
                                    <td class="font-weight-bold">#<?= $row->installment_num ?></td>
                                    <td><?= date("M d, Y", strtotime($row->due_date)) ?></td>
                                    <td class="font-weight-bold"><?= amountExchange($row->amount, 0, $this->aauth->get_user()->loc) ?></td>
                                    <td>
                                        <?php if($row->status == 'paid') { ?>
                                            <span class="badge badge-success badge-luxury">Paid</span>
                                        <?php } else { ?>
                                            <span class="badge badge-warning badge-luxury">Unpaid</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-right">
                                        <?php if($row->status != 'paid') { ?>
                                            <button class="btn btn-pay-luxury pay-btn" data-id="<?= $row->id ?>" data-amount="<?= $row->amount ?>">
                                                <i class="ft-credit-card"></i> Pay
                                            </button>
                                        <?php } else { ?>
                                            <i class="ft-check-circle text-success font-medium-3"></i>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Premium Payment Modal -->
<div id="paymentModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-luxury">
            <div class="modal-header modal-header-luxury">
                <h4 class="modal-title"><i class="ft-pocket"></i> Record Payment</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form id="payment_form">
                <div class="modal-body p-3">
                    <div class="alert alert-info py-1">
                        Select the destination account for this installment collection.
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Collection Amount</label>
                        <input type="text" class="form-control form-control-lg text-primary font-weight-bold" name="amount" id="modal_amount" readonly>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Deposit to Account</label>
                        <select name="account_id" class="form-control form-control-lg">
                            <?php 
                            $this->load->model('accounts_model');
                            $accounts = $this->accounts_model->accountslist();
                            foreach($accounts as $acc) {
                                echo '<option value="'.$acc['id'].'">'.$acc['holder'].' ('.$acc['acn'].')</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="installment_id" id="modal_id">
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-success btn-lg btn-block font-weight-bold rounded-pill" id="confirm_pay">
                        CONFIRM RECEIPT
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on('click', '.pay-btn', function() {
        $('#modal_id').val($(this).data('id'));
        $('#modal_amount').val($(this).data('amount'));
        $('#paymentModal').modal('show');
    });

    $('#payment_form').on('submit', function(e) {
        e.preventDefault();
        var btn = $('#confirm_pay');
        btn.prop('disabled', true).text('Processing...');
        
        $.ajax({
            url: "<?= base_url('hp/pay_installment') ?>",
            type: 'POST',
            data: $(this).serialize() + '&<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>',
            dataType: 'json',
            success: function(data) {
                if(data.status == 'Success') {
                    location.reload();
                } else {
                    alert(data.message);
                    btn.prop('disabled', false).text('CONFIRM RECEIPT');
                }
            }
        });
    });
</script>
