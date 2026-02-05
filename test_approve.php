<!DOCTYPE html>
<html>
<head>
    <title>Test Approve</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<h2>Manual Approval Test</h2>
<p>This will test the approval without the full framework.</p>

<button onclick="testApprove()">Test Approve Run #23</button>

<div id="result"></div>

<script>
function testApprove() {
    var runId = 23;
    
    document.getElementById('result').innerHTML = 'Sending approval request...';
    
    fetch('<?php echo "http://" . $_SERVER['HTTP_HOST']; ?>/newroot/payrollworkflow/approve', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'run_id=' + runId + '&comments=Test+Approval'
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('result').innerHTML = '<pre>' + data + '</pre>';
        console.log('Response:', data);
    })
    .catch(error => {
        document.getElementById('result').innerHTML = '<span style="color:red;">Error: ' + error + '</span>';
        console.error('Error:', error);
    });
}
</script>
</body>
</html>
