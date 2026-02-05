<?php
// sms_sender.php - Pure PHP Solution (No JavaScript)

// Configuration - Replace with your credentials
define('NOTIFY_USER_ID', '11464');
define('NOTIFY_API_KEY', 'pUXz1mMt8GiSfiJzXNOi');
define('NOTIFY_SENDER_ID', 'NotifyDEMO');

// Initialize variables
$mobile = '';
$message = '';
$error = '';
$success = '';
$charCount = 0;
$unicodeDetected = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_sms'])) {
    $mobile = trim($_POST['mobile'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    try {
        // Validate inputs
        if (empty($mobile) || empty($message)) {
            throw new Exception("Mobile number and message are required");
        }

        if (!preg_match('/^94\d{9}$/', $mobile)) {
            throw new Exception("Invalid mobile number format. Use 947XXXXXXXX");
        }

        if (strlen($message) > 621) {
            throw new Exception("Message too long (max 621 characters)");
        }

        // Check for Unicode characters
        $unicodeDetected = preg_match('/[^\x00-\x7F]/', $message);

        // Prepare API request
        $params = [
            'user_id' => NOTIFY_USER_ID,
            'api_key' => NOTIFY_API_KEY,
            'sender_id' => NOTIFY_SENDER_ID,
            'to' => $mobile,
            'message' => $message,
            'type' => $unicodeDetected ? 'unicode' : ''
        ];

        // Send SMS via Notify.lk API
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://app.notify.lk/api/v1/send',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => true
        ]);
        
        $apiResponse = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($curlError) {
            throw new Exception("Connection error: $curlError");
        }

        $result = json_decode($apiResponse, true);
        if ($httpCode !== 200 || !isset($result['status'])) {
            throw new Exception("API request failed");
        }

        if ($result['status'] !== 'success') {
            throw new Exception($result['message'] ?? 'Failed to send SMS');
        }

        $success = 'SMS sent successfully!';
        // Clear form on success
        $mobile = '';
        $message = '';

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Calculate character count if message exists
if (!empty($message)) {
    $charCount = strlen($message);
    $unicodeDetected = preg_match('/[^\x00-\x7F]/', $message);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Sender</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-sms me-2"></i>Send SMS</h4>
                    </div>
                    
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                        <?php endif; ?>

                        <form method="post">
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                    <input type="text" class="form-control" id="mobile" name="mobile" 
                                           value="<?= htmlspecialchars($mobile) ?>" 
                                           placeholder="94771234567" required
                                           pattern="94\d{9}" 
                                           title="Format: 947XXXXXXXX">
                                </div>
                                <div class="form-text">Format: 947XXXXXXXX</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="5" 
                                          maxlength="621" required><?= htmlspecialchars($message) ?></textarea>
                                <div class="form-text">
                                    <?= $charCount ?>/621 characters
                                    <?php if ($unicodeDetected): ?>
                                        <span class="text-danger fw-bold">(Unicode detected)</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" name="send_sms" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Send SMS
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>