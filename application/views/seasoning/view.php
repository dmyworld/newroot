<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Batch Details</h5>
                <hr>
                <p><strong>Name:</strong> <?php echo $batch['batch_name']; ?></p>
                <p><strong>Method:</strong> <?php echo $batch['method']; ?></p>
                <p><strong>Location:</strong> <?php echo $batch['location']; ?></p>
                <p><strong>Start Date:</strong> <?php echo $batch['start_date']; ?></p>
                <hr>
                <div class="text-center">
                    <h2><?php echo $batch['current_mc']; ?>% <small class="text-muted">Current MC</small></h2>
                    <p>Target: <?php echo $batch['target_mc']; ?>%</p>
                </div>
            </div>
        </div>
        
        <div class="card">
             <div class="card-body">
                <h5 class="card-title">Log New Reading</h5>
                <hr>
                <form id="reading_form">
                    <input type="hidden" name="batch_id" value="<?php echo $batch['id']; ?>">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="text" name="check_date" class="form-control required" data-toggle="datepicker" autocomplete="false" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label>Moisture Content (%)</label>
                        <input type="number" step="0.1" name="moisture" class="form-control required">
                    </div>
                    <div class="form-group">
                        <label>Temperature (C)</label>
                        <input type="number" step="1" name="temp" class="form-control">
                    </div>
                     <div class="form-group">
                        <label>Humidity (%)</label>
                        <input type="number" step="1" name="humidity" class="form-control">
                    </div>
                    <button type="button" id="save_reading" class="btn btn-primary btn-block">Log Reading</button>
                </form>
             </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <h5 class="card-title">Moisture Log History</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Moisture %</th>
                            <th>Temp / Humidity</th>
                            <th>Noted By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($logs as $log) { ?>
                        <tr>
                            <td><?php echo $log['check_date']; ?></td>
                            <td><span class="badge badge-primary"><?php echo $log['moisture_content']; ?>%</span></td>
                            <td><?php echo $log['temperature'] ? $log['temperature'].'C' : '-'; ?> / <?php echo $log['humidity'] ? $log['humidity'].'%' : '-'; ?></td>
                            <td><?php echo $log['noted_by']; ?></td>
                        </tr>
                        <?php } ?>
                         <?php if(empty($logs)) { ?>
                            <tr><td colspan="4" class="text-center">No logs yet.</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#save_reading').click(function() {
            $.ajax({
                url: "<?php echo site_url('seasoning/add_reading')?>",
                type: 'POST',
                data: $('#reading_form').serialize() + '&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
                dataType: 'json',
                success: function(data) {
                    $('#notify').show();
                    if(data.status == 'Success') {
                        $('.message').text(data.message);
                        setTimeout(function(){ location.reload(); }, 1000);
                    } else {
                         $('#notify').removeClass('alert-success').addClass('alert-danger');
                         $('.message').text(data.message);
                    }
                }
            });
        });
    });
</script>
