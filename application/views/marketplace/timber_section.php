
<!-- Hero Carousel -->
<div class="marketplace-hero">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            <?php $featured = isset($featured_lots) ? array_slice($featured_lots, 0, 5) : []; ?>
            <?php if(empty($featured)): ?>
            <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1550537687-c91072c4792d?w=1920');">
                <div class="hero-overlay">
                    <div class="hero-content">
                        <h1>🌲 Premium Timber Marketplace</h1>
                        <p>Buy and sell timber directly from verified suppliers across Sri Lanka</p>
                        <div class="hero-search">
                            <input type="text" placeholder="Search timber types, species, or location..." id="heroSearch">
                            <button><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <?php foreach($featured as $item): ?>
            <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1550537687-c91072c4792d?w=1920');">
                <div class="hero-overlay">
                    <div class="hero-content">
                        <h1><?= htmlspecialchars($item['name'] ?? 'Premium Timber') ?></h1>
                        <p><?= htmlspecialchars($item['location'] ?? 'Sri Lanka') ?> • <?= number_format($item['volume'] ?? 0) ?> ft³</p>
                        <div class="hero-search">
                            <button onclick="window.location.href='<?= base_url('marketplace/view/'.$item['type'].'/'.$item['id']) ?>'">View Details →</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<!-- Stats Bar -->
<div class="stats-bar">
    <div class="stats-container">
        <div class="stat-item">
            <h3><?= count($lots) ?></h3>
            <p>Active Listings</p>
        </div>
        <div class="stat-item">
            <h3>2,500+</h3>
            <p>Verified Sellers</p>
        </div>
        <div class="stat-item">
            <h3>$2.5M+</h3>
            <p>Total Transactions</p>
        </div>
        <div class="stat-item">
            <h3>4.8★</h3>
            <p>Average Rating</p>
        </div>
    </div>
</div>

