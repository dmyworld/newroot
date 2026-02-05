<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimberPro ERP & POS - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        :root {
            --primary-color: #13ec5b;
            --bg-dark: #1a1412;
            --surface-dark: #1a1412; /* Updated to match background */
            --input-bg: #231b19;
            --text-white: #ffffff;
            --text-gray: #9ca3af;
            --text-muted: #6b7280;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-white);
            height: 100vh;
            overflow: hidden;
            display: flex;
        }

        /* Layout */
        .container {
            display: flex;
            width: 100%;
            height: 100%;
        }

        /* Left Split - Image */
        .left-panel {
            display: none;
            flex: 1;
            position: relative;
            background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDIxnF3o2iBVNa-WL8kSDTHWu7vMROc-PlFnq1U3qUZ61X49KvUnLjBmuH9hIfNm3_aGhEbT4KwimiZInI9eHSThWiwTewGZ3PJNssxkwP18fDIxcrr8bN9aHnjRNwNrU1dP6CTVcUu3fpz3WTpqNjTh4Kqd4-L2LLT-sC5x_TaCPF6wbn5IbRubSMSIkpkGQ6z-X52rboLNEk6N1geizB85Bla-qhg0dAqmsbAvJ8MTrIa6P4z3hJsI0Tc6VuRw-hIU2t4pq3SusrG');
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(26, 20, 18, 0.9), rgba(26, 20, 18, 0.5), transparent);
            z-index: 1;
        }
        
        .left-panel::after {
            content: '';
            position: absolute;
            inset: 0;
            background-color: rgba(26, 20, 18, 0.4);
            z-index: 1;
        }

        .left-content {
            position: relative;
            z-index: 10;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 4rem;
            max-width: 40rem;
        }

        .left-content h1 {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.1;
        }

        .left-content p {
            font-size: 1.125rem;
            color: #d1d5db;
            margin-bottom: 2rem;
            max-width: 28rem;
        }

        .feature-badges {
            display: flex;
            gap: 1rem;
        }

        .badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(19, 236, 91, 0.8);
            font-size: 0.875rem;
        }

        /* Right Split - Form */
        .right-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 1.5rem;
            background-color: #1e2023; /* Updated per user request */
            position: relative;
        }

        .form-wrapper {
            width: 100%;
            max-width: 420px;
            display: flex;
            flex-direction: column;
            gap: 2rem;
            z-index: 10;
        }

        /* Logo Placeholder area */
        .logo-area {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .logo-area img {
            max-height: 5rem;
            object-fit: contain;
        }

        .header-text {
            text-align: center;
        }

        .header-text h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .header-text p {
            color: var(--text-gray);
            font-size: 0.875rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #d1d5db;
            margin-bottom: 0.5rem;
            margin-left: 0.25rem;
        }

        .form-group-inner {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            padding-left: 0.75rem;
            display: flex;
            align-items: center;
            pointer-events: none;
            color: var(--text-muted);
            transition: color 0.2s;
        }

        .form-control {
            display: block;
            width: 100%;
            border-radius: 0.5rem;
            border: 1px solid #374151; /* Added border for visibility */
            background-color: var(--surface-dark);
            color: var(--text-white);
            padding: 0.875rem 1rem 0.875rem 2.5rem; /* Left padding for icon */
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        
        .form-control:focus {
            outline: none;
            background-color: var(--input-bg);
            box-shadow: 0 0 0 2px var(--primary-color);
        }

        .form-control::placeholder {
            color: #4b5563;
        }

        .form-group-inner:focus-within .input-icon {
            color: var(--primary-color);
        }

        .btn-primary {
            display: flex;
            width: 100%;
            justify-content: center;
            border-radius: 0.5rem;
            background-color: var(--primary-color);
            padding: 0.875rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--bg-dark);
            text-transform: uppercase;
            letter-spacing: 0.025em;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background-color: #0fb845;
        }

        /* Utilities */
        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-left: 0.25rem;
        }

        .forgot-link {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--primary-color);
            text-decoration: none;
            transition: opacity 0.2s;
        }
        
        .forgot-link:hover {
            opacity: 0.8;
        }

        /* Checkbox Override */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkbox-wrapper input[type="checkbox"] {
            accent-color: var(--primary-color);
            width: 1rem;
            height: 1rem;
        }

        .checkbox-wrapper label {
            font-size: 0.875rem;
            color: var(--text-gray);
            cursor: pointer;
        }

        /* Alerts */
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
        .alert-danger {
            background-color: rgba(220, 38, 38, 0.2);
            border: 1px solid rgba(220, 38, 38, 0.5);
            color: #fca5a5;
        }
        .close {
            float: right;
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1;
            color: inherit;
            text-decoration: none;
            opacity: 0.5;
            cursor: pointer;
        }
        .close:hover { opacity: 1; }

        /* Footer */
        .footer-text {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .footer-text a {
            color: var(--text-gray);
            text-decoration: underline;
        }
        .footer-text a:hover {
            color: var(--primary-color);
        }
        
        .copyright {
            margin-top: 2rem;
            font-size: 0.625rem;
            color: #4b5563;
        }

        /* Desktop specific */
        @media (min-width: 1024px) {
            .left-panel {
                display: flex;
            }
            .right-panel {
                padding: 6rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Left Panel -->
    <div class="left-panel">
        <div class="left-content">
            <h1>Master Your Inventory.</h1>
            <p>Streamline your timber processing and sales with the industry's most robust ERP solution.</p>
            <div class="feature-badges">
                <div class="badge">
                    <span class="material-symbols-outlined">verified</span>
                    <span>Secure Access</span>
                </div>
                <div class="badge">
                    <span class="material-symbols-outlined">cloud_sync</span>
                    <span>Real-time Sync</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="right-panel">
        <div class="form-wrapper">
            
            <!-- Logo -->
            <div class="logo-area">
                 <img src="<?php echo base_url('userfiles/company/') . $this->config->item('logo'); ?>" alt="TimberPro Logo">
            </div>

            <!-- Header -->
            <div class="header-text">
                <h2>Welcome back</h2>
                <p>Please enter your credentials to access the dashboard.</p>
            </div>

            <!-- PHP Login Form -->
             <?php
                $attributes = array('id' => 'login_form');
                echo form_open('user/checklogin', $attributes);
             ?>
            
                <!-- Username -->
                <div class="form-group">
                    <label for="user-name">Username or Email</label>
                    <div class="form-group-inner">
                        <div class="input-icon">
                            <span class="material-symbols-outlined" style="font-size: 20px;">person</span>
                        </div>
                        <input type="text" class="form-control" id="user-name" name="username" 
                               placeholder="<?php echo $this->lang->line('Your Email') ?>" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <div class="flex-between">
                        <label for="user-password" style="margin-bottom: 0;">Password</label>
                        <a href="<?php echo base_url('user/forgot'); ?>" class="forgot-link"><?php echo $this->lang->line('forgot_password') ?>?</a>
                    </div>
                    <div style="margin-top: 0.5rem;" class="form-group-inner">
                        <div class="input-icon">
                            <span class="material-symbols-outlined" style="font-size: 20px;">lock</span>
                        </div>
                        <input type="password" class="form-control" id="user-password" name="password" 
                               placeholder="<?php echo $this->lang->line('Your Password') ?>" required>
                    </div>
                </div>

                <!-- Error Messages -->
                 <?php if ($response) {
                    echo '<div id="notify" class="alert alert-danger">
                        <a href="#" class="close" onclick="this.parentElement.style.display=\'none\';">&times;</a> 
                        <div class="message">' . $response . '</div>
                    </div>';
                } ?>

                <!-- Captcha (Preserved) -->
                 <?php if ($this->aauth->get_login_attempts() > 1 && $captcha_on) {
                    echo '<script src="https://www.google.com/recaptcha/api.js"></script>
                        <div class="form-group">
                          <div class="g-recaptcha" data-sitekey="' . $captcha . '"></div>
                        </div>';
                } ?>

                <!-- Remember Me -->
                <div class="form-group" style="margin-top: 1rem;">
                    <div class="checkbox-wrapper">
                         <input type="checkbox" id="remember-me" name="remember_me">
                         <label for="remember-me"><?php echo $this->lang->line('remember_me') ?></label>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-primary">
                    <?php echo $this->lang->line('login') ?>
                </button>

            </form>

            <div class="footer-text">
                <p>Having trouble logging in? <a href="#">Contact IT Support</a></p>
                <div class="copyright">
                    &copy; <?php echo date('Y'); ?> TimberPro Systems. All rights reserved.
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?= assets_url(); ?>app-assets/vendors/js/vendors.min.js"></script>
</body>
</html>
