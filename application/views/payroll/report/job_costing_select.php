<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Generate Labor Costing Report</h5>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="post" action="<?php echo base_url('payrollreport/job_costing'); ?>">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Start Date</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="start" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">End Date</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="end" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
