<link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/<?= LTR ?>/core/menu/menu-types/vertical-menu-modern.css">
    <style>
        :root {
            /* Luxury Command Palette - "The Boardroom" */
            --timber-dark: #020617;        /* Midnight Obsidian - Main Background */
            --timber-panel: #0f172a;       /* Deep Gunmetal - Panel Background */
            --timber-accent: #3b82f6;      /* Luxury Blue - Primary Accent */
            --timber-green: #22c55e;       /* Life Green - Success/Growth */
            --timber-text: #f8fafc;        /* Platinum White - Primary Text */
            --timber-text-muted: #94a3b8;  /* Silver - Secondary Text */
            --timber-border: rgba(59, 130, 246, 0.15); /* Subtle Blue Edge */
            
            /* High-End Glassmorphism */
            --glass-bg: rgba(15, 23, 42, 0.85); /* Dark Slate Glass */
            --glass-border: rgba(255, 255, 255, 0.05); /* Diamond Cut Edge */
            --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.4);
            --blue-glow: 0 0 15px rgba(59, 130, 246, 0.3);

            --primary-color: var(--timber-accent);
            --accent-glow: var(--blue-glow);
            --bg-dark: var(--timber-dark);
            --sidebar-bg: rgba(2, 6, 23, 0.95);
            --sidebar-hover: rgba(59, 130, 246, 0.08);
            --text-primary: var(--timber-text);
            --text-secondary: var(--timber-text-muted);
            --transition-speed: 0.4s;
            
            /* Section Specific Colors (Premium Palette) */
            --color-erp: #3b82f6;      /* Blue */
            --color-hr: #22c55e;       /* Life Green */
            --color-services: #8b5cf6; /* Royal Purple */
            --color-tools: #f59e0b;    /* Amber */
            --color-data: #ef4444;     /* Crimson */
            --color-settings: #06b6d4; /* Sapphire */
            --color-default: var(--primary-color);
        }

        /* Alive Keyframes */
        @keyframes slideIn { from { opacity: 0; transform: translateX(-10px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes glowPulse {
            0% { filter: drop-shadow(0 0 5px rgba(var(--section-accent-rgb, 59, 130, 246), 0.5)); transform: scale(1); }
            50% { filter: drop-shadow(0 0 15px rgba(var(--section-accent-rgb, 59, 130, 246), 0.8)); transform: scale(1.1); }
            100% { filter: drop-shadow(0 0 5px rgba(var(--section-accent-rgb, 59, 130, 246), 0.5)); transform: scale(1); }
        }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-3px); } 100% { transform: translateY(0px); } }
        @keyframes shimmer { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }
        @keyframes textExpand { from { letter-spacing: normal; transform: translateX(0); } to { letter-spacing: 0.5px; transform: translateX(3px); } }

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
            margin: 0px 14px;
            border-radius: 10px;
            overflow: hidden;
            transition: all var(--transition-speed);
        }

        .navigation li a {
            padding: 4px 18px !important;
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

        .navigation li a {
            padding: 12px 18px !important;
            display: flex !important;
            align-items: center;
            color: var(--text-secondary) !important;
            transition: all var(--transition-speed);
            position: relative;
            z-index: 1;
        }

        .navigation li.active > a, .navigation li:hover > a {
            background: var(--sidebar-hover) !important;
            color: var(--text-primary) !important;
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
            background: var(--primary-color);
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 15px var(--accent-glow);
            z-index: 5;
        }

        .navigation li i {
            font-size: 1.4rem;
            width: 42px;
            height: 42px;
            display: flex !important;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            z-index: 2;
        }

        /* Collapsed Menu Icon Visibility & Stability */
        body.menu-collapsed .main-menu.menu-dark .navigation > li > a {
            justify-content: center !important;
            padding: 8px 0 !important;
        }

        body.menu-collapsed .main-menu.menu-dark .navigation > li > a i {
            margin-right: 0 !important;
            width: 42px !important;
            height: 42px !important;
            font-size: 1.4rem !important;
            border-radius: 12px;
            display: flex !important;
            align-items: center;
            justify-content: center;
            transition: margin 0.3s ease;
        }

        body.menu-collapsed .main-menu:hover .navigation > li > a {
            justify-content: flex-start !important;
            padding-left: 14px !important;
        }

        body.menu-collapsed .main-menu:hover .navigation > li > a i {
            margin-right: 15px !important;
        }

        body.menu-collapsed .navigation li span { display: none !important; }
        body.menu-collapsed .main-menu:hover .navigation li span { display: inline-block !important; }

        body.menu-collapsed .main-menu.menu-dark .navigation > li:hover > a i {
            transform: scale(1.1) !important;
            background: rgba(var(--section-accent-rgb, 59, 130, 246), 0.2) !important;
            box-shadow: 0 0 15px rgba(var(--section-accent-rgb, 59, 130, 246), 0.4) !important;
        }

        .navigation li:hover i {
            transform: scale(1.1) translateY(-2px);
            background: rgba(var(--section-accent-rgb, 59, 130, 246), 0.15) !important;
            border-color: var(--section-accent, var(--primary-color));
            color: var(--section-accent, var(--primary-color)) !important;
            box-shadow: 0 5px 15px rgba(var(--section-accent-rgb, 59, 130, 246), 0.3);
        }

        .navigation li span { transition: all 0.4s ease; font-weight: 500; }
        .navigation li:hover span { animation: textExpand 0.4s forwards; color: var(--text-primary) !important; }

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
            background: linear-gradient(to bottom, var(--primary-color), transparent);
            opacity: 0.5;
        }

        .navigation li .menu-content li { margin: 2px 8px; border-radius: 6px; opacity: 0; animation: slideIn 0.4s ease forwards; }
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
        }

        .navigation li.active > a i { color: var(--section-accent, var(--primary-color)) !important; opacity: 1; }

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

        .navigation li .menu-content li a:hover { opacity: 1; transform: translateX(5px); background: rgba(255, 255, 255, 0.05) !important; }
        .navigation li .menu-content li a i { font-size: 0.9rem; margin-right: 10px; width: 18px; }

        /* Modern Scrollbar */
        .main-menu-content::-webkit-scrollbar { width: 5px; }
        .main-menu-content::-webkit-scrollbar-track { background: transparent; }
        .main-menu-content::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid transparent; background-clip: padding-box; }
        .main-menu-content::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2); }

        /* User Section Refinement */
        .navbar-header { 
            background: var(--timber-dark) !important; 
            padding: 0 !important; 
            border-bottom: 1px solid var(--glass-border); 
            height: 56px !important;
            width: 300px !important; /* Explicit default width for expanded state */
       
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .brand-logo { 
          
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            filter: drop-shadow(0 0 10px var(--accent-glow)); 
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
        }

        .brand-logo img {
            width: 100% !important;
            height: 100% !important;
            max-width: 100% !important;
          
            padding: 0 !important; 
            margin: 0 !important;
        }

        .brand-logo:hover { transform: translateY(-2px); filter: drop-shadow(0 5px 15px var(--accent-glow)); }

        /* Ensure Navbar Header expands with menu */
        body.vertical-layout.vertical-menu-modern.menu-expanded .navbar .navbar-header {
            width: 300px !important;
        }

        /* Header Navbar Glassmorphism */
        .header-navbar {
            background: rgba(2, 6, 23, 0.9) !important;
            backdrop-filter: blur(20px) saturate(180%) !important;
            border-bottom: 1px solid var(--timber-border) !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6) !important;
        }

        .header-navbar .navbar-header { background: transparent !important; }
        .header-navbar .navbar-container { padding: 0 1.5rem; }

        .btn-pos {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px !important;
            letter-spacing: 0.5px;
            font-weight: 700;
            overflow: hidden;
            position: relative;
            color: white !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-alert {
            background: linear-gradient(135deg, #22c55e 0%, #15803d 100%) !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.4) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px !important;
            letter-spacing: 0.5px;
            font-weight: 700;
            overflow: hidden;
            position: relative;
            color: white !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-pos:hover, .btn-alert:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3) !important;
        }

        .btn-pos::after, .btn-alert::after {
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
        .header-navbar .nav-link-label i { transition: all 0.3s ease; }
        .header-navbar .nav-link-label:hover i {
            color: var(--timber-accent) !important;
            transform: translateY(-2px) scale(1.1);
            filter: drop-shadow(0 0 10px var(--gold-glow));
        }

        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px) scale(1.1); } }

        .header-navbar .nav-link span, .header-navbar .btn-info { transition: all 0.3s ease; }
        .header-navbar .nav-link:hover span { letter-spacing: 0.5px; color: var(--primary-color) !important; }

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

        .badge-danger { background: linear-gradient(135deg, #ef4444, #991b1b) !important; animation: glowPulse 2s infinite !important; }
        .badge-info { background: linear-gradient(135deg, #0ea5e9, #0369a1) !important; }

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
        body.menu-expanded .app-content { margin-left: 300px !important; }
        body.menu-collapsed .app-content { margin-left: 60px !important; }
        body.menu-expanded .header-navbar.navbar-fixed { left: 0 !important; width: 100% !important; }
        body.menu-collapsed .header-navbar.navbar-fixed { left: 0 !important; width: 100% !important; }

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
            background: linear-gradient(135deg, rgba(var(--section-accent-rgb, 59, 130, 246), 0.15), rgba(var(--section-accent-rgb, 59, 130, 246), 0.05) ) !important;
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

        @keyframes heartbeat { 0% { transform: scale(1); } 14% { transform: scale(1.15); } 28% { transform: scale(1); } 42% { transform: scale(1.15); } 70% { transform: scale(1); } }

        .sidebar-search-container { padding: 15px 18px; margin-bottom: 10px; }
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

        .sidebar-footer a.social-icon i { font-size: 1.15rem; margin: 0 !important; width: auto !important; height: auto !important; background: none !important; border: none !important; box-shadow: none !important; transition: transform 0.3s ease; }
        .sidebar-footer a.social-icon:hover i { transform: rotate(15deg); }

        /* Top Navbar Social Style */
        .social-icon-top { padding: 0 10px !important; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important; }
        .social-icon-top i { font-size: 1.4rem !important; transition: all 0.3s ease !important; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3)); }
        .social-icon-top:hover { transform: translateY(-4px) scale(1.2) rotate(8deg); }
        .social-icon-top:hover i { filter: drop-shadow(0 0 15px var(--timber-accent)) !important; color: var(--timber-accent) !important; }

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

        .dropdown-item { border-radius: 8px; transition: all 0.2s ease; color: var(--text-secondary) !important; padding: 10px 15px; }

        /* Menu Toggle Enhancement */
        .menu-toggle {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
            width: 42px !important;
            height: 42px !important;
            border-radius: 50% !important;
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid var(--glass-border) !important;
            padding: 0 !important;
            margin: 0 10px !important;
        }

        .menu-toggle i { font-size: 1.5rem !important; color: var(--timber-text-muted) !important; transition: all 0.3s ease !important; }
        .menu-toggle:hover { background: rgba(212, 175, 55, 0.1) !important; border-color: var(--timber-accent) !important; transform: scale(1.1) rotate(5deg); }
        .menu-toggle:hover i { color: var(--timber-accent) !important; filter: drop-shadow(0 0 8px var(--timber-accent)); }

        /* Fixed the is-active state mentioned by user */
        .menu-toggle.is-active { background: rgba(212, 175, 55, 0.15) !important; border-color: var(--timber-accent) !important; box-shadow: 0 0 20px rgba(212, 175, 55, 0.25) !important; }
        .menu-toggle.is-active i { color: var(--timber-accent) !important; transform: rotate(90deg) !important; animation: glowPulse 2s infinite !important; }

        /* Navbar Global Overrides */
        .header-navbar.navbar-semi-dark .navbar-header { background: var(--timber-dark) !important; border-right: 1px solid var(--timber-border); box-shadow: 10px 0 30px rgba(0,0,0,0.5); }
        .header-navbar .navbar-header .navbar-brand .brand-logo { filter: drop-shadow(0 0 5px var(--timber-accent)); transition: all 0.3s ease; }
        .header-navbar.navbar-semi-dark { background: linear-gradient(135deg, var(--timber-dark) 0%, var(--timber-panel) 100%) !important; border-bottom: 1px solid var(--timber-border); }

        /* Nav Links */
        .header-navbar .nav-link { color: var(--timber-text) !important; transition: all 0.3s ease; position: relative; }
        .header-navbar .nav-link:hover { color: var(--timber-accent) !important; text-shadow: 0 0 10px rgba(230, 184, 0, 0.4); }
        .header-navbar .nav-link i { font-size: 1.2rem; transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .header-navbar .nav-link:hover i { transform: translateY(-2px); color: var(--timber-accent) !important; }

        /* Buttons in Nav */
        .header-navbar .btn-info { background: linear-gradient(45deg, var(--timber-green), #588157) !important; border: none; box-shadow: 0 4px 15px rgba(58, 90, 64, 0.4); font-weight: 600; letter-spacing: 0.5px; }
        .header-navbar .btn-info:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(58, 90, 64, 0.6); }

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
        .mega-dropdown-menu .card-header .text-uppercase { color: var(--timber-accent) !important; font-weight: 700; letter-spacing: 1px; font-size: 0.9rem; display: flex; align-items: center; gap: 10px; }
        .mega-dropdown-menu .card-header i { color: var(--timber-accent) !important; background: rgba(230, 184, 0, 0.1); padding: 8px; border-radius: 6px; }
        .mega-dropdown-menu .dropdown-item { color: var(--timber-text-muted) !important; padding: 10px 15px !important; border-radius: 6px; margin-bottom: 2px; transition: all 0.2s ease; border-left: 2px solid transparent; }
        .mega-dropdown-menu .dropdown-item:hover { background: rgba(255, 255, 255, 0.03) !important; color: var(--timber-text) !important; border-left: 2px solid var(--timber-accent); padding-left: 20px !important; }
        .mega-dropdown-menu .dropdown-item i { color: var(--timber-green) !important; opacity: 0.7; }

        /* Horizontal Menu (if active) */
        .main-menu.menu-dark { background: var(--timber-panel) !important; border-right: 1px solid var(--timber-border); }
        .main-menu.menu-dark .navigation > li.active > a { background: linear-gradient(90deg, rgba(230, 184, 0, 0.1), transparent) !important; border-left: 4px solid var(--timber-accent); }

        /* Clean up existing overrides */
        .dropdown-menu-header { border-bottom: 1px solid var(--glass-border); }
        .dropdown-item:active { background-color: var(--timber-accent) !important; }

        /* ================================================================================= */
        /* LUXURY COMMAND SIDEBAR REDESIGN */
        /* ================================================================================= */
        /* Main Menu Container */
        .main-menu.menu-dark {
            background-color: var(--timber-dark) !important;
            background-image: linear-gradient(180deg, rgba(255,255,255,0.03) 0%, rgba(0,0,0,0.4) 100%), radial-gradient(circle at top right, rgba(59, 130, 246, 0.05), transparent 40%);
            border-right: 1px solid var(--glass-border);
            box-shadow: 10px 0 40px rgba(0,0,0,0.6);
        }

        /* Section Headers (e.g., MAIN, ERP OPERATIONS) */
        .main-menu.menu-dark .navigation > .navigation-header {
            color: var(--timber-accent) !important;
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 24px 24px 8px 24px;
            opacity: 0.9;
            text-shadow: 0 0 10px rgba(59, 130, 246, 0.2);
        }

        .main-menu.menu-dark .navigation > .navigation-header span { border-bottom: 2px solid rgba(59, 130, 246, 0.2); padding-bottom: 4px; }

        /* Top Level Menu Items */
        .main-menu.menu-dark .navigation > li > a {
            color: var(--timber-text-muted) !important;
            padding: 12px 24px;
            font-weight: 500;
            transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
            border-left: 3px solid transparent;
            margin: 4px 0;
            position: relative;
            overflow: hidden;
        }

        .main-menu.menu-dark .navigation > li:not(.active) > a:hover {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.03), transparent);
            color: var(--timber-text) !important;
            padding-left: 28px;
            border-left-color: rgba(255, 255, 255, 0.2);
        }

        /* Active Top Level Item - The "Blue Standard" */
        .main-menu.menu-dark .navigation > li.active > a {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1), transparent) !important;
            border-left: 3px solid var(--timber-accent);
            color: var(--timber-text) !important;
            box-shadow: inset 10px 0 20px -10px rgba(59, 130, 246, 0.15);
        }

        .main-menu.menu-dark .navigation > li.active > a::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.05), transparent);
            animation: shimmer 3s infinite;
        }

        .main-menu.menu-dark .navigation > li.active > a i {
            color: var(--timber-accent) !important;
            filter: drop-shadow(0 0 8px rgba(59, 130, 246, 0.5));
            transform: scale(1.1);
        }

        /* Icon Styling */
        .main-menu.menu-dark .navigation > li > a i { color: var(--timber-text-muted); font-size: 1.1rem; margin-right: 14px; transition: all 0.4s ease; }
        .main-menu.menu-dark .navigation > li:hover > a i { color: var(--timber-accent); transform: scale(1.1); }

        /* ================================================================================= */
        /* NESTED MENU STYLING (Level 2 & 3) */
        /* ================================================================================= */
        /* Level 2 Container */
        .main-menu.menu-dark .navigation > li ul.menu-content { background: rgba(0, 0, 0, 0.2) !important; box-shadow: inset 0 5px 15px -5px rgba(0,0,0,0.5); }

        /* Level 2 Items */
        .main-menu.menu-dark .navigation > li .menu-content > li > a { padding: 10px 15px 10px 54px !important; font-size: 0.9rem; color: var(--timber-text-muted) !important; transition: all 0.2s; position: relative; }

        /* Tree Branch Line for Level 2 */
        .main-menu.menu-dark .navigation > li .menu-content > li > a:before { content: ''; position: absolute; left: 36px; top: 50%; height: 1px; width: 8px; background: rgba(255,255,255,0.1); transition: all 0.3s; }
        .main-menu.menu-dark .navigation > li .menu-content > li:hover > a { color: var(--timber-text) !important; background: transparent; transform: translateX(5px); }
        .main-menu.menu-dark .navigation > li .menu-content > li:hover > a:before { background: var(--timber-accent); width: 12px; }

        /* Level 2 Active */
        .main-menu.menu-dark .navigation > li .menu-content > li.active > a { color: var(--timber-accent) !important; font-weight: 600; }
        .main-menu.menu-dark .navigation > li .menu-content > li.active > a:before { background: var(--timber-accent); width: 12px; box-shadow: 0 0 5px var(--timber-accent); }

        /* ================================================================================= */
        /* LEVEL 3 ITEMS */
        /* ================================================================================= */
        /* Level 3 Container */
        .main-menu.menu-dark .navigation > li .menu-content .menu-content { background: rgba(0, 0, 0, 0.15) !important; /* Slightly darker */ }

        /* Level 3 Items */
        .main-menu.menu-dark .navigation > li .menu-content .menu-content > li > a { padding: 10px 15px 10px 50px !important; /* Adjusted Indent */ font-size: 0.85rem; color: var(--timber-text-muted) !important; white-space: normal !important; /* Fix truncation */ height: auto !important; display: flex !important; align-items: flex-start; line-height: 1.4; }

        /* Tree Branch Line for Level 3 */
        .main-menu.menu-dark .navigation > li .menu-content .menu-content > li > a:before { left: 36px; /* Shift line to match Level 2 alignment */ top: 20px; /* Align with first line of text */ }
        .main-menu.menu-dark .navigation > li .menu-content .menu-content > li:hover > a { color: var(--timber-text) !important; background: rgba(255,255,255,0.03); }
        .main-menu.menu-dark .navigation > li .menu-content .menu-content > li.active > a { color: var(--timber-accent) !important; }

        /* Search Box in Sidebar */
        .sidebar-search-container { padding: 20px; background: var(--timber-dark); border-bottom: 1px solid var(--timber-border); }
        .sidebar-search { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; color: var(--timber-text); padding: 8px 15px; width: 100%; font-size: 0.85rem; transition: all 0.3s; }
        .sidebar-search:focus { outline: none; border-color: var(--timber-accent); background: rgba(0,0,0,0.3); box-shadow: 0 0 10px rgba(230, 184, 0, 0.1); }

        /* ================================================================================= */
        /* MENU TOGGLE ICONS (ARROWS) */
        /* ================================================================================= */
        /* Base Arrow Style */
        .main-menu.menu-dark .navigation > li.has-sub > a:after { content: '\f105'; /* FontAwesome Chevron Right */ font-family: 'FontAwesome'; position: absolute; right: 20px; top: 50%; transform: translateY(-50%); font-size: 1rem; color: var(--timber-text-muted); transition: all 0.3s ease; }
        /* Rotate Arrow when Open */
        .main-menu.menu-dark .navigation > li.open > a:after { transform: translateY(-50%) rotate(90deg); color: var(--timber-accent); }
        /* Hide default Theme arrows if any */
        .main-menu.menu-dark .navigation > li.has-sub > a > span.description { display: none !important; }

        /* ================================================================================= */
        /* SIDEBAR WIDTH ADJUSTMENT (300px / 60px) */
        /* ================================================================================= */
        @media (min-width: 768px) {
            /* Increase Sidebar Width */
            body.vertical-layout.vertical-menu-modern.menu-expanded .main-menu { width: 300px !important; }
            /* Adjust Content Margin */
            body.vertical-layout.vertical-menu-modern.menu-expanded .content, body.vertical-layout.vertical-menu-modern.menu-expanded .footer { margin-left: 300px !important; }
            /* Collapsed Sidebar Width & Hover Expand */
            body.vertical-layout.vertical-menu-modern.menu-collapsed .main-menu { 
                width: 60px !important; 
                transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important; 
                overflow: visible !important;
            }
            body.vertical-layout.vertical-menu-modern.menu-collapsed .main-menu:hover { width: 300px !important; }
            
            body.vertical-layout.vertical-menu-modern.menu-collapsed .navbar .navbar-header { 
                width: 60px !important; 
                transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important; 
            }
            
            /* Logo Area Sync on Hover */
            body.vertical-layout.vertical-menu-modern.menu-collapsed:has(.main-menu:hover) .navbar .navbar-header { 
                width: 300px !important; 
            }

            /* Spacing adjustments for icon visibility */
            body.vertical-layout.vertical-menu-modern.menu-collapsed .navigation li { margin: 0px 4px !important; position: static !important; }
        }

        /* ================================================================================= */
        /* VISUAL REFINEMENTS (Typography, Icons, Animation) */
        /* ================================================================================= */
        /* 1. Bold Typography */
        .main-menu.menu-dark .navigation .navigation-header { font-weight: 800 !important; letter-spacing: 1.5px; color: var(--timber-accent); opacity: 1; /* Make headers fully visible */ }
        .main-menu.menu-dark .navigation > li > a { font-weight: 600; }

        /* 2. Related Icons & Colors */
        /* Level 1 Icons - Default to Timber Accent (Blue) */
        .main-menu.menu-dark .navigation > li > a > i { color: var(--timber-accent) !important; opacity: 0.8; transition: all 0.3s; }
        /* Brighten on Hover/Active */
        .main-menu.menu-dark .navigation > li:hover > a > i, .main-menu.menu-dark .navigation > li.active > a > i { color: var(--timber-green) !important; /* Switch to Green on interaction */ opacity: 1; text-shadow: 0 0 8px rgba(76, 175, 80, 0.4); }

        /* Level 3 "Leaf" Icon */
        .main-menu.menu-dark .navigation > li .menu-content .menu-content > li > a:before { content: '\f06c' !important; /* FontAwesome Leaf */ font-family: 'FontAwesome'; font-size: 0.7rem; color: var(--timber-green); /* Green Leaf */ top: 22px; /* Adjust alignment */ background: none; /* Remove previous line style if specific */ width: auto; height: auto; }

        /* 3. New Animation Style */

        /* 4. Dual Logo Logic */
        .brand-logo .logo-collapsed { display: none !important; }
        .brand-logo .logo-expanded { display: block !important; }

        /* When Menu Collapsed, Show Collapsed Logo */
        body.vertical-layout.vertical-menu-modern.menu-collapsed .navbar .navbar-header .brand-logo .logo-expanded { display: none !important; }
        body.vertical-layout.vertical-menu-modern.menu-collapsed .navbar .navbar-header .brand-logo .logo-collapsed { 
            display: block !important;
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            object-fit: contain !important;
        }

        /* Show Expanded Logo on Hover */
        body.vertical-layout.vertical-menu-modern.menu-collapsed:has(.main-menu:hover) .navbar .navbar-header .brand-logo .logo-expanded { display: block !important; }
        body.vertical-layout.vertical-menu-modern.menu-collapsed:has(.main-menu:hover) .navbar .navbar-header .brand-logo .logo-collapsed { display: none !important; }

        /* Multi-location / Sprint 1: Soft-Delete Highlighting */
        .pending-delete-row {
            background-color: rgba(239, 68, 68, 0.08) !important;
            border-left: 4px solid #ef4444 !important;
            transition: all 0.3s ease;
        }
        .pending-delete-row:hover {
            background-color: rgba(239, 68, 68, 0.12) !important;
        }
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
        <div class="navbar-header">
             <a href="<?= base_url() ?>dashboard/" class="brand-logo">
                 <img class="logo-expanded" src="<?php echo base_url(); ?>userfiles/theme/logo-header.png" alt="logo">
                 <img class="logo-collapsed" src="<?php echo base_url(); ?>userfiles/theme/logo-h.png" alt="logo">
             </a>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                                                              href="#"><i class="ft-menu"></i></a></li>


                    <li class="dropdown nav-item"><a class="nav-link nav-link-label" href="#"
                                                      data-toggle="dropdown"><i
                                     class="ficon ft-map-pin success"></i></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-left">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                             class="grey darken-2"><i
                                                 class="ficon ft-map-pin success"></i><?php echo $this->lang->line('Business') . ' ' . $this->lang->line('Location') ?></span>
                                </h6>
                            </li>
                            <div class="scrollable-container media-list">
                                <?php
                                $this->db->select('geopos_locations.id, geopos_locations.cname');
                                $this->db->from('geopos_locations');
                                $roleid = $this->aauth->get_user()->roleid;
                                if ($roleid != 1) {
                                    // If not Super Admin, check assigned locations
                                    $this->db->join('geopos_user_locations', 'geopos_locations.id = geopos_user_locations.location_id');
                                    $this->db->where('geopos_user_locations.user_id', $this->aauth->get_user()->id);
                                }
                                $this->db->where('geopos_locations.delete_status', 0);
                                $this->db->where('geopos_locations.id !=', 0);
                                $query = $this->db->get();
                                $locs = ($query) ? $query->result_array() : array();
                                
                                foreach ($locs as $row) {
                                    $active = ($row['id'] == $this->session->userdata('loc')) ? 'style="border-left: 3px solid #22c55e; background: rgba(34, 197, 94, 0.05);"' : '';
                                    echo '<a class="dropdown-item" '.$active.' href="'.base_url('OwnerDashboard/switch_location?id='.$row['id']).'">'.$row['cname'].'</a>';
                                }
                                ?>
                            </div>
                            <li class="dropdown-menu-footer"><span class="dropdown-item text-muted text-center blue"
                                > Current: <?php $loc = location($this->session->userdata('loc'));
                                    echo $loc['cname']; ?></span>
                            </li>
                        </ul>
                    </li>
                    <?php if ($this->aauth->premission(1)) { ?>
                    <li class="nav-item d-none d-md-block nav-link "><a href="<?= base_url() ?>pos_invoices/create"
                                                                        class="btn btn-pos btn-md t_tooltip"
                                                                        title="Access POS"><i
                                    class="icon-handbag"></i><?php echo $this->lang->line('POS') ?> </a>
                    </li>
                    <?php } ?>
                    
                    <li class="nav-item d-none d-md-block nav-link "><a href="<?= base_url() ?>products_alert/manage_alert2"
                                                                        class="btn btn-alert btn-md t_tooltip"
                                                                        title="Advanced Inventory Management System"><i
                                    class="ft-bell mr-1"></i>Inventory Alert</a>
                    </li>
                    
                    <li class="nav-item d-none d-md-block nav-link "><a href="<?= base_url() ?>project_command"
                                                                        class="btn btn-info btn-md t_tooltip"
                                                                        title="TimberPro Project Command Center"><i
                                    class="ft-briefcase mr-1"></i>Projects</a>
                    </li>
               

                </ul>

                <ul class="nav navbar-nav float-right"><?php if ($this->aauth->get_user()->roleid == 1 || $this->aauth->get_user()->roleid == 5) { ?>
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
                            <a href="https://web.facebook.com/koralahawage" class="nav-link nav-link-label social-icon-top p-1" style="color: #1877F2 !important;"><i class="fa fa-facebook-official" style="font-size: 1.6rem;"></i></a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.linkedin.com/in/dashan-korala-hewage-52801a89/" class="nav-link nav-link-label social-icon-top p-1" style="color: #0A66C2 !important;"><i class="fa fa-linkedin-square" style="font-size: 1.6rem;"></i></a>
                        </li>
                        <li class="nav-item">
                            <a href="https://wa.link/s8s8ns" class="nav-link nav-link-label social-icon-top p-1" style="color: #25D366 !important;"><i class="fa fa-whatsapp" style="font-size: 1.6rem;"></i></a>
                        </li>
                    </ul>

                    
                   
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
                    <!-- 🎓 Guided Tour Button -->
                    <li class="dropdown nav-item" id="guided-tour-btn" data-lang="si">
                        <a class="nav-link nav-link-label dropdown-toggle" href="#" data-toggle="dropdown"
                           title="Guided Tour / මඟ පෙන්වීම" style="font-size:1.2rem; color:var(--timber-green);">
                            🎓
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" style="background:#0f172a;border:1px solid rgba(59,130,246,0.2);border-radius:12px;min-width:180px;">
                            <li class="dropdown-item" style="color:#94a3b8;font-size:0.75rem;font-weight:700;padding:8px 16px;">🌐 Tour Language</li>
                            <li><a class="dropdown-item" href="#" onclick="startGuidedTour('si');return false;" style="color:white;">🇱🇰 සිංහල</a></li>
                            <li><a class="dropdown-item" href="#" onclick="startGuidedTour('ta');return false;" style="color:white;">🇱🇰 தமிழ்</a></li>
                            <li><a class="dropdown-item" href="#" onclick="startGuidedTour('en');return false;" style="color:white;">🇬🇧 English</a></li>
                            <div class="dropdown-divider" style="border-top-color:rgba(255,255,255,0.1);"></div>
                            <li><a class="dropdown-item" href="#" onclick="localStorage.removeItem('timber_tour_done');startGuidedTour(tourLang);return false;" style="color:#22c55e;">↩️ Restart Tour</a></li>
                        </ul>
                    </li>
                    <!-- End Guided Tour Button -->

                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"
                                                                   href="#" data-toggle="dropdown"><span
                                    class="avatar avatar-online" style="border: 2px solid var(--timber-accent); border-radius: 50%; padding: 1px; box-shadow: 0 0 10px rgba(59, 130, 246, 0.2);"><img
                                        src="<?php echo base_url('userfiles/employee/thumbnail/' . $this->aauth->get_user()->picture) ?>"
                                        alt="avatar" style="border-radius: 50%;"><i></i></span><span
                                    class="user-name" style="color: var(--timber-accent) !important; font-weight: 700; margin-left: 8px;"><?php echo $this->lang->line('Account') ?></span></a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                           href="<?php echo base_url(); ?>user/profile"><i
                                        class="ft-user"></i> <?php echo $this->lang->line('Profile') ?></a>
                           

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
            <?php
                $roleid = $this->aauth->get_user()->roleid;
                $username = $this->aauth->get_user()->username;
                $is_superadmin = ($roleid == 1 || $roleid == 5);
                $is_owner      = ($roleid == 1 || $roleid == 5 || $roleid == 4);
                $is_manager    = ($roleid >= 3);
                $is_staff      = ($roleid >= 1);
                $is_customer   = ($roleid == 0);
                
                // Blueprint visibility flags: Incorporating Granular RBAC
                $show_erp         = ($is_manager || $this->aauth->has_permission('sales_invoices_view')); 
                $show_finance     = ($is_manager || $this->aauth->has_permission('accounts_view'));
                $show_health      = ($is_superadmin || $this->aauth->has_permission('global_settings_view'));
                $show_hr          = ($is_manager || $this->aauth->has_permission('employees_view'));
                $show_gig         = ($is_manager || $this->aauth->has_permission('active_rings_view'));
                $show_marketing   = ($is_manager || $this->aauth->has_permission('ai_video_showcase_view'));
                $show_marketplace = ($is_staff || $is_customer);
            ?>
            
            <!-- 1. DASHBOARDS (Common) -->
            <li class="navigation-header section-erp"><span>📊 Dashboard Center</span></li>
            <li class="nav-item section-erp <?php if (current_url() == base_url('dashboard')) echo 'active'; ?>">
                <a href="<?= base_url(); ?>dashboard/"><i class="ft-home"></i><span>Main Dashboard</span></a>
            </li>

            <?php if ($roleid == 1 || $roleid == 5 || $this->aauth->premission(10)) { ?>
            <li class="nav-item section-erp <?php if (strpos(current_url(), 'SystemHealth') !== false) echo 'active'; ?>">
                <a href="<?= base_url(); ?>SystemHealth/dashboard"><i class="ft-activity"></i><span>System Health Status</span></a>
            </li>
            <?php } ?>

            <!-- 2. SALES (Module 1) -->
            <?php if ($this->aauth->premission(1)) { ?>
            <li class="navigation-header section-erp"><span>💰 Sales & Invoicing</span></li>
            <li class="nav-item has-sub section-erp <?php if ($this->li_a == "sales") echo 'open active'; ?>">
                <a href="#"><i class="ft-shopping-cart"></i><span><?php echo $this->lang->line('sales') ?></span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('pos_invoices/create')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>pos_invoices/create"><i class="ft-plus-circle"></i><?php echo $this->lang->line('New Invoice'); ?></a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('pos_invoices')) echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>pos_invoices"><i class="ft-list"></i><?php echo $this->lang->line('Manage Invoices'); ?></a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('pos_invoices/quotecreate')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>pos_invoices/quotecreate"><i class="ft-file"></i><?php echo $this->lang->line('New Quote'); ?></a>
                    </li>
                </ul>
            </li>
            <?php } ?>

            <!-- 3. STOCK & INVENTORY (Module 2) -->
            <?php if ($this->aauth->premission(2)) { ?>
            <li class="navigation-header section-erp"><span>📦 Inventory Operations</span></li>
            <li class="nav-item has-sub section-erp <?php if ($this->li_a == "stock") echo 'open active'; ?>">
                <a href="#"><i class="ft-package"></i><span><?php echo $this->lang->line('Stock') ?></span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('products')) echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>products"><i class="ft-box"></i><?= $this->lang->line('Manage Products'); ?></a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('products/stock_transfer')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>products/stock_transfer"><i class="ft-wind"></i>Stock Transfer</a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('productcategory/warehouse')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>productcategory/warehouse"><i class="ft-map-pin"></i>Warehouses</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-sub section-erp <?php if ($this->li_a == "purchase") echo 'open active'; ?>">
                <a href="#"><i class="ft-download"></i><span>Purchasing (LOGS)</span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('purchase/log_purchasing')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>purchase/log_purchasing"><i class="ft-shopping-cart"></i>Log Purchasing</a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('purchase')) echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>purchase"><i class="ft-file-text"></i><?= $this->lang->line('Manage Orders'); ?></a>
                    </li>
                </ul>
            </li>
            <?php } ?>
            
            <!-- Service Management (Phase 1) -->
            <?php if ($roleid == 1) { ?>
            <li class="navigation-header section-services"><span>🛠️ Service Management</span></li>
            <li class="nav-item has-sub section-services <?php if ($this->li_a == "service_mgmt") echo 'open active'; ?>">
                <a href="#"><i class="ft-briefcase"></i><span>Service Management</span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('servicecategories')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>servicecategories"><i class="ft-folder"></i>Service Categories</a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('services')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>services"><i class="ft-list"></i>Master Service List</a>
                    </li>
                </ul>
            </li>
            <?php } ?>

            <!-- 4. CRM & CUSTOMERS (Module 3) -->
            <?php if ($this->aauth->premission(3)) { ?>
            <li class="navigation-header section-erp"><span>👥 CRM & Clients</span></li>
            <li class="nav-item has-sub section-erp <?php if ($this->li_a == "customers") echo 'open active'; ?>">
                <a href="#"><i class="ft-users"></i><span>Customers</span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('customers')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>customers">Manage Customers</a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('customers/groups')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>customers/groups">Customer Groups</a>
                    </li>
                </ul>
            </li>
            <?php } ?>

            <!-- 5. PROJECT MANAGEMENT (Module 4) -->
            <?php if ($this->aauth->premission(4)) { ?>
            <li class="navigation-header section-erp"><span>🏗️ Project Hub</span></li>
            <li class="nav-item has-sub section-erp <?php if ($this->li_a == "projects") echo 'open active'; ?>">
                <a href="#"><i class="ft-grid"></i><span>Manage Projects</span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('projects')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>projects">Projects List</a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('projects/tasks')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>projects/tasks">Project Tasks</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-sub section-erp <?php if ($this->li_a == "timberpro") echo 'open active'; ?>">
                <a href="#"><i class="ft-layers"></i><span>Timber Operations</span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('TimberPro')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>TimberPro"><i class="ft-activity"></i>Timber Dashboard</a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('sawmill/processing')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>sawmill/processing"><i class="ft-cpu"></i>Sawmill Processing</a>
                    </li>
                </ul>
            </li>
            <?php } ?>

            <!-- 6. ACCOUNTS & FINANCE (Module 5) -->
            <?php if ($this->aauth->premission(5)) { ?>
            <li class="navigation-header section-erp"><span>💳 Financial Center</span></li>
            <li class="nav-item has-sub section-erp <?php if ($this->li_a == "accounting") echo 'open active'; ?>">
                <a href="#"><i class="ft-trending-up"></i><span>Accounting & Ledger</span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('settings/dual_entry')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>settings/dual_entry"><i class="ft-list"></i>Double Entry Ledger</a>
                    </li>
                    <li class="menu-item <?php if ($this->li_a == 'accounts') echo 'active'; ?>">
                        <a href="<?= base_url(); ?>accounts"><i class="ft-credit-card"></i>Financial Accounts</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-sub section-erp <?php if ($this->li_a == "hp") echo 'open active'; ?>">
                <a href="#"><i class="ft-credit-card"></i><span>Hire Purchase</span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('hp/manage')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>hp/manage"><i class="ft-file"></i>Manage Contracts</a>
                    </li>
                </ul>
            </li>
            <?php } ?>

            <!-- 7. DATA & REPORTS (Module 6) -->
            <?php if ($this->aauth->premission(6)) { ?>
            <li class="navigation-header section-data"><span>📈 Data & Analytics</span></li>
            <li class="nav-item has-sub section-data <?php if ($this->li_a == "data") echo 'open active'; ?>">
                <a href="#"><i class="ft-pie-chart"></i><span>Intelligence Reports</span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('financial/profit_loss')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>financial/profit_loss"><i class="ft-pie-chart"></i>Profit & Loss</a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('financial/balance_sheet')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>financial/balance_sheet"><i class="ft-file-text"></i>Balance Sheet</a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('advanced_reports')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>advanced_reports"><i class="fa fa-line-chart"></i>Advanced Report Center</a>
                    </li>
                </ul>
            </li>
            <?php } ?>

            <!-- 8. PROJECT WORKER / FIELD HUB (Module 7) -->
            <?php if ($this->aauth->premission(7)) { ?>
            <li class="navigation-header section-services"><span>⚡ Field Workforce</span></li>
            <li class="nav-item section-services <?php if (current_url() == base_url('worker/job_requests')) echo 'active'; ?>">
                <a href="<?= base_url(); ?>worker/job_requests"><i class="ft-mail"></i><span>Marketplace Hub</span></a>
            </li>
            <li class="nav-item section-services <?php if (current_url() == base_url('worker/attendance')) echo 'active'; ?>">
                <a href="<?= base_url(); ?>worker/attendance"><i class="ft-clock"></i><span>Time & Attendance</span></a>
            </li>
            <?php } ?>

            <!-- 9. SERVICES & TICKETS (Module 8) -->
            <?php if ($this->aauth->premission(8)) { ?>
            <li class="navigation-header section-services"><span>🔔 Service Desk</span></li>
            <li class="nav-item section-services <?php if (strpos(current_url(), 'ring') !== false) echo 'active'; ?>">
                <a href="<?= base_url(); ?>ring"><i class="ft-bell"></i><span>Ring (Service Logs)</span></a>
            </li>
            <?php } ?>

            <!-- 10. HRM (Module 9) -->
            <?php if ($this->aauth->premission(9)) { ?>
            <li class="navigation-header section-erp"><span>👮 HRM & Staff</span></li>
            <li class="nav-item has-sub section-erp <?php if ($this->li_a == "employee") echo 'open active'; ?>">
                <a href="#"><i class="ft-users"></i><span>Staff Management</span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('employee')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>employee"><i class="ft-users"></i>Employees List</a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('employee/roles')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>employee/roles"><i class="ft-shield"></i>Roles & Permissions</a>
                    </li>
                </ul>
            </li>
            <?php } ?>

            <!-- 11. SETTINGS & SYSTEM (Module 10) -->
            <?php if ($this->aauth->premission(10)) { ?>
            <li class="navigation-header section-settings"><span>⚙️ System Settings</span></li>
            <li class="nav-item has-sub section-settings <?php if ($this->li_a == "settings") echo 'open active'; ?>">
                <a href="#"><i class="ft-settings"></i><span>Configuration</span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('settings/company')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>settings/company"><i class="ft-briefcase"></i>Company Settings</a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('export/dbexport')) echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>export/dbexport"><i class="ft-database"></i>Database Backup</a>
                    </li>
                </ul>
            </li>
            <?php } ?>

            <!-- 11.5 SUBSCRIPTIONS & COMMISSIONS (Super Admin) -->
            <?php if ($is_superadmin) { ?>
            <li class="navigation-header section-settings"><span>💎 Subscription Manager</span></li>
            <li class="nav-item has-sub section-settings <?php if ($this->li_a == "subscriptions") echo 'open active'; ?>">
                <a href="#"><i class="ft-award"></i><span>Subscriptions</span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('subscriptions/approvals')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>subscriptions/approvals"><i class="ft-check-circle"></i>Pending Approvals</a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('subscriptions/active_users')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>subscriptions/active_users"><i class="ft-users"></i>Active Subscribers</a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('subscriptions/commissions')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>subscriptions/commissions"><i class="ft-trending-up"></i>Commission Tracker</a>
                    </li>
                </ul>
            </li>
            <?php } ?>


            <!-- 12. SPECIALIZED SECTIONS (CSR / MARKETPLACE) -->
            <li class="navigation-header"><span>🌍 Global Network</span></li>
            <li class="nav-item has-sub <?php if (strpos(current_url(), 'greenfuture') !== false) echo 'open active'; ?>">
                <a href="#"><i class="ft-globe" style="color:#22c55e;"></i><span>🌳 Green Future (CSR)</span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('greenfuture')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>greenfuture"><i class="ft-bar-chart-2"></i> CSR Dashboard</a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('greenfuture/donate')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>greenfuture/donate"><i class="ft-heart"></i> Participate/Donate</a>
                    </li>
                </ul>
            </li>

            <?php if ($roleid == 1 || $roleid == 5 || $roleid == 0) { ?>
            <!-- CUSTOMER MARKETPLACE LINK -->
            <li class="nav-item has-sub section-tools <?php if ($this->li_a == "marketplace_admin") echo 'open active'; ?>">
                <a href="#"><i class="ft-shopping-bag"></i><span>Marketplace Portal</span></a>
                <ul class="menu-content">
                    <li class="menu-item <?php if (current_url() == base_url('shop/listings')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>shop/listings"><i class="ft-list"></i>My Purchases</a>
                    </li>
                    <li class="menu-item <?php if (current_url() == base_url('referral')) echo 'active'; ?>">
                        <a href="<?= base_url(); ?>referral"><i class="ft-users"></i> Referral Program</a>
                    </li>
                </ul>
            </li>
            <?php } ?>
        </div>
        <!-- /main menu content-->
    </div>
    <!-- /main menu-->
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

