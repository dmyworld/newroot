<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join TimberPro Hub - <?php echo $type; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        :root {
            --primary-color: #13ec5b;
            --bg-dark: #1a1412;
            --surface-dark: #1a1412;
            --input-bg: #231b19;
            --text-white: #ffffff;
            --text-gray: #9ca3af;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-white);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 450px;
            padding: 2rem;
            background: #1e2023;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        p.subtitle {
            color: var(--text-gray);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            color: #d1d5db;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            background: var(--surface-dark);
            border: 1px solid #374151;
            border-radius: 0.5rem;
            color: white;
            font-size: 0.875rem;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background: var(--primary-color);
            border: none;
            border-radius: 0.5rem;
            color: var(--bg-dark);
            font-weight: 600;
            margin-top: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background: #0fb845;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.5);
            color: #fca5a5;
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: var(--text-gray);
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Register as <?php echo $type; ?></h1>
    <p class="subtitle">Join the TimberPro Hub today.</p>

    <?php if (isset($response) && $response): ?>
        <div class="alert alert-danger">
            <?php echo $response; ?>
        </div>
    <?php endif; ?>

    <?php echo form_open(''); ?>

    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" required value="<?php echo set_value('username'); ?>" placeholder="Choose a username">
    </div>

    <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" required value="<?php echo set_value('email'); ?>" placeholder="Enter your email">
    </div>

    <div class="form-group">
        <label>Mobile Number</label>
        <input type="text" name="mobile" required value="<?php echo set_value('mobile'); ?>" placeholder="Enter mobile number">
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required placeholder="Create a password">
    </div>

    <button type="submit">Create Account</button>

    <?php echo form_close(); ?>

    <div class="login-link">
        Already have an account? <a href="<?php echo base_url('hub/login'); ?>">Log in</a>
    </div>
</div>

</body>
</html>
