<style>
    .hp-create-body { padding: 1.5rem; background: #f4f7fa; }
    .glass-card {
        background: #fff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .card-header-luxury {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 2rem;
        color: #fff;
        border: none;
    }
    .card-header-luxury h4 { color: #fff; font-weight: 700; margin: 0; font-size: 1.5rem; }
    
    .form-section { margin-bottom: 2rem; }
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e3c72;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    .section-title i { margin-right: 10px; font-size: 1.2rem; color: #4facfe; }
    .section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
        margin-left: 15px;
    }

    .form-control-luxury {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }
    .form-control-luxury:focus {
        border-color: #4facfe;
        box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        background: #fff;
    }
    .col-form-label { font-weight: 600; color: #4a5568; }

    .btn-luxury-submit {
        background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
        border: none;
        border-radius: 12px;
        padding: 1rem 2.5rem;
        font-weight: 700;
        color: #fff;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 176, 155, 0.3);
    }
    .btn-luxury-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 176, 155, 0.4);
    }
    
    .guarantor-row {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 15px;
        border: 1px dashed #cbd5e0;
    }
</style>

<div class="content-body hp-create-body">
    <div class="glass-card">
        <div class="card-header card-header-luxury">
            <h4><i class="ft-edit-3"></i> New Hire Purchase Contract</h4>
            <p class="mb-0 opacity-75">Initialize a new financial agreement with automated scheduling.</p>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body p-3">
                <form method="post" id="data_form" class="form-horizontal">
                    <div class="row">
                        <!-- Customer & Contract -->
                        <div class="col-md-6 border-right">
                            <div class="form-section">
                                <div class="section-title"><i class="ft-user"></i> Customer & Product</div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="customer_id">Customer</label>
                                    <div class="col-sm-8">
                                        <select name="customer_id" class="form-control select-box" id="customer_id">
                                            <?php foreach ($customers as $row) {
                                                echo ' <option value="' . $row['id'] . '">' . $row['name'] . ' (' . $row['phone'] . ')</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="total_amount">Product Value</label>
                                    <div class="col-sm-8">
                                        <input type="number" placeholder="0.00" class="form-control form-control-luxury b_input" name="total_amount" id="total_amount">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="down_payment">Down Payment</label>
                                    <div class="col-sm-8">
                                        <input type="number" placeholder="0.00" class="form-control form-control-luxury b_input" name="down_payment" id="down_payment">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="interest_rate">Interest Rate (%)</label>
                                    <div class="col-sm-8">
                                        <input type="number" step="0.01" class="form-control form-control-luxury b_input" name="interest_rate" id="interest_rate" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Installment Plan -->
                        <div class="col-md-6">
                            <div class="form-section">
                                <div class="section-title"><i class="ft-calendar"></i> Repayment Plan</div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="num_installments">Installments</label>
                                    <div class="col-sm-8">
                                        <input type="number" placeholder="Number of payments" class="form-control form-control-luxury b_input" name="num_installments" id="num_installments">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="frequency">Frequency</label>
                                    <div class="col-sm-8">
                                        <select name="frequency" class="form-control form-control-luxury">
                                            <option value="month">Monthly</option>
                                            <option value="week">Weekly</option>
                                            <option value="day">Daily</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="start_date">Start Date</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-luxury datepicker" name="start_date" id="start_date" data-toggle="datepicker" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="notes">Internal Notes</label>
                                    <div class="col-sm-8">
                                        <textarea name="notes" class="form-control form-control-luxury" rows="2" placeholder="Optional contract details..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Guarantor Section -->
                    <div class="row mt-1">
                        <div class="col-sm-12">
                            <div class="form-section">
                                <div class="section-title"><i class="ft-shield"></i> Guarantor Information</div>
                                <div class="guarantor-row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="small font-weight-bold">FULL NAME</label>
                                            <input type="text" placeholder="John Doe" class="form-control form-control-luxury" name="g_name">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small font-weight-bold">NIC / PASSPORT</label>
                                            <input type="text" placeholder="ID Number" class="form-control form-control-luxury" name="g_nic">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small font-weight-bold">PHONE NUMBER</label>
                                            <input type="text" placeholder="+1234..." class="form-control form-control-luxury" name="g_phone">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small font-weight-bold">RESIDENTIAL ADDRESS</label>
                                            <input type="text" placeholder="Street, City" class="form-control form-control-luxury" name="g_address">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-sm-12 text-center">
                            <button type="submit" id="submit-data" class="btn btn-luxury-submit" data-loading-text="Finalizing...">
                                <i class="ft-check-circle"></i> ACTIVATE HP CONTRACT
                            </button>
                            <input type="hidden" value="hp/save" id="action-url">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.select-box').select2();
        $('.datepicker').datepicker({autoHide: true, format: 'yyyy-mm-dd'});
    });
</script>
