<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join TimberPro Hub — <?php echo $type; ?></title>
    <meta name="description" content="Create your TimberPro Hub account as a <?php echo $type; ?>.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green:#13ec5b; --green-dk:#0fb845;
            --bg:#0f0d0c; --panel:#161412; --card:#1e1b19;
            --border:rgba(255,255,255,0.07);
            --text:#f1f5f9; --muted:#94a3b8; --dim:#4b5563;
        }
        html,body { height:100%; font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); }

        .layout { display:flex; min-height:100vh; }

        /* Left accent strip */
        .accent-strip {
            width:6px; flex-shrink:0;
            background:linear-gradient(to bottom, var(--green), #0e9a3e, transparent);
        }

        /* Card */
        .card-wrap {
            flex:1; display:flex; align-items:center; justify-content:center;
            padding:2rem 1.5rem;
        }
        .card {
            width:100%; max-width:440px;
            background:var(--panel); border:1px solid var(--border);
            border-radius:1.25rem; padding:2.5rem 2rem;
            box-shadow:0 25px 60px rgba(0,0,0,.5);
            animation:fadeUp .45s ease both;
        }
        @keyframes fadeUp { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:none} }

        /* Header */
        .header { text-align:center; margin-bottom:1.75rem; }
        .type-badge {
            display:inline-flex; align-items:center; gap:.4rem;
            background:rgba(19,236,91,.1); border:1px solid rgba(19,236,91,.2);
            color:var(--green); padding:.3rem .8rem; border-radius:999px;
            font-size:.7rem; font-weight:700; letter-spacing:.07em; text-transform:uppercase;
            margin-bottom:.9rem;
        }
        .header h1 { font-size:1.5rem; font-weight:700; margin-bottom:.3rem; }
        .header p { color:var(--muted); font-size:.85rem; }

        /* Alert */
        .alert {
            background:rgba(239,68,68,.1); border:1px solid rgba(239,68,68,.25);
            color:#fca5a5; border-radius:.6rem; padding:.7rem .9rem;
            font-size:.8rem; margin-bottom:1rem; display:flex; align-items:flex-start; gap:.5rem;
        }

        /* Fields */
        .field { margin-bottom:1.1rem; }
        .field label { display:block; font-size:.78rem; font-weight:500; color:#cbd5e1; margin-bottom:.4rem; }
        .field-inner { position:relative; }
        .icon {
            position:absolute; left:.8rem; top:50%; transform:translateY(-50%);
            color:var(--dim); font-size:18px; pointer-events:none; transition:color .2s;
        }
        .field-inner:focus-within .icon { color:var(--green); }
        input[type="text"],input[type="email"],input[type="password"] {
            width:100%; padding:.8rem 1rem .8rem 2.6rem;
            background:var(--card); border:1px solid var(--border); border-radius:.6rem;
            color:var(--text); font-size:.85rem; font-family:'Inter',sans-serif;
            transition:border-color .2s, box-shadow .2s;
        }
        input:focus { outline:none; border-color:var(--green); box-shadow:0 0 0 3px rgba(19,236,91,.1); }
        input::placeholder { color:var(--dim); }

        /* Row of two fields */
        .field-row { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; }

        /* Btn */
        .btn {
            width:100%; padding:.875rem;
            background:var(--green); border:none; border-radius:.6rem;
            color:#061209; font-size:.875rem; font-weight:700;
            letter-spacing:.03em; text-transform:uppercase; cursor:pointer;
            display:flex; align-items:center; justify-content:center; gap:.5rem;
            transition:background .2s, box-shadow .2s, transform .1s;
            margin-top:1.25rem;
        }
        .btn:hover { background:var(--green-dk); box-shadow:0 6px 24px rgba(19,236,91,.25); }
        .btn:active { transform:scale(.98); }

        /* Login link */
        .foot { text-align:center; margin-top:1.5rem; font-size:.8rem; color:var(--muted); }
        .foot a { color:var(--green); text-decoration:none; font-weight:500; }
        .foot a:hover { text-decoration:underline; }

        /* switch type */
        .switch-type { text-align:center; margin-top:.75rem; font-size:.75rem; color:var(--dim); }
        .switch-type a { color:var(--muted); text-decoration:none; }
        .switch-type a:hover { color:var(--green); }
    </style>
</head>
<body>
<div class="layout">
    <div class="accent-strip"></div>
    <div class="card-wrap">
        <div class="card">

            <div class="header">
                <div class="type-badge">
                    <span class="material-symbols-outlined" style="font-size:13px;">
                        <?php echo $type === 'Buyer' ? 'shopping_cart' : 'store'; ?>
                    </span>
                    <?php echo $type; ?>
                </div>
                <h1>Create Your Account</h1>
                <p>Join the TimberPro Hub as a <?php echo $type; ?> today.</p>
            </div>

            <?php if (isset($response) && $response): ?>
            <div class="alert">
                <span class="material-symbols-outlined" style="font-size:15px;">error</span>
                <span><?php echo $response; ?></span>
            </div>
            <?php endif; ?>

            <?php echo form_open(''); ?>

            <div class="field">
                <label>Username</label>
                <div class="field-inner">
                    <span class="material-symbols-outlined icon">person</span>
                    <input type="text" name="username" required
                           value="<?php echo set_value('username'); ?>"
                           placeholder="Choose a username">
                </div>
            </div>

            <div class="field">
                <label>Email Address</label>
                <div class="field-inner">
                    <span class="material-symbols-outlined icon">mail</span>
                    <input type="email" name="email" required
                           value="<?php echo set_value('email'); ?>"
                           placeholder="your@email.com">
                </div>
            </div>

            <div class="field">
                <label>Mobile Number</label>
                <div class="field-inner">
                    <span class="material-symbols-outlined icon">phone</span>
                    <input type="text" name="mobile" required
                           value="<?php echo set_value('mobile'); ?>"
                           placeholder="+94 7X XXX XXXX">
                </div>
            </div>

            <div class="field">
                <label>Password</label>
                <div class="field-inner">
                    <span class="material-symbols-outlined icon">lock</span>
                    <input type="password" name="password" required placeholder="Create a strong password">
                </div>
            </div>

            <button type="submit" class="btn">
                <span class="material-symbols-outlined" style="font-size:18px;">person_add</span>
                Create Account
            </button>

            <?php echo form_close(); ?>

            <div class="foot">
                Already have an account? <a href="<?php echo base_url('hub/login'); ?>">Sign in</a>
            </div>
            <div class="switch-type">
                <?php if ($type === 'Buyer'): ?>
                    Want to sell? <a href="<?php echo base_url('hub/register_seller'); ?>">Register as Seller →</a>
                <?php else: ?>
                    Want to buy? <a href="<?php echo base_url('hub/register_buyer'); ?>">Register as Buyer →</a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
</body>
</html>
