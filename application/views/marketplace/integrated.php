<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Timber & Workers | TimberPro</title>
    
    <!-- SEO Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Premium Marketplace - TimberPro">
    <meta property="og:description" content="Buy timber and hire skilled workers directly. 500+ active listings from verified sellers across Sri Lanka.">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f5f7fa; }
        
        /* Tab Navigation */
        .marketplace-tabs {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .tabs-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            padding: 0 20px;
        }
        
        .tab-btn {
            flex: 1;
            padding: 20px;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            color: #666;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .tab-btn:hover {
            color: #2a5298;
            background: #f5f7fa;
        }
        
        .tab-btn.active {
            color: #2a5298;
            border-bottom-color: #13ec5b;
            background: #f5f7fa;
        }
        
        .tab-btn i {
            font-size: 20px;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        /* Copy styles from redesign.php for timber section */
        <?php include(APPPATH . 'views/marketplace/redesign_styles.php'); ?>
    </style>
</head>
<body>

<!-- Modern Header -->
<?php 
$header_data = ['is_logged_in' => $is_logged_in ?? false];
if (isset($usernm)) $header_data['usernm'] = $usernm;
$this->load->view('landing_page/includes/modern_header', $header_data); 
?>

<!-- Tab Navigation -->
<div class="marketplace-tabs">
    <div class="tabs-container">
        <button class="tab-btn active" onclick="switchTab('timber')">
            <i class="fa fa-tree"></i>
            <span>Timber Marketplace</span>
        </button>
        <button class="tab-btn" onclick="switchTab('workers')">
            <i class="fa fa-users"></i>
            <span>Find Workers</span>
        </button>
    </div>
</div>

<!-- Timber Tab Content -->
<div id="timber-tab" class="tab-content active">
    <?php $this->load->view('marketplace/timber_content', [
        'lots' => $lots ?? [],
        'featured_lots' => $featured_lots ?? [],
        'is_logged_in' => $is_logged_in ?? false
    ]); ?>
</div>

<!-- Workers Tab Content -->
<div id="workers-tab" class="tab-content">
    <div style="max-width: 1400px; margin: 40px auto; padding: 0 20px;">
        <iframe 
            src="<?= base_url('worker') ?>" 
            id="workers-iframe"
            style="width: 100%; min-height: 1000px; border: none; border-radius: 12px; background: white;"
            onload="resizeIframe(this)"
        ></iframe>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
// Tab Switching
function switchTab(tabName) {
    // Update tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.closest('.tab-btn').classList.add('active');
    
    // Update tab content
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    document.getElementById(tabName + '-tab').classList.add('active');
    
    // Update URL without reload
    window.history.pushState({}, '', '<?= base_url('shop') ?>?tab=' + tabName);
}

// Resize iframe
function resizeIframe(iframe) {
    try {
        iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 100 + 'px';
    } catch(e) {
        console.log('Cannot resize iframe due to CORS');
    }
}

// Check URL param for tab
window.addEventListener('DOMContentLoaded', function() {
    const urlParams = new UrlSearchParams(window.location.search);
    const tab = urlParams.get('tab');
    if (tab === 'workers') {
        document.querySelectorAll('.tab-btn')[1].click();
    }
});
</script>

</body>
</html>
