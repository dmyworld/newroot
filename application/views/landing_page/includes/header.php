<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'TimberPro ERP - Sri Lanka\'s #1 Timber Business Solution'; ?></title>
    <meta name="description" content="<?php echo isset($metaDescription) ? $metaDescription : 'Manage your timber business with Sri Lanka\'s leading ERP. Inventory, Sales, Marketplace, and more in one platform.'; ?>">
    
    <!-- Favicon -->
    <?php $basePath = isset($basePath) ? $basePath : ''; ?>
    <link rel="icon" href="<?php echo $basePath; ?>assets/images/favicon.ico" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Theme Colors -->
    <?php include_once 'theme_colors.php'; ?>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        body: ['"Inter"', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2563eb',    // Royal Blue
                        secondary: '#1e3a8a',  // Navy Blue
                        success: '#16a34a',    // Life Green
                        warning: '#f59e0b',    // Amber
                        danger: '#ef4444',     // Red
                        light: '#eff6ff',      // Alice Blue
                        dark: '#0f172a',       // Slate 900
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #bfdbfe;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }

        /* Glassmorphism Header */
        .glass-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }
        
        /* Smooth Scroll Padding */
        html {
            scroll-padding-top: 80px;
        }
        
        /* Mobile Menu Animation */
        .mobile-menu {
            transition: transform 0.3s ease-in-out;
        }
        .mobile-menu.hidden {
            transform: translateX(100%);
        }
        .mobile-menu.active {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-[#eff6ff] text-slate-700 font-sans antialiased overflow-x-hidden">


