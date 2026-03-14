<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Service Provider Dashboard</h3>
            </div>
        </div>
        <div class="content-body">
            <!-- stats -->
            <div class="row">
                <div class="col-md-12">
                    <div class="premium-card mb-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">Status: <?php echo ($provider['is_online'] == 1) ? '<span class="text-success">ONLINE</span>' : '<span class="text-muted">OFFLINE</span>'; ?></h4>
                            </div>
                            <div>
                                <input type="checkbox" id="online_toggle" <?php echo ($provider['is_online'] == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onboarding & Verification -->
            <?php if ($provider['is_verified'] == 0) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="premium-card bg-light-warning mb-2">
                        <div class="card-body">
                            <h5><i class="fa fa-exclamation-triangle"></i> Action Required: KYC Verification</h5>
                            <p>Please upload your documents to be verified and start receiving jobs.</p>
                            <form action="<?php echo base_url('ServiceDashboard/update_onboarding') ?>" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>NIC / ID Photo</label>
                                        <input type="file" name="nic_doc" class="form-control" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label>Driving License / Professional Cert</label>
                                        <input type="file" name="license_doc" class="form-control">
                                    </div>
                                    <div class="col-md-2 mt-1">
                                         <button type="submit" class="btn btn-primary btn-block">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <!-- Active On-Demand Job -->
            <?php if ($current_job) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="premium-card bg-gradient-x-info white mb-2">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="white">Ongoing Job: <?php echo $current_job['service_name'] ?></h4>
                                    <p class="white mb-0"><i class="fa fa-user"></i> <?php echo $current_job['customer_name'] ?> | <i class="fa fa-map-marker"></i> <?php echo $current_job['pickup_address'] ?></p>
                                    <p class="white"><strong>LKR <?php echo $current_job['agreed_price'] ?></strong></p>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $current_job['pickup_lat'] ?>,<?php echo $current_job['pickup_lng'] ?>" target="_blank" class="btn btn-warning btn-sm mb-1"><i class="fa fa-location-arrow"></i> Navigate</a>
                                    <a href="tel:<?php echo $current_job['customer_phone'] ?>" class="btn btn-success btn-sm mb-1"><i class="fa fa-phone"></i> Call Customer</a>
                                    
                                    <?php if ($current_job['status'] == 2) { ?>
                                        <div class="input-group mt-1">
                                            <input type="text" id="otp_entry" class="form-control" placeholder="Enter OTP">
                                            <div class="input-group-append">
                                                <button class="btn btn-dark" type="button" id="btn-start-job">Start Job</button>
                                            </div>
                                        </div>
                                    <?php } else if ($current_job['status'] == 3) { ?>
                                        <button class="btn btn-premium-white btn-block mt-1" id="btn-complete-job">Finish Job</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <!-- Stats -->
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-12">
                    <div class="card bg-gradient-x-primary white">
                    <div class="premium-card mb-2">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body text-left">
                                    <h3 class="success">LKR <?php echo number_format($wallet['balance'], 2) ?></h3>
                                    <span>Wallet Balance (On-Demand)</span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="fa fa-wallet success font-large-2 float-right"></i>
                                </div>
                            </div>
                            <div class="progress mt-1 mb-0" style="height: 7px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <?php if($wallet['balance'] > 500) { ?>
                            <button class="btn btn-outline-success btn-sm btn-block mt-1" data-toggle="modal" data-target="#withdrawalModal">Request Payout</button>
                            <?php } else { ?>
                             <p class="text-muted small mt-1">Min. LKR 500 required for payout.</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-12">
                    <div class="premium-card mb-2">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body text-left">
                                    <h3 class="info"><?php echo $wallet['jobs_done'] ?></h3>
                                    <span>Jobs Completed</span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="fa fa-briefcase info font-large-2 float-right"></i>
                                </div>
                            </div>
                            <div class="progress mt-1 mb-0" style="height: 7px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-12">
                    <div class="card bg-gradient-x-info white">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="fa fa-clock-o font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3 class="white"><?php echo $earnings['total_hours_month'] ?></h3>
                                        <span>Hours Worked (Month)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skill Selection & Pricing -->
            <div class="row">
                <div class="col-md-12">
                    <div class="premium-card mb-2">
                        <div class="premium-card-header">
                            <h4 class="premium-card-title">My Services & Pricing</h4>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo base_url('ServiceDashboard/update_onboarding') ?>" method="post">
                                <div class="table-responsive">
                                    <table class="table table-premium">
                                        <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Service Name</th>
                                            <th>Price Range (Admin)</th>
                                            <th>My Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $my_skill_ids = array_column($my_skills, 'service_id');
                                        $my_skill_prices = array_column($my_skills, 'fixed_price', 'service_id');
                                        
                                        foreach ($master_services as $s) { ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="services[]" value="<?php echo $s['id'] ?>" <?php echo in_array($s['id'], $my_skill_ids) ? 'checked' : ''; ?>>
                                                </td>
                                                <td><?php echo $s['service_name'] ?></td>
                                                <td><?php echo number_format($s['min_price'],2) ?> - <?php echo number_format($s['max_price'],2) ?></td>
                                                <td>
                                                    <input type="number" name="prices[<?php echo $s['id'] ?>]" class="form-control form-control-sm" 
                                                           min="<?php echo $s['min_price'] ?>" max="<?php echo $s['max_price'] ?>" step="0.01"
                                                           value="<?php echo $my_skill_prices[$s['id']] ?? $s['min_price']; ?>">
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="submit" class="btn btn-premium mt-1">Save Skills & Pricing</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Jobs -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">My Active Jobs</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Job Title</th>
                                            <th>Location</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($active_jobs as $job) { ?>
                                            <tr>
                                                <td><?php echo $job['title'] ?></td>
                                                <td><?php echo $job['location'] ?></td>
                                                <td><span class="badge badge-success"><?php echo $job['status'] ?></span></td>
                                            </tr>
                                        <?php } if(empty($active_jobs)) echo '<tr><td colspan="3" class="text-center">No active jobs found.</td></tr>'; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Available Opportunities -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Nearby Opportunities</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Opportunity</th>
                                            <th>Rate Range</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($available_jobs as $job) { ?>
                                            <tr>
                                                <td><?php echo $job['title'] ?></td>
                                                <td><?php echo amountExchange($job['hourly_rate_min']) ?> - <?php echo amountExchange($job['hourly_rate_max']) ?></td>
                                                <td><a href="#" class="btn btn-sm btn-outline-primary">Apply</a></td>
                                            </tr>
                                        <?php } if(empty($available_jobs)) echo '<tr><td colspan="3" class="text-center">No new opportunities in your area.</td></tr>'; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Job Request Modal -->
<div class="modal fade" id="jobRequestModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content premium-modal">
            <div class="modal-body text-center p-3">
                <div class="job-timer-circle mb-2">
                    <span id="job-timer-count">60</span>
                </div>
                <h4 class="mb-1" id="job-title">New Job Request!</h4>
                <p class="text-muted" id="job-address">Calculating distance...</p>
                <h3 class="text-success mb-2" id="job-price">LKR 0.00</h3>
                <div class="row">
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-danger btn-block" id="btn-reject-job">Decline</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-success btn-block" id="btn-accept-job">ACCEPT</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Withdrawal Modal -->
<div class="modal fade" id="withdrawalModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content premium-modal">
            <form action="<?php echo base_url('ServiceDashboard/request_payout') ?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
                <div class="modal-header">
                    <h5 class="modal-title">Request Payout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Withdrawal Amount (LKR)</label>
                        <input type="number" name="amount" class="form-control" min="500" max="<?php echo $wallet['balance'] ?>" value="<?php echo $wallet['balance'] ?>" required>
                        <small class="text-muted">Available Balance: LKR <?php echo number_format($wallet['balance'], 2) ?></small>
                    </div>
                    <p class="small text-danger">Note: Payouts are usually processed within 24-48 hours after admin review.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var pollInterval;
    var timerCountdown;
    var currentRequestId = 0;

    $(document).ready(function() {
        startPolling();
    });

    function startPolling() {
        pollInterval = setInterval(function() {
            $.get("<?php echo base_url('Dispatch/poll_requests') ?>", function(data) {
                var res = JSON.parse(data);
                if (res.new_job && currentRequestId != res.job.id) {
                    showJobModal(res.job);
                }
            });
        }, 10000); // Poll every 10 seconds
    }

    function showJobModal(job) {
        currentRequestId = job.id;
        $('#job-title').text(job.service_name);
        $('#job-address').text(job.pickup_address);
        $('#job-price').text('LKR ' + job.agreed_price);
        $('#jobRequestModal').modal('show');
        
        var count = 60;
        $('#job-timer-count').text(count);
        clearInterval(timerCountdown);
        timerCountdown = setInterval(function() {
            count--;
            $('#job-timer-count').text(count);
            if (count <= 0) {
                clearInterval(timerCountdown);
                $('#jobRequestModal').modal('hide');
                // Auto-reject if timer expires
            }
        }, 1000);
    }

    $('#btn-accept-job').click(function() {
        $.post("<?php echo base_url('Dispatch/accept_job') ?>", {
            request_id: currentRequestId,
            '<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash()?>'
        }, function(data) {
            location.reload();
        });
    });

    $('#btn-reject-job').click(function() {
        $('#jobRequestModal').modal('hide');
        clearInterval(timerCountdown);
    });

    $('#btn-start-job').click(function() {
        var otp = $('#otp_entry').val();
        if(!otp) { alert("Please enter the OTP provided by the customer."); return; }
        
        $.post("<?php echo base_url('Dispatch/start_job') ?>", {
            request_id: "<?php echo $current_job['id'] ?? 0 ?>",
            otp: otp,
            '<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash()?>'
        }, function(data) {
            var res = JSON.parse(data);
            if(res.status == 'Success') {
                location.reload();
            } else {
                alert(res.message);
            }
        });
    });

    $('#btn-complete-job').click(function() {
        if(confirm("Confirm that the service is completed?")) {
            $.post("<?php echo base_url('Dispatch/complete_job') ?>", {
                request_id: "<?php echo $current_job['id'] ?? 0 ?>",
                '<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash()?>'
            }, function(data) {
                location.reload();
            });
        }
    });

    $('#online_toggle').change(function() {
        var status = $(this).prop('checked') ? 1 : 0;
        
        // Browser Geolocation
        if (status == 1 && navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                updateStatus(status, position.coords.latitude, position.coords.longitude);
            }, function(error) {
                alert("Location access required to go online.");
                $('#online_toggle').bootstrapToggle('off');
            });
        } else {
            updateStatus(status, 0, 0);
        }
    });

    function updateStatus(status, lat, lng) {
        $.post("<?php echo base_url('ServiceDashboard/toggle_status') ?>", {
            status: status,
            lat: lat,
            lng: lng,
            '<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash()?>'
        }, function(data) {
            location.reload();
        });
    }
</script>

<style>
    .premium-modal {
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 50px rgba(0,0,0,0.2);
    }
    .job-timer-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 4px solid #28a745;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
        color: #28a745;
    }
    .premium-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid rgba(255,255,255,0.2);
    }
</style>
    </div>
</div>
