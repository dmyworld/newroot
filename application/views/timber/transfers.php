<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Stock Transfers (Inter-Location)</h4>
            <div class="heading-elements">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#newTransferModal">
                    <i class="fa fa-plus"></i> Request Stock Transfer
                </button>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered" id="transfersTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Lot Type</th>
                            <th>Lot Name</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transfers as $row): ?>
                        <tr>
                            <td><?= date('Y-m-d H:i', strtotime($row['created_at'])) ?></td>
                            <td><?= strtoupper($row['lot_type']) ?></td>
                            <td><?= $row['lot_name'] ?: '#' . $row['lot_id'] ?></td>
                            <td><?= $row['from_name'] ?></td>
                            <td><?= $row['to_name'] ?></td>
                            <td>
                                <?php 
                                $cls = 'info';
                                if($row['status'] == 'completed') $cls = 'success';
                                if($row['status'] == 'pending') $cls = 'warning';
                                ?>
                                <span class="badge badge-<?= $cls ?>"><?= strtoupper($row['status']) ?></span>
                            </td>
                            <td>
                                <?php if ($row['status'] == 'pending' && $row['to_loc'] == $this->aauth->get_user()->loc): ?>
                                    <button class="btn btn-success btn-sm approve-btn" data-id="<?= $row['id'] ?>">
                                        <i class="fa fa-check"></i> Approve & Accept
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newTransferModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="transfer_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Request Stock Transfer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Lot Type</label>
                        <select name="lot_type" class="form-control" id="lot_type">
                            <option value="log">Log Lot</option>
                            <option value="sawn">Sawn Timber Lot</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Lot</label>
                        <select name="lot_id" class="form-control select2" id="lot_list" style="width:100%">
                            <!-- Loaded via AJAX -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Destination Location</label>
                        <select name="to_loc" class="form-control" required>
                            <?php foreach ($locations as $loc): ?>
                                <?php if ($loc['id'] != $this->aauth->get_user()->loc): ?>
                                    <option value="<?= $loc['id'] ?>"><?= $loc['cname'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    $('#transfersTable').DataTable({ 'order': [[0, 'desc']] });

    // Load available lots based on type
    function loadLots() {
        var type = $('#lot_type').val();
        $.ajax({
            url: "<?php echo site_url('sawmill/ajax_get_logs') ?>", // Reuse log fetching logic
            type: 'POST',
            dataType: 'json',
            data: {'<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash()?>'},
            success: function(data) {
                $('#lot_list').empty();
                data.forEach(function(item) {
                    $('#lot_list').append('<option value="'+item.id+'">'+item.lot_name+' ('+item.total_cubic_feet+' CF)</option>');
                });
            }
        });
    }
    loadLots();
    $('#lot_type').change(loadLots);

    $("#transfer_form").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo site_url('transfers/create') ?>",
            type: 'POST',
            data: $(this).serialize() + '&<?=$this->security->get_csrf_token_name()?>=<?=$this->security->get_csrf_hash()?>',
            dataType: 'json',
            success: function (data) {
                location.reload();
            }
        });
    });

    $(document).on('click', '.approve-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "<?php echo site_url('transfers/approve') ?>",
            type: 'POST',
            data: {id: id, '<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash()?>'},
            dataType: 'json',
            success: function (data) {
                location.reload();
            }
        });
    });
});
</script>
