<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users text-success"></i> Staff Performance Leaderboard
            <small>Trust scores & performance rankings</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('ownerdashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Staff Leaderboard</li>
        </ol>
    </section>

    <section class="content">
        <!-- Filter Section -->
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-filter"></i> Filters</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <form method="get" action="<?= base_url('ownerdashboard/staff_leaderboard') ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Branch</label>
                                <select name="branch_id" class="form-control">
                                    <option value="0">All Branches</option>
                                    <?php foreach ($branches as $branch): ?>
                                        <option value="<?= $branch['id'] ?>" <?= $branch_id == $branch['id'] ? 'selected' : '' ?>>
                                            <?= $branch['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label><br>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-filter"></i> Apply Filter
                            </button>
                            <a href="<?= base_url('ownerdashboard/staff_leaderboard') ?>" class="btn btn-default">
                                <i class="fa fa-refresh"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Top 3 Podium -->
        <?php if (count($staff_list) >= 3): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-trophy"></i> Top 3 Performers</h3>
                        </div>
                        <div class="box-body">
                            <div class="row text-center">
                                <!-- 2nd Place -->
                                <div class="col-md-4">
                                    <div class="podium-card" style="padding-top: 40px;">
                                        <div class="medal bg-silver" style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #C0C0C0, #E8E8E8);">
                                            <h1 class="text-white mb-0">2</h1>
                                        </div>
                                        <h3 class="mt-2"><?= $staff_list[1]['username'] ?></h3>
                                        <h2 class="text-muted"><?= number_format($staff_list[1]['trust_score'], 1) ?></h2>
                                        <p class="text-muted">
                                            <small>
                                                Sales: Rs <?= number_format($staff_list[1]['sales_amount'] ?? 0, 0) ?><br>
                                                Errors: <?= $staff_list[1]['error_count'] ?? 0 ?>
                                            </small>
                                        </p>
                                    </div>
                                </div>

                                <!-- 1st Place (Winner) -->
                                <div class="col-md-4">
                                    <div class="podium-card">
                                        <div class="medal bg-gold" style="width: 120px; height: 120px; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #FFD700, #FFA500); box-shadow: 0 6px 12px rgba(255,215,0,0.5);">
                                            <h1 class="text-white mb-0">👑</h1>
                                        </div>
                                        <h3 class="mt-2"><strong><?= $staff_list[0]['username'] ?></strong></h3>
                                        <h1 class="text-success"><strong><?= number_format($staff_list[0]['trust_score'], 1) ?></strong></h1>
                                        <p class="text-success">
                                            <strong>
                                                Sales: Rs <?= number_format($staff_list[0]['sales_amount'] ?? 0, 0) ?><br>
                                                Errors: <?= $staff_list[0]['error_count'] ?? 0 ?>
                                            </strong>
                                        </p>
                                    </div>
                                </div>

                                <!-- 3rd Place -->
                                <div class="col-md-4">
                                    <div class="podium-card" style="padding-top: 60px;">
                                        <div class="medal bg-bronze" style="width: 90px; height: 90px; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #CD7F32, #D2691E);">
                                            <h1 class="text-white mb-0">3</h1>
                                        </div>
                                        <h3 class="mt-2"><?= $staff_list[2]['username'] ?></h3>
                                        <h2 class="text-muted"><?= number_format($staff_list[2]['trust_score'], 1) ?></h2>
                                        <p class="text-muted">
                                            <small>
                                                Sales: Rs <?= number_format($staff_list[2]['sales_amount'] ?? 0, 0) ?><br>
                                                Errors: <?= $staff_list[2]['error_count'] ?? 0 ?>
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Full Leaderboard Table -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-list"></i> Complete Rankings</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-sm btn-success" onclick="exportTableToExcel()">
                        <i class="fa fa-file-excel-o"></i> Export
                    </button>
                </div>
            </div>
            <div class="box-body">
                <?php if (count($staff_list) > 0): ?>
                    <table id="staffLeaderboardTable" class="table table-bordered table-striped">
                        <thead>
                            <tr class="bg-primary">
                                <th>Rank</th>
                                <th>Staff Name</th>
                                <th>Trust Score</th>
                                <th>Sales Amount</th>
                                <th>Error Count</th>
                                <th>Return Count</th>
                                <th>Performance</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($staff_list as $staff): 
                                // Determine badge color based on rank
                                $badge_class = 'default';
                                if ($staff['rank'] == 1) $badge_class = 'success';
                                elseif ($staff['rank'] == 2) $badge_class = 'info';
                                elseif ($staff['rank'] == 3) $badge_class = 'warning';
                                
                                // Determine performance rating
                                $trust = $staff['trust_score'];
                                $perf_class = 'success';
                                $perf_text = 'Excellent';
                                if ($trust < 60) {
                                    $perf_class = 'danger';
                                    $perf_text = 'Needs Improvement';
                                } elseif ($trust < 75) {
                                    $perf_class = 'warning';
                                    $perf_text = 'Average';
                                } elseif ($trust < 90) {
                                    $perf_class = 'info';
                                    $perf_text = 'Good';
                                }
                            ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-<?= $badge_class ?>" style="font-size: 14px;">
                                            <?php if ($staff['rank'] <= 3): ?>
                                                #<?= $staff['rank'] ?> 🏆
                                            <?php else: ?>
                                                #<?= $staff['rank'] ?>
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td><strong><?= $staff['username'] ?></strong><br><small class="text-muted"><?= $staff['email'] ?></small></td>
                                    <td>
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar progress-bar-<?= $perf_class ?>" style="width: <?= $trust ?>%">
                                                <span style="line-height: 25px;"><strong><?= number_format($trust, 1) ?></strong></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rs <?= number_format($staff['sales_amount'] ?? 0, 2) ?></td>
                                    <td>
                                        <span class="badge badge-<?= $staff['error_count'] > 5 ? 'danger' : 'success' ?>">
                                            <?= $staff['error_count'] ?? 0 ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= $staff['return_count'] > 10 ? 'danger' : 'info' ?>">
                                            <?= $staff['return_count'] ?? 0 ?>
                                        </span>
                                    </td>
                                    <td><span class="label label-<?= $perf_class ?>"><?= $perf_text ?></span></td>
                                    <td><?= date('d M Y H:i', strtotime($staff['last_calculated'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">
                        <h4><i class="icon fa fa-info"></i> No Data Available</h4>
                        No staff performance data found for today. Run the daily cron job to generate scores.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Performance Distribution Chart -->
        <?php if (count($staff_list) > 0): ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart"></i> Performance Distribution</h3>
                </div>
                <div class="box-body">
                    <canvas id="performanceChart" height="80"></canvas>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#staffLeaderboard Table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "pageLength": 25,
        "order": [[0, 'asc']], // Sort by rank
        "responsive": true
    });

    <?php if (count($staff_list) > 0): ?>
        // Performance Distribution Chart
        var ctx = document.getElementById('performanceChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php echo '"' . implode('", "', array_column($staff_list, 'username')) . '"'; ?>],
                datasets: [{
                    label: 'Trust Score',
                    data: [<?php echo implode(', ', array_column($staff_list, 'trust_score')); ?>],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    <?php endif; ?>
});

function exportTableToExcel() {
    let table = document.getElementById("staffLeaderboardTable");
    let html = table.outerHTML;
    let url = 'data:application/vnd.ms-excel,' + escape(html);
    let downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    downloadLink.href = url;
    downloadLink.download = 'staff_leaderboard_' + new Date().getTime() + '.xls';
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>

<style>
.podium-card {
    padding: 20px;
    transition: transform 0.3s;
}
.podium-card:hover {
    transform: scale(1.05);
}
.medal h1 {
    font-size: 48px;
    font-weight: bold;
}
</style>
