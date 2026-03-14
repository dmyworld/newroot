<style>
    .premium-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        background: #fff;
        overflow: hidden;
    }
    .premium-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        padding: 25px;
        border-radius: 15px 15px 0 0;
    }
    .table-container {
        padding: 20px;
    }
    .plan-badge {
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
    }
    .plan-1 { background: #e0f2fe; color: #0369a1; } /* Free */
    .plan-2 { background: #dcfce7; color: #15803d; } /* Pro */
    .plan-3 { background: #fef9c3; color: #a16207; } /* Premium */
    
    .action-btn {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        margin-right: 5px;
        border: none;
    }
    .btn-edit { background: #eff6ff; color: #2563eb; }
    .btn-delete { background: #fef2f2; color: #dc2626; }
    .btn-edit:hover { background: #2563eb; color: #fff; }
    .btn-delete:hover { background: #dc2626; color: #fff; }
</style>

<article class="content">
    <div class="premium-card">
        <div class="premium-header">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="mb-1">Active Subscriptions</h4>
                    <p class="mb-0 text-white-50">Manage your business partners and their system access.</p>
                </div>
                <div class="col-sm-6 text-right">
                    <span class="badge badge-pill badge-light p-2 px-3">Total: <?= count($list) ?></span>
                </div>
            </div>
        </div>
        
        <div class="table-container">
            <table class="table table-hover zero-configuration">
                <thead>
                <tr class="text-secondary">
                    <th>#</th>
                    <th>Business / User</th>
                    <th>Selected Plan</th>
                    <th>Activation</th>
                    <th>Expiry</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $i => $row) { 
                    $days_left = ceil((strtotime($row['expires_at']) - time()) / 86400);
                    $plan_label = ($row['plan_id'] == 1) ? 'Free Access' : (($row['plan_id'] == 2) ? 'Pro (15k)' : 'Ultimate (25k)');
                ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-primary text-white mr-2" style="width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                    <?= strtoupper(substr($row['username'], 0, 1)) ?>
                                </div>
                                <div>
                                    <h6 class="mb-0"><?= $row['username'] ?></h6>
                                    <small class="text-muted"><?= $row['email'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td><span class="plan-badge plan-<?= $row['plan_id'] ?>"><?= $plan_label ?></span></td>
                        <td><?= date('M d, Y', strtotime($row['activated_at'])) ?></td>
                        <td>
                            <div class="<?= ($days_left <= 7) ? 'text-danger font-weight-bold' : '' ?>">
                                <?= date('M d, Y', strtotime($row['expires_at'])) ?>
                                <br><small><?= $days_left ?> days left</small>
                            </div>
                        </td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td class="text-center">
                            <button class="action-btn btn-edit edit-sub" data-id="<?= $row['id'] ?>" data-username="<?= $row['username'] ?>" data-plan="<?= $row['plan_id'] ?>" title="Change Plan">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="action-btn btn-delete delete-sub" data-id="<?= $row['id'] ?>" data-username="<?= $row['username'] ?>" title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</article>

<!-- Modals for Actions -->
<?php $this->load->view('subscriptions/modals'); ?>

<script>
$(document).ready(function() {
    $('.edit-sub').click(function() {
        $('#edit_user_id').val($(this).data('id'));
        $('#edit_username').text($(this).data('username'));
        $('#edit_plan_id').val($(this).data('plan'));
        $('#planModal').modal('show');
    });

    $('.delete_sub').click(function() {
        $('#del_user_id').val($(this).data('id'));
        $('#del_username').text($(this).data('username'));
        $('#deleteModal').modal('show');
    });

    $('#planForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('subscriptions/change_plan') ?>",
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data.status == 'Success') {
                    location.reload();
                } else {
                    alert(data.message);
                }
            }
        });
    });

    $('#confirmDelete').click(function() {
        $.ajax({
            url: "<?= base_url('subscriptions/delete_subscription') ?>",
            type: 'POST',
            data: {id: $('#del_user_id').val()},
            dataType: 'json',
            success: function(data) {
                if(data.status == 'Success') {
                    location.reload();
                } else {
                    alert(data.message);
                }
            }
        });
    });
});
</script>
