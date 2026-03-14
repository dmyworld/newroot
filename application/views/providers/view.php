<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h5>Provider Profile: <?php echo $details['username'] ?></h5>
            <hr>
        </div>
        <div class="header-actions">
            <a href="<?php echo base_url('providers') ?>" class="btn-premium btn-secondary-glass">
                <i class="fa fa-arrow-left"></i> Back to Queue
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="premium-card">
                <div class="card-body text-center">
                    <img src="<?php echo base_url('assets/images/user.png') ?>" class="rounded-circle mb-2" style="width:100px;">
                    <h4><?php echo $details['username'] ?></h4>
                    <p class="text-muted"><?php echo $details['email'] ?></p>
                    <p><strong>Phone:</strong> <?php echo $details['phone'] ?></p>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <h6>Rating</h6>
                            <span class="badge badge-warning"><?php echo $details['rating_avg'] ?> <i class="fa fa-star"></i></span>
                        </div>
                        <div class="col-6">
                            <h6>Jobs Done</h6>
                            <span class="badge badge-info"><?php echo $details['total_jobs'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="premium-card mt-2">
                <div class="premium-card-header">
                    <h5 class="premium-card-title">Accounting Summary</h5>
                </div>
                <div class="card-body">
                    <h5>Total Earnings: <span class="text-success"><?php echo number_format($details['total_earnings'], 2) ?></span></h5>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="premium-card">
                <div class="premium-card-header">
                    <h5 class="premium-card-title"><i class="fa fa-file-text-o"></i> Verification Documents</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <h6>NIC / ID Document</h6>
                            <?php if($details['nic_doc']) { ?>
                                <img src="<?php echo base_url('userfiles/providers/'.$details['nic_doc']) ?>" class="img-fluid rounded border shadow-sm">
                            <?php } else { echo '<p class="text-danger">Not Uploaded</p>'; } ?>
                        </div>
                        <div class="col-md-6 mb-2">
                            <h6>License / Certificate</h6>
                            <?php if($details['license_doc']) { ?>
                                <img src="<?php echo base_url('userfiles/providers/'.$details['license_doc']) ?>" class="img-fluid rounded border shadow-sm">
                            <?php } else { echo '<p class="text-danger">Not Uploaded</p>'; } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="premium-card mt-2">
                <div class="premium-card-header">
                    <h5 class="premium-card-title"><i class="fa fa-wrench"></i> Registered Skills & Pricing</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-premium">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Worker Quote</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($skills as $skill) { ?>
                                <tr>
                                    <td><?php echo $skill['service_name'] ?></td>
                                    <td><?php echo number_format($skill['fixed_price'], 2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
