<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h5>Provider Approval Queue</h5>
            <hr>
        </div>
    </div>

    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>

    <div class="premium-card">
        <div class="table-responsive">
            <table id="providertable" class="table table-premium">
                <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>NIC Doc</th>
                    <th>Date Joined</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach ($providers as $row) {
                    $pid = $row['id'];
                    $name = $row['username'];
                    if ($row['is_verified'] == 1) {
                        $name .= ' <span class="badge badge-success" title="KYC Verified"><i class="fa fa-check-circle"></i></span>';
                    }
                    $email = $row['email'];
                    $nic = $row['nic_doc'] ? '<i class="fa fa-file-image-o text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
                    $date = date('Y-m-d', strtotime($row['created_at']));
                    
                    echo "<tr>
                    <td>$i</td>
                    <td>$name</td>
                    <td>$email</td>
                    <td>$nic</td>
                    <td>$date</td>
                    <td>
                        <a href='" . base_url("providers/view?id=$pid") . "' class='btn btn-outline-info btn-sm rounded'><i class='fa fa-eye'></i> View Docs</a>&nbsp;
                        <a href='#' data-id='$pid' class='btn btn-outline-success btn-sm rounded approve-provider'><i class='fa fa-check'></i> Approve</a>&nbsp;
                        <a href='#' data-id='$pid' class='btn btn-outline-danger btn-sm rounded reject-provider'><i class='fa fa-times'></i> Reject</a>
                    </td></tr>";
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#providertable').DataTable({
            responsive: true
        });

        $(document).on('click', ".approve-provider", function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var btn = $(this);
            if(confirm("Are you sure you want to approve this provider?")) {
                $.ajax({
                    url: "<?php echo base_url('providers/approve') ?>",
                    type: 'POST',
                    data: {id: id, '<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == "Success") {
                            $("#notify .message").html("<strong>Success</strong>: " + data.message);
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
