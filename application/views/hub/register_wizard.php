<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join TimberPro — Registration Wizard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --accent: #22c55e;
            --accent-soft: rgba(34, 197, 94, 0.1);
            --bg: #05060a;
            --panel: rgba(16, 19, 32, 0.8);
            --border: rgba(148, 163, 184, 0.2);
            --text: #e5e7eb;
            --muted: #9ca3af;
        }
        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top, #1d283a 0, #020617 55%, #000 100%);
            color: var(--text);
            overflow: hidden;
        }

        .wizard-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .wizard-card {
            width: 100%;
            max-width: 600px;
            background: var(--panel);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 2rem;
            padding: 3rem;
            box-shadow: 0 40px 80px rgba(0,0,0,0.6);
            position: relative;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Steps Indicator */
        .steps {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2.5rem;
        }
        .step-dot {
            width: 8px;
            height: 8px;
            border-radius: 99px;
            background: var(--border);
            transition: all 0.3s;
        }
        .step-dot.active {
            background: var(--accent);
            box-shadow: 0 0 12px var(--accent);
            width: 24px;
        }

        /* Step Content */
        .step-content {
            display: none;
            animation: slideUp 0.5s ease both;
        }
        .step-content.active {
            display: block;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 { font-size: 1.75rem; font-weight: 800; margin-bottom: 0.5rem; text-align: center; }
        p.subtitle { color: var(--muted); font-size: 0.9rem; text-align: center; margin-bottom: 2rem; }

        /* Role Options */
        .role-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .role-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .role-card:hover {
            background: rgba(255,255,255,0.06);
            border-color: var(--accent);
        }
        .role-card.selected {
            background: var(--accent-soft);
            border-color: var(--accent);
            box-shadow: 0 0 20px rgba(34,197,94,0.1);
        }
        .role-icon {
            width: 48px;
            height: 48px;
            background: var(--accent-soft);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
        }
        .role-info h3 { font-size: 1rem; font-weight: 700; margin-bottom: 0.2rem; }
        .role-info p { font-size: 0.8rem; color: var(--muted); }

        /* Plan Selection */
        .plan-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1rem;
        }
        .plan-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .plan-card:hover { border-color: var(--accent); }
        .plan-card.selected { background: var(--accent-soft); border-color: var(--accent); }
        .plan-card h3 { font-size: 0.9rem; margin-bottom: 0.5rem; }
        .plan-price { font-size: 1.1rem; font-weight: 800; color: var(--accent); }
        .plan-price small { font-size: 0.6rem; color: var(--muted); }

        /* Fields */
        .field { margin-bottom: 1.25rem; }
        .field label { display: block; font-size: 0.8rem; color: var(--muted); margin-bottom: 0.5rem; }
        .input-wrap { position: relative; }
        .input-wrap span { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 20px; }
        input {
            width: 100%;
            background: rgba(0,0,0,0.2);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 0.8rem 1rem 0.8rem 2.8rem;
            color: var(--text);
            font-family: inherit;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        input:focus { outline: none; border-color: var(--accent); background: rgba(0,0,0,0.4); }

        /* Buttons */
        .actions { display: flex; gap: 1rem; margin-top: 2rem; }
        .btn {
            flex: 1;
            padding: 1rem;
            border-radius: 0.75rem;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-primary { background: var(--accent); color: #000; border: none; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(34,197,94,0.3); }
        .btn-ghost { background: transparent; color: var(--muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: rgba(255,255,255,0.05); color: var(--text); }

        .hidden { display: none; }

        .btn-demo {
            padding: 0.4rem 0.8rem;
            border-radius: 0.5rem;
            background: var(--accent);
            color: #000;
            font-size: 0.7rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            margin-left: auto;
        }
        .btn-demo:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px var(--accent-soft);
        }

        @media (max-width: 500px) {
            .wizard-card { padding: 2rem 1.5rem; border-radius: 1.5rem; }
            .plan-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="wizard-container">
    <div class="wizard-card">
        <div class="steps" id="step-indicator">
            <div class="step-dot active"></div>
            <div class="step-dot"></div>
            <div class="step-dot"></div>
        </div>

        <?php echo form_open('hub/register', ['id' => 'wizard-form']); ?>
            <input type="hidden" name="role" id="selected-role" value="Customer">
            <input type="hidden" name="plan" id="selected-plan" value="Starter">

            <!-- Step 1: Role -->
            <div class="step-content active" id="step-1">
                <h2>Choose your path</h2>
                <p class="subtitle">Tell us how you plan to use TimberPro.</p>
                
                <div class="role-grid">
                    <div class="role-card selected" onclick="selectRole('Customer', this)">
                        <div class="role-icon"><span class="material-symbols-outlined">person</span></div>
                        <div class="role-info">
                            <h3>Customer</h3>
                            <p>Browse timber, request quotes, and manage orders.</p>
                        </div>
                        <a href="<?php echo base_url('hub/demo_login/customer'); ?>" class="btn-demo" onclick="event.stopPropagation()">Try Demo</a>
                    </div>
                    <div class="role-card" onclick="selectRole('Business Owner', this)">
                        <div class="role-icon"><span class="material-symbols-outlined">storefront</span></div>
                        <div class="role-info">
                            <h3>Business Owner</h3>
                            <p>Manage inventory, sales, and multiple branches.</p>
                        </div>
                        <a href="<?php echo base_url('hub/demo_login/owner'); ?>" class="btn-demo" onclick="event.stopPropagation()">Try Demo</a>
                    </div>
                    <div class="role-card" onclick="selectRole('Service Provider', this)">
                        <div class="role-icon"><span class="material-symbols-outlined">engineering</span></div>
                        <div class="role-info">
                            <h3>Service Provider</h3>
                            <p>Offer logistics, cutting, or construction services.</p>
                        </div>
                        <a href="<?php echo base_url('hub/demo_login/provider'); ?>" class="btn-demo" onclick="event.stopPropagation()">Try Demo</a>
                    </div>
                </div>

                <div class="actions">
                    <button type="button" class="btn btn-primary" onclick="nextStep()">Continue</button>
                </div>
            </div>

            <!-- Step 2: Plan (Conditional for Business Owner) -->
            <div class="step-content" id="step-2">
                <h2>Choose your plan</h2>
                <p class="subtitle">Select the right tier for your growing business.</p>

                <div class="plan-grid">
                    <div class="plan-card selected" onclick="selectPlan('Starter', this)">
                        <h3>Starter</h3>
                        <div class="plan-price">Free<br><small>3% Commission</small></div>
                    </div>
                    <div class="plan-card" onclick="selectPlan('Pro', this)">
                        <h3>Pro Yard</h3>
                        <div class="plan-price">Rs 15k<br><small>/ month</small></div>
                    </div>
                    <div class="plan-card" onclick="selectPlan('Enterprise', this)">
                        <h3>Enterprise</h3>
                        <div class="plan-price">Rs 25k<br><small>/ month</small></div>
                    </div>
                </div>

                <div class="actions">
                    <button type="button" class="btn btn-ghost" onclick="prevStep()">Back</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep()">Continue</button>
                </div>
            </div>

            <!-- Step 3: Account Details -->
            <div class="step-content" id="step-3">
                <h2 id="final-step-title">Create Account</h2>
                <p class="subtitle">Almost there! Just a few more details.</p>

                <?php if (isset($response) && $response && !isset($success)): ?>
                <div style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #f87171; padding: 0.75rem; border-radius: 0.75rem; font-size: 0.8rem; margin-bottom: 1.5rem; text-align: center;">
                    <?php echo $response; ?>
                </div>
                <?php endif; ?>

                <div class="field">
                    <label>Full Name</label>
                    <div class="input-wrap">
                        <span class="material-symbols-outlined">person</span>
                        <input type="text" name="username" required placeholder="Ex: Kamal Perera" value="<?php echo set_value('username'); ?>">
                    </div>
                </div>

                <div class="field">
                    <label>Email Address</label>
                    <div class="input-wrap">
                        <span class="material-symbols-outlined">mail</span>
                        <input type="email" name="email" required placeholder="email@example.com" value="<?php echo set_value('email'); ?>">
                    </div>
                </div>

                <div class="field">
                    <label>Mobile Number</label>
                    <div class="input-wrap">
                        <span class="material-symbols-outlined">phone</span>
                        <input type="text" name="mobile" required placeholder="+94 7X XXX XXXX" value="<?php echo set_value('mobile'); ?>">
                    </div>
                </div>

                <div class="field">
                    <label>Secure Password</label>
                    <div class="input-wrap">
                        <span class="material-symbols-outlined">lock</span>
                        <input type="password" name="password" required placeholder="Min 8 characters">
                    </div>
                </div>

                <div class="actions">
                    <button type="button" class="btn btn-ghost" onclick="prevStep()">Back</button>
                    <button type="submit" class="btn btn-primary">Complete Registration</button>
                </div>
            </div>

            <!-- Step 4: Success Message -->
            <div class="step-content <?php echo isset($success) ? 'active' : ''; ?>" id="step-4">
                <div style="text-align: center; padding: 2rem 0;">
                    <div style="width: 80px; height: 80px; background: var(--accent-soft); border-radius: 99px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: var(--accent);">
                        <span class="material-symbols-outlined" style="font-size: 40px;">check_circle</span>
                    </div>
                    <h2>Welcome to the Ecosystem!</h2>
                    <p class="subtitle">Your account has been created successfully. You are now being redirected to your dashboard.</p>
                    
                    <div style="margin-top: 2rem;">
                        <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-primary">Go to Dashboard</a>
                    </div>
                </div>
            </div>

        <?php echo form_close(); ?>

        <div style="text-align: center; margin-top: 2rem; font-size: 0.8rem; color: var(--muted);">
            Already have an account? <a href="<?php echo base_url('hub/login'); ?>" style="color: var(--accent); font-weight: 700;">Sign In</a>
        </div>
    </div>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 3;

    function selectRole(role, el) {
        document.getElementById('selected-role').value = role;
        document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
    }

    function selectPlan(plan, el) {
        document.getElementById('selected-plan').value = plan;
        document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
    }

    function nextStep() {
        const role = document.getElementById('selected-role').value;
        
        // Skip step 2 (Plans) if not Business Owner or Service Provider
        if (currentStep === 1 && role !== 'Business Owner' && role !== 'Service Provider') {
            currentStep = 3;
        } else {
            currentStep++;
        }
        
        updateWizard();
    }

    function prevStep() {
        const role = document.getElementById('selected-role').value;
        
        // Skip step 2 backwards if not Business Owner or Service Provider
        if (currentStep === 3 && role !== 'Business Owner' && role !== 'Service Provider') {
            currentStep = 1;
        } else {
            currentStep--;
        }
        
        updateWizard();
    }

    function updateWizard() {
        // Update visibility
        document.querySelectorAll('.step-content').forEach((s, idx) => {
            s.classList.toggle('active', (idx + 1) === currentStep);
        });

        // Update dots
        document.querySelectorAll('.step-dot').forEach((d, idx) => {
            d.classList.toggle('active', (idx + 1) === currentStep);
        });

        // Special handling for step 3 title
        if (currentStep === 3) {
            const role = document.getElementById('selected-role').value;
            document.getElementById('final-step-title').innerText = `Register as ${role}`;
        }
    }
</script>

</body>
</html>
