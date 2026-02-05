<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Advanced Report Center <span class="float-right"><input type="text" id="reportSearch" class="form-control form-control-sm" placeholder="Search Reports..."></span></h4>
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
                <div class="row" id="reportGrid">
                    
                    <!-- 1. CORE FINANCIAL SUITE -->
                    <div class="col-xl-3 col-md-6 col-12 report-card-wrapper">
                        <div class="card border-left-primary h-100 box-shadow-1">
                            <div class="card-body">
                                <h5 class="text-bold-600 mb-2"><i class="fa fa-university primary"></i> Core Financial Suite</h5>
                                <ul class="list-unstyled mt-1 pl-1">
                                    <li>
                                        <a href="<?= base_url('advanced_reports/consolidated_financials') ?>" class="text-dark"><i class="ft-arrow-right list-icon"></i> Consolidated Financials</a>
                                        <a href="<?= base_url('advanced_reports/export_csv/consolidated_financials') ?>" class="float-right text-muted" title="Export CSV"><i class="fa fa-download"></i></a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('advanced_reports/multi_period_analysis') ?>" class="text-dark"><i class="ft-arrow-right list-icon"></i> Multi-Period Analysis</a>
                                        <a href="<?= base_url('advanced_reports/export_csv/multi_period_analysis') ?>" class="float-right text-muted" title="Export CSV"><i class="fa fa-download"></i></a>
                                    </li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Financial Statement Designer</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> GAAP/IFRS Reports</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Earnings Per Share (EPS)</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 2. ADVANCED ACCOUNTING & AUDIT -->
                    <div class="col-xl-3 col-md-6 col-12 report-card-wrapper">
                        <div class="card border-left-info h-100 box-shadow-1">
                            <div class="card-body">
                                <h5 class="text-bold-600 mb-2"><i class="fa fa-gavel info"></i> Accounting & Audit</h5>
                                <ul class="list-unstyled mt-1 pl-1">
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Full Audit Package</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> GL Drill-Down</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Subledger Reconciliation</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Accrual to Cash Conversion</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Suspense Account Analysis</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 3. ENTERPRISE MANAGEMENT REPORTS -->
                    <div class="col-xl-3 col-md-6 col-12 report-card-wrapper">
                        <div class="card border-left-warning h-100 box-shadow-1">
                            <div class="card-body">
                                <h5 class="text-bold-600 mb-2"><i class="fa fa-line-chart warning"></i> Enterprise Management</h5>
                                <ul class="list-unstyled mt-1 pl-1">
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Executive Dashboard</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Board of Directors Package</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Investor Relations</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Bank Covenant Compliance</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Due Diligence Room</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 4. ADVANCED SALES ANALYTICS -->
                    <div class="col-xl-3 col-md-6 col-12 report-card-wrapper">
                        <div class="card border-left-success h-100 box-shadow-1">
                            <div class="card-body">
                                <h5 class="text-bold-600 mb-2"><i class="fa fa-shopping-cart success"></i> Sales Analytics</h5>
                                <ul class="list-unstyled mt-1 pl-1">
                                    <li>
                                        <a href="<?= base_url('advanced_reports/sales_funnel') ?>" class="text-dark"><i class="ft-arrow-right list-icon"></i> Sales Funnel Analysis</a>
                                        <a href="<?= base_url('advanced_reports/export_csv/sales_funnel') ?>" class="float-right text-muted" title="Export CSV"><i class="fa fa-download"></i></a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('advanced_reports/customer_lifetime_value') ?>" class="text-dark"><i class="ft-arrow-right list-icon"></i> Customer Lifetime Value</a>
                                        <a href="<?= base_url('advanced_reports/export_csv/customer_lifetime_value') ?>" class="float-right text-muted" title="Export CSV"><i class="fa fa-download"></i></a>
                                    </li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Churn Rate Analysis</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Recurring Revenue (MRR/ARR)</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Cohort & RFM Analysis</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 5. ADVANCED INVENTORY & COSTING -->
                    <!-- ... skipped content ... -->

                    <!-- 12. ADVANCED CUSTOMER ANALYTICS -->
                    <div class="col-xl-3 col-md-6 col-12 report-card-wrapper">
                        <div class="card border-left-info h-100 box-shadow-1">
                            <div class="card-body">
                                <h5 class="text-bold-600 mb-2"><i class="fa fa-users info"></i> Customer Analytics</h5>
                                <ul class="list-unstyled mt-1 pl-1">
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Profitability Analysis</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Concentration & Risk</a></li>
                                    <li>
                                        <a href="<?= base_url('advanced_reports/nps') ?>" class="text-dark"><i class="ft-arrow-right list-icon"></i> Health Score & NPS</a>
                                        <a href="<?= base_url('advanced_reports/export_csv/nps') ?>" class="float-right text-muted" title="Export CSV"><i class="fa fa-download"></i></a>
                                    </li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Journey Analysis</a></li>
                                    <li>
                                        <a href="<?= base_url('advanced_reports/churn_rate') ?>" class="text-dark"><i class="ft-arrow-right list-icon"></i> Churn Risk Analysis</a>
                                        <a href="<?= base_url('advanced_reports/export_csv/churn_risk') ?>" class="float-right text-muted" title="Export CSV"><i class="fa fa-download"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- ... -->

                    <!-- 15. INDUSTRY-SPECIFIC -->
                    <div class="col-xl-3 col-md-6 col-12 report-card-wrapper">
                        <div class="card border-left-danger h-100 box-shadow-1">
                            <div class="card-body">
                                <h5 class="text-bold-600 mb-2"><i class="fa fa-industry danger"></i> Industry Specific</h5>
                                <ul class="list-unstyled mt-1 pl-1">
                                    <li>
                                        <a href="<?= base_url('advanced_reports/retainage') ?>" class="text-dark"><i class="ft-arrow-right list-icon"></i> Construction (AIA/Retainage)</a>
                                        <a href="<?= base_url('advanced_reports/export_csv/retainage') ?>" class="float-right text-muted" title="Export CSV"><i class="fa fa-download"></i></a>
                                    </li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Manufacturing (Yield/Scrap)</a></li>
                                    <li>
                                        <a href="<?= base_url('advanced_reports/retail_traffic') ?>" class="text-dark"><i class="ft-arrow-right list-icon"></i> Retail (Traffic Heatmap)</a>
                                        <a href="<?= base_url('advanced_reports/export_csv/retail_traffic') ?>" class="float-right text-muted" title="Export CSV"><i class="fa fa-download"></i></a>
                                    </li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Professional Services</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Non-Profit (Grant/Funds)</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 16. TECH & ADMIN -->
                    <div class="col-xl-3 col-md-6 col-12 report-card-wrapper">
                        <div class="card border-left-primary h-100 box-shadow-1">
                            <div class="card-body">
                                <h5 class="text-bold-600 mb-2"><i class="fa fa-server primary"></i> Technical & Admin</h5>
                                <ul class="list-unstyled mt-1 pl-1">
                                    <li><a href="<?= base_url('advanced_reports/activity_log') ?>" class="text-dark"><i class="ft-arrow-right list-icon"></i> User Activity Analytics</a></li>
                                    <li><a href="<?= base_url('advanced_reports/system_health') ?>" class="text-dark"><i class="ft-arrow-right list-icon"></i> System Health Status</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Data Integrity</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> API Usage & Errors</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Backup Logs</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 17. EXPORT & AUTOMATION -->
                    <div class="col-xl-3 col-md-6 col-12 report-card-wrapper">
                        <div class="card border-left-info h-100 box-shadow-1">
                            <div class="card-body">
                                <h5 class="text-bold-600 mb-2"><i class="fa fa-cogs info"></i> Export & Automation</h5>
                                <ul class="list-unstyled mt-1 pl-1">
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Report Scheduler</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Automated Distribution</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Custom Report Builder</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Advanced Filtering</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Data Validation</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 18. STRATEGIC PLANNING -->
                    <div class="col-xl-3 col-md-6 col-12 report-card-wrapper">
                        <div class="card border-left-warning h-100 box-shadow-1">
                            <div class="card-body">
                                <h5 class="text-bold-600 mb-2"><i class="fa fa-compass warning"></i> Strategic Planning</h5>
                                <ul class="list-unstyled mt-1 pl-1">
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Balanced Scorecard</a></li>
                                    <li><a href="<?= base_url('advanced_reports/swot_analysis') ?>" class="text-dark"><i class="ft-arrow-right list-icon"></i> SWOT Analysis</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> M&A Integration</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Market Share Analysis</a></li>
                                    <li><a href="#" class="text-dark"><i class="ft-arrow-right list-icon"></i> Competitive Framework</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
.list-icon {
    font-size: 0.8rem;
    margin-right: 5px;
    opacity: 0.6;
}
.report-card-wrapper {
    margin-bottom: 20px;
}
</style>

<script>
$(document).ready(function(){
    $("#reportSearch").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#reportGrid .report-card-wrapper").filter(function() {
            var cardText = $(this).text().toLowerCase();
            $(this).toggle(cardText.indexOf(value) > -1)
        });
    });
});
</script>