<!-- ===== GUIDED TOUR (Intro.js — Sinhala / Tamil / English) ===== -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/introjs.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/intro.min.js"></script>
<script>
var tourLang = <?php echo json_encode($this->session->userdata('lang') ?: 'si'); ?>;
var tourSteps = {
    si: [
        { element: '.main-menu', intro: '👋 <strong>ආයුබෝවන්!</strong><br>මේ ප්‍රදහන සිරස් මැනැවය. ඔබඩේ සියලු මොඩල් මැතැනින් ප්‍රවේශ කල හැක.', title: 'ප්‍රදහන මැනු' },
        { element: '#menu-search', intro: '🔍 <strong>මැනු සේවුම</strong><br>ඔනෙේම මොඩලයක් ඉක්මනින් සොයා ගන්න.', title: 'වේගවත් සේවුම' },
        { element: '.section-erp li', intro: '🏢 <strong>ආයතනය සහ මූල්‍ය</strong><br>Dashboard, ගිණුම්, ගනුදේනු සියල්.', title: 'ව්‍යාපාර කලමානාකරණය' },
        { element: 'a[href*="shop"]', intro: '🛒 <strong>Shop</strong><br>ලී ද්‍රව්‍ය, දෘඩාංග, සේවා සොයා ගැන මිලදී ගන්න. Smart Filter භාළිතා කරන්න!', title: 'Shop මාර්කේට්ප්ලස්' },
        { element: 'a[href*="greenfuture"]', intro: '🌳 <strong>Green Future</strong><br>ගස් රෝපන ඉල්ලීම් කරන්න, නඩත්තු දීමනාවට ඉල්ලුම් කරන්න.', title: 'Green Future CSR' },
        { element: '.section-services li', intro: '⚡ <strong>Workforce Hub</strong><br>සේවකයින් කලමානාකරණය, Ring Service Logs.', title: 'Workforce' },
        { element: '#guided-tour-btn', intro: '🎓 ඔනෙේ අවස්ඐවක tour යරඉ ආරම්භ කීරීමට මැතැන ක්ලික් කරන්න!', title: 'Tour නැවත ආරම්භ කරන්න' }
    ],
    ta: [
        { element: '.main-menu', intro: '👋 <strong>வரவேற்கிறோம்!</strong><br>இது முதன்மை பக்கப்பட்டி. அனைத்து தொகுதிகளையும் இங்கிருந்து அணுகலாம்.', title: 'பக்கப்பட்டி மெனு' },
        { element: '#menu-search', intro: '🔍 மெனு தேடல் மூலம் எண்ணிய தொகுதியை விரைவாக கண்டுபிடிக்க.', title: 'விரைவு தேடல்' },
        { element: 'a[href*="greenfuture"]', intro: '🌳 Green Future - மரம் நடவு கோரிக்கைகள், பராமரிப்பு உதவிதொகை விண்ணப்பிக்கவும்.', title: 'Green Future CSR' },
        { element: '#guided-tour-btn', intro: '🎓 எந்நேரமும் tour மீண்டும் தொடங்க இங்கே கிளிக் செய்யவும்!', title: 'Tour மீண்டும் தொடங்கு' }
    ],
    en: [
        { element: '.main-menu', intro: '👋 <strong>Welcome!</strong><br>This is the main sidebar. Access all modules from here.', title: 'Main Navigation' },
        { element: '#menu-search', intro: '🔍 <strong>Menu Search</strong><br>Quickly find any module or page by typing here.', title: 'Quick Search' },
        { element: 'a[href*="shop"]', intro: '🛒 Use the <strong>Shop</strong> to browse timber &amp; hardware. Use the <strong>Smart Filter</strong> on the left to find products by location, price and type.', title: 'Marketplace' },
        { element: 'a[href*="greenfuture"]', intro: '🌳 <strong>Green Future</strong><br>Donate to the CSR fund, request tree planting with Grama Niladhari &amp; Sabhapathi certificates, and apply for monthly maintenance stipends verified by photo.', title: 'Green Future CSR' },
        { element: '#guided-tour-btn', intro: '🎓 Click here anytime to restart this guided tour!', title: 'Restart Tour' }
    ]
};

