<header id="main-header" class="fixed top-0 left-0 right-0 z-[100] transition-all duration-500 bg-white/70 backdrop-blur-xl border-b border-white/20 shadow-sm h-20">
    <nav class="w-full h-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex items-center justify-between h-full">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center h-full">
                    <a href="<?= base_url() ?>" class="flex items-center h-full group">
                        <span class="text-2xl font-extrabold tracking-tighter text-slate-900">Timber<span class="text-success">Pro</span></span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="<?= base_url() ?>" class="px-3 py-2 rounded-xl font-bold text-sm text-slate-600 hover:text-slate-900 hover:bg-slate-100/50 transition-all <?= (uri_string() == '' || uri_string() == 'user') ? 'text-success bg-success/5' : '' ?>"><?= $t['nav_home'] ?></a>
                    
                    <!-- Unified Search Bar -->
                    <div class="relative flex-1 max-w-md mx-6 hidden xl:block">
                        <div class="relative group">
                            <i class="fa fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="text" id="global-search-input" placeholder="Search timber, tools or experts..." 
                                   class="w-full bg-slate-100/50 border border-slate-200 rounded-2xl py-2.5 pl-11 pr-4 text-sm font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:bg-white focus:border-blue-500 transition-all"
                                   onkeyup="handleGlobalSearch(this.value)">
                            
                            <!-- Search Results Dropdown -->
                            <div id="search-results-dropdown" class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden hidden transform origin-top transition-all duration-200 scale-95 opacity-0">
                                <div class="max-h-[400px] overflow-y-auto custom-scrollbar" id="search-results-container">
                                    <!-- Results injected here -->
                                </div>
                                <div class="bg-slate-50 p-3 border-t border-slate-100 text-center">
                                    <button onclick="applyGlobalSearch()" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:text-blue-700">View All Results</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Unified Toggle -->
                    <div class="mx-4 flex items-center bg-slate-100/80 backdrop-blur-md p-1 rounded-2xl border border-slate-200">
                        <button onclick="window.location.href='<?= base_url('shop?macro=products') ?>'" 
                                class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all <?= (strpos(uri_string(), 'shop') !== false || uri_string() == '') ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' ?>">
                            <i class="fa fa-shopping-bag mr-2"></i> Shop
                        </button>
                        <button onclick="window.location.href='<?= base_url('shop?macro=services') ?>'" 
                                class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all <?= (strpos(uri_string(), 'worker') !== false || (isset($_GET['macro']) && $_GET['macro'] == 'services')) ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' ?>">
                            <i class="fa fa-tools mr-2"></i> Services
                        </button>
                    </div>

                    <!-- Location Indicator -->
                    <div class="flex items-center px-3 py-2 bg-blue-50/50 rounded-xl border border-blue-100 group cursor-pointer mr-2" onclick="requestLocation()">
                        <i class="fa-solid fa-location-dot text-blue-500 mr-2 group-hover:animate-bounce"></i>
                        <div class="flex flex-col">
                            <span class="text-[9px] font-bold text-blue-400 uppercase leading-none mb-1">Near You</span>
                            <span class="text-xs font-black text-slate-900" id="current-location-text">
                                <?php 
                                $loc = $this->session->userdata('user_location');
                                echo is_array($loc) ? $loc['name'] : ($loc ?: 'Detecting...'); 
                                ?>
                            </span>
                        </div>
                    </div>

                    <a href="<?= base_url('shop') ?>" class="px-3 py-2 rounded-xl font-bold text-sm text-slate-600 hover:text-slate-900 hover:bg-slate-100/50 transition-all <?= (strpos(uri_string(), 'shop') !== false) ? 'text-success bg-success/5' : '' ?>"><?= $t['nav_marketplace'] ?></a>
                    <a href="<?= base_url('worker') ?>" class="px-3 py-2 rounded-xl font-bold text-sm text-slate-600 hover:text-slate-900 hover:bg-slate-100/50 transition-all <?= (strpos(uri_string(), 'worker') !== false) ? 'text-success bg-success/5' : '' ?>"><?= $t['nav_workforce'] ?></a>
                    <a href="<?= base_url('greenfuture') ?>" class="px-3 py-2 rounded-xl font-bold text-sm text-slate-600 hover:text-slate-900 hover:bg-slate-100/50 transition-all <?= (strpos(uri_string(), 'greenfuture') !== false) ? 'text-success bg-success/5' : '' ?>"><?= $t['nav_green'] ?></a>
                    <a href="<?= base_url('shop/calculator') ?>" class="px-3 py-2 rounded-xl font-bold text-sm text-slate-600 hover:text-slate-900 hover:bg-slate-100/50 transition-all"><?= $t['nav_calculator'] ?></a>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-4">
                    <!-- Language Switcher -->
                    <div class="hidden sm:flex items-center bg-slate-100/50 rounded-full p-1 border border-slate-200">
                        <a href="?lang=si" class="px-3 py-1 rounded-full text-xs font-bold transition-all <?= $lang_id == 'si' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' ?>">සිංහල</a>
                        <a href="?lang=en" class="px-3 py-1 rounded-full text-xs font-bold transition-all <?= $lang_id == 'en' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' ?>">English</a>
                    </div>

                    <?php if($this->aauth->is_loggedin()): ?>
                        <a href="<?= base_url('dashboard') ?>" class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-slate-900 text-white font-bold text-sm transition-all hover:bg-slate-800 hover:shadow-lg hover:-translate-y-0.5"><?= $this->aauth->get_user()->username ?></a>
                    <?php else: ?>
                        <a href="<?= base_url('hub/login') ?>" class="hidden sm:inline-flex px-3 py-2 font-bold text-sm text-slate-600 hover:text-slate-900"><?= $t['nav_login'] ?></a>
                        <a href="<?= base_url('hub/register') ?>" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-success text-white font-bold text-sm transition-all hover:bg-green-600 hover:shadow-lg hover:-translate-y-0.5"><?= $t['nav_register'] ?></a>
                    <?php endif; ?>

                    <!-- Mobile Menu Button -->
                    <button class="lg:hidden w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-900" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="hidden lg:hidden absolute top-full left-0 right-0 bg-white border-b border-slate-100 shadow-2xl p-4 overflow-y-auto max-h-[calc(100vh-80px)]">
        <div class="flex flex-col gap-2">
            <a href="<?= base_url() ?>" class="p-3 rounded-xl font-bold text-slate-900 hover:bg-slate-50"><?= $t['nav_home'] ?></a>
            <a href="<?= base_url('shop') ?>" class="p-3 rounded-xl font-bold text-slate-900 hover:bg-slate-50"><?= $t['nav_marketplace'] ?></a>
            <a href="<?= base_url('worker') ?>" class="p-3 rounded-xl font-bold text-slate-900 hover:bg-slate-50"><?= $t['nav_workforce'] ?></a>
            <a href="<?= base_url('greenfuture') ?>" class="p-3 rounded-xl font-bold text-slate-900 hover:bg-slate-50"><?= $t['nav_green'] ?></a>
            <a href="<?= base_url('shop/calculator') ?>" class="p-3 rounded-xl font-bold text-slate-900 hover:bg-slate-50"><?= $t['nav_calculator'] ?></a>
            <hr class="my-2 border-slate-100">
            <div class="flex items-center gap-2 p-3">
                <a href="?lang=si" class="flex-1 text-center py-2 rounded-lg border <?= $lang_id == 'si' ? 'bg-slate-900 text-white border-slate-900' : 'text-slate-600 border-slate-200' ?>">සිංහල</a>
                <a href="?lang=en" class="flex-1 text-center py-2 rounded-lg border <?= $lang_id == 'en' ? 'bg-slate-900 text-white border-slate-900' : 'text-slate-600 border-slate-200' ?>">English</a>
            </div>
        </div>
    </div>
