<!DOCTYPE html>
<html>
<head>
    <title>Subscription Pending</title>
    <link rel="stylesheet" href="<?= assets_url() ?>app-assets/<?= LTR ?>/vendors.css">
    <link rel="stylesheet" href="<?= assets_url() ?>app-assets/<?= LTR ?>/app.css">
    <style>
        body { background: #f4f7fa; display: flex; align-items: center; justify-content: center; height: 100vh; font-family: 'Inter', sans-serif; }
        .pending-card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center; max-width: 500px; }
        .icon { font-size: 60px; color: #ff9f43; margin-bottom: 20px; }
        h2 { color: #2c3e50; font-weight: 700; }
        p { color: #7f8c8d; line-height: 1.6; }
        .btn-logout { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="pending-card">
        <div class="icon"><i class="ft-clock spinner"></i></div>
        <h2>Account Activation Pending</h2>
        <p>Your subscription is currently being reviewed by our team. This usually takes 12-24 hours. You will receive an email once your account is active.</p>
        <p>Thank you for your patience!</p>
        <a href="<?= base_url('user/logout') ?>" class="btn btn-outline-danger btn-logout">Logout</a>
    </div>
</body>
</html>
