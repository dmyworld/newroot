// Quick fix: Instead of relying on form.serialize(), manually collect the data
$(document).on('click', '#btn_finalize_payroll', function (e) {
    e.preventDefault();

    if (!confirm('This will finalize the payroll with the values currently entered. Proceed?')) return;

    var btn = $(this);
    var form = $('#payroll_run_form');

    if (form.length == 0) {
        alert('Error: Form not found!');
        return;
    }

    // MANUAL DATA COLLECTION instead of serialize()
    var formData = {
        start: $('input[name="start"]').val(),
        end: $('input[name="end"]').val(),
        employee_ids: [],
        hours: {},
        gross: {},
        tax: {},
        deductions: {},
        advance: {},
        net_pay: {}
    };

    // Collect employee IDs
    $('input[name="employee_ids[]"]').each(function () {
        formData.employee_ids.push($(this).val());
    });

    // Collect payroll data for each employee
    $('input[name^="hours["]').each(function () {
        var match = $(this).attr('name').match(/\[(\d+)\]/);
        if (match) {
            formData.hours[match[1]] = $(this).val();
        }
    });

    $('input[name^="gross["]').each(function () {
        var match = $(this).attr('name').match(/\[(\d+)\]/);
        if (match) {
            formData.gross[match[1]] = $(this).val();
        }
    });

    $('input[name^="tax["]').each(function () {
        var match = $(this).attr('name').match(/\[(\d+)\]/);
        if (match) {
            formData.tax[match[1]] = $(this).val();
        }
    });

    $('input[name^="deductions["]').each(function () {
        var match = $(this).attr('name').match(/\[(\d+)\]/);
        if (match) {
            formData.deductions[match[1]] = $(this).val();
        }
    });

    $('input[name^="advance["]').each(function () {
        var match = $(this).attr('name').match(/\[(\d+)\]/);
        if (match) {
            formData.advance[match[1]] = $(this).val();
        }
    });

    $('input[name^="net_pay["]').each(function () {
        var match = $(this).attr('name').match(/\[(\d+)\]/);
        if (match) {
            formData.net_pay[match[1]] = $(this).val();
        }
    });

    console.log('Manual formData:', formData);

    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Finalizing...');

    $.ajax({
        url: baseurl + 'payrollprocessing/finalize',
        type: 'POST',
        data: $.param(formData) + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {
            console.log('Response:', data);
            if (data.status == 'Success') {
                alert(data.message);
                window.location.href = baseurl + 'payrollworkflow';
            } else {
                alert('Error: ' + data.message);
                btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> Submit Payroll for Approval');
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.log('Response Text:', xhr.responseText);
            alert('System Error: ' + status + ' ' + error);
            btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> Submit Payroll for Approval');
        }
    });
});