</header>
<!-- Spacer for fixed header -->
<div class="h-20"></div>

<script>
    // Location Sensing
    function requestLocation() {
        const textElem = document.getElementById('current-location-text');
        textElem.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sensing...';
        
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    updateLocationSession(lat, lon);
                },
                (error) => {
                    console.error('Geolocation error:', error);
                    textElem.innerText = 'Allow GPS Access';
                }
            );
        } else {
            textElem.innerText = 'GPS Not Supported';
        }
    }

    function updateLocationSession(lat, lon) {
        const textElem = document.getElementById('current-location-text');
        
        fetch('<?= base_url('shop/update_location') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `lat=${lat}&lon=${lon}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'Success') {
                textElem.innerText = data.location_name;
                // Optional: Reload if on a location-dependent page
                if (window.location.search.includes('macro=services') || window.location.pathname.includes('worker')) {
                     window.location.reload();
                }
            }
        })
        .catch(err => {
            console.error('Update failed:', err);
            textElem.innerText = 'Sri Lanka'; // Fallback
        });
    }

    // Auto-sensing on first load if not set
    <?php if(!$this->session->userdata('user_location')): ?>
        document.addEventListener('DOMContentLoaded', () => { setTimeout(requestLocation, 2000); });
    <?php endif; ?>

    // Global Search Logic
    let searchTimeout = null;
    function handleGlobalSearch(val) {
        clearTimeout(searchTimeout);
        const dropdown = document.getElementById('search-results-dropdown');
        const container = document.getElementById('search-results-container');
        
        if (val.length < 2) {
            dropdown.classList.add('hidden');
            dropdown.classList.remove('scale-100', 'opacity-100');
            return;
        }
        
        searchTimeout = setTimeout(() => {
            fetch(`<?= site_url('shop/smart_search') ?>?q=${val}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        dropdown.classList.remove('hidden');
                        setTimeout(() => dropdown.classList.add('scale-100', 'opacity-100'), 10);
                        
                        let html = '';
                        data.slice(0, 8).forEach(item => {
                            const icon = item.result_type === 'pro' ? 'fa-user-tie text-purple-500' : (item.result_type === 'hardware' ? 'fa-tools text-amber-500' : 'fa-tree text-green-500');
                            const label = item.name || item.product_name || (item.species + ' ' + item.lot_type);
                            const price = item.price || item.sell_price || item.pay_rate || 0;
                            const url = item.result_type === 'pro' ? `<?= base_url('worker/view/') ?>${item.id}` : `<?= base_url('shop/view/') ?>${item.type || 'logs'}/${item.id}`;
                            
                            html += `
                                <a href="${url}" class="flex items-center p-4 hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center mr-4 flex-shrink-0">
                                        <i class="fa ${icon}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-bold text-slate-900 truncate">${label}</h4>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">${item.result_type}</p>
                                    </div>
                                    <div class="text-right ml-4">
                                        <span class="text-xs font-black text-slate-900">Rs. ${parseFloat(price).toLocaleString()}</span>
                                    </div>
                                </a>
                            `;
                        });
                        container.innerHTML = html;
                    } else {
                        container.innerHTML = '<div class="p-8 text-center"><p class="text-sm text-slate-400 font-bold">No results found</p></div>';
                        dropdown.classList.remove('hidden');
                        setTimeout(() => dropdown.classList.add('scale-100', 'opacity-100'), 10);
                    }
                });
        }, 300);
    }

    function applyGlobalSearch() {
        const val = document.getElementById('global-search-input').value;
        window.location.href = `<?= site_url('shop') ?>?q=${val}`;
    }

    // Header scroll effect
    window.addEventListener('scroll', () => {
        const header = document.getElementById('main-header');
        if (window.scrollY > 20) {
            header.classList.add('bg-white/90', 'shadow-md');
            header.classList.remove('bg-white/70');
            header.style.height = '72px';
        } else {
            header.classList.remove('bg-white/90', 'shadow-md');
            header.classList.add('bg-white/70');
            header.style.height = '80px';
        }
    });

    // Close mobile menu on resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            document.getElementById('mobile-menu').classList.add('hidden');
        }
    });
</script>
