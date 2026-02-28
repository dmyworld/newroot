<!DOCTYPE html>
<html>
<head>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        /* Modern Header */
        .modern-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .header-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white;
        }
        
        .header-logo i {
            font-size: 32px;
            color: #13ec5b;
        }
        
        .header-logo h1 {
            font-size: 28px;
            font-weight: 700;
        }
        
        .header-logo span {
            font-size: 12px;
            background: #13ec5b;
            padding: 3px 8px;
            border-radius: 4px;
            color: #1e3c72;
            font-weight: 600;
            margin-left: 5px;
        }
        
        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .header-btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        
        .header-btn.primary {
            background: #13ec5b;
            color: #1e3c72;
        }
        
        .header-btn.primary:hover {
            background: #0fc94d;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(19, 236, 91, 0.3);
        }
        
        .header-btn.secondary {
            background: transparent;
            color: white;
            border: 2px solid rgba(255,255,255,0.3);
        }
        
        .header-btn.secondary:hover {
            border-color: white;
            background: rgba(255,255,255,0.1);
        }
        
        .user-menu {
            position: relative;
        }
        
        .user-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.1);
            padding: 8px 15px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .user-trigger:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #13ec5b;
            color: #1e3c72;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        
        .user-name {
            color: white;
            font-weight: 600;
            font-size: 14px;
        }
        
        /* Navigation */
        .header-nav {
            padding: 12px 0;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 5px;
            align-items: center;
        }
        
        .nav-item a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
            font-weight: 500;
            font-size: 15px;
        }
        
        .nav-item a:hover {
            background: rgba(255,255,255,0.15);
            color: white;
        }
        
        .nav-item a.active {
            background: rgba(19, 236, 91, 0.2);
            color: #13ec5b;
        }
        
        .nav-item i {
            font-size: 16px;
        }
        
        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 8px;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .header-nav {
                display: none;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .header-actions .header-btn {
                padding: 8px 12px;
                font-size: 13px;
            }
        }
        
        @media (max-width: 768px) {
            .header-logo h1 {
                font-size: 20px;
            }
            
            .header-logo span {
                display: none;
            }
            
            .user-name {
                display: none;
            }
        }
    </style>
</head>
<body>

<header class="modern-header">
    <div class="header-container">
        <!-- Top Bar -->
        <div class="header-top">
            <a href="<?= base_url() ?>" class="header-logo">
                <i class="fa fa-tree"></i>
                <div>
                    <h1>TimberPro<span>BETA</span></h1>
                </div>
            </a>
            
            <div class="header-actions">
                <?php if($is_logged_in ?? false): ?>
                    <div class="user-menu">
                        <div class="user-trigger">
                            <div class="user-avatar">
                                <?= strtoupper(substr($usernm ?? 'U', 0, 1)) ?>
                            </div>
                            <span class="user-name"><?= htmlspecialchars($usernm ?? 'User') ?></span>
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('user') ?>" class="header-btn secondary">
                        <i class="fa fa-sign-in-alt"></i> Login
                    </a>
                    <a href="<?= base_url('user/register') ?>" class="header-btn primary">
                        <i class="fa fa-user-plus"></i> Sign Up
                    </a>
                <?php endif; ?>
                
                <button class="mobile-menu-btn">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="header-nav">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="<?= base_url() ?>">
                        <i class="fa fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('shop') ?>" class="active">
                        <i class="fa fa-store"></i> Marketplace
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('timber') ?>">
                        <i class="fa fa-clipboard-list"></i> My Listings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('shop/my_deals') ?>">
                        <i class="fa fa-handshake"></i> My Deals
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('worker/register') ?>">
                        <i class="fa fa-user-tie"></i> Worker Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('pos') ?>">
                        <i class="fa fa-cash-register"></i> POS
                    </a>
                </li>
                <?php if($is_logged_in ?? false): ?>
                <li class="nav-item">
                    <a href="<?= base_url('user/logout') ?>">
                        <i class="fa fa-sign-out-alt"></i> Logout
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

</body>
</html>
