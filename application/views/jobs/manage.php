<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .manage-container { max-width: 1200px; margin: 40px auto; padding: 20px; }
        .manage-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .manage-header h2 { color: #2a5298; font-weight: 700; margin: 0; }
        .job-card { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px; transition: transform 0.3s; border-left: 5px solid #2a5298; }
        .job-card:hover { transform: translateX(5px); }
        .job-card.closed { border-left-color: #666; opacity: 0.8; }
        .job-card.filled { border-left-color: #13ec5b; }
        .card-body { padding: 25px; display: flex; justify-content: space-between; align-items: center; }
        .job-info h4 { margin-bottom: 5px; font-weight: 700; color: #333; }
        .job-meta { display: flex; gap: 15px; color: #888; font-size: 13px; }
        .job-meta span i { color: #2a5298; margin-right: 5px; }
        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .status-open { background: #e0f2fe; color: #0369a1; }
        .status-filled { background: #dcfce7; color: #166534; }
        .status-closed { background: #f3f4f6; color: #374151; }
        .action-btns { display: flex; gap: 10px; }
        .btn-view { background: #f0f7ff; color: #2a5298; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .btn-view:hover { background: #2a5298; color: white; }
    </style>
</head>
<body>
<div class="manage-container">
    <div class="manage-header">
        <div>
            <h2>Recruitment Management</h2>
            <p class="text-muted">Manage your job openings and review candidate applications.</p>
        </div>
        <a href="<?= base_url('jobs/post') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Post New Job</a>
    </div>

    <div class="job-list">
        <?php foreach ($jobs as $job) { ?>
            <div class="job-card <?= $job['status'] ?>">
                <div class="card-body">
                    <div class="job-info">
                        <span class="status-badge status-<?= $job['status'] ?>"><?= $job['status'] ?></span>
                        <h4 class="mt-2"><?= htmlspecialchars($job['title']) ?></h4>
                        <div class="job-meta">
                            <span><i class="fa fa-building"></i> <?= htmlspecialchars($job['dept_name']) ?></span>
                            <span><i class="fa fa-map-marker-alt"></i> <?= htmlspecialchars($job['location']) ?></span>
                            <span><i class="fa fa-calendar"></i> Posted <?= date('M d, Y', strtotime($job['created_at'])) ?></span>
                        </div>
                    </div>
                    <div class="action-btns">
                        <a href="<?= base_url('jobs/applications/' . $job['id']) ?>" class="btn-view">
                            <i class="fa fa-users"></i> View Applications 
                            <?php 
                                $count = $this->db->where('job_id', $job['id'])->count_all_results('geopos_job_applications');
                                if($count > 0) echo '<span class="badge badge-danger ml-1">'.$count.'</span>';
                            ?>
                        </a>
                        <button class="btn btn-outline-secondary btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>
