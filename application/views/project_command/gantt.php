<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Project Gantt Chart: <?php echo $project['project_name']; ?></h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a href="<?php echo base_url('project_command/explore?id='.$project['id']); ?>" class="btn btn-warning btn-sm"><i class="fa fa-reply"></i> Back to Project</a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div id="gantt"></div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/frappe-gantt@0.6.1/dist/frappe-gantt.css">
<script src="https://unpkg.com/frappe-gantt@0.6.1/dist/frappe-gantt.min.js"></script>

<script>
    var tasks = [
        <?php foreach($tasks as $t): 
            $start = $t['start_date'] ? $t['start_date'] : $project['start_date'];
            $end = $t['due_date'] ? $t['due_date'] : date('Y-m-d', strtotime($start . ' + 1 day'));
            
            // Fix overlapping start/end if end < start
            if(strtotime($end) < strtotime($start)) $end = $start;

            $progress = 0;
            if($t['status'] == 'Finished') $progress = 100;
            elseif($t['status'] == 'In-Progress') $progress = 50;
        ?>
        {
            id: "<?php echo $t['id']; ?>",
            name: "<?php echo $t['task_name']; ?>",
            start: "<?php echo $start; ?>",
            end: "<?php echo $end; ?>",
            progress: <?php echo $progress; ?>,
            dependencies: ""
        },
        <?php endforeach; ?>
    ];

    var gantt = new Gantt("#gantt", tasks, {
        header_height: 50,
        column_width: 30,
        step: 24,
        view_modes: ['Quarter Day', 'Half Day', 'Day', 'Week', 'Month'],
        bar_height: 20,
        bar_corner_radius: 3,
        arrow_curve: 5,
        padding: 18,
        view_mode: 'Day',
        date_format: 'YYYY-MM-DD',
        custom_popup_html: null,
        on_date_change: function(task, start, end) {
            console.log(task, start, end);
            // Update via AJAX
            $.ajax({
                url: baseurl + 'project_command/update_task_dates',
                type: 'POST',
                data: {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                    id: task.id,
                    start: moment(start).format('YYYY-MM-DD'),
                    end: moment(end).format('YYYY-MM-DD')
                },
                success: function(response) {
                    console.log('Updated');
                }
            });
        },
        on_progress_change: function(task, progress) {
            console.log(task, progress);
        },
        on_view_change: function(mode) {
            console.log(mode);
        }
    });
</script>
