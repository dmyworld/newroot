<link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/<?= LTR ?>/core/menu/menu-types/vertical-menu-modern.css">
    <style>
        :root {
            --primary-color: #3b82f6;
            --accent-glow: rgba(59, 130, 246, 0.5);
            --bg-dark: #0f172a;
            --sidebar-bg: rgba(15, 23, 42, 0.85);
            --sidebar-hover: rgba(255, 255, 255, 0.05);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --transition-speed: 0.4s;
            --glass-bg: rgba(15, 23, 42, 0.7);
            --glass-border: rgba(255, 255, 255, 0.08); /* Updated glass border */
            --glass-reflection: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);

            /* Alive Tokens */
            --glow-pulse: 0 0 15px var(--accent-glow);
            --float-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);

            /* Section Specific Colors */
            --color-erp: #3b82f6;
            --color-hr: #10b981;
            --color-services: #8b5cf6;
            --color-tools: #f59e0b;
            --color-data: #ef4444;
        --color-settings: #06b6d4;
        --color-default: var(--primary-color);
        }

        /* Alive Keyframes */
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes glowPulse {
        0% { filter: drop-shadow(0 0 5px rgba(var(--section-accent-rgb, 59, 130, 246), 0.5)); transform: scale(1); }
        50% { filter: drop-shadow(0 0 15px rgba(var(--section-accent-rgb, 59, 130, 246), 0.8)); transform: scale(1.1); }
        100% { filter: drop-shadow(0 0 5px rgba(var(--section-accent-rgb, 59, 130, 246), 0.5)); transform: scale(1); }
    }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-3px); }
            100% { transform: translateY(0px); }
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        @keyframes textExpand {
            from { letter-spacing: normal; transform: translateX(0); }
            to { letter-spacing: 0.5px; transform: translateX(3px); }
        }

        .main-menu.menu-dark {
            background: var(--sidebar-bg) !important;
            backdrop-filter: blur(12px) saturate(160%);
            border-right: 1px solid var(--glass-border);
            transition: width var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.3);
            height: 100vh !important;
            position: fixed !important;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .main-menu-content {
            flex: 1;
            overflow-y: auto !important;
            overflow-x: hidden;
            padding-bottom: 80px; /* Space for sticky footer */
        }

        .main-menu.menu-dark .navigation {
            background: transparent !important;
            padding: 15px 0;
        }

        .navigation li {
            position: relative;
            margin: 6px 14px;
            border-radius: 10px;
            overflow: hidden;
            transition: all var(--transition-speed);
        }

        .navigation li a {
            padding: 12px 18px !important;
            display: flex !important;
            align-items: center;
            color: var(--text-secondary) !important;
            transition: all var(--transition-speed);
            position: relative;
            z-index: 1;
        }

        .navigation li.active > a,
        .navigation li:hover > a {
            background: var(--sidebar-hover) !important;
            color: var(--text-primary) !important;
            transform: translateX(4px);
        }

        .navigation li.active::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: var(--glass-reflection);
            pointer-events: none;
            opacity: 0.3;
        }

        .navigation li.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            height: 60%;
            width: 4px;
            background: var(--primary-color); /* Changed to primary-color */
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 15px var(--accent-glow);
            z-index: 5;
        }

        .navigation li i {
            font-size: 1.15rem;
            width: 38px;
            height: 38px;
            display: flex !important;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            z-index: 2;
        }

        .navigation li:hover i {
            transform: scale(1.1) translateY(-2px);
            background: rgba(var(--section-accent-rgb, 59, 130, 246), 0.15) !important;
            border-color: var(--section-accent, var(--primary-color));
            color: var(--section-accent, var(--primary-color)) !important;
            box-shadow: 0 5px 15px rgba(var(--section-accent-rgb, 59, 130, 246), 0.3);
        }

        .navigation li span {
            transition: all 0.4s ease;
            font-weight: 500;
        }

        .navigation li:hover span {
            animation: textExpand 0.4s forwards;
            color: var(--text-primary) !important;
        }

        .navigation li.active i {
            background: linear-gradient(135deg, var(--section-accent), rgba(var(--section-accent-rgb), 0.6)) !important;
            color: white !important;
            border: none;
            box-shadow: 0 5px 15px rgba(var(--section-accent-rgb), 0.4);
        }

        .navigation li .menu-content {
            background: rgba(15, 23, 42, 0.4) !important;
            border-radius: 0 0 10px 10px;
            margin: 0 !important;
            padding: 8px 0 8px 10px !important;
            border-left: 2px solid var(--glass-border);
            margin-left: 28px !important;
            list-style: none !important;
            position: relative;
        }

        /* Line Connector Effect */
        .navigation li .menu-content::before {
            content: '';
            position: absolute;
            left: -2px;
            top: 0;
            height: 100%;
            width: 2px;
            background: linear-gradient(to bottom, var(--primary-color), transparent); /* Changed to primary-color */
            opacity: 0.5;
        }

        .navigation li .menu-content li {
            margin: 2px 8px;
            border-radius: 6px;
            opacity: 0;
            animation: slideIn 0.4s ease forwards;
        }

        .navigation li.open .menu-content li:nth-child(1) { animation-delay: 0.1s; }
        .navigation li.open .menu-content li:nth-child(2) { animation-delay: 0.15s; }
        .navigation li.open .menu-content li:nth-child(3) { animation-delay: 0.2s; }
        .navigation li.open .menu-content li:nth-child(4) { animation-delay: 0.25s; }
        .navigation li.open .menu-content li:nth-child(5) { animation-delay: 0.3s; }
        .navigation li.open .menu-content li:nth-child(6) { animation-delay: 0.35s; }

        .navigation li .menu-content li a {
            padding: 8px 12px !important;
            font-size: 0.85rem;
            opacity: 0.8;
            display: flex !important;
            align-items: center;
            color: var(--text-secondary) !important;
            transition: all 0.3s ease;
        }

        .navigation li.active > a {
            background: rgba(var(--section-accent-rgb, 59, 130, 246), 0.1) !important;
            color: var(--text-primary) !important;
            border-left: 3px solid var(--section-accent, var(--primary-color));
        }

        .navigation li.active > a i {
            color: var(--section-accent, var(--primary-color)) !important;
            opacity: 1;
        }

        .navigation li .menu-content li.active a {
            background: rgba(var(--section-accent-rgb, 59, 130, 246), 0.15) !important;
            color: var(--section-accent, var(--primary-color)) !important;
            border-radius: 20px;
            font-weight: 600;
            padding-left: 20px !important;
            transition: all 0.3s ease;
        }

        .navigation li .menu-content li.active a i {
            color: var(--section-accent, var(--primary-color)) !important;
            animation: float 2s infinite ease-in-out;
        }

        .navigation li .menu-content li a:hover {
            opacity: 1;
            transform: translateX(5px);
            background: rgba(255, 255, 255, 0.05) !important;
        }

        .navigation li .menu-content li a i {
            font-size: 0.9rem;
            margin-right: 10px;
            width: 18px;
        }

        /* Modern Scrollbar */
        .main-menu-content::-webkit-scrollbar {
            width: 5px;
        }
        .main-menu-content::-webkit-scrollbar-track {
            background: transparent;
        }
        .main-menu-content::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            border: 1px solid transparent;
            background-clip: padding-box;
        }
        .main-menu-content::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* User Section Refinement */
        .navbar-header {
            background: var(--sidebar-bg) !important;
            padding: 1.2rem 0;
            border-bottom: 1px solid var(--glass-border);
        }

        .brand-logo {
            filter: drop-shadow(0 0 10px var(--accent-glow));
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .brand-logo:hover {
            transform: translateY(-2px) scale(1.05);
            filter: drop-shadow(0 5px 15px var(--accent-glow));
        }

        /* Header Navbar Glassmorphism */
        .header-navbar {
            background: rgba(15, 23, 42, 0.8) !important;
            backdrop-filter: blur(15px) saturate(180%) !important;
            border-bottom: 1px solid var(--glass-border) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Kept original box-shadow */
        }

        .header-navbar .navbar-header {
            background: transparent !important;
        }

        .header-navbar .navbar-container {
            padding: 0 1.5rem;
        }

        .nav-item .btn-info {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2563eb 100%) !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 10px !important;
            letter-spacing: 0.5px;
            font-weight: 600;
            overflow: hidden;
            position: relative;
        }

        .nav-item .btn-info::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 3s infinite;
        }

        .nav-item .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4) !important;
            filter: brightness(1.1);
        }

        /* Top Bar Icons Hover */
        .header-navbar .nav-link-label i {
            transition: all 0.3s ease;
        }

        .header-navbar .nav-link-label:hover i {
            color: var(--primary-color) !important;
            animation: bounce 0.6s ease-in-out;
            filter: drop-shadow(0 0 8px var(--accent-glow));
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px) scale(1.1); }
        }

        .header-navbar .nav-link span, 
        .header-navbar .btn-info {
            transition: all 0.3s ease;
        }

        .header-navbar .nav-link:hover span {
            letter-spacing: 0.5px;
            color: var(--primary-color) !important;
        }

        /* Avatar & Badges Polishing */
        .avatar-online i {
            background-color: #10b981 !important;
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.6) !important;
            border: 2px solid #0f172a !important;
            bottom: 2px !important;
            right: 2px !important;
        }

        .badge-up {
            top: 4px !important;
            right: 4px !important;
            padding: 4px 6px !important;
            font-size: 0.6rem !important;
            font-weight: 700 !important;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.5) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .badge-danger {
            background: linear-gradient(135deg, #ef4444, #991b1b) !important;
            animation: glowPulse 2s infinite !important;
        }

        .badge-info {
            background: linear-gradient(135deg, #0ea5e9, #0369a1) !important;
        }

        /* Top Search Polish */
        .header-navbar .search-input input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 12px !important;
            color: var(--text-primary) !important;
            padding: 10px 15px !important;
            transition: all 0.3s ease !important;
        }

        .header-navbar .search-input input:focus {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 15px var(--accent-glow) !important;
            outline: none !important;
        }

        /* Layout Fix for Fixed Sidebar */
        body.menu-expanded .app-content {
            margin-left: 260px !important;
            transition: margin-left var(--transition-speed);
        }
        body.menu-collapsed .app-content {
            margin-left: 80px !important;
            transition: margin-left var(--transition-speed);
        }
        .header-navbar.navbar-fixed {
            left: 260px !important;
            width: calc(100% - 260px) !important;
            transition: all var(--transition-speed);
        }
        body.menu-collapsed .header-navbar.navbar-fixed {
            left: 80px !important;
            width: calc(100% - 80px) !important;
        }

        /* Section Dynamic Overrides */
        .section-erp { --section-accent: var(--color-erp); --section-accent-rgb: 59, 130, 246; }
        .section-hr { --section-accent: var(--color-hr); --section-accent-rgb: 16, 185, 129; }
        .section-services { --section-accent: var(--color-services); --section-accent-rgb: 139, 92, 246; }
        .section-tools { --section-accent: var(--color-tools); --section-accent-rgb: 245, 158, 11; }
        .section-data { --section-accent: var(--color-data); --section-accent-rgb: 239, 68, 68; }
    .section-settings { --section-accent: var(--color-settings); --section-accent-rgb: 6, 182, 212; }
    .section-default { --section-accent: var(--color-default); --section-accent-rgb: 59, 130, 246; }

        .navigation-header {
            color: var(--text-secondary);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.1rem;
            padding: 1.5rem 1.5rem 0.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }

        .navigation-header::after {
            content: '';
            height: 1px;
            flex-grow: 1;
            background: linear-gradient(90deg, var(--section-accent, var(--glass-border)), transparent);
            opacity: 0.4;
        }

        .navigation-header span {
            background: linear-gradient(90deg, var(--text-primary), var(--text-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        /* Update Active-Pill with Section Accent */
        .menu-item.active > a {
            background: linear-gradient(135deg, 
                rgba(var(--section-accent-rgb, 59, 130, 246), 0.15), 
                rgba(var(--section-accent-rgb, 59, 130, 246), 0.05)
            ) !important;
            color: var(--section-accent, #3b82f6) !important;
            border-right: 3px solid var(--section-accent, #3b82f6);
            box-shadow: -10px 0 20px rgba(0, 0, 0, 0.2);
        }
        /* Section Specific Personalities */
        .section-erp.active > a i, .section-erp.menu-item.active > a i { animation: glowPulse 2s infinite; }
        .section-hr.active > a i, .section-hr.menu-item.active > a i { filter: drop-shadow(0 0 8px var(--color-hr)); animation: float 3s infinite ease-in-out; }
        .section-services.active > a i, .section-services.menu-item.active > a i { animation: float 1.5s infinite ease-in-out; filter: drop-shadow(0 0 10px var(--color-services)); }
        .section-tools.active > a i, .section-tools.menu-item.active > a i { transform: rotate(10deg); color: var(--color-tools) !important; filter: drop-shadow(0 0 5px var(--color-tools)); }
        .section-data.active > a i, .section-data.menu-item.active > a i { animation: heartbeat 1.5s infinite; filter: drop-shadow(0 0 8px var(--color-data)); }

        @keyframes heartbeat {
            0% { transform: scale(1); }
            14% { transform: scale(1.15); }
            28% { transform: scale(1); }
            42% { transform: scale(1.15); }
            70% { transform: scale(1); }
        }
        .sidebar-search-container {
            padding: 15px 18px;
            margin-bottom: 10px;
        }
        .sidebar-search {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-primary);
            padding: 12px 20px;
            width: 100%;
            font-size: 0.85rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(5px);
            margin: 10px 0;
        }
        .sidebar-search:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent-color);
            box-shadow: 0 0 20px var(--accent-glow);
            transform: translateY(-1px);
        }

        /* Sidebar Footer Social Icons Redesign */
        .sidebar-footer {
            padding: 15px;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(10px);
            border-top: 1px solid var(--glass-border);
            display: flex;
            justify-content: space-around;
            align-items: center;
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 10;
        }

        .sidebar-footer a.social-icon {
            width: 38px;
            height: 38px;
            display: flex !important;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 50% !important;
            color: var(--text-secondary) !important;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none !important;
        }

        .sidebar-footer a.social-icon:hover {
            transform: translateY(-5px) scale(1.1);
            background: rgba(var(--section-accent-rgb, 59, 130, 246), 0.15) !important;
            border-color: var(--section-accent, var(--primary-color));
            color: var(--section-accent, var(--primary-color)) !important;
            box-shadow: 0 5px 15px rgba(var(--section-accent-rgb, 59, 130, 246), 0.3);
        }

        .sidebar-footer a.social-icon i {
            font-size: 1.15rem;
            margin: 0 !important;
            width: auto !important;
            height: auto !important;
            background: none !important;
            border: none !important;
            box-shadow: none !important;
            transition: transform 0.3s ease;
        }

        .sidebar-footer a.social-icon:hover i {
            transform: rotate(15deg);
        }

        /* Top Navbar Social Style */
        .social-icon-top {
            padding: 0 8px !important;
            transition: all 0.3s ease;
        }

        .social-icon-top i {
            font-size: 1.1rem !important;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
        }

        .social-icon-top:hover i {
            animation: bounce 0.6s ease-in-out;
            color: var(--primary-color) !important;
            filter: drop-shadow(0 0 8px var(--accent-glow));
        }

        /* Dropdown Enhancements */
        .dropdown-menu {
            background: var(--glass-bg) !important;
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            border-radius: 12px;
            margin-top: 10px !important;
            padding: 10px;
        }

        .dropdown-item {
            border-radius: 8px;
            transition: all 0.2s ease;
            color: var(--text-secondary) !important;
            padding: 10px 15px;
        }


        :root {
            /* Timber Professional Palette */
            --timber-dark: #1a1412;        /* Deepest Oak - Main Background */
            --timber-panel: #261e1b;       /* Dark Walnut - Panel Background */
            --timber-accent: #e6b800;      /* Golden Oak - Primary Accent */
            --timber-green: #3a5a40;       /* Forest Pine - Secondary Accent */
            --timber-text: #f0f0f0;        /* White Birch - Primary Text */
            --timber-text-muted: #a8a29e;  /* Ash - Secondary Text */
            --timber-border: rgba(230, 184, 0, 0.15); /* Golden Glow Border */
            
            /* Glassmorphism Variables */
            --glass-bg: rgba(38, 30, 27, 0.85);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        /* Navbar Global Overrides */
        .header-navbar.navbar-semi-dark .navbar-header {
            background: var(--timber-dark) !important;
            border-right: 1px solid var(--timber-border);
            box-shadow: 10px 0 30px rgba(0,0,0,0.5);
        }

        .header-navbar .navbar-header .navbar-brand .brand-logo {
            filter: drop-shadow(0 0 5px var(--timber-accent));
            transition: all 0.3s ease;
        }

        .header-navbar.navbar-semi-dark {
            background: linear-gradient(135deg, var(--timber-dark) 0%, var(--timber-panel) 100%) !important;
            border-bottom: 1px solid var(--timber-border);
        }

        /* Nav Links */
        .header-navbar .nav-link {
            color: var(--timber-text) !important;
            transition: all 0.3s ease;
            position: relative;
        }

        .header-navbar .nav-link:hover {
            color: var(--timber-accent) !important;
            text-shadow: 0 0 10px rgba(230, 184, 0, 0.4);
        }

        .header-navbar .nav-link i {
            font-size: 1.2rem;
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .header-navbar .nav-link:hover i {
            transform: translateY(-2px);
            color: var(--timber-accent) !important;
        }

        /* Buttons in Nav */
        .header-navbar .btn-info {
            background: linear-gradient(45deg, var(--timber-green), #588157) !important;
            border: none;
            box-shadow: 0 4px 15px rgba(58, 90, 64, 0.4);
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .header-navbar .btn-info:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(58, 90, 64, 0.6);
        }

        /* Mega Dropdown - Timber Style */
        .mega-dropdown-menu {
            width: 90vw !important;
            max-width: 1400px !important;
            left: 5vw !important;
            padding: 30px !important;
            background: rgba(26, 20, 18, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid var(--timber-border) !important;
            border-radius: 12px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8) !important;
        }

        /* Mega Dropdown Sections */
        .mega-dropdown-menu .card-header .text-uppercase {
            color: var(--timber-accent) !important;
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mega-dropdown-menu .card-header i {
            color: var(--timber-accent) !important;
            background: rgba(230, 184, 0, 0.1);
            padding: 8px;
            border-radius: 6px;
        }

        .mega-dropdown-menu .dropdown-item {
            color: var(--timber-text-muted) !important;
            padding: 10px 15px !important;
            border-radius: 6px;
            margin-bottom: 2px;
            transition: all 0.2s ease;
            border-left: 2px solid transparent;
        }

        .mega-dropdown-menu .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.03) !important;
            color: var(--timber-text) !important;
            border-left: 2px solid var(--timber-accent);
            padding-left: 20px !important;
        }

        .mega-dropdown-menu .dropdown-item i {
            color: var(--timber-green) !important;
            opacity: 0.7;
        }

        /* Horizontal Menu (if active) */
        .main-menu.menu-dark {
            background: var(--timber-panel) !important;
            border-right: 1px solid var(--timber-border);
        }
        
        .main-menu.menu-dark .navigation > li.active > a {
            background: linear-gradient(90deg, rgba(230, 184, 0, 0.1), transparent) !important;
            border-left: 4px solid var(--timber-accent);
        }

        /* Clean up existing overrides */
        .dropdown-menu-header { border-bottom: 1px solid var(--glass-border); }
        .dropdown-item:active { background-color: var(--timber-accent) !important; }

        /* ================================================================================= */
        /* TIMBER SIDEBAR REDESIGN                                                           */
        /* ================================================================================= */

        /* Main Menu Container */
        .main-menu.menu-dark {
            background-color: var(--timber-panel) !important;
            background-image: linear-gradient(180deg, rgba(255,255,255,0.02) 0%, rgba(0,0,0,0.1) 100%);
            border-right: 1px solid var(--timber-border);
            box-shadow: 5px 0 20px rgba(0,0,0,0.5);
        }

        /* Section Headers (e.g., MAIN, ERP OPERATIONS) */
        .main-menu.menu-dark .navigation > .navigation-header {
            color: var(--timber-accent) !important;
            font-weight: 800;
            font-size: 0.75rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 24px 24px 8px 24px;
            opacity: 1;
        }
        
        .main-menu.menu-dark .navigation > .navigation-header span {
             border-bottom: 2px solid rgba(230, 184, 0, 0.3);
             padding-bottom: 4px;
        }

        /* Top Level Menu Items */
        .main-menu.menu-dark .navigation > li > a {
            color: var(--timber-text) !important;
            padding: 12px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            margin: 2px 0;
        }

        .main-menu.menu-dark .navigation > li:not(.active) > a:hover {
            background: rgba(58, 90, 64, 0.2);
            color: #fff !important;
            padding-left: 28px;
        }

        /* Active Top Level Item */
        .main-menu.menu-dark .navigation > li.active > a {
            background: linear-gradient(90deg, rgba(230, 184, 0, 0.15), transparent) !important;
            border-left: 4px solid var(--timber-accent);
            color: var(--timber-accent) !important;
            box-shadow: inset 5px 0 10px -5px rgba(230, 184, 0, 0.2);
        }
        
        .main-menu.menu-dark .navigation > li.active > a i {
             color: var(--timber-accent) !important;
             filter: drop-shadow(0 0 5px rgba(230, 184, 0, 0.6));
        }

        /* Icon Styling */
        .main-menu.menu-dark .navigation > li > a i {
            color: var(--timber-text-muted);
            font-size: 1.1rem;
            margin-right: 12px;
            transition: all 0.3s;
        }
        
        .main-menu.menu-dark .navigation > li:hover > a i {
            color: var(--timber-accent);
            transform: scale(1.1);
        }

        /* ================================================================================= */
        /* NESTED MENU STYLING (Level 2 & 3)                                                 */
        /* ================================================================================= */

        /* Level 2 Container */
        .main-menu.menu-dark .navigation > li ul.menu-content {
            background: rgba(0, 0, 0, 0.2) !important;
            box-shadow: inset 0 5px 15px -5px rgba(0,0,0,0.5);
        }

        /* Level 2 Items */
        .main-menu.menu-dark .navigation > li .menu-content > li > a {
            padding: 10px 15px 10px 54px !important;
            font-size: 0.9rem;
            color: var(--timber-text-muted) !important;
            transition: all 0.2s;
            position: relative;
        }
        
        /* Tree Branch Line for Level 2 */
        .main-menu.menu-dark .navigation > li .menu-content > li > a:before {
            content: '';
            position: absolute;
            left: 36px;
            top: 50%;
            height: 1px;
            width: 8px;
            background: rgba(255,255,255,0.1);
            transition: all 0.3s;
        }

        .main-menu.menu-dark .navigation > li .menu-content > li:hover > a {
            color: var(--timber-text) !important;
            background: transparent;
            transform: translateX(5px);
        }
        
        .main-menu.menu-dark .navigation > li .menu-content > li:hover > a:before {
             background: var(--timber-accent);
             width: 12px;
        }

        /* Level 2 Active */
        .main-menu.menu-dark .navigation > li .menu-content > li.active > a {
            color: var(--timber-accent) !important;
            font-weight: 600;
        }
        
        .main-menu.menu-dark .navigation > li .menu-content > li.active > a:before {
             background: var(--timber-accent);
             width: 12px;
             box-shadow: 0 0 5px var(--timber-accent);
        }

        /* ================================================================================= */
        /* LEVEL 3 ITEMS                                                                     */
        /* ================================================================================= */
        
        /* Level 3 Container */
        .main-menu.menu-dark .navigation > li .menu-content .menu-content {
             background: rgba(0, 0, 0, 0.15) !important; /* Slightly darker */
        }

        /* Level 3 Items */
        .main-menu.menu-dark .navigation > li .menu-content .menu-content > li > a {
            padding: 10px 15px 10px 50px !important; /* Adjusted Indent */
            font-size: 0.85rem;
            color: var(--timber-text-muted) !important;
            white-space: normal !important; /* Fix truncation */
            height: auto !important;
            display: flex !important;
            align-items: flex-start;
            line-height: 1.4;
        }
        
         /* Tree Branch Line for Level 3 */
        .main-menu.menu-dark .navigation > li .menu-content .menu-content > li > a:before {
            left: 36px; /* Shift line to match Level 2 alignment */
            top: 20px; /* Align with first line of text */
        }
        
        .main-menu.menu-dark .navigation > li .menu-content .menu-content > li:hover > a {
            color: var(--timber-text) !important;
            background: rgba(255,255,255,0.03);
        }
        
        .main-menu.menu-dark .navigation > li .menu-content .menu-content > li.active > a {
            color: var(--timber-accent) !important;
        }

        /* Search Box in Sidebar */
        .sidebar-search-container {
            padding: 20px;
            background: var(--timber-dark);
            border-bottom: 1px solid var(--timber-border);
        }
        
        .sidebar-search {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            color: var(--timber-text);
            padding: 8px 15px;
            width: 100%;
            font-size: 0.85rem;
            transition: all 0.3s;
        }
        
        .sidebar-search:focus {
            outline: none;
            border-color: var(--timber-accent);
            background: rgba(0,0,0,0.3);
            box-shadow: 0 0 10px rgba(230, 184, 0, 0.1);
        }

        /* ================================================================================= */
        /* MENU TOGGLE ICONS (ARROWS)                                                        */
        /* ================================================================================= */

        /* Base Arrow Style */
        .main-menu.menu-dark .navigation > li.has-sub > a:after {
            content: '\f105'; /* FontAwesome Chevron Right */
            font-family: 'FontAwesome';
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            color: var(--timber-text-muted);
            transition: all 0.3s ease;
        }

        /* Rotate Arrow when Open */
        .main-menu.menu-dark .navigation > li.open > a:after {
            transform: translateY(-50%) rotate(90deg);
            color: var(--timber-accent);
        }

        /* Hide default Theme arrows if any */
        .main-menu.menu-dark .navigation > li.has-sub > a > span.description {
            display: none !important; 
        }

        /* ================================================================================= */
        /* SIDEBAR WIDTH ADJUSTMENT (300px)                                                  */
        /* ================================================================================= */
        
        @media (min-width: 768px) {
            /* Increase Sidebar Width */
            body.vertical-layout.vertical-menu-modern.menu-expanded .main-menu {
                width: 300px !important;
            }

            /* Adjust Content Margin */
            body.vertical-layout.vertical-menu-modern.menu-expanded .content,
            body.vertical-layout.vertical-menu-modern.menu-expanded .footer {
                margin-left: 300px !important;
            }
            
            /* Adjust Navbar Header (Logo Area) */
            body.vertical-layout.vertical-menu-modern.menu-expanded .navbar .navbar-header {
                width: 300px !important; 
            }
            
            /* Adjust Navbar Container positions */
            body.vertical-layout.vertical-menu-modern.menu-expanded .navbar .navbar-container {
                margin-left: 300px !important;
            }
            
            /* Ensure fixed navbar matches */
            body.vertical-layout.vertical-menu-modern.menu-expanded .header-navbar.fixed-top {
                left: 0; 
            }
        }

        /* ================================================================================= */
        /* VISUAL REFINEMENTS (Typography, Icons, Animation)                                 */
        /* ================================================================================= */

        /* 1. Bold Typography */
        .main-menu.menu-dark .navigation .navigation-header {
            font-weight: 800 !important;
            letter-spacing: 1.5px;
            color: var(--timber-accent);
            opacity: 1; /* Make headers fully visible */
        }

        .main-menu.menu-dark .navigation > li > a {
            font-weight: 600;
        }

        /* 2. Related Icons & Colors */
        /* Level 1 Icons - Default to Timber Accent (Golden Oak) */
        .main-menu.menu-dark .navigation > li > a > i {
            color: var(--timber-accent) !important;
            opacity: 0.8;
            transition: all 0.3s;
        }
        
        /* Brighten on Hover/Active */
        .main-menu.menu-dark .navigation > li:hover > a > i,
        .main-menu.menu-dark .navigation > li.active > a > i {
            color: var(--timber-green) !important; /* Switch to Green on interaction */
            opacity: 1;
            text-shadow: 0 0 8px rgba(76, 175, 80, 0.4);
        }

        /* Level 3 "Leaf" Icon */
        .main-menu.menu-dark .navigation > li .menu-content .menu-content > li > a:before {
            content: '\f06c' !important; /* FontAwesome Leaf */
            font-family: 'FontAwesome';
            font-size: 0.7rem;
            color: var(--timber-green); /* Green Leaf */
            top: 22px; /* Adjust alignment */
            background: none; /* Remove previous line style if specific */
            width: auto;
            height: auto;
        }

        /* 3. New Animation Style */


    </style>
    <script type="text/javascript">
        var baseurl = '<?php echo base_url(); ?>';
        var crsf_token = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var crsf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>
</head>
<body class="vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar dark-layout" data-open="click"
      data-menu="vertical-menu-modern" data-col="2-columns" style="background: var(--timber-dark);">
<span id="hdata"
      data-df="<?php echo $this->config->item('dformat2'); ?>"
      data-curr="<?php echo currency($this->aauth->get_user()->loc); ?>"></span>
<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header" style="padding: 0; width: 300px; height: 56px;">
             <a href="<?= base_url() ?>dashboard/" style="display: block; width: 100%; height: 100%;">
                 <img 
                      src="<?php echo base_url(); ?>userfiles/theme/logo-header.png" style="width: 300px; height: 56px; object-fit: fill;">
             </a>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                                                              href="#"><i class="ft-menu"></i></a></li>


                    <li class="dropdown  nav-item"><a class="nav-link nav-link-label" href="#"
                                                      data-toggle="dropdown"><i
                                    class="ficon ft-map-pin success"></i></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-left">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><i
                                                class="ficon ft-map-pin success"></i><?php echo $this->lang->line('Business') . ' ' . $this->lang->line('Location') ?></span>
                                </h6>
                            </li>

                            <li class="dropdown-menu-footer"><span class="dropdown-item text-muted text-center blue"
                                > <?php $loc = location($this->aauth->get_user()->loc);
                                    echo $loc['cname']; ?></span>
                            </li>
                        </ul>
                    </li>
                    <?php if ($this->aauth->premission(1)) { ?>
                    <li class="nav-item d-none d-md-block nav-link "><a href="<?= base_url() ?>pos_invoices/create"
                                                                        class="btn btn-info btn-md t_tooltip"
                                                                        title="Access POS"><i
                                    class="icon-handbag"></i><?php echo $this->lang->line('POS') ?> </a>
                    </li>
                    <?php } ?>
                    
                    <li class="nav-item d-none d-md-block nav-link "><a href="<?= base_url() ?>products_alert/manage_alert2"
                                                                        class="btn btn-info btn-md t_tooltip"
                                                                        title="Advanced Alert Management System"><i
                                    class="ft-bell mr-1"></i>Alerts </a>
                    </li>
                    <li class="nav-item d-none d-md-block nav-link "><a href="<?= base_url() ?>products/stock_transfer"
                                                                        class="btn btn-info btn-md t_tooltip"
                                                                        title="Stock Transfer"><i
                                    class="ft-repeat mr-1"></i>Transfer </a>
                    </li>

                </ul>

                <ul class="nav navbar-nav float-right"><?php if ($this->aauth->get_user()->roleid == 5) { ?>
                        <li class="dropdown nav-item mega-dropdown"><a class="dropdown-toggle nav-link " href="#"
                                                                       data-toggle="dropdown"><?php echo $this->lang->line('Business') ?><?php echo $this->lang->line('Settings') ?></a>
                            <ul class="mega-dropdown-menu dropdown-menu row">
                                <li class="col-md-3">

                                    <div id="accordionWrap" role="tablist" aria-multiselectable="true" class="section-erp">
                                        <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading1" role="tab">
                                                <a class="text-uppercase" data-toggle="collapse"
                                                   data-parent="#accordionWrap" href="#accordion1"
                                                   aria-controls="accordion1"><i
                                                            class="fa fa-leaf"></i> <?php echo $this->lang->line('Business') . '  ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion1" role="tabpanel"
                                                 aria-labelledby="heading1" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li class="<?php if (current_url() == base_url('settings/company')) echo 'active'; ?>"><a class="dropdown-item"
                                                                href="<?php echo base_url(); ?>settings/company"><i
                                                                         class="ft-chevron-right"></i> <?php echo $this->lang->line('Company') . ' ' . $this->lang->line('Settings') ?>
                                                             </a></li>
                                                        <li class="<?php if (current_url() == base_url('locations')) echo 'active'; ?>"><a class="dropdown-item"
                                                                href="<?php echo base_url(); ?>locations"><i
                                                                         class="ft-chevron-right"></i><?php echo $this->lang->line('Business Locations') ?>
                                                             </a></li>
                                                        <li class="<?php if (current_url() == base_url('tools/setgoals')) echo 'active'; ?>"><a class="dropdown-item"
                                                                href="<?php echo base_url(); ?>tools/setgoals"><i
                                                                         class="ft-chevron-right"></i> <?php echo $this->lang->line('Set Goals') ?>
                                                             </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading2" role="tab">
                                                <a class="text-uppercase" data-toggle="collapse"
                                                   data-parent="#accordionWrap" href="#accordion2"
                                                   aria-controls="accordion2"> <i
                                                            class="fa fa-calendar"></i><?php echo $this->lang->line('Localisation') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion2" role="tabpanel"
                                                 aria-labelledby="heading2" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/currency"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Currency') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/language"><i
                                                                        class="ft-chevron-right"></i>Languages</a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/dtformat"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Date & Time Format') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/theme"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Theme') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading3" role="tab">
                                                <a class="text-uppercase" data-toggle="collapse"
                                                   data-parent="#accordionWrap" href="#accordion3"
                                                   aria-controls="accordion3"> <i
                                                            class="fa fa-lightbulb-o"></i><?php echo $this->lang->line('Miscellaneous') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion3" role="tabpanel"
                                                 aria-labelledby="heading3" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>webupdate"><i
                                                                        class="ft-chevron-right"></i> Software
                                                                Update</a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/email"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Email Config') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>transactions/categories"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Transaction Categories') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/misc_automail"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Email') . ' ' . $this->lang->line('Alert') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/about"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('About') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </li>
                                <li class="col-md-3">

                                    <div id="accordionWrap1" role="tablist" aria-multiselectable="true" class="section-erp">
                                        <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading4" role="tab">
                                                <a class="text-uppercase" data-toggle="collapse"
                                                   data-parent="#accordionWrap1" href="#accordion4"
                                                   aria-controls="accordion4"><i
                                                            class="fa fa-fire"></i><?php echo $this->lang->line('Advanced') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion4" role="tabpanel"
                                                 aria-labelledby="heading4" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>restapi"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('REST API') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>cronjob"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Automatic Corn Job') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/custom_fields"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Custom') ?> <?php echo $this->lang->line('Fields') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/dual_entry"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Dual Entry') . ' ' . $this->lang->line('Accounting') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/logdata"><i
                                                                        class="ft-chevron-right"></i> Application
                                                                Activity Log</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/debug"><i
                                                                        class="ft-chevron-right"></i> Debug Mode </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading2" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap1" href="#accordion5"
                                                   aria-controls="accordion5"> <i
                                                            class="fa fa-shopping-cart"></i><?php echo $this->lang->line('Billing') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion5" role="tabpanel"
                                                 aria-labelledby="heading5" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/discship"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Discount') . ' & ' . $this->lang->line('Shipping') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/prefix"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Prefix') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/billing_terms"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Billing Terms') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/automail"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Auto Email SMS') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/warehouse"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Default') . ' ' . $this->lang->line('Warehouse') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/zero_stock"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Zero Stock') . ' ' . $this->lang->line('Billing') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/pos_style"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('POS') . ' ' . $this->lang->line('Style') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading6" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap1" href="#accordion6"
                                                   aria-controls="accordion6"><i
                                                            class="fa fa-scissors"></i><?php echo $this->lang->line('Tax') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion6" role="tabpanel"
                                                 aria-labelledby="heading6" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/tax"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Tax') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/taxslabs"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Other') . ' ' . $this->lang->line('Tax') . ' ' . $this->lang->line('Settings') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </li>
                                <li class="col-md-3">

                                    <div id="accordionWrap2" role="tablist" aria-multiselectable="true">
                                        <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate section-erp">
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading7" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap2" href="#accordion7"
                                                   aria-controls="accordion7"><i
                                                            class="fa fa-flask"></i><?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion7" role="tabpanel"
                                                 aria-labelledby="heading7" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>

                                                        <li data-menu="">
                                                            <a class="dropdown-item" href="<?php echo base_url(); ?>assetmanager"><i
                                                                        class="fa fa-wrench"></i>Tools & Assets</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>units"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Measurement Unit') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>units/variations"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Variations') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>units/variables"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Variations') . ' ' . $this->lang->line('Variables') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading8" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap2" href="#accordion8"
                                                   aria-controls="accordion8"> <i
                                                            class="fa fa-money"></i><?php echo $this->lang->line('Payment Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion8" role="tabpanel"
                                                 aria-labelledby="heading8" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways/settings"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Payment Settings') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Payment Gateways') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways/currencies"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Payment Currencies') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways/exchange"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Currency Exchange') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways/bank_accounts"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Bank Accounts') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-header p-0 pb-1 border-0 mt-1 section-hr" id="heading9" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap2" href="#accordion9"
                                                   aria-controls="accordion9"><i
                                                            class="fa fa-umbrella"></i><?php echo $this->lang->line('CRM') . ' & ' . $this->lang->line('HRM') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion9" role="tabpanel"
                                                 aria-labelledby="heading9" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>employee/auto_attendance"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Self') . ' ' . $this->lang->line('Attendance') ?>
                                                            </a></li>

                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/registration"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('CRM') . ' ' . $this->lang->line('Settings') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>plugins/recaptcha"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Security') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/tickets"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Support Tickets') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </li>


                                <li class="col-md-3">

                                    <div id="accordionWrap3" role="tablist" aria-multiselectable="true" class="section-settings">
                                        <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading10" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap3" href="#accordion10"
                                                   aria-controls="accordion10"><i
                                                            class="fa fa-magic"></i><?php echo $this->lang->line('Plugins') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion10" role="tabpanel"
                                                 aria-labelledby="heading10" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>plugins/recaptcha"><i
                                                                        class="ft-chevron-right"></i>reCaptcha Security</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>plugins/shortner"><i
                                                                        class="ft-chevron-right"></i> URL Shortener</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>plugins/twilio"><i
                                                                        class="ft-chevron-right"></i> SMS Configuration</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways/exchange"><i
                                                                        class="ft-chevron-right"></i>Currency Exchange
                                                                API</a></li>
                                                        <?php plugins_checker(); ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading11" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap3" href="#accordion11"
                                                   aria-controls="accordion11"> <i
                                                            class="fa fa-eye"></i><?php echo $this->lang->line('Templates') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion11" role="tabpanel"
                                                 aria-labelledby="heading8" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>templates/email"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Email') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>templates/sms"><i
                                                                        class="ft-chevron-right"></i> SMS</a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/print_invoice"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Print Invoice') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/theme"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Theme') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading12" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap3" href="#accordion12"
                                                   aria-controls="accordion12"><i
                                                            class="fa fa-print"></i>POS Printers</a>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion12" role="tabpanel"
                                                 aria-labelledby="heading12" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>printer/add"><i
                                                                        class="ft-chevron-right"></i>Add Printer</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>printer"><i
                                                                        class="ft-chevron-right"></i> List Printers</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </li>


                            </ul>
                        </li>       <?php } ?>
                    
                    <ul class="nav navbar-nav float-right flex-row align-items-center d-none d-lg-flex mr-2">
                        <li class="nav-item">
                            <a href="#" class="nav-link nav-link-label social-icon-top p-1"><i class="fa fa-twitter" style="font-size: 1.5rem;"></i></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link nav-link-label social-icon-top p-1"><i class="fa fa-facebook" style="font-size: 1.5rem;"></i></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link nav-link-label social-icon-top p-1"><i class="fa fa-linkedin" style="font-size: 1.5rem;"></i></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link nav-link-label social-icon-top p-1" style="color: #25d366 !important;"><i class="fa fa-whatsapp" style="font-size: 1.5rem;"></i></a>
                        </li>
                    </ul>

                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                                                           data-toggle="dropdown"><i
                                    class="ficon ft-bell"></i><span
                                    class="badge badge-pill badge-default badge-danger badge-default badge-up"
                                    id="taskcount">0</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><?php echo $this->lang->line('Pending Tasks') ?></span><span
                                            class="notification-tag badge badge-default badge-danger float-right m-0">New</span>
                                </h6>
                            </li>
                            <li class="scrollable-container media-list" id="tasklist"></li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                                                href="<?php echo base_url('manager/todo') ?>"><?php echo $this->lang->line('Manage tasks') ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                                                           data-toggle="dropdown"><i
                                    class="ficon ft-mail"></i><span
                                    class="badge badge-pill badge-default badge-info badge-default badge-up"><?php echo $this->aauth->count_unread_pms() ?></span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><?php echo $this->lang->line('Messages') ?></span><span
                                            class="notification-tag badge badge-default badge-warning float-right m-0"><?php echo $this->aauth->count_unread_pms() ?><?php echo $this->lang->line('new') ?></span>
                                </h6>
                            </li>
                            <li class="scrollable-container media-list">
                                <?php $list_pm = $this->aauth->list_pms(6, 0, $this->aauth->get_user()->id, false);

                                foreach ($list_pm as $row) {

                                    echo '<a href="' . base_url('messages/view?id=' . $row->pid) . '">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm  rounded-circle"><img src="' . base_url('userfiles/employee/' . $row->picture) . '" alt="avatar"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row->name . '</h6>
                          <p class="notification-text font-small-3 text-muted">' . $row->{'title'} . '</p><small>
                            <time class="media-meta text-muted" datetime="' . $row->{'date_sent'} . '">' . $row->{'date_sent'} . '</time></small>
                        </div>
                      </div></a>';
                                } ?>    </li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                                                href="<?php echo base_url('messages') ?>"><?php echo $this->lang->line('Read all messages') ?></a>
                            </li>
                        </ul>
                    </li>
                    <?php if ($this->aauth->auto_attend()) { ?>
                        <li class="dropdown dropdown-d nav-item">


                            <?php if ($this->aauth->clock()) {

                                echo ' <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon spinner icon-clock"></i><span class="badge badge-pill badge-default badge-success badge-default badge-up">' . $this->lang->line('On') . '</span></a>';

                            } else {
                                echo ' <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon icon-clock"></i><span class="badge badge-pill badge-default badge-warning badge-default badge-up">' . $this->lang->line('Off') . '</span></a>';
                            }
                            ?>

                            <ul class="dropdown-menu dropdown-menu-right border-primary border-lighten-3 text-xs-center">
                                <br><br>
                                <?php echo '<span class="p-1 text-bold-300">' . $this->lang->line('Attendance') . ':</span>';
                                if (!$this->aauth->clock()) {
                                    echo '<a href="' . base_url() . '/dashboard/clock_in" class="btn btn-outline-success  btn-outline-white btn-md ml-1 mr-1" ><span class="icon-toggle-on" aria-hidden="true"></span> ' . $this->lang->line('Clock') . ' ' . $this->lang->line('In') . ' <i
                                    class="ficon icon-clock spinner"></i></a>';
                                } else {
                                    echo '<a href="' . base_url() . '/dashboard/clock_out" class="btn btn-outline-danger  btn-outline-white btn-md ml-1 mr-1" ><span class="icon-toggle-off" aria-hidden="true"></span> ' . $this->lang->line('Clock') . ' ' . $this->lang->line('Out') . ' </a>';
                                }
                                ?>

                                <br><br>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"
                                                                   href="#" data-toggle="dropdown"><span
                                    class="avatar avatar-online"><img
                                        src="<?php echo base_url('userfiles/employee/thumbnail/' . $this->aauth->get_user()->picture) ?>"
                                        alt="avatar"><i></i></span><span
                                    class="user-name"><?php echo $this->lang->line('Account') ?></span></a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                          href="<?php echo base_url(); ?>user/profile"><i
                                        class="ft-user"></i> <?php echo $this->lang->line('Profile') ?></a>
                            <a href="<?php echo base_url(); ?>user/attendance"
                               class="dropdown-item"><i
                                        class="fa fa-list-ol"></i><?php echo $this->lang->line('Attendance') ?></a>
                            <a href="<?php echo base_url(); ?>user/holidays"
                               class="dropdown-item"><i
                                        class="fa fa-hotel"></i><?php echo $this->lang->line('Holidays') ?></a>

                            <div class="dropdown-divider" style="border-top-color: var(--glass-border);"></div>
                            <a class="dropdown-item" href="<?php echo base_url('user/logout'); ?>" style="color: #ef4444 !important;"><i
                                        class="ft-power"></i> <?php echo $this->lang->line('Logout') ?></a>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</nav>

<!-- ////////////////////////////////////////////////////////////////////////////-->
<!-- Horizontal navigation-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <!-- Horizontal menu content-->
    <div class="main-menu-content">
        <div class="sidebar-search-container">
            <input type="text" id="menu-search" class="sidebar-search" placeholder="Quick search menu...">
        </div>
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="navigation-header section-erp"><span>Main</span></li>
            <li class="nav-item section-erp <?php if (current_url() == base_url('dashboard')) echo 'active'; ?>"><a href="<?= base_url(); ?>dashboard/"><i
                            class="ft-home"></i><span><?= $this->lang->line('Dashboard') ?></span></a>
            </li>
            
            <li class="navigation-header section-hr"><span><?php echo $this->lang->line('Self Service') ?></span></li>
             <li class="nav-item section-hr <?php if (current_url() == base_url('payrollreport/my_payslips')) echo 'active'; ?>"><a href="<?= base_url(); ?>payrollreport/my_payslips"><i
                            class="fa fa-money"></i><span><?php echo $this->lang->line('My Payslips') ?></span></a>
            </li>
           
            <li class="navigation-header section-erp"><span>ERP Operations</span></li>
            <?php
            if ($this->aauth->premission(1)) { ?>
                <li class="nav-item has-sub section-erp <?php if ($this->li_a == "sales") {
                    echo ' open';
                } ?>"><a href="#"><i
                                class="ft-shopping-cart"></i><span><?php echo $this->lang->line('sales') ?></span></a>
                    <ul class="menu-content">
                        <li class="menu-item <?php if ($this->li_a == "pos") echo 'active'; ?>"><a
                                    href="#"><i
                                        class="ft-chevron-right"></i>POS <?php echo $this->lang->line('sales') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('pos_invoices/create')) echo 'active'; ?>"><a href="<?= base_url(); ?>pos_invoices/create"
                                    ><?php echo $this->lang->line('New Invoice'); ?></a></li>
                                <li class="menu-item <?php if (current_url() == base_url('pos_invoices')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>pos_invoices"><?php echo $this->lang->line('Manage Invoices'); ?></a></li>
                            </ul>
                        </li>
                        <li class="menu-item <?php if ($this->li_a == "timber") echo 'active'; ?>"><a href="#"><i
                                        class="ft-chevron-right"></i>Timber Treatment</a>
                            <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('invoices/create')) echo 'active'; ?>"><a href="<?= base_url(); ?>invoices/create"><?php echo $this->lang->line('New Invoice'); ?></a>
                                </li>

                                <li class="menu-item <?php if (current_url() == base_url('invoices')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>invoices"><?php echo $this->lang->line('Manage Invoices'); ?></a></li>
                            </ul>
                        </li>
                        <li class="menu-item <?php if ($this->li_a == "quotes") echo 'active'; ?>"><a href="#"><i
                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Quotes') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('pos_invoices/quotecreate')) echo 'active'; ?>"><a
                                            href="<?= base_url(); ?>pos_invoices/quotecreate"><?php echo $this->lang->line('New Quote'); ?></a>
                                </li>

                                <li class="menu-item <?php if (current_url() == base_url('quote')) echo 'active'; ?>"><a class="dropdown-item" href="<?php echo base_url(); ?>quote"><?php echo $this->lang->line('Manage Quotes'); ?></a></li>
                            </ul>
                        </li>

                      
                        <li class="menu-item <?php if (current_url() == base_url('stockreturn/creditnotes')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>stockreturn/creditnotes"><i
                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Credit Notes'); ?></a></li>
                    </ul>
                </li>
                        <li class="nav-item has-sub section-erp <?php if ($this->li_a == "stock_transfer") echo 'active'; ?>"><a href="#"><i
                                        class="ft-wind"></i> <span>Stock Transfer</span></a>
                            <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('products/stock_transfer')) echo 'active'; ?>"><a
                                            href="<?= base_url(); ?>products/stock_transfer">New Transfer</a></li>
                                <li class="menu-item <?php if (current_url() == base_url('products/manage_transfer2')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>products/manage_transfer2">Manage Transfer</a></li>
                            </ul>
                        </li>

            <?php }
            if ($this->aauth->premission(2)) { ?>
                <li class="nav-item has-sub section-erp <?php if ($this->li_a == "stock") {
                    echo ' open';
                } ?>"><a href="#"><i
                                class="ft-package"></i> <span><?php echo $this->lang->line('Stock') ?></span></a>
                    <ul class="menu-content">
                        <li class="menu-item <?php if (current_url() == base_url('products/add') || current_url() == base_url('products')) echo 'active'; ?>"><a
                                    href="#"><i
                                        class="ft-list"></i> <?php echo $this->lang->line('Items Manager') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('products/add')) echo 'active'; ?>"><a
                                            href="<?= base_url(); ?>products/add"> <?php echo $this->lang->line('New Product'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('products')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>products"><?= $this->lang->line('Manage Products'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item <?php if (current_url() == base_url('productcategory')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>productcategory"><i
                                        class="ft-umbrella"></i><?php echo $this->lang->line('Product Categories'); ?>
                            </a>
                        </li>
                        <li class="menu-item <?php if (current_url() == base_url('productcategory/warehouse')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>productcategory/warehouse"><i
                                        class="ft-home"></i><?php echo $this->lang->line('Warehouses'); ?></a>
                        </li>


                      
     
                        
                        
                        
                        

                        <li class="menu-item <?php if (strpos(current_url(), 'stockreturn') !== false && strpos(current_url(), 'creditnotes') === false) echo 'active'; ?>"><a href="#"><i
                                        class="ft-repeat"></i> <?php echo $this->lang->line('Stock Return') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('stockreturn')) echo 'active'; ?>"><a
                                            href="<?= base_url(); ?>stockreturn"> <?php echo $this->lang->line('Suppliers') . ' ' . $this->lang->line('Records'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('stockreturn/customer')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>stockreturn/customer"><?php echo $this->lang->line('Customers') . ' ' . $this->lang->line('Records'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item <?php if (current_url() == base_url('supplier/create') || current_url() == base_url('supplier')) echo 'active'; ?>"><a href="#"><i
                                        class="ft-target"></i><?php echo $this->lang->line('Suppliers') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('supplier/create')) echo 'active'; ?>"><a
                                            href="<?= base_url(); ?>supplier/create"><?php echo $this->lang->line('New Supplier'); ?></a>
                                </li>

                                <li class="menu-item <?php if (current_url() == base_url('supplier')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>supplier"><?php echo $this->lang->line('Manage Suppliers'); ?></a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </li>
                
                <li class="nav-item has-sub section-erp <?php if ($this->li_a == "purchase") echo 'active'; ?>"><a href="#"><i
                                        class="ft-shopping-cart"></i> <span><?php echo $this->lang->line('Purchase Order') ?></span></a>
                            <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('pos_invoices/purchasecreate')) echo 'active'; ?>"><a class="dropdown-item" href="<?= base_url(); ?>pos_invoices/purchasecreate"> <?php echo $this->lang->line('New Order'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('purchase')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>purchase"><?= $this->lang->line('Manage Orders'); ?></a></li>

                                 <li class="menu-item <?php if (current_url() == base_url('purchase/createlogs')) echo 'active'; ?>"><a class="dropdown-item" href="<?= base_url(); ?>purchase/createlogs"> New Logs Order</a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('purchase/list')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>purchase/list">Manage Logs Orders</a></li>
                            </ul>
                        </li>
                <li class="nav-item has-sub section-erp <?php if (current_url() == base_url('purchase/newprocessing') || current_url() == base_url('purchase/manageprocessing')) echo 'open active'; ?>"><a href="#"><i
                                class="ft-cpu"></i> <span>Trunks Processing</span></a>
                    <ul class="menu-content">
                        <li class="menu-item <?php if (current_url() == base_url('purchase/newprocessing')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>purchase/newprocessing"><i
                                        class="ft-chevron-right"></i>New Processing</a>
                        </li>
                        <li class="menu-item <?php if (current_url() == base_url('purchase/manageprocessing')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>purchase/manageprocessing"><i
                                        class="ft-chevron-right"></i>Manage Processing</a>
                        </li>
                    </ul>
                </li>

                <!-- PRODUCTION LINE START -->
                <li class="navigation-header section-erp"><span>Production Line</span></li>
                <li class="nav-item has-sub section-erp"><a href="#"><i class="ft-layers"></i><span>Production</span></a>
                    <ul class="menu-content">
                        <!-- 1. Master Data -->
                        <li class="menu-item has-sub"><a href="#"><i class="ft-settings"></i> Setup & Master Data</a>
                            <ul class="menu-content">
                                <li><a href="<?php echo base_url(); ?>wood_types" class="menu-item">Wood Types</a></li>
                                <li><a href="<?php echo base_url(); ?>timber_grades" class="menu-item">Timber Grades</a></li>
                                <li><a href="<?php echo base_url(); ?>machines" class="menu-item">Machines</a></li>
                                <li><a href="<?php echo base_url(); ?>carpenter_skills" class="menu-item">Skills</a></li>
                            </ul>
                        </li>

                        <!-- 2. Planning -->
                        <li class="menu-item"><a href="<?php echo base_url(); ?>production_schedule"><i class="ft-calendar"></i> Planning & Schedule</a></li>

                        <!-- 3. Routing -->
                        <li class="menu-item"><a href="<?php echo base_url(); ?>production_routes"><i class="ft-map"></i> Routes & Stages</a></li>
                        <li class="menu-item"><a href="<?php echo base_url(); ?>cutting_plan"><i class="ft-scissors"></i> Cutting Plans</a></li>

                        <!-- 4. Seasoning -->
                        <li class="menu-item"><a href="<?php echo base_url(); ?>seasoning"><i class="ft-thermometer"></i> Seasoning (Kiln)</a></li>

                        <!-- 5. Execution -->
                        <li class="menu-item"><a href="<?php echo base_url(); ?>work_orders"><i class="ft-check-square"></i> Work Orders</a></li>
                        
                        <!-- 6. QC -->
                        <li class="menu-item"><a href="<?php echo base_url(); ?>quality_control"><i class="ft-shield"></i> Quality Control</a></li>

                        <!-- 7. Inventory -->
                        <li class="menu-item"><a href="<?php echo base_url(); ?>production_inventory"><i class="ft-box"></i> WIP Inventory</a></li>

                        <!-- 8. Costing -->
                        <li class="menu-item"><a href="<?php echo base_url(); ?>production_costing"><i class="ft-dollar-sign"></i> Costing & Profit</a></li>

                        <!-- 9. Intelligence -->
                        <li class="menu-item"><a href="<?php echo base_url(); ?>production_intelligence"><i class="ft-activity"></i> AI Insights</a></li>

                         <!-- 10. Maintenance -->
                        <li class="menu-item"><a href="<?php echo base_url(); ?>production_maintenance"><i class="ft-tool"></i> Maintenance</a></li>
                    </ul>
                </li>
                <!-- PRODUCTION LINE END -->
                
                <li class="nav-item section-erp"><a href="<?php echo base_url(); ?>pos_invoices/invoices_list_action"><i
                                    class="ft-file-text"></i> <span>Sales Reports</span></a></li>
                        
                        
                        <li class="nav-item has-sub section-erp <?php if ($this->li_a == "transactions") echo 'active'; ?>"><a href="#"><i
                                        class="ft-repeat"></i> <span><?php echo $this->lang->line('Transactions') ?></span></a>
                            <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('transactions')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>transactions"><?php echo $this->lang->line('View Transactions') ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('transactions/add')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>transactions/add"><?= $this->lang->line('New Transaction'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('transactions/transfer')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>transactions/transfer"><?= $this->lang->line('New Transfer'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('transactions/income')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>transactions/income"><?= $this->lang->line('Income'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('transactions/expense')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>transactions/expense"><?= $this->lang->line('Expense'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('customers')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>customers"><?= $this->lang->line('Clients Transactions'); ?></a>
                                </li>
                            </ul>
                        </li>
                        
                        
                                             <li class="nav-item has-sub section-erp <?php if ($this->li_a == "accounts") echo 'active'; ?>"><a href="#"><i
                                        class="ft-briefcase"></i> <span><?php echo $this->lang->line('Accounts') ?></span></a>
                            <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('accounts')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>accounts"
                                    ><?php echo $this->lang->line('Manage Accounts') ?></a></li>
                                <li class="menu-item <?php if (current_url() == base_url('accounts/balancesheet')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>accounts/balancesheet"><?= $this->lang->line('BalanceSheet'); ?></a></li>
                                <li class="menu-item <?php if (current_url() == base_url('reports/accountstatement')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>reports/accountstatement"><?= $this->lang->line('Account Statements'); ?></a></li>
                            </ul>
                        </li>
                        
                
            <?php }
            if ($this->aauth->premission(9)) { ?>
                <li class="nav-item has-sub section-erp <?php if ($this->li_a == "carpentry") echo ' open'; ?>"><a href="#"><i
                                        class="fa fa-gavel"></i> <span>Carpentry</span></a>
                    <ul class="menu-content">
                        <li class="menu-item <?php if (current_url() == base_url('carpentry_dashboard')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>carpentry_dashboard">
                                    <i class="ft-chevron-right"></i> Dashboard</a>
                        </li>
                        <li class="menu-item"><a href="#"><i class="ft-chevron-right"></i> Job Sites</a>
                             <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('jobsites')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>jobsites" class="menu-item">Manage Job Sites</a></li>
                                <li class="menu-item <?php if (current_url() == base_url('jobsites/create')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>jobsites/create" class="menu-item">Add Job Site</a></li>
                            </ul>
                        </li>
                        <li class="menu-item"><a href="#"><i class="ft-chevron-right"></i> Materials</a>
                             <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('project_stock/issue')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>project_stock/issue" class="menu-item">Issue Stock to Project</a></li>
                            </ul>
                        </li>
                        <li class="menu-item"><a href="#"><i class="ft-chevron-right"></i> Reports</a>
                             <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('carpentry_reports/profitability')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>carpentry_reports/profitability" class="menu-item">Profitability Report</a></li>
                            </ul>
                        </li>
                         <li class="menu-item"><a href="#"><i class="ft-chevron-right"></i> Tools & Assets</a>
                             <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('assetmanager')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>assetmanager" class="menu-item">Manage Assets</a></li>
                                <li class="menu-item <?php if (current_url() == base_url('assetmanager/add')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>assetmanager/add" class="menu-item">Add Asset</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(3)) {
                ?>
                <li class="navigation-header section-erp"><span>Customer Relations</span></li>
                <li class="nav-item has-sub section-erp <?php if ($this->li_a == "crm") {
                    echo ' open';
                } ?>"><a href="#"><i
                                class="ft-users"></i> <span><?php echo $this->lang->line('CRM') ?></span></a>
                    <ul class="menu-content">
                        <li class="menu-item"><a href="#"><i
                                        class="ft-users"></i> <?php echo $this->lang->line('Clients') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>customers/create"><?php echo $this->lang->line('New Client') ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('customers')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>customers"><?= $this->lang->line('Manage Clients'); ?></a></li>
                            </ul>
                        </li>
                        <li class="menu-item <?php if (current_url() == base_url('clientgroup')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>clientgroup"><i
                                        class="icon-grid"></i> <?php echo $this->lang->line('Client Groups'); ?></a>
                        </li>
                        

                    </ul>
                </li>
            <?php } ?>

                <?php if ($this->aauth->premission(9)) { ?>
            <li class="navigation-header section-hr"><span>Human Resources</span></li>
                <li class="nav-item has-sub section-hr <?php if ($this->li_a == "hrm") { echo ' open'; } ?>">
                    <a href="#"><i class="ft-users"></i> <span>HRM</span></a>
                    <ul class="menu-content">
                        <li class="menu-item <?php if (current_url() == base_url('employee')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>employee">
                            <i class="ft-chevron-right"></i>Employees List</a>
                        </li>
                        <li class="menu-item <?php if (current_url() == base_url('employee/salaries')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>employee/salaries">
                            <i class="ft-chevron-right"></i>Salaries</a>
                        </li>
                        
                        <li class="menu-item <?php if (current_url() == base_url('employee/departments')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>employee/departments">
                            <i class="ft-chevron-right"></i>Departments</a>
                        </li>
                         <li class="menu-item <?php if (current_url() == base_url('employee/roles')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>employee/roles">
                            <i class="ft-chevron-right"></i>Role Management</a>
                        </li>
                        
                        <li class="menu-item has-sub <?php if ($this->li_a == "payroll") echo ' open'; ?>"><a href="#">
                                <i class="ft-chevron-right"></i>Payroll</a>
                                <ul class="menu-content">
                                    <li class="menu-item <?php if (current_url() == base_url('payrollprocessing')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>payrollprocessing">
                                        <i class="ft-arrow-right"></i>Processing</a>
                                    </li>
                                    <li class="menu-item <?php if (current_url() == base_url('payrollreport')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>payrollreport">
                                        <i class="ft-file-text"></i>Reports & Payslips</a>
                                    </li>
                                    <li class="menu-item <?php if (current_url() == base_url('payrollbonus')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>payrollbonus">
                                        <i class="ft-award"></i>Bonus Management</a>
                                    </li>
                                    <li class="menu-item <?php if (current_url() == base_url('payrolltimesheets')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>payrolltimesheets">
                                        <i class="ft-clock"></i>Timesheets</a>
                                    </li>
                                     <li class="menu-item <?php if (current_url() == base_url('employeeloans')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>employeeloans">
                                        <i class="ft-arrow-right"></i>Loans & Advances</a>
                                    </li>
                                    <li class="menu-item <?php if (current_url() == base_url('payrollworkflow')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>payrollworkflow">
                                        <i class="ft-arrow-right"></i>Approval Workflow</a>
                                    </li>
                                    <li class="menu-item <?php if (current_url() == base_url('payrollanalytics')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>payrollanalytics">
                                        <i class="ft-pie-chart"></i>Analytics</a>
                                    </li>
                                    <li class="menu-item <?php if (current_url() == base_url('payrollsettings')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>payrollsettings">
                                        <i class="ft-settings"></i>Settings</a>
                                    </li>
                                </ul>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <?php if ($this->aauth->premission(8)) { ?>
            <li class="navigation-header section-services"><span>Services</span></li>
                <li class="nav-item has-sub section-services <?php if ($this->li_a == "services") { echo ' open'; } ?>">
                    <a href="#"><i class="ft-server"></i> <span>Service Management</span></a>
                    <ul class="menu-content">
                        <li class="menu-item <?php if (current_url() == base_url('subscriptions')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>subscriptions">
                            <i class="ft-chevron-right"></i>Subscriptions</a>
                        </li>
                        <li class="menu-item <?php if (current_url() == base_url('tickets')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>tickets">
                            <i class="ft-chevron-right"></i>Support Tickets</a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

            <li class="navigation-header section-tools"><span>Tools & Productivity</span></li>
                <li class="nav-item has-sub section-tools <?php if ($this->li_a == "tools") { echo ' open'; } ?>">
                    <a href="#"><i class="ft-briefcase"></i> <span>Tools</span></a>
                    <ul class="menu-content">
                        <?php if ($this->aauth->premission(6)) { ?>
                        <li class="menu-item <?php if (current_url() == base_url('events')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>events">
                            <i class="ft-chevron-right"></i>Events & Calendar</a>
                        </li>
                        <?php } ?>
                        <?php if ($this->aauth->premission(6) || $this->aauth->premission(7)) { ?>
                        <li class="menu-item <?php if (current_url() == base_url('manager/todo')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>manager/todo">
                            <i class="ft-chevron-right"></i>Notes & To-Do</a>
                        </li>
                        <?php } ?>
                        <?php if ($this->aauth->get_user()->roleid < 5) { ?>
                        <li class="menu-item <?php if (current_url() == base_url('tools/setgoals')) echo 'active'; ?>"><a href="<?php echo base_url(); ?>tools/setgoals">
                            <i class="ft-chevron-right"></i>Set Goals</a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>

            <?php
            if (!$this->aauth->premission(4) && $this->aauth->premission(7)) {
                ?>
                <li class="nav-item has-sub section-tools <?php if ($this->li_a == "manager") { echo ' open'; } ?>">
                    <a href="#"><i class="icon-briefcase"></i> <span><?php echo $this->lang->line('Project') ?></span></a>
                    <ul class="menu-content">
                        <li class="menu-item <?php if (current_url() == base_url('manager/projects')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>manager/projects"><i
                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Manage Projects'); ?></a>
                        </li>
                        <li class="menu-item <?php if (current_url() == base_url('manager/todo')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>manager/todo"><i
                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('To Do List'); ?></a>
                        </li>
                    </ul>
                </li>
            <?php }
            
               
            if ($this->aauth->premission(6)) {
                ?>
                <li class="navigation-header section-data"><span>Data & Reports</span></li>
                <li class="nav-item has-sub section-data <?php if ($this->li_a == "data") {
                    echo ' open';
                } ?>"><a href="#"><i
                                class="icon-pie-chart"></i>
                        <span><?php echo $this->lang->line('Data & Reports') ?></span></a>
                    <ul class="menu-content">
                        <li class="menu-item <?php if ($this->li_a == 'adv_reports') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>advanced_reports">
                                <i class="fa fa-line-chart"></i>
                                <span>Advanced Report Center</span>
                            </a>
                        </li>
                        <li class="menu-item <?php if (current_url() == base_url('register')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>register"><i
                                        class="icon-eyeglasses"></i> <?php echo $this->lang->line('Business Registers'); ?></a>
                        </li>

                        <li class="menu-item <?php if (current_url() == base_url('reports/accountstatement') || current_url() == base_url('reports/customerstatement') || current_url() == base_url('reports/supplierstatement') || current_url() == base_url('reports/taxstatement')) echo 'active'; ?>"><a href="#"><i
                                        class="ft-file-text"></i> <?php echo $this->lang->line('Statements') ?></a>
                            <ul class="menu-content">

                                <li class="menu-item <?php if (current_url() == base_url('reports/accountstatement')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>reports/accountstatement"><?= $this->lang->line('Account Statements'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('reports/customerstatement')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>reports/customerstatement"><?php echo $this->lang->line('Customer') . ' ' . $this->lang->line('Account Statements') ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('reports/supplierstatement')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>reports/supplierstatement"><?php echo $this->lang->line('Supplier') . ' ' . $this->lang->line('Account Statements') ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('reports/taxstatement')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>reports/taxstatement"><?php echo $this->lang->line('TAX') . ' ' . $this->lang->line('Statements'); ?></a>
                                </li>
                            </ul>
                        </li>

                        <li class="menu-item <?php if (strpos(current_url(), 'chart/') !== false) echo 'active'; ?>"><a href="#"><i
                                        class="ft-bar-chart-2"></i> <?php echo $this->lang->line('Graphical Reports') ?>
                            </a>
                            <ul class="menu-content">

                                <li class="menu-item <?php if (current_url() == base_url('chart/product_cat')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>chart/product_cat"><?= $this->lang->line('Product Categories'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('chart/trending_products')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>chart/trending_products"><?= $this->lang->line('Trending Products'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('chart/profit')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>chart/profit"><?= $this->lang->line('Profit'); ?></a>
                                </li>

                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>chart/topcustomers"><?php echo $this->lang->line('Top') . ' ' . $this->lang->line('Customers') ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>chart/incvsexp"><?php echo $this->lang->line('Income') . ' vs ' . $this->lang->line('Expenses') ?></a>
                                </li>

                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>chart/income"><?= $this->lang->line('Income'); ?></a>
                                </li>
                                 <li class="menu-item <?php if (current_url() == base_url('chart/expenses')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>chart/expenses"><?= $this->lang->line('Expenses'); ?></a></li>


                            </ul>
                        </li>
                        <li class="menu-item <?php if (strpos(current_url(), 'reports/') !== false && strpos(current_url(), 'statement') === false) echo 'active'; ?>"><a href="#"><i
                                        class="ft-pie-chart"></i> <?php echo $this->lang->line('Summary') . ' & ' . $this->lang->line('Report') ?>
                            </a>
                            <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('reports/statistics')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>reports/statistics"><?php echo $this->lang->line('Statistics') ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('reports/profitstatement')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>reports/profitstatement"><?= $this->lang->line('Profit'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>reports/incomestatement"><?php echo $this->lang->line('Calculate Income'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>reports/expensestatement"><?php echo $this->lang->line('Calculate Expenses') ?></a>
                                </li>
                                 <li class="menu-item <?php if (current_url() == base_url('reports/sales')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>reports/sales"><?php echo $this->lang->line('Sales') ?></a></li>
                                <li class="menu-item <?php if (current_url() == base_url('reports/products')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>reports/products"><?php echo $this->lang->line('Products') ?></a></li>
                                <li class="menu-item <?php if (current_url() == base_url('reports/commission')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>reports/commission"><?= $this->lang->line('Employee'); ?> <?= $this->lang->line('Commission'); ?></a></li>
                            </ul>
                        </li>

                    </ul>
                </li>
            
            
            <?php }  ?>
                
                
                
                 <?php if ($this->aauth->premission(6)) {
                ?>
                
                <li class="nav-item has-sub section-data <?php if (current_url() == base_url('export/people')) echo 'open active'; ?>"><a href="#"><i
                                        class="ft-database"></i><span><?php echo $this->lang->line('Backup & Export') . '-' . $this->lang->line('Import'); ?></span>
                            </a>
                            <ul class="menu-content">
                                <li class="menu-item <?php if (current_url() == base_url('export/people')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>export/people"><?php echo $this->lang->line('Export People Data'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('export/transactions')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>export/transactions"><?php echo $this->lang->line('Export Transactions'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('export/products')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>export/products"><?php echo $this->lang->line('Export Products'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('export/account')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>export/account"><?php echo $this->lang->line('Account Statements'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('export/taxstatement')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>export/taxstatement"><?php echo $this->lang->line('TAX') . ' ' . $this->lang->line('Backup & Export'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('export/dbexport')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>export/dbexport"><?php echo $this->lang->line('Database Backup'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('import/products')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>import/products"><?php echo $this->lang->line('Import Products'); ?></a>
                                </li>
                                <li class="menu-item <?php if (current_url() == base_url('import/customers')) echo 'active'; ?>"><a
                                            href="<?php echo base_url(); ?>import/customers"><?php echo $this->lang->line('Import Customers'); ?></a>
                                </li>
                            </ul>
                        </li>
<?php }  ?>
                            


        </ul>

    </div>
    <!-- /horizontal menu content-->
</div>
<script>
$(document).ready(function() {
    $('#menu-search').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $("#main-menu-navigation li:not(.navigation-header)").each(function() {
            var match = $(this).text().toLowerCase().indexOf(value) > -1;
            $(this).toggle(match);
            
            // If it's a sub-item matching, ensure its parent is visible
            if(match && $(this).hasClass('menu-item')) {
                $(this).parents('.has-sub').show();
            }
        });
        
        // Hide headers if no items visible under them
        $('.navigation-header').each(function() {
            var nextItems = $(this).nextUntil('.navigation-header', 'li:visible');
            $(this).toggle(nextItems.length > 0);
        });
    });
});
</script>
<!-- Horizontal navigation-->
<div id="c_body"></div>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">