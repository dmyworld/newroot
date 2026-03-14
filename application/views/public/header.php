<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'TimberPro - Sri Lanka\'s Leading Timber Ecosystem'; ?></title>
    
    <!-- Meta Tags -->
    <meta name="description" content="<?= isset($meta_description) ? $meta_description : 'The leading timber marketplace and CSR initiative in Sri Lanka. Connect with verified sellers, buyers, and green initiatives.' ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= isset($title) ? $title : 'TimberPro Ecosystem' ?>">
    <meta property="og:description" content="<?= isset($meta_description) ? $meta_description : 'Explore Sri Lanka\'s premium timber marketplace and support our Green Future CSR initiatives.' ?>">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Noto+Sans+Sinhala:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Outfit"', '"Plus Jakarta Sans"', 'sans-serif'],
                        body: ['"Inter"', '"Noto Sans Sinhala"', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2563eb',    /* Royal Blue */
                        success: '#16a34a',    /* Life Green */
                        dark: '#0f172a',       /* Slate 900 */
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --primary: #2563eb;
            --success: #16a34a;
            --bg-light: #eff6ff;
        }
        body {
            background-color: var(--bg-light);
            color: #334155;
        }
        .glass-header {
            background: rgba(26, 28, 35, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-[#eff6ff] text-slate-700 font-sans antialiased overflow-x-hidden">
<?php 
// Global Translation Logic for Public Header
$lang_id = isset($_GET['lang']) ? $_GET['lang'] : 'si'; 
$trans = [
    'en' => [
        'nav_home' => 'Home',
        'nav_solutions' => 'Solutions',
        'nav_marketplace' => 'Marketplace',
        'nav_green' => 'Green SL',
        'nav_workforce' => 'Workforce',
        'nav_calculator' => 'Calculator',
        'nav_login' => 'Login',
        'nav_register' => 'Get Started',
        'industry_timber' => 'Timber Industry',
        'industry_hardware' => 'Hardware Stores',
        'industry_construction' => 'Construction & Services',
    ],
    'si' => [
        'nav_home' => 'මුල් පිටුව',
        'nav_solutions' => 'විසඳුම්',
        'nav_marketplace' => 'වෙළඳපොළ',
        'nav_green' => 'Green Future',
        'nav_workforce' => 'සේවක බලකාය',
        'nav_calculator' => 'ගණක යන්ත්‍රය',
        'nav_login' => 'ඇතුල් වන්න',
        'nav_register' => 'ලියාපදිංචි වන්න',
        'industry_timber' => 'දැව කර්මාන්තය',
        'industry_hardware' => 'Hardware වෙළඳසැල්',
        'industry_construction' => 'ඉදිකිරීම් සහ සේවා',
    ]
];
$t = isset($trans[$lang_id]) ? $trans[$lang_id] : $trans['si'];
$this->load->view('public/nav', ['t' => $t, 'lang_id' => $lang_id]); 
?>
