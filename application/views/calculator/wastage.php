<div class="content-body">
    <div class="card">
        <div class="card-header bg-gradient-x-purple-blue white">
            <h4 class="card-title">Timber Wastage & Yield Analysis</h4>
            <div class="heading-elements">
                <i class="ft-percent font-medium-3"></i>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <form id="wastage_form" class="p-1">
                            <div class="form-group">
                                <label class="text-bold-600">Total Log Volume (Input Cu.Ft)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="log_volume_cuft" class="form-control" placeholder="0.00">
                                    <div class="input-group-append"><span class="input-group-text">Cu.Ft</span></div>
                                </div>
                                <small class="text-muted text-italic">Total raw material volume before processing.</small>
                            </div>
                            <div class="form-group">
                                <label class="text-bold-600">Expected/Actual Sawn Volume (Output Cu.Ft)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="expected_output_cuft" class="form-control" placeholder="0.00">
                                    <div class="input-group-append"><span class="input-group-text">Cu.Ft</span></div>
                                </div>
                                <small class="text-muted text-italic">Finished product volume after sawing/planing.</small>
                            </div>
                            <button type="button" id="btn_analyze" class="btn btn-primary btn-block btn-lg">
                                <i class="ft-bar-chart-2"></i> Analyze Yield Efficiency
                            </button>
                        </form>
                    </div>

                    <div class="col-md-6 bg-light p-2">
                        <div id="analysis_result" class="d-none text-center">
                            <h5 class="text-muted mb-2">Analysis Results</h5>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <h2 id="yield_pct" class="text-success text-bold-700">0%</h2>
                                    <small class="text-uppercase text-bold-600">Yield Efficiency</small>
                                </div>
                                <div class="col-6">
                                    <h2 id="wastage_pct" class="text-danger text-bold-700">0%</h2>
                                    <small class="text-uppercase text-bold-600">Total Wastage</small>
                                </div>
                            </div>

                            <div class="p-2 border rounded bg-white shadow-sm mb-2">
                                <p id="wastage_vol" class="h4 text-warning">0.00 <span class="small">Cu.Ft</span></p>
                                <small class="text-muted">Lost in Bark, Dust, and Offcuts</small>
                            </div>

                            <div class="alert alert-info">
                                <p id="yield_tip" class="mb-0 small font-italic"></p>
                            </div>
                        </div>
                        
                        <div id="placeholder" class="text-center py-5">
                            <i class="ft-activity font-large-3 text-muted mb-2 d-block"></i>
                            <p class="text-muted">Enter volumes to see efficiency analysis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#btn_analyze').click(function() {
        $.ajax({
            url: baseurl + 'api/calculator/wastage',
            type: 'POST',
            data: $('#wastage_form').serialize(),
            dataType: 'json',
            success: function(res) {
                if(res.status === 'success') {
                    $('#placeholder').addClass('d-none');
                    $('#analysis_result').removeClass('d-none');
                    
                    $('#yield_pct').text(res.data.yield_percent + '%');
                    $('#wastage_pct').text(res.data.wastage_percent + '%');
                    $('#wastage_vol').html(res.data.wastage_cuft + ' <span class="small">Cu.Ft</span>');
                    $('#yield_tip').text(res.data.tip);
                }
            }
        });
    });
});
</script>
