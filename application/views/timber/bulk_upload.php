<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Timber Bulk Upload <a href="<?= base_url('timberpro') ?>" class="btn btn-sm btn-outline-primary ml-1"> <i class="fa fa-arrow-left"></i> Back</a></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <h5>1. Upload Data File</h5>
                        <p class="text-muted">Import large timber lots via CSV or Excel (XLSX) files.</p>
                        
                        <form id="bulk_form" enctype="multipart/form-data">
                            <div class="form-group mb-2">
                                <label for="type">Import Type</label>
                                <select name="type" id="import_type" class="form-control">
                                    <option value="logs">Logs (Hoppus Rule)</option>
                                    <option value="sawn">Sawn Timber (Cubic Feet)</option>
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <label for="lot_name">Lot Reference Name</label>
                                <input type="text" name="lot_name" class="form-control" placeholder="e.g. Batch_2024_02_19" required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="warehouse_id">Target Warehouse</label>
                                <select name="warehouse_id" class="form-control">
                                    <?php foreach ($warehouse as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                    } ?>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="file">Choose File (.csv, .xlsx)</label>
                                <input type="file" name="file" class="form-control-file" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block" id="submit_btn">
                                <i class="fa fa-upload"></i> Start Import Process
                            </button>
                        </form>
                    </div>

                    <div class="col-md-6 bg-light p-2">
                        <h5>2. Required File Formats</h5>
                        <div class="mb-3">
                            <h6 class="text-bold-600">Logs Format (CSV)</h6>
                            <code class="d-block p-1 bg-white border rounded">Length,Girth<br>12.5,42<br>10,38</code>
                            <small class="text-muted">Column 1: Length in Feet, Column 2: Girth in Inches.</small>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-bold-600">Sawn Format (CSV)</h6>
                            <code class="d-block p-1 bg-white border rounded">WoodTypeID,Width,Thickness,Length,Quantity<br>5,2,4,10,25<br>3,1,6,12,50</code>
                            <small class="text-muted">W, T, L in common units (Inches, Inches, Feet).</small>
                        </div>
                        
                        <div id="upload_status" class="mt-4 d-none">
                            <div class="alert alert-info">
                                <p id="status_msg" class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#bulk_form').submit(function(e) {
        e.preventDefault();
        var btn = $('#submit_btn');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
        
        $.ajax({
            url: "<?= base_url('timberpro/bulk_upload') ?>",
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                $('#upload_status').removeClass('d-none');
                if(res.status === 'Success') {
                    $('#status_msg').html('<span class="text-success text-bold-700">Import Successful!</span><br>' + res.message);
                    $('#bulk_form')[0].reset();
                } else {
                    $('#status_msg').html('<span class="text-danger text-bold-700">Error:</span> ' + res.message);
                }
                btn.prop('disabled', false).html('<i class="fa fa-upload"></i> Start Import Process');
            },
            error: function() {
                alert('Communication error with server');
                btn.prop('disabled', false).html('<i class="fa fa-upload"></i> Start Import Process');
            }
        });
    });
</script>
