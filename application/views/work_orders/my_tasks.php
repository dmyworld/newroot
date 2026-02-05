<div class="row">
    <?php foreach($tasks as $task) { ?>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="success"><?php echo $task['stage_name']; ?></h3>
                            <span>Batch: <?php echo $task['batch_name']; ?></span><br>
                            <?php if($task['machine_name']) { ?>
                                <small>Machine: <?php echo $task['machine_name']; ?></small><br>
                            <?php } ?>
                            <small>Status: <?php echo $task['status']; ?></small>
                        </div>
                        <div class="align-self-center">
                            <i class="icon-briefcase success font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top-blue-grey border-top-lighten-5 text-muted">
                    <?php if($task['status'] == 'Pending') { ?>
                        <button class="btn btn-primary btn-block update-status" data-id="<?php echo $task['id']; ?>" data-status="In Progress">Start Task</button>
                    <?php } elseif($task['status'] == 'In Progress') { ?>
                        <button class="btn btn-success btn-block update-status" data-id="<?php echo $task['id']; ?>" data-status="Completed">Complete Task</button>
                        <button class="btn btn-warning btn-sm mt-1 update-status" data-id="<?php echo $task['id']; ?>" data-status="Hold">Hold</button>
                    <?php } else { ?>
                        <button class="btn btn-secondary btn-block" disabled>Completed</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if(empty($tasks)) { ?>
        <div class="col-12 alert alert-info">No tasks assigned to you.</div>
    <?php } ?>
</div>

<script>
$(document).ready(function(){
    $('.update-status').click(function(){
        var id = $(this).data('id');
        var status = $(this).data('status');
        
        if(confirm("Change status to " + status + "?")) {
            $.ajax({
                url: "<?php echo site_url('work_orders/update_status')?>",
                type: 'POST',
                data: {
                    id: id, 
                    status: status,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                success: function(data){
                    if(data.status=='Success'){
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                }
            });
        }
    });
});
</script>
