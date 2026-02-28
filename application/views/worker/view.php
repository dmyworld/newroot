<?php
$worker = $worker ?? [];
$is_logged_in = $is_logged_in ?? false;
$initials = strtoupper(substr($worker['display_name'] ?? 'W', 0, 2));
?>
<div class="content-body">
    <div class="worker-profile-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 60px 20px; color: white; border-radius: 12px 12px 0 0; text-align: center; position: relative; margin-bottom: 80px;">
        <div class="profile-photo-large" style="width: 150px; height: 150px; border-radius: 50%; border: 6px solid white; position: absolute; bottom: -75px; left: 50%; transform: translateX(-50%); background: #f0f0f0; overflow: hidden; display: flex; align-items: center; justify-content: center; font-size: 60px; color: #2a5298; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <?php if(!empty($worker['photo'])): ?>
                <img src="<?= base_url($worker['photo']) ?>" alt="<?= $worker['display_name'] ?>" style="width:100%; height:100%; object-fit:cover;">
            <?php else: ?>
                <span><?= $initials ?></span>
            <?php endif; ?>
        </div>
        <h1 style="margin-bottom: 5px; font-weight: 700;"><?= htmlspecialchars($worker['display_name']) ?></h1>
        <p style="opacity: 0.9; font-size: 1.1rem;"><i class="fa fa-briefcase"></i> <?= htmlspecialchars($worker['category_name']) ?> • <?= $worker['experience_years'] ?> Years Experience</p>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h4 class="mb-3"><i class="fa fa-info-circle text-primary"></i> Professional Bio</h4>
                        <p class="lead" style="color: #555;"><?= nl2br(htmlspecialchars($worker['bio'] ?? 'No bio provided.')) ?></p>
                        
                        <hr>
                        
                        <h4 class="mb-3 mt-4"><i class="fa fa-tools text-primary"></i> Skills & Expertise</h4>
                        <div class="d-flex flex-wrap gap-2">
                            <?php 
                            $skills = json_decode($worker['skills'] ?? '[]', true);
                            if(!empty($skills)): 
                                foreach($skills as $skill): ?>
                                    <span class="badge badge-lg" style="background: #e3f2fd; color: #2a5298; padding: 10px 15px; border-radius: 20px; font-size: 0.95rem;">
                                        <?= htmlspecialchars($skill) ?>
                                    </span>
                                <?php endforeach; 
                            else: ?>
                                <p class="text-muted">No specific skills listed.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h4 class="mb-3"><i class="fa fa-star text-warning"></i> Recent Reviews</h4>
                        <p class="text-muted">Ratings and feedback from previous employers.</p>
                        <div class="alert alert-light border">
                            <i class="fa fa-comment-dots text-secondary"></i> "A very dedicated professional. Completed the task ahead of schedule with great attention to detail." - <em>Previous Client</em>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4" style="border-top: 5px solid #13ec5b !important;">
                    <div class="card-body p-4 text-center">
                        <div class="price-tag mb-4">
                            <span style="font-size: 0.9rem; color: #888; display: block;">Rate / Pricing</span>
                            <strong style="font-size: 2.5rem; color: #333;">LKR <?= number_format($worker['pay_rate'] ?? 0) ?></strong>
                            <span class="text-muted">/ <?= $worker['pay_type'] ?? 'hr' ?></span>
                        </div>
                        
                        <?php if(($worker['pay_type'] ?? 'hourly') !== 'hourly' && ($worker['hourly_rate'] ?? 0) > 0): ?>
                            <div class="alert alert-info py-2" style="font-size: 0.9rem;">
                                <i class="fa fa-calculator"></i> (~ LKR <?= number_format($worker['hourly_rate'], 2) ?> per hour)
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-center gap-3 mb-4 text-muted" style="font-size: 0.9rem;">
                            <span><i class="fa fa-map-marker-alt"></i> <?= htmlspecialchars($worker['location']) ?></span>
                            <span><i class="fa fa-star text-warning"></i> <?= number_format($worker['average_rating'] ?? 5, 1) ?> (<?= $worker['total_ratings'] ?? 0 ?>)</span>
                        </div>

                        <button class="btn btn-success btn-block btn-lg py-3" onclick="hireWorker(<?= $worker['id'] ?>)">
                            <i class="fa fa-handshake"></i> Hire <?= explode(' ', $worker['display_name'])[0] ?>
                        </button>
                        
                        <button class="btn btn-outline-primary btn-block mt-3" onclick="openMessageModal()">
                            <i class="fa fa-envelope"></i> Send Message
                        </button>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Verification Details</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2 text-success"><i class="fa fa-check-circle"></i> Identity Verified</li>
                            <li class="mb-2 text-success"><i class="fa fa-check-circle"></i> Background Checked</li>
                            <li class="mb-0 text-success"><i class="fa fa-check-circle"></i> Skills Certified</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function hireWorker(id) {
    Swal.fire({
        title: 'Confirm Hire',
        text: "You are about to hire this professional. A contract will be generated.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#13ec5b',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Hire!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('<?= base_url('worker/hire') ?>', {worker_id: id}, function(res) {
                const data = JSON.parse(res);
                if(data.status === 'Success') {
                    Swal.fire('Success!', data.message, 'success').then(() => {
                        window.location.href = '<?= base_url('employee') ?>';
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            });
        }
    });
}

function openMessageModal() {
    Swal.fire('Coming Soon', 'In-app messaging is currently being finalized.', 'info');
}
</script>

<style>
    .worker-profile-header h1 { color: white !important; }
    .badge-lg { border: 1px solid rgba(0,0,0,0.05); }
    .price-tag strong { font-family: 'Inter', sans-serif; }
</style>
