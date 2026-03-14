<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <div class="message"></div>
        </div>
        <div class="card-body">
            <h5 class="title">Pending Subscription Approvals</h5>
            <p>Review paid plan registrations and verify receipts before activating accounts.</p>
            <hr>
            <table id="approvals_table" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Receipt</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $i => $row) { ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $row['username'] ?></td>
                        <td>#<?= $row['tid'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td>
                            <?php if ($row['receipt_image']) { ?>
                                <a href="<?= base_url('userfiles/receipts/' . $row['receipt_image']) ?>" target="_blank">
                                    <img src="<?= base_url('userfiles/receipts/' . $row['receipt_image']) ?>" width="50" class="img-thumbnail">
                                </a>
                            <?php } else { echo "No Receipt"; } ?>
                        </td>
                        <td><?= date('Y-m-d', strtotime($row['date_created'])) ?></td>
                        <td>
                            <button class="btn btn-success btn-sm approve-sub" data-id="<?= $row['id'] ?>">
                                <i class="fa fa-check"></i> Approve
                            </button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</article>

<script type="text/javascript">
    $(document).ready(function () {
        $('.approve-sub').click(function() {
            var id = $(this).data('id');
            var btn = $(this);
            if(confirm('Are you sure you want to approve this subscription?')) {
                $.ajax({
                    url: "<?php echo base_url('subscriptions/approve') ?>",
                    type: 'POST',
                    data: {id: id, <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>"},
                    dataType: 'json',
                    success: function (data) {
                        if(data.status == 'Success') {
                            $("#notify .message").html(data.message);
                            $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                            btn.closest('tr').fadeOut();
                        } else {
                            alert(data.message);
                        }
                    }
                });
            }
        });
    });
</script>
