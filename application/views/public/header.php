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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        body: ['"Inter"', 'sans-serif'],
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
<?php $this->load->view('public/nav'); ?>
