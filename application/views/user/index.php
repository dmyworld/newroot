<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimberPro ERP — Sign In</title>
    <meta name="description" content="Sign in to TimberPro ERP — the industry's most powerful timber processing and sales platform.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green:    #13ec5b;
            --green-dk: #0fb845;
            --bg:       #0f0d0c;
            --panel:    #161412;
            --card:     #1e1b19;
            --border:   rgba(255,255,255,0.07);
            --text:     #f1f5f9;
            --muted:    #94a3b8;
            --dim:      #4b5563;
            --red:      #ef4444;
        }

        html, body { height: 100%; font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); }

        /* ── Layout ── */
        .layout { display: flex; height: 100vh; overflow: hidden; }

        /* ── Hero Panel (left) ── */
        .hero {
            flex: 1.1;
            position: relative;
            display: none;
            background: url('https://images.unsplash.com/photo-1528323273322-d81458248d40?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
        }
        .hero::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(15,11,9,.92) 0%, rgba(15,11,9,.55) 60%, rgba(19,236,91,.08) 100%);
        }
        .hero-content {
            position: relative; z-index: 2;
            display: flex; flex-direction: column; justify-content: flex-end;
            height: 100%; padding: 3.5rem;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(19,236,91,.12); border: 1px solid rgba(19,236,91,.25);
            color: var(--green); padding: .4rem .9rem; border-radius: 999px;
            font-size: .75rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase;
            margin-bottom: 1.5rem; width: max-content;
        }
        .hero-title { font-size: clamp(2rem, 3.5vw, 3rem); font-weight: 800; line-height: 1.1; margin-bottom: 1rem; }
        .hero-title span { color: var(--green); }
        .hero-sub { color: #cbd5e1; font-size: 1rem; line-height: 1.7; max-width: 36ch; margin-bottom: 2rem; }
        .hero-stats { display: flex; gap: 2rem; }
        .stat-num { font-size: 1.5rem; font-weight: 700; color: var(--green); }
        .stat-lbl { font-size: .75rem; color: var(--muted); margin-top: .15rem; }

        /* ── Form Panel (right) ── */
        .form-panel {
            width: 100%; max-width: 480px;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            background: var(--panel); padding: 2rem 2.5rem;
            position: relative; overflow-y: auto;
        }

        /* glowing orb accent */
        .form-panel::before {
            content: '';
            position: absolute; top: -120px; right: -80px;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(19,236,91,.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .inner { width: 100%; max-width: 360px; position: relative; z-index: 1; }

        /* logo */
        .logo-wrap { display: flex; justify-content: center; margin-bottom: 2rem; }
        .logo-wrap img { height: 52px; object-fit: contain; }
        .logo-fallback {
            display: flex; align-items: center; gap: .6rem;
            font-size: 1.25rem; font-weight: 700;
        }
        .logo-fallback .dot { width: 10px; height: 10px; border-radius: 3px; background: var(--green); }

        /* heading */
        .heading { text-align: center; margin-bottom: 2rem; }
        .heading h1 { font-size: 1.6rem; font-weight: 700; margin-bottom: .35rem; }
        .heading p { color: var(--muted); font-size: .875rem; }

        /* form */
        .field { margin-bottom: 1.2rem; }
        .field label { display: block; font-size: .8rem; font-weight: 500; color: #cbd5e1; margin-bottom: .45rem; }
        .field-inner { position: relative; }
        .field-inner .icon {
            position: absolute; left: .85rem; top: 50%; transform: translateY(-50%);
            color: var(--dim); font-size: 18px; transition: color .2s;
            pointer-events: none;
        }
        .field-inner:focus-within .icon { color: var(--green); }
        input[type="text"], input[type="password"] {
            width: 100%; padding: .85rem 1rem .85rem 2.75rem;
            background: var(--card); border: 1px solid var(--border); border-radius: .6rem;
            color: var(--text); font-size: .875rem; font-family: 'Inter',sans-serif;
            transition: border-color .2s, box-shadow .2s;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(19,236,91,.12);
        }
        input::placeholder { color: var(--dim); }

        /* row between label + forgot */
        .label-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: .45rem; }
        .label-row label { margin-bottom: 0; }
        .forgot { font-size: .75rem; font-weight: 500; color: var(--green); text-decoration: none; transition: opacity .2s; }
        .forgot:hover { opacity: .75; }

        /* remember me */
        .check-row { display: flex; align-items: center; gap: .5rem; margin-top: .5rem; }
        .check-row input[type="checkbox"] { accent-color: var(--green); width: 15px; height: 15px; }
        .check-row label { font-size: .8rem; color: var(--muted); cursor: pointer; }

        /* alert */
        .alert {
            background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3);
            color: #fca5a5; border-radius: .6rem; padding: .75rem 1rem;
            font-size: .8rem; margin-bottom: 1rem; display: flex; align-items: flex-start; gap: .6rem;
        }
        .alert .material-symbols-outlined { font-size: 16px; flex-shrink: 0; margin-top: .05rem; }
        .alert-close { margin-left: auto; cursor: pointer; opacity: .6; font-size: 16px; }
        .alert-close:hover { opacity: 1; }

        /* captcha */
        .captcha-wrap { margin-bottom: 1rem; transform: scale(.85); transform-origin: left; }

        /* submit btn */
        .btn-login {
            width: 100%; padding: .9rem;
            background: var(--green); border: none; border-radius: .6rem;
            color: #0a1a0f; font-size: .875rem; font-weight: 700;
            letter-spacing: .03em; text-transform: uppercase; cursor: pointer;
            transition: background .2s, transform .1s, box-shadow .2s;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            margin-top: 1.25rem;
        }
        .btn-login:hover { background: var(--green-dk); box-shadow: 0 4px 24px rgba(19,236,91,.25); }
        .btn-login:active { transform: scale(.98); }

        /* divider */
        .divider { display: flex; align-items: center; gap: .75rem; margin: 1.5rem 0; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        .divider span { font-size: .7rem; color: var(--dim); white-space: nowrap; }

        /* register links */
        .register-links { display: flex; gap: .75rem; }
        .btn-ghost {
            flex: 1; padding: .7rem; border: 1px solid var(--border);
            background: transparent; border-radius: .6rem;
            color: var(--muted); font-size: .75rem; font-weight: 500;
            cursor: pointer; text-align: center; text-decoration: none;
            transition: border-color .2s, color .2s;
        }
        .btn-ghost:hover { border-color: var(--green); color: var(--green); }

        /* footer */
        .foot { text-align: center; margin-top: 2rem; font-size: .7rem; color: var(--dim); }

        @media (min-width: 1024px) {
            .layout { flex-direction: row; }
            .hero { display: flex; }
            .form-panel { padding: 3rem 3.5rem; }
        }

        /* smooth fade in */
        @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:none; } }
        .inner { animation: fadeUp .5s ease both; }
    </style>
</head>
<body>
<div class="layout">

    <!-- ── Hero ── -->
    <div class="hero">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="material-symbols-outlined" style="font-size:14px;">eco</span>
                TimberPro Platform
            </div>
            <h1 class="hero-title">Master Your<br><span>Timber Business.</span></h1>
            <p class="hero-sub">End-to-end ERP for lumber mills, sawmills, and timber traders — from log to ledger.</p>
            <div class="hero-stats">
                <div><div class="stat-num">500+</div><div class="stat-lbl">Active Branches</div></div>
                <div><div class="stat-num">99.9%</div><div class="stat-lbl">Uptime SLA</div></div>
                <div><div class="stat-num">24/7</div><div class="stat-lbl">Support</div></div>
            </div>
        </div>
    </div>

    <!-- ── Form ── -->
    <div class="form-panel">
        <div class="inner">

            <!-- Logo -->
            <div class="logo-wrap">
                <?php
                $logo = $this->config->item('logo');
                $logo_path = base_url('userfiles/company/') . $logo;
                if ($logo): ?>
                    <img src="<?php echo $logo_path; ?>" alt="TimberPro Logo" onerror="this.style.display='none';document.getElementById('fallback-logo').style.display='flex';">
                <?php endif; ?>
                <div class="logo-fallback" id="fallback-logo" style="display:<?php echo $logo ? 'none' : 'flex'; ?>">
                    <div class="dot"></div> TimberPro
                </div>
            </div>

            <!-- Heading -->
            <div class="heading">
                <h1>Welcome back</h1>
                <p>Sign in to your workspace to continue</p>
            </div>

            <!-- Error Alert -->
            <?php if ($response): ?>
            <div class="alert" id="login-alert">
                <span class="material-symbols-outlined">error</span>
                <span><?php echo $response; ?></span>
                <span class="material-symbols-outlined alert-close" onclick="document.getElementById('login-alert').remove()">close</span>
            </div>
            <?php endif; ?>

            <!-- Login Form -->
            <?php
                $attributes = array('id' => 'login_form', 'autocomplete' => 'on');
                echo form_open('user/checklogin', $attributes);
            ?>

                <div class="field">
                    <label for="user-email"><?php echo $this->lang->line('Your Email') ?></label>
                    <div class="field-inner">
                        <span class="material-symbols-outlined icon">person</span>
                        <input type="text" id="user-email" name="username"
                               placeholder="Username or email" required autocomplete="username">
                    </div>
                </div>

                <div class="field">
                    <div class="label-row">
                        <label for="user-pass">Password</label>
                        <a href="<?php echo base_url('user/forgot'); ?>" class="forgot">Forgot password?</a>
                    </div>
                    <div class="field-inner">
                        <span class="material-symbols-outlined icon">lock</span>
                        <input type="password" id="user-pass" name="password"
                               placeholder="Enter your password" required autocomplete="current-password">
                    </div>
                </div>

                <?php if ($this->aauth->get_login_attempts() > 1 && $captcha_on): ?>
                <div class="captcha-wrap">
                    <script src="https://www.google.com/recaptcha/api.js"></script>
                    <div class="g-recaptcha" data-sitekey="<?php echo $captcha; ?>"></div>
                </div>
                <?php endif; ?>

                <div class="check-row">
                    <input type="checkbox" id="remember-me" name="remember_me">
                    <label for="remember-me"><?php echo $this->lang->line('remember_me') ?></label>
                </div>

                <button type="submit" class="btn-login">
                    <span class="material-symbols-outlined" style="font-size:18px;">login</span>
                    <?php echo $this->lang->line('login') ?>
                </button>

            </form>

            <!-- Divider + Register -->
            <div class="divider"><span>New to TimberPro?</span></div>
            <div class="register-links">
                <a href="<?php echo base_url('hub/register_buyer'); ?>" class="btn-ghost">Register as Buyer</a>
                <a href="<?php echo base_url('hub/register_seller'); ?>" class="btn-ghost">Register as Seller</a>
            </div>

            <div class="foot">&copy; <?php echo date('Y'); ?> TimberPro Systems. All rights reserved.</div>
        </div>
    </div>

</div>
<script src="<?= assets_url(); ?>app-assets/vendors/js/vendors.min.js"></script>
</body>
</html>
