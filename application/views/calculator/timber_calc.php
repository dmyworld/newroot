<div class="content-body">
    <div class="row">
        <!-- Main Calculator -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-gradient-x-purple-blue white">
                    <h4 class="card-title">Advanced Timber Calculator (Hoppus Rule & Sawn)</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item">
                                <a class="nav-link active" id="log-tab" data-toggle="tab" href="#log_calc" aria-controls="log_calc" aria-expanded="true">Log Volume (Hoppus)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="sawn-tab" data-toggle="tab" href="#sawn_calc" aria-controls="sawn_calc" aria-expanded="false">Sawn Timber (Cubic/Sqft)</a>
                            </li>
                        </ul>
                        <div class="tab-content px-1 pt-1">
                            <!-- Log Calculator -->
                            <div role="tabpanel" class="tab-pane active" id="log_calc" aria-labelledby="log-tab">
                                <form id="form_hoppus" class="p-2 border rounded bg-light">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Girth (G) in Inches</label>
                                            <input type="number" step="0.01" name="girth_inches" class="form-control" placeholder="Measure mid-point girth">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Length (L) in Feet</label>
                                            <input type="number" step="0.01" name="length_ft" class="form-control" placeholder="Log length">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Species (Optional)</label>
                                            <input type="text" name="species" class="form-control" placeholder="e.g. Teak, Mahogany">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Price per Cubic Foot (LKR)</label>
                                            <input type="number" step="0.01" name="price_per_cuft" class="form-control" placeholder="Optional market rate">
                                        </div>
                                    </div>
                                    <button type="button" id="btn_calc_hoppus" class="btn btn-primary btn-block">
                                        <i class="ft-play"></i> Calculate Log Volume
                                    </button>
                                </form>
                            </div>

                            <!-- Sawn Calculator -->
                            <div class="tab-pane" id="sawn_calc" role="tabpanel" aria-labelledby="sawn-tab">
                                <form id="form_sawn" class="p-2 border rounded bg-light">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>Thickness (Inches)</label>
                                            <input type="number" step="0.01" name="thickness_inches" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Width (Inches)</label>
                                            <input type="number" step="0.01" name="width_inches" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Length (Feet)</label>
                                            <input type="number" step="0.01" name="length_ft" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Quantity</label>
                                            <input type="number" name="quantity" value="1" class="form-control">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Price per Unit</label>
                                            <input type="number" step="0.01" name="price_per_unit" class="form-control">
                                        </div>
                                    </div>
                                    <button type="button" id="btn_calc_sawn" class="btn btn-success btn-block">
                                        <i class="ft-play"></i> Calculate Sawn Dimensions
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Result Section -->
                        <div id="result_box" class="mt-3 p-3 border rounded border-primary bg-primary bg-lighten-5 d-none">
                            <h5 class="text-primary"><i class="ft-info"></i> Calculation Results</h5>
                            <hr>
                            <div id="result_content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-gradient-x-info white">
                    <h4 class="card-title">Formula Guide</h4>
                </div>
                <div class="card-body">
                    <h6>Hoppus Rule (Log Volume)</h6>
                    <p class="small text-muted font-italic">Traditional Sri Lankan Standard</p>
                    <code class="p-1 d-block bg-light mb-2">V = (Girth / 4)² × Length / 144</code>
                    
                    <h6>Sawn Timber (Cubic Feet)</h6>
                    <code class="p-1 d-block bg-light mb-2">V = (T" × W" × L') / 144</code>

                    <h6>Market Accuracy Note</h6>
                    <p class="small text-warning">These calculations provide standard theoretical volume. Actual yield depends on seasoning and processing wastage.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#btn_calc_hoppus').click(function() {
        $.ajax({
            url: baseurl + 'api/calculator/log_volume',
            type: 'POST',
            data: $('#form_hoppus').serialize(),
            dataType: 'json',
            success: function(res) {
                if(res.status === 'success') {
                    $('#result_box').removeClass('d-none');
                    var html = '<h3>' + res.data.volume_cuft + ' <small>Cu.Ft</small></h3>';
                    html += '<p><strong>Price Estimate:</strong> ' + res.data.price_estimate + ' LKR</p>';
                    html += '<p class="small text-muted">Using formula: ' + res.data.formula + '</p>';
                    $('#result_content').html(html);
                }
            }
        });
    });

    $('#btn_calc_sawn').click(function() {
        $.ajax({
            url: baseurl + 'api/calculator/sawn_volume',
            type: 'POST',
            data: $('#form_sawn').serialize(),
            dataType: 'json',
            success: function(res) {
                if(res.status === 'success') {
                    $('#result_box').removeClass('d-none');
                    var html = '<div class="row">';
                    html += '<div class="col-6"><h3>' + res.data.total.cubic_ft + ' <small>Cu.Ft</small></h3></div>';
                    html += '<div class="col-6"><h3>' + res.data.total.sq_ft + ' <small>Sq.Ft</small></h3></div>';
                    html += '</div>';
                    html += '<p><strong>Running Feet:</strong> ' + res.data.total.running_ft + ' ft</p>';
                    html += '<p><strong>Total Estimate:</strong> ' + res.data.price_estimate + ' LKR</p>';
                    $('#result_content').html(html);
                }
            }
        });
    });
});
</script>
