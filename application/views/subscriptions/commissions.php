<style>
    .premium-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        background: #fff;
        overflow: hidden;
    }
    .premium-header {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        color: white;
        padding: 25px;
        border-radius: 15px 15px 0 0;
    }
    .table-container {
        padding: 20px;
    }
    .amount-display {
        font-weight: 700;
        font-size: 1.1rem;
    }
    .text-outstanding {
        color: #e11d48;
    }
    .action-btn {
        padding: 8px 15px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
    }
    .btn-settle {
        background: #f0fdf4;
        color: #16a34a;
    }
    .btn-settle:hover {
        background: #16a34a;
        color: white;
    }
    .highlight-row {
        background-color: #fff1f2 !important;
    }
</style>

<article class="content">
    <div class="premium-card">
        <div class="premium-header">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="mb-1">Commission Tracker</h4>
                    <p class="mb-0 text-white-50">Manage 3% platform revenue from Free Plan partners.</p>
                </div>
                <div class="col-sm-6 text-right">
                    <span class="badge badge-pill badge-light p-2 px-3">Businesses: <?= count($list) ?></span>
                </div>
            </div>
        </div>
        
        <div class="table-container">
            <table class="table table-hover">
                <thead>
                <tr class="text-secondary">
                    <th>Business / User</th>
                    <th>Total Sales (ERP)</th>
                    <th>Comm. (3%)</th>
                    <th>Total Paid</th>
                    <th>Outstanding</th>
                    <th class="text-right">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $row) { 
                    $is_high_debt = ($row['outstanding'] > 5000); // UI trigger for high debt
                ?>
                    <tr class="<?= $is_high_debt ? 'highlight-row' : '' ?>">
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-light text-dark mr-2" style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.75rem; border: 1px solid #e2e8f0;">
                                    <?= strtoupper(substr($row['username'], 0, 1)) ?>
                                </div>
                                <div>
                                    <h6 class="mb-0"><?= $row['username'] ?></h6>
                                    <small class="text-muted"><?= $row['email'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="amount-display"><?= amountExchange($row['total_sales']) ?></td>
                        <td><?= amountExchange($row['total_commission']) ?></td>
                        <td class="text-success"><?= amountExchange($row['total_paid']) ?></td>
                        <td class="amount-display text-outstanding">
                            <?= amountExchange($row['outstanding']) ?>
                        </td>
                        <td class="text-right">
                            <?php if ($row['outstanding'] > 0) { ?>
                                <button class="action-btn btn-settle open-settle" 
                                        data-id="<?= $row['user_id'] ?>" 
                                        data-username="<?= $row['username'] ?>" 
                                        data-amount="<?= $row['outstanding'] ?>"
                                        data-formatted="<?= amountExchange($row['outstanding']) ?>">
                                    <i class="fa fa-check-circle"></i> Settle Payment
                                </button>
                            <?php } else { ?>
                                <span class="badge badge-success p-2">Clear <i class="fa fa-thumbs-up"></i></span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                <?php if (empty($list)) { ?>
                    <tr>
                        <td colspan="6" class="text-center p-5">
                            <i class="fa fa-info-circle fa-2x text-muted mb-2"></i>
                            <p>No active commission logs found. Create some invoices for 'Free Plan' users to see data here.</p>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</article>

<!-- Shared Modals -->
<?php $this->load->view('subscriptions/modals'); ?>

<script>
$(document).ready(function() {
    $('.open-settle').click(function() {
        $('#settle_user_id').val($(this).data('id'));
        $('#settle_amount').val($(this).data('amount'));
        $('#settle_username').text($(this).data('username'));
        $('#settle_amount_display').text($(this).data('formatted'));
        $('#settleModal').modal('show');
    });

    $('#confirmSettle').click(function() {
        var user_id = $('#settle_user_id').val();
        var amount = $('#settle_amount').val();
        var btn = $(this);
        
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            url: "<?= base_url('subscriptions/settle') ?>",
            type: 'POST',
            data: {user_id: user_id, amount: amount},
            dataType: 'json',
            success: function(data) {
                if(data.status == 'Success') {
                    $('#settleModal').modal('hide');
                    location.reload();
                } else {
                    alert(data.message);
                    btn.prop('disabled', false).text('Confirm & Settle');
                }
            },
            error: function(xhr, status, error) {
                alert('Settlement failed. Server responded with error: ' + error + '\nPlease check logs for details.');
                btn.prop('disabled', false).text('Confirm & Settle');
            }
        });
    });
});
</script>