<!-- Main Container -->
<div class="marketplace-container">
    <!-- Filters Sidebar -->
    <aside class="filters-sidebar">
        <div class="filter-section">
            <h3><i class="fa fa-sliders"></i> Filters</h3>
        </div>
        
        <div class="filter-section">
            <h3><i class="fa fa-tag"></i> Price Range</h3>
            <div class="price-range">
                <input type="number" placeholder="Min" id="priceMin">
                <input type="number" placeholder="Max" id="priceMax">
            </div>
        </div>
        
        <div class="filter-section">
            <h3><i class="fa fa-tree"></i> Timber Type</h3>
            <div class="filter-options">
                <div class="filter-option">
                    <input type="checkbox" id="type_logs" value="logs">
                    <label for="type_logs">Logs</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="type_standing" value="standing">
                    <label for="type_standing">Standing Trees</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="type_sawn" value="sawn">
                    <label for="type_sawn">Sawn Timber</label>
                </div>
            </div>
        </div>
        
        <div class="filter-section">
            <h3><i class="fa fa-map-marker-alt"></i> Location</h3>
            <div class="filter-options">
                <div class="filter-option">
                    <input type="checkbox" id="loc_western" value="Western">
                    <label for="loc_western">Western Province</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="loc_southern" value="Southern">
                    <label for="loc_southern">Southern Province</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="loc_central" value="Central">
                    <label for="loc_central">Central Province</label>
                </div>
            </div>
        </div>
        
        <button class="filter-btn" onclick="applyFilters()"><i class="fa fa-check"></i> Apply Filters</button>
        <button class="reset-filters" onclick="resetFilters()"><i class="fa fa-redo"></i> Reset</button>
    </aside>
    
    <!-- Listings Area -->
    <main class="listings-area">
        <div class="listings-header">
            <h2>All Listings <span id="resultCount">(<?= count($lots) ?>)</span></h2>
            <div class="view-controls">
                <div class="view-toggle">
                    <button class="active" onclick="setView('grid')"><i class="fa fa-th-large"></i></button>
                    <button onclick="setView('list')"><i class="fa fa-list"></i></button>
                </div>
                <select class="sort-dropdown" onchange="sortListings(this.value)">
                    <option value="newest">Newest First</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                    <option value="volume">Volume</option>
                </select>
            </div>
        </div>
        
        <div class="listings-grid" id="listingsGrid">
            <?php foreach($lots as $item): ?>
            <div class="listing-card" data-type="<?= $item['type'] ?>" data-price="<?= $item['price'] ?? 0 ?>" data-location="<?= $item['location'] ?? '' ?>">
                <div class="listing-image" style="background-image: url('https://images.unsplash.com/photo-1550537687-c91072c4792d?w=600');">
                    <?php if($item['featured'] ?? false): ?>
                    <span class="listing-badge featured">★ FEATURED</span>
                    <?php else: ?>
                    <span class="listing-badge">AVAILABLE</span>
                    <?php endif; ?>
                    
                    <div class="listing-actions">
                        <button class="action-btn favorite" title="Add to Favorites">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="action-btn share" onclick="openShareModal('<?= $item['id'] ?>', '<?= $item['type'] ?>')" title="Share Listing">
                            <i class="fa fa-share-alt"></i>
                        </button>
                    </div>
                </div>
                
                <div class="listing-content">
                    <h3 class="listing-title"><?= htmlspecialchars($item['name'] ?? 'Timber Lot') ?></h3>
                    
                    <div class="listing-meta">
                        <span class="meta-item">
                            <i class="fa fa-cube"></i>
                            <?= number_format($item['volume'] ?? 0) ?> ft³
                        </span>
                        <span class="meta-item">
                            <i class="fa fa-map-marker-alt"></i>
                            <?= htmlspecialchars($item['location'] ?? 'N/A') ?>
                        </span>
                        <span class="meta-item">
                            <i class="fa fa-calendar"></i>
                            <?= date('M d', strtotime($item['created_at'] ?? 'now')) ?>
                        </span>
                    </div>
                    
                    <div class="listing-price">
                        LKR <?= number_format($item['price'] ?? 0) ?>
                    </div>
                    
                    <p class="listing-description">
                        <?= htmlspecialchars(substr($item['description'] ?? 'Premium quality timber available for immediate purchase.', 0, 100)) ?>...
                    </p>
                    
                    <div class="listing-footer">
                        <div class="seller-info">
                            <div class="seller-avatar">
                                <?= strtoupper(substr($item['seller_name'] ?? 'S', 0, 1)) ?>
                            </div>
                            <span class="seller-name"><?= htmlspecialchars($item['seller_name'] ?? 'Seller') ?></span>
                        </div>
                        <?php if($is_logged_in): ?>
                        <button class="view-btn" onclick="window.location.href='<?= base_url('marketplace/view/'.$item['type'].'/'.$item['id']) ?>'">
                            View Details
                        </button>
                        <?php else: ?>
                        <button class="view-btn" onclick="window.location.href='<?= base_url('user') ?>'">
                            Login to View
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>

<!-- Share Modal -->
<div class="share-modal" id="shareModal">
    <div class="share-content">
        <div class="share-header">
            <h3>Share This Listing</h3>
            <button class="close-modal" onclick="closeShareModal()">×</button>
        </div>
        
        <div class="share-buttons">
            <button class="share-btn facebook" onclick="shareOn('facebook')">
                <i class="fab fa-facebook-f"></i> Facebook
            </button>
            <button class="share-btn twitter" onclick="shareOn('twitter')">
                <i class="fab fa-twitter"></i> Twitter
            </button>
            <button class="share-btn linkedin" onclick="shareOn('linkedin')">
                <i class="fab fa-linkedin-in"></i> LinkedIn
            </button>
            <button class="share-btn whatsapp" onclick="shareOn('whatsapp')">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </button>
            <button class="share-btn telegram" onclick="shareOn('telegram')">
                <i class="fab fa-telegram-plane"></i> Telegram
            </button>
            <button class="share-btn email" onclick="shareOn('email')">
                <i class="fa fa-envelope"></i> Email
            </button>
        </div>
        
        <div class="share-link-box">
            <p>Or copy link:</p>
            <div class="share-link-input">
                <input type="text" id="shareUrl" readonly>
                <button class="copy-btn" onclick="copyLink()">
                    <i class="fa fa-copy"></i> Copy
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize Swiper
const swiper = new Swiper('.hero-swiper', {
    loop: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
});

// Global variables for share modal
let currentShareListing = null;
let currentShareType = null;

