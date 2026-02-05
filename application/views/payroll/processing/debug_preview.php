<!DOCTYPE html>
<html>
<head>
    <title>Debug Form Preview</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .debug-section { background: #f5f5f5; padding: 15px; margin: 10px 0; border-left: 4px solid #007bff; }
        .error { border-left-color: #dc3545; background: #f8d7da; }
        .success { border-left-color: #28a745; background: #d4edda; }
        input { margin: 5px; padding: 5px; }
        button { padding: 10px 20px; margin: 10px 5px; cursor: pointer; }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>🔍 Form Data Debug Tool</h1>
    
    <div class="debug-section">
        <h3>Test Form (Simulates Preview Form)</h3>
        <form id="payroll_run_form">
            <input type="hidden" name="start" value="2026-01-01">
            <input type="hidden" name="end" value="2026-01-31">
            
            <!-- Employee IDs -->
            <input type="hidden" name="employee_ids[]" value="1">
            <input type="hidden" name="employee_ids[]" value="2">
            
            <!-- Payroll Data for Employee 1 -->
            <label>Employee 1 - Hours:</label>
            <input type="number" name="hours[1]" value="160" style="width: 80px;"><br>
            
            <label>Employee 1 - Gross:</label>
            <input type="number" name="gross[1]" value="50000" style="width: 100px;"><br>
            
            <label>Employee 1 - Tax:</label>
            <input type="number" name="tax[1]" value="0" style="width: 90px;"><br>
            
            <label>Employee 1 - Deductions:</label>
            <input type="number" name="deductions[1]" value="5000" style="width: 90px;"><br>
            
            <label>Employee 1 - Advance:</label>
            <input type="number" name="advance[1]" value="0" style="width: 90px;"><br>
            
            <input type="hidden" name="net_pay[1]" value="45000">
            
            <hr>
            
            <!-- Payroll Data for Employee 2 -->
            <label>Employee 2 - Hours:</label>
            <input type="number" name="hours[2]" value="180" style="width: 80px;"><br>
            
            <label>Employee 2 - Gross:</label>
            <input type="number" name="gross[2]" value="60000" style="width: 100px;"><br>
            
            <label>Employee 2 - Tax:</label>
            <input type="number" name="tax[2]" value="0" style="width: 90px;"><br>
            
            <label>Employee 2 - Deductions:</label>
            <input type="number" name="deductions[2]" value="6000" style="width: 90px;"><br>
            
            <label>Employee 2 - Advance:</label>
            <input type="number" name="advance[2]" value="1000" style="width: 90px;"><br>
            
            <input type="hidden" name="net_pay[2]" value="53000">
        </form>
        
        <button onclick="analyzeForm()">🔍 Analyze Form</button>
        <button onclick="testSerialize()">📋 Test Serialize</button>
        <button onclick="testSubmit()">🚀 Test AJAX Submit</button>
    </div>
    
    <div id="results" class="debug-section" style="display: none;">
        <h3>Results</h3>
        <pre id="output"></pre>
    </div>
    
    <script>
        function analyzeForm() {
            var form = $('#payroll_run_form');
            var output = '';
            
            output += '📊 FORM ANALYSIS\n';
            output += '================\n\n';
            
            output += 'Form exists: ' + (form.length > 0 ? '✓ YES' : '✗ NO') + '\n';
            output += 'Form ID: ' + form.attr('id') + '\n\n';
            
            var allInputs = form.find('input');
            output += 'Total inputs: ' + allInputs.length + '\n\n';
            
            output += 'INPUTS BY NAME:\n';
            allInputs.each(function(i) {
                var name = $(this).attr('name') || 'NO NAME';
                var value = $(this).val();
                var type = $(this).attr('type') || 'text';
                output += '  [' + (i+1) + '] ' + name + ' = ' + value + ' (type: ' + type + ')\n';
            });
            
            $('#results').show();
            $('#output').text(output);
        }
        
        function testSerialize() {
            var form = $('#payroll_run_form');
            var serialized = form.serialize();
            
            var output = '';
            output += '📦 SERIALIZATION TEST\n';
            output += '=====================\n\n';
            output += 'Raw serialized string:\n';
            output += serialized + '\n\n';
            
            output += 'Decoded parameters:\n';
            var params = new URLSearchParams(serialized);
            for(let [key, value] of params) {
                output += '  ' + key + ' = ' + value + '\n';
            }
            
            $('#results').show();
            $('#output').text(output);
        }
        
        function testSubmit() {
            var form = $('#payroll_run_form');
            var formData = form.serialize();
            
            $('#results').show();
            $('#output').text('🚀 SIMULATING AJAX SUBMIT...\n\nData that would be sent:\n' + formData);
            
            // Show what PHP would receive
            setTimeout(function() {
                var output = '✅ SUCCESS!\n\nThis is what your finalize() method should receive:\n\n';
                var params = new URLSearchParams(formData);
                
                output += 'count(employee_ids): ' + $('input[name="employee_ids[]"]').length + '\n';
                output += 'count(hours): ' + $('input[name^="hours"]').length + '\n';
                output += 'count(gross): ' + $('input[name^="gross"]').length + '\n\n';
                
                output += 'Full POST array would look like:\n';
                output += '  start => ' + params.get('start') + '\n';
                output += '  end => ' + params.get('end') + '\n';
                output += '  employee_ids => Array(' + params.getAll('employee_ids[]').join(', ') + ')\n';
                output += '  hours => Array(...)\n';
                output += '  gross => Array(...)\n';
                output += '  etc...\n';
                
                $('#output').text(output);
            }, 500);
        }
    </script>
</body>
</html>
