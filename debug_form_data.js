// Add this to the preview page to debug form data
// Just paste in browser console or add to preview_table.php

function debugFormData() {
    var form = $('#payroll_run_form');

    console.log('=== FORM DEBUG ===');
    console.log('Form exists:', form.length > 0);
    console.log('Form ID:', form.attr('id'));

    // Count inputs
    var allInputs = form.find('input');
    console.log('Total inputs in form:', allInputs.length);

    // List all inputs by type
    var byType = {};
    allInputs.each(function () {
        var type = $(this).attr('type') || 'unknown';
        var name = $(this).attr('name') || 'no-name';
        if (!byType[type]) byType[type] = [];
        byType[type].push(name);
    });
    console.log('Inputs by type:', byType);

    // Show what serialize returns
    var serialized = form.serialize();
    console.log('Serialized data:', serialized);

    // Parse it to show structure
    var params = new URLSearchParams(serialized);
    console.log('Parsed parameters:');
    for (let [key, value] of params) {
        console.log('  ' + key + ' = ' + value);
    }

    // Check specific fields
    console.log('\n=== CHECKING SPECIFIC FIELDS ===');
    console.log('start field:', $('input[name="start"]').val());
    console.log('end field:', $('input[name="end"]').val());
    console.log('employee_ids[]:', $('input[name="employee_ids[]"]').length, 'fields');
    console.log('hours inputs:', $('input[name^="hours"]').length);
    console.log('gross inputs:', $('input[name^="gross"]').length);

    return serialized;
}

// Run it
debugFormData();
