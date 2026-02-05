<div class="card bg-light">
    <div class="card-body">
        
        <?php
            $total_gross = 0;
            $total_tax = 0;
            $total_net = 0;
            foreach($results as $row) {
                $total_gross += $row['gross'];
                $total_tax += $row['tax'];
                $total_net += $row['net_pay'];
                echo '<input type="hidden" name="employee_ids[]" value="' . $row['employee_id'] . '">';
            }
        ?>
        
        <div class="row mb-2">
             <div class="col-md-12 text-right">
                <h4 class="text-info float-left">Payroll Preview</h4>
                <button class="btn btn-success" onclick="$('#btn_finalize_payroll').click()">
                    <i class="fa fa-check"></i> Submit (Top)
                </button>
             </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h4 class="text-white">Total Gross Pay</h4>
                        <h2><?php echo amountFormat($total_gross); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h4 class="text-white">Total Taxes</h4>
                        <h2><?php echo amountFormat($total_tax); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h4 class="text-white">Total Net Pay</h4>
                        <h2><?php echo amountFormat($total_net); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <form id="payroll_run_form">
        <input type="hidden" name="start" value="<?php echo $start; ?>">
        <input type="hidden" name="end" value="<?php echo $end; ?>">
        
        <?php 
        // Add hidden inputs for all employee IDs at form level
        if (!empty($results)) {
            foreach ($results as $row) {
                echo '<input type="hidden" name="employee_ids[]" value="' . $row['employee_id'] . '">';
            }
        }
        ?>
        
        <table class="table table-bordered table-striped table-hover bg-white" id="preview_table_dt">
            <thead class="thead-dark">
                <tr>
                    <th>Employee</th>
                    <th>Hours</th>
                    <th>Gross Pay</th>
                    <th>Taxes</th>
                    <th>Deductions</th>
                    <th>Advance/Loan</th>
                    <th>Net Pay</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($results)) { 
                    foreach ($results as $row) { ?>
                <tr>
                    <td class="font-weight-bold">
                        <?php echo $row['employee_name']; ?>
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control form-control-sm calc-trigger" name="hours[<?php echo $row['employee_id']; ?>]" id="hours_<?php echo $row['employee_id']; ?>" value="<?php echo $row['hours']; ?>" style="width: 80px;">
                        <input type="hidden" id="rate_<?php echo $row['employee_id']; ?>" value="<?php echo isset($row['hourly_rate']) ? $row['hourly_rate'] : 0; ?>">
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control form-control-sm calc-trigger" name="gross[<?php echo $row['employee_id']; ?>]" id="gross_<?php echo $row['employee_id']; ?>" value="<?php echo $row['gross']; ?>" style="width: 100px;">
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control form-control-sm calc-trigger text-danger" name="tax[<?php echo $row['employee_id']; ?>]" id="tax_<?php echo $row['employee_id']; ?>" value="<?php echo $row['tax']; ?>" style="width: 90px;">
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control form-control-sm calc-trigger text-warning" name="deductions[<?php echo $row['employee_id']; ?>]" id="ded_<?php echo $row['employee_id']; ?>" value="<?php echo $row['total_deductions']; ?>" style="width: 90px;">
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control form-control-sm calc-trigger text-info" name="advance[<?php echo $row['employee_id']; ?>]" id="adv_<?php echo $row['employee_id']; ?>" value="0.00" placeholder="Advance" style="width: 90px;">
                    </td>
                    <td class="font-weight-bold text-success" style="font-size: 1.1em;">
                        <span id="net_span_<?php echo $row['employee_id']; ?>"><?php echo amountFormat($row['net_pay']); ?></span>
                        <input type="hidden" name="net_pay[<?php echo $row['employee_id']; ?>]" id="net_<?php echo $row['employee_id']; ?>" value="<?php echo $row['net_pay']; ?>">
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-info" type="button" data-toggle="collapse" data-target="#det_<?php echo $row['employee_id']; ?>">
                            <i class="fa fa-chevron-down"></i> Breakdown
                        </button>
                    </td>
                </tr>
                <tr id="det_<?php echo $row['employee_id']; ?>" class="collapse">
                    <td colspan="8" class="bg-light p-3">
                        <small class="text-muted">Note: Editing 'Total Deductions' above overrides specific breakdowns below.</small>
                        <strong>Calculated Breakdown:</strong>
                        <ul>
                            <?php foreach($row['deductions'] as $d) { ?>
                                <li><?php echo $d['name']; ?>: <strong><?php echo amountFormat($d['amount']); ?></strong></li>
                            <?php } ?>
                            <?php if(empty($row['deductions'])) echo "<li>No Deductions</li>"; ?>
                        </ul>
                    </td>
                </tr>
                <?php }} else { ?>
                <tr><td colspan="7" class="text-center p-4">No data found within the selected date range.</td></tr>
                <?php } ?>
            </tbody>
        </table>
        </form>

        <div class="row mt-4">
            <div class="col-md-12 text-right">
                <hr>
                <div class="alert alert-info text-left">
                    <i class="fa fa-info-circle"></i> <strong>Note:</strong> Finalizing will create a Payroll Run with status 'Pending'. Loan repayments will be deducted from balances upon <strong>Approval</strong>.
                </div>
                <button class="btn btn-success btn-lg shadow-lg" id="btn_finalize_payroll">
                    <i class="fa fa-check-circle"></i> Submit Payroll for Approval
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Don't use DataTable for this complex editable table with collapse rows
        // DataTable doesn't work well with collapsible child rows and editable inputs
        // Instead, we'll keep it as a static table
        
        // If you really need DataTable features, use this minimal config:
        // $('#preview_table_dt').DataTable({
        //     "paging": false,
        //     "ordering": false,
        //     "searching": false,
        //     "info": false
        // });

        // Live Recalculation
        $(document).on('keyup change', '.calc-trigger', function() {
            var row = $(this).closest('tr');
            var name_attr = $(this).attr('name');
            if(!name_attr) return; // robustness
            
            var eid = name_attr.match(/\[(.*?)\]/)[1];
            
            var gross_input = $('#gross_' + eid);
            var gross = parseFloat(gross_input.val()) || 0;
            
            // If Hours changed, recalculate Gross?
            // Problem: How do we know WHICH field changed?
            // "this" is the changed element.
            if($(this).attr('name').indexOf('hours') !== -1) {
                 var h = parseFloat($(this).val()) || 0;
                 var r = parseFloat($('#rate_' + eid).val()) || 0;
                 if(r > 0) {
                     gross = (h * r).toFixed(2);
                     gross_input.val(gross);
                 }
            }
            
            // Re-read gross in case it was updated
            gross = parseFloat(gross_input.val()) || 0;

            var tax = parseFloat($('#tax_' + eid).val()) || 0;
            var ded = parseFloat($('#ded_' + eid).val()) || 0;
            var adv = parseFloat($('#adv_' + eid).val()) || 0;
            
            var net = gross - tax - ded - adv;
            
            $('#net_' + eid).val(net.toFixed(2));
            $('#net_span_' + eid).text(net.toFixed(2));
        });

        // Unbind previous to prevent duplicates if reloaded
        $(document).off('click', '#btn_finalize_payroll');

        $(document).on('click', '#btn_finalize_payroll', function(e) {
            e.preventDefault();
            
            if(!confirm('This will finalize the payroll with the values currently entered. Proceed?')) return;
            
            var btn = $(this);
            
            // MANUAL DATA COLLECTION - Don't rely on form.serialize()
            var postData = {};
            
            // Basic fields
            postData.start = $('input[name="start"]').val();
            postData.end = $('input[name="end"]').val();
            
            // Collect employee IDs (remove duplicates)
            var employeeIds = [];
            $('input[name="employee_ids[]"]').each(function() {
                var val = $(this).val();
                if(employeeIds.indexOf(val) === -1) {
                    employeeIds.push(val);
                }
            });
            postData['employee_ids[]'] = employeeIds;
            
            // Collect payroll data arrays
            $('input[name^="hours["]').each(function() {
                postData[$(this).attr('name')] = $(this).val();
            });
            
            $('input[name^="gross["]').each(function() {
                postData[$(this).attr('name')] = $(this).val();
            });
            
            $('input[name^="tax["]').each(function() {
                postData[$(this).attr('name')] = $(this).val();
            });
            
            $('input[name^="deductions["]').each(function() {
                postData[$(this).attr('name')] = $(this).val();
            });
            
            $('input[name^="advance["]').each(function() {
                postData[$(this).attr('name')] = $(this).val();
            });
            
            $('input[name^="net_pay["]').each(function() {
                postData[$(this).attr('name')] = $(this).val();
            });
            
            console.log('Collected data:', postData);
            console.log('Employees:', employeeIds.length);
            
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Finalizing...');
            
            $.ajax({
                url: baseurl + 'payrollprocessing/finalize',
                type: 'POST',
                data: $.param(postData) + '&' + crsf_token + '=' + crsf_hash,
                dataType: 'json',
                success: function(data) {
                    console.log('Response:', data);
                    if(data.status == 'Success') {
                        alert(data.message);
                        window.location.href = baseurl + 'payrollworkflow';
                    } else {
                        alert('Error: ' + data.message);
                        btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> Submit Payroll for Approval');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.log('Response Text:', xhr.responseText);
                    alert('System Error: ' + status + ' ' + error);
                    btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> Submit Payroll for Approval');
                }
            });
        });
    });
</script>
