<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>Sales Funnel Analysis</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="get" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Start Date</label>
                            <input type="date" name="start" class="form-control" value="<?= $start ?>">
                        </div>
                        <div class="col-md-4">
                            <label>End Date</label>
                            <input type="date" name="end" class="form-control" value="<?= $end ?>">
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label><br>
                            <button type="submit" class="btn btn-primary">Analysis</button>
                        </div>
                    </div>
                </form>
                <hr>
                
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- Funnel Visualization -->
                        <div class="funnel-container">
                            <div class="funnel-step step-1">
                                <h5>Total Leads / Traffic</h5>
                                <h2><?= $funnel['leads'] ?></h2>
                                <small>Quotes + Invoices</small>
                            </div>
                             <div class="funnel-arrow"><i class="fa fa-arrow-down"></i></div>
                            
                            <div class="funnel-step step-2">
                                <h5>Active Quotes</h5>
                                <h2><?= $funnel['quotes'] ?></h2>
                                <small>Stage 1</small>
                            </div>
                            <div class="funnel-arrow"><i class="fa fa-arrow-down"></i></div>

                            <div class="funnel-step step-3">
                                <h5>Converted Invoices</h5>
                                <h2><?= $funnel['invoices'] ?></h2>
                                <small>Stage 2 (Conversion Rate: <?= $funnel['leads'] > 0 ? round(($funnel['invoices']/$funnel['leads'])*100,1) : 0 ?>%)</small>
                            </div>
                            <div class="funnel-arrow"><i class="fa fa-arrow-down"></i></div>

                            <div class="funnel-step step-4">
                                <h5>Closed / Paid</h5>
                                <h2><?= $funnel['closed'] ?></h2>
                                <small>Stage 3</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
.funnel-container {
    text-align: center;
}
.funnel-step {
    padding: 20px;
    margin: 0 auto;
    color: white;
    border-radius: 5px;
    width: 60%;
}
.step-1 { background-color: #607d8b; width: 80%; }
.step-2 { background-color: #00bcd4; width: 70%; }
.step-3 { background-color: #ff9800; width: 60%; }
.step-4 { background-color: #4caf50; width: 50%; }
.funnel-arrow {
    margin: 10px 0;
    font-size: 20px;
    color: #ccc;
}
</style>
