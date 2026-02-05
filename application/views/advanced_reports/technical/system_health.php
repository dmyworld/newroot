<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>System Health Status</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th>PHP Version</th>
                            <td><?= $health['php_version'] ?></td>
                        </tr>
                        <tr>
                            <th>Database Platform</th>
                            <td><?= $health['db_platform'] ?></td>
                        </tr>
                        <tr>
                            <th>Database Version</th>
                            <td><?= $health['db_version'] ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                         <tr>
                            <th>Server IP</th>
                            <td><?= $health['server_ip'] ?></td>
                        </tr>
                        <tr>
                            <th>Server Software</th>
                            <td><?= $health['server_software'] ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span class="badge badge-success">Online & Operational</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
