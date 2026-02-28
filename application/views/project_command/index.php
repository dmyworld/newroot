<div class="content-body">
    <div class="row">
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card bg-gradient-x-primary white">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="fa fa-rocket font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3 class="white"><?php echo count($projects); ?></h3>
                                <span>Active Projects</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card bg-gradient-x-success white">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="fa fa-money font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3 class="white"><?php echo amountExchange($total_wip, 0, $this->aauth->get_user()->loc); ?></h3>
                                <span>Current WIP Value</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <a href="<?php echo base_url('project_command/create') ?>" class="btn btn-primary btn-block btn-lg">
                            <i class="fa fa-plus-circle"></i> Setup New Project Wizard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Project Command Center</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table id="projects_table" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Project Name</th>
                        <th>Customer</th>
                        <th>Location</th>
                        <th>Timeline</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i = 1;
                    foreach ($projects as $row) {
                        echo "<tr>
                            <td>$i</td>
                            <td><strong>{$row['project_name']}</strong></td>
                            <td>{$row['customer_name']}</td>
                            <td>{$row['location_name']}</td>
                            <td>".dateformat($row['start_date'])." - ".dateformat($row['end_date'])."</td>
                            <td><span class='badge badge-info'>{$row['status']}</span></td>
                            <td>
                                <a href='".base_url('project_command/explore?id='.$row['id'])."' class='btn btn-sm btn-primary'><i class='fa fa-eye'></i> View</a>
                                <a href='".base_url('project_command/edit?id='.$row['id'])."' class='btn btn-sm btn-warning'><i class='fa fa-pencil'></i></a>
                            </td>
                        </tr>";
                        $i++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#projects_table').DataTable({
            responsive: true,
            "order": [[0, "desc"]]
        });
    });
</script>
