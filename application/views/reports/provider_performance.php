<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h5>Provider Performance Leaderboard</h5>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="premium-card">
                <div class="premium-card-header">
                    <h5 class="premium-card-title">Top Rated Service Providers</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-premium">
                        <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Provider</th>
                            <th>Avg Rating</th>
                            <th>Total Jobs</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; foreach ($leaderboard as $row) { ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $row['username'] ?></td>
                                <td><span class="badge badge-warning"><?php echo $row['rating_avg'] ?> <i class="fa fa-star"></i></span></td>
                                <td><?php echo $row['total_jobs'] ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="premium-card mt-2">
        <div class="premium-card-header">
            <h5 class="premium-card-title">Provider Payout & Earnings Summary</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-premium">
                <thead>
                <tr>
                    <th>Provider</th>
                    <th>Total Jobs</th>
                    <th>Total Earnings (Worker Share)</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($payouts as $row) { ?>
                    <tr>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['total_jobs'] ?></td>
                        <td><?php echo number_format($row['total_earnings'], 2) ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
