<div class="content-body">
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="icon-rocket primary font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3><?php echo $total_projects; ?></h3>
                                <span>Total Projects</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="icon-users warning font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3><?php echo amountExchange($monthly_payroll, 0, $this->aauth->get_user()->loc); ?></h3>
                                <span>Payroll (Month)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="icon-wrench success font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3><?php echo $total_assets; ?></h3>
                                <span>Total Assets</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="icon-wallet danger font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3><?php echo amountExchange($assets_value, 0, $this->aauth->get_user()->loc); ?></h3>
                                <span>Assets Value</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Recent Projects</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th>Project Name</th>
                                <th>Status</th>
                                <th>Budget</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($recent_projects as $project) { ?>
                                <tr>
                                    <td class="text-truncate"><?php echo $project['name']; ?></td>
                                    <td class="text-truncate"><span class="badge badge-info"><?php echo $project['status']; ?></span></td>
                                    <td class="text-truncate"><?php echo amountExchange($project['budget'], 0, $this->aauth->get_user()->loc); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