// Open share modal
function openShareModal(id, type) {
    currentShareListing = id;
    currentShareType = type;
    const url = '<?= base_url() ?>marketplace/view/' + type + '/' + id;
    document.getElementById('shareUrl').value = url;
    document.getElementById('shareModal').classList.add('active');
    
    // Track share modal open
    trackShare('modal_open', type, id);
}

// Close share modal
function closeShareModal() {
    document.getElementById('shareModal').classList.remove('active');
}

// Share on platform
function shareOn(platform) {
    const url = document.getElementById('shareUrl').value;
    const title = 'Premium Timber Available - TimberPro Marketplace';
    const text = '🌲 Check out this premium timber listing on TimberPro! Direct from verified sellers.';
    
    let shareUrl = '';
    
    switch(platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}&hashtags=TimberTrade,SriLanka,Timber`;
            break;
        case 'linkedin':
            shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
            break;
        case 'whatsapp':
            shareUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`;
            break;
        case 'telegram':
            shareUrl = `https://t.me/share/url?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
            break;
        case 'email':
            shareUrl = `mailto:?subject=${encodeURIComponent(title)}&body=${encodeURIComponent(text + '\n\n' + url)}`;
            break;
    }
    
    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=500');
        trackShare(platform, currentShareType, currentShareListing);
    }
}

// Copy link to clipboard
function copyLink() {
    const input = document.getElementById('shareUrl');
    input.select();
    document.execCommand('copy');
    
    const btn = event.target.closest('.copy-btn');
    btn.classList.add('copied');
    btn.innerHTML = '<i class="fa fa-check"></i> Copied!';
    
    setTimeout(() => {
        btn.classList.remove('copied');
        btn.innerHTML = '<i class="fa fa-copy"></i> Copy';
    }, 2000);
    
    trackShare('copy_link', currentShareType, currentShareListing);
}

// Track share action
function trackShare(platform, type, id) {
    fetch('<?= base_url('marketplace/track_share') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            platform: platform,
            listing_type: type,
            listing_id: id
        })
    });
}

// Filter and sort functions
function applyFilters() {
    const priceMin = parseInt(document.getElementById('priceMin').value) || 0;
    const priceMax = parseInt(document.getElementById('priceMax').value) || Infinity;
    const types = Array.from(document.querySelectorAll('[id^="type_"]:checked')).map(cb => cb.value);
    const locations = Array.from(document.querySelectorAll('[id^="loc_"]:checked')).map(cb => cb.value);
    
    const cards = document.querySelectorAll('.listing-card');
    let visibleCount = 0;
    
    cards.forEach(card => {
        const price = parseInt(card.dataset.price);
        const type = card.dataset.type;
        const location = card.dataset.location;
        
        const priceMatch = price >= priceMin && price <= priceMax;
        const typeMatch = types.length === 0 || types.includes(type);
        const locationMatch = locations.length === 0 || locations.some(loc => location.includes(loc));
        
        if (priceMatch && typeMatch && locationMatch) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    document.getElementById('resultCount').textContent = `(${visibleCount})`;
}

function resetFilters() {
    document.getElementById('priceMin').value = '';
    document.getElementById('priceMax').value = '';
    document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(cb => cb.checked = false);
    applyFilters();
}

function sortListings(sortBy) {
    const grid = document.getElementById('listingsGrid');
    const cards = Array.from(grid.querySelectorAll('.listing-card'));
    
    cards.sort((a, b) => {
        switch(sortBy) {
            case 'price_low':
                return parseInt(a.dataset.price) - parseInt(b.dataset.price);
            case 'price_high':
                return parseInt(b.dataset.price) - parseInt(a.dataset.price);
            default:
                return 0;
        }
    });
    
    cards.forEach(card => grid.appendChild(card));
}

function setView(view) {
    const grid = document.getElementById('listingsGrid');
    const buttons = document.querySelectorAll('.view-toggle button');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.closest('button').classList.add('active');
    
    if (view === 'list') {
        grid.style.gridTemplateColumns = '1fr';
    } else {
        grid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(320px, 1fr))';
    }
}

// Hero search
document.getElementById('heroSearch').addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.listing-card').forEach(card => {
            const title = card.querySelector('.listing-title').textContent.toLowerCase();
            const location = card.dataset.location.toLowerCase();
            if (title.includes(query) || location.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
});

// Close modal on outside click
document.getElementById('shareModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeShareModal();
    }
});
</script>
