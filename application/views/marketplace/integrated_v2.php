සිංහල අපේ වෙබ් අඩවියට පැමිණීම ගැන ස්තුතියි! මෙන්න ඔබට අවශ්ය සම්පූර්ණ මාකට්ප්ලේස් පිටුව Timber සහ Worker යන මෙවලම් දෙකම සමඟ සම්පූර්ණ කර ඇත.

<?php
$lots = $lots ?? [];
$featured_lots = $featured_lots ?? [];
$is_logged_in = $is_logged_in ?? false;
$usernm = $usernm ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Timber & Workers | TimberPro</title>
    
    <!-- SEO -->
    <meta property="og:title" content="Premium Marketplace - TimberPro">
    <meta property="og:description" content="Buy timber and hire skilled workers directly from verified suppliers across Sri Lanka.">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    
    <style>
        <?php include(APPPATH . 'views/marketplace/styles.css'); ?>
    </style>
</head>
<body>

<!-- Modern Header -->
<?php include(APPPATH . 'views/landing_page/includes/modern_header.php'); ?>

<!-- Tab Navigation -->
<div class="marketplace-tabs">
    <div class="tabs-container">
        <button class="tab-btn active" onclick="switchTab('timber')">
            <i class="fa fa-tree"></i>
            <span>🌲 Timber Marketplace</span>
        </button>
        <button class="tab-btn" onclick="switchTab('workers')">
            <i class="fa fa-users"></i>
            <span>👷 Find Workers</span>
        </button>
    </div>
</div>

<!-- Timber Tab -->
<div id="timber-tab" class="tab-content active">
    <?php include(APPPATH . 'views/marketplace/timber_section.php'); ?>
</div>

<!-- Workers Tab -->
<div id="workers-tab" class="tab-content">
    <?php include(APPPATH . 'views/marketplace/worker_section.php'); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
function switchTab(tabName) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.closest('.tab-btn').classList.add('active');
    
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    document.getElementById(tabName + '-tab').classList.add('active');
}
</script>

</body>
</html>
