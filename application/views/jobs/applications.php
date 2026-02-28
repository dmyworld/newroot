<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .app-container { max-width: 1200px; margin: 40px auto; padding: 20px; }
        .app-header { margin-bottom: 30px; }
        .app-header h2 { color: #2a5298; font-weight: 700; }
        .candidate-card { background: white; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 30px; margin-bottom: 25px; display: flex; gap: 30px; }
        .app-status { padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 700; }
        .status-hired { background: #dcfce7; color: #166534; }
        .status-pending { background: #fff7ed; color: #9a3412; }
        .profile-side { text-align: center; width: 150px; }
        .avatar-circle { width: 80px; height: 80px; background: #2a5298; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; margin: 0 auto 15px; }
        .content-side { flex: 1; }
        .badge-list { display: flex; gap: 8px; margin: 10px 0; }
        .badge-item { background: #f0f7ff; color: #2a5298; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; border: 1px solid #d0e7ff; }
        .badge-item i { margin-right: 5px; }
        .btn-hire { background: #13ec5b; color: white; border: none; padding: 12px 30px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.3s; }
        .btn-hire:hover { background: #0fc94d; transform: scale(1.05); }
    </style>
</head>
<body>
<div class="app-container">
    <div class="app-header">
        <a href="<?= base_url('jobs/manage') ?>" class="btn btn-sm btn-outline-primary mb-3"><i class="fa fa-arrow-left"></i> Back to Jobs</a>
        <h2>Applications for Job #<?= $this->uri->segment(3) ?></h2>
    </div>

    <div class="candidate-list">
        <?php foreach ($applications as $app) { 
            $this->load->model('Worker_model', 'worker');
            $badges = $this->worker->get_skill_badges($app['worker_id']);
        ?>
            <div class="candidate-card">
                <div class="profile-side">
                    <div class="avatar-circle"><?= substr($app['display_name'], 0, 1) ?></div>
                    <div class="rating text-warning">
                        <?php for($i=1; $i<=5; $i++) echo $i <= $app['average_rating'] ? '★' : '☆'; ?>
                    </div>
                    <small class="text-muted"><?= $app['average_rating'] ?> Rating</small>
                </div>
                <div class="content-side">
                    <div class="d-flex justify-content-between">
                        <h4><?= htmlspecialchars($app['display_name']) ?></h4>
                        <span class="app-status status-<?= $app['status'] ?>"><?= strtoupper($app['status']) ?></span>
                    </div>
                    <p class="text-muted"><i class="fa fa-clock"></i> <?= $app['experience_years'] ?> Years Experience</p>
                    
                    <div class="badge-list">
                        <?php foreach($badges as $badge) { ?>
                            <span class="badge-item"><i class="fa fa-<?= $badge['icon'] ?>"></i> <?= $badge['name'] ?></span>
                        <?php } ?>
                    </div>

                    <div class="mt-3">
                        <h6>Cover Letter:</h6>
                        <p class="text-muted small"><?= nl2br(htmlspecialchars($app['cover_letter'] ?? 'No cover letter provided.')) ?></p>
                    </div>

                    <div class="mt-4 d-flex gap-3">
                        <button class="btn btn-outline-primary btn-sm"><i class="fa fa-download"></i> Download Resume</button>
                        <?php if($app['status'] !== 'hired') { ?>
                            <button onclick="hireCandidate(<?= $app['id'] ?>)" class="btn-hire">Hire Candidate</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    function hireCandidate(appId) {
        if(confirm('Are you sure you want to hire this candidate? This will create an employee record and link them to this branch.')) {
            $.post('<?= base_url('jobs/hire') ?>', {app_id: appId}, function(res) {
                alert(res.message);
                if(res.status === 'Success') location.reload();
            }, 'json');
        }
    }
</script>
</body>
</html>