function startGuidedTour(lang) {
    lang = lang || tourLang || 'si';
    var steps = tourSteps[lang] || tourSteps['si'];
    var validSteps = steps.filter(function(s) {
        if (!s.element) return true;
        return document.querySelector(s.element) !== null;
    });
    introJs().setOptions({
        steps: validSteps,
        nextLabel: lang === 'si' ? 'ඉල්ලග ➡️' : (lang === 'ta' ? 'அடுத்து ➡️' : 'Next ➡️'),
        prevLabel: lang === 'si' ? '⬅️ ආපසු' : (lang === 'ta' ? '⬅️ முந்தையது' : '⬅️ Back'),
        doneLabel: lang === 'si' ? '✅ අවසන්' : (lang === 'ta' ? '✅ முடிந்தது' : '✅ Done'),
        showProgress: true,
        showBullets: true,
        exitOnOverlayClick: false,
        overlayOpacity: 0.5,
        tooltipClass: 'timber-tour-tooltip',
    }).start();
}

$(document).ready(function() {
    // Language switcher in tour
    $('#guided-tour-btn').on('click', function() {
        var lang = $(this).data('lang') || tourLang;
        startGuidedTour(lang);
    });

    // Auto-start for first-time visitors only
    if (!localStorage.getItem('timber_tour_done')) {
        setTimeout(function() { startGuidedTour(tourLang); }, 2000);
    }
});
</script>
<style>
.timber-tour-tooltip { font-family: inherit !important; border-radius: 12px !important; max-width: 320px; }
.timber-tour-tooltip .introjs-tooltip-title { color: #1e3c72 !important; font-weight: 700; font-size: 1rem; }
.timber-tour-tooltip .introjs-button { border-radius: 8px !important; font-weight: 600; font-size: 0.85rem; }
.timber-tour-tooltip .introjs-nextbutton { background: #2a5298 !important; color: white !important; border-color: #2a5298 !important; }
.timber-tour-tooltip .introjs-donebutton { background: #22c55e !important; color: white !important; border-color: #22c55e !important; }
.timber-tour-tooltip .introjs-skipbutton { color: #64748b; }
.introjs-helperLayer { border-radius: 8px; }
</style>
<!-- ===== END GUIDED TOUR ===== -->
<!-- Horizontal navigation-->
<div id="c_body"></div>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
