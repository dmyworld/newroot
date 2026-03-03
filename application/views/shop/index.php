<?php $this->load->view('shop/hero_premium'); ?>

<!-- SMART FILTER LAYOUT -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- ===== LEFT FILTER SIDEBAR ===== -->
        <aside class="w-full lg:w-72 flex-shrink-0" id="filterSidebar">
            <div class="sticky top-24 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-slate-900 px-6 py-5 flex items-center justify-between">
                    <h5 class="text-white font-bold text-sm flex items-center">
                        <i class="fa fa-sliders-h mr-2 text-blue-400"></i> Smart Filter
                    </h5>
                    <button onclick="resetFilters()" class="text-[10px] font-bold uppercase tracking-wider text-slate-400 hover:text-white transition-colors">
                        Reset All
                    </button>
                </div>

                <!-- Active Filters Badges -->
                <div class="px-6 py-3 bg-slate-50 border-b border-slate-100 hidden" id="activeFilterSection">
                    <div class="flex flex-wrap gap-2" id="activeFilterBadges"></div>
                </div>

                <div class="p-6 space-y-8 max-h-[calc(100vh-200px)] overflow-y-auto custom-scrollbar">
                    
                    <!-- 1. Sector Switcher (Field) -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4">Market Sector</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button data-filter="field" data-val="all" onclick="setFieldFilter(this,'all')" class="filter-pill active col-span-2">All Market</button>
                            <button data-filter="field" data-val="timber" onclick="setFieldFilter(this,'timber')" class="filter-pill">Timber</button>
                            <button data-filter="field" data-val="hardware" onclick="setFieldFilter(this,'hardware')" class="filter-pill">Tools</button>
                            <button data-filter="field" data-val="services" onclick="setFieldFilter(this,'services')" class="filter-pill">Pros</button>
                            <button data-filter="field" data-val="jobs" onclick="setFieldFilter(this,'jobs')" class="filter-pill text-[9px]">Job Board</button>
                            <button data-filter="field" data-val="quotes" onclick="setFieldFilter(this,'quotes')" class="filter-pill text-[9px]">Bidding</button>
                        </div>
                    </div>

                    <!-- 2. Category -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Market Category</label>
                        <select class="custom-select" id="mainCatFilter" onchange="loadSubCat()">
                            <option value="">All Categories</option>
                            <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['title']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select class="custom-select mt-2" id="subCatFilter">
                            <option value="">Sub Category (Select Main First)</option>
                        </select>
                    </div>

                    <!-- 3. Location -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Location (Sri Lanka)</label>
                        <select class="custom-select" id="provinceFilter" onchange="loadDistricts()">
                            <option value="">All Provinces</option>
                            <?php foreach(array_keys($locations) as $province): ?>
                            <option value="<?= $province ?>"><?= $province ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select class="custom-select mt-2" id="districtFilter">
                            <option value="">All Districts</option>
                        </select>
                    </div>
                        
                        <div class="mt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-semibold text-slate-600 uppercase">Radius</span>
                                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded" id="distanceVal">Any</span>
                            </div>
                            <input type="range" id="maxDistFilter" min="0" max="300" step="10" value="0"
                                class="w-full h-1.5 bg-slate-100 rounded-lg appearance-none cursor-pointer accent-blue-600"
                                oninput="document.getElementById('distanceVal').textContent = this.value > 0 ? this.value+'km' : 'Any'">
                        </div>
                    </div>

                    <!-- 4. Price -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Price Range (LKR)</label>
                        <div class="flex items-center space-x-2">
                            <input type="number" id="minPriceFilter" placeholder="Min" class="custom-input">
                            <span class="text-slate-300">—</span>
                            <input type="number" id="maxPriceFilter" placeholder="Max" class="custom-input">
                        </div>
                    </div>

                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-2xl shadow-lg shadow-blue-200 transition-all duration-300 transform hover:-translate-y-0.5" onclick="applyFilters()">
                        Apply Changes
                    </button>
                    
                    <button class="w-full text-slate-400 hover:text-red-500 font-bold text-xs py-2 transition-colors" onclick="resetFilters()">
                        Clear All Filters
                    </button>
                </div>
            </div>
        </aside>

        <!-- ===== MAIN CONTENT AREA ===== -->
        <main class="flex-1 min-w-0">
            
            <!-- Context Bar -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight" id="marketTitle">Active Listings</h2>
                    <p class="text-slate-500 text-sm mt-1">Found <span class="font-bold text-slate-900" id="visibleCount"><?= count($lots) ?></span> items matching your search</p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sort By</span>
                    <select onchange="sortResults(this.value)" class="bg-white border-none rounded-xl text-sm font-bold text-slate-700 px-4 py-2 shadow-sm cursor-pointer hover:bg-slate-50 transition-colors focus:ring-2 focus:ring-blue-500/20">
                        <option value="default">Default</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                        <option value="newest">Latest Arrivals</option>
                    </select>
                </div>
            </div>

            <!-- TIMBER GRID -->
            <div id="timber-tab" class="tab-content active transition-all duration-300">
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6" id="timberGrid">
                    <?php foreach($lots as $lot): ?>
                    <div class="group bg-white rounded-3xl border border-slate-100 overflow-hidden hover:shadow-2xl hover:shadow-slate-200 transition-all duration-500 lot-card"
                         data-field="timber"
                         data-type="<?= htmlspecialchars(strtolower($lot['lot_type'] ?? '')) ?>"
                         data-district="<?= htmlspecialchars(strtolower($lot['district'] ?? '')) ?>"
                         data-province="<?= htmlspecialchars(strtolower($lot['province'] ?? '')) ?>"
                         data-maincat="<?= $lot['pcid'] ?? '' ?>"
                         data-subcat="<?= $lot['p_id'] ?? '' ?>"
                         data-price="<?= $lot['price'] ?? 0 ?>"
                         data-name="<?= htmlspecialchars(strtolower($lot['name'] ?? '')) ?>">
                        
                        <!-- Card Media -->
                        <div class="relative h-56 overflow-hidden">
                            <img src="<?= !empty($lot['thumbnail']) ? base_url($lot['thumbnail']) : 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2013&auto=format&fit=crop' ?>" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Timber">
                            
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                <span class="bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full">
                                    <?= htmlspecialchars($lot['lot_type'] ?? 'Logs') ?>
                                </span>
                                <?php if($lot['is_verified'] ?? false): ?>
                                <span class="bg-green-500/90 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full flex items-center">
                                    <i class="fa fa-check-circle mr-1.5"></i> Verified
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-slate-900 mb-2 truncate group-hover:text-blue-600 transition-colors">
                                <?= htmlspecialchars($lot['name'] ?? 'Premium Timber Lot') ?>
                            </h3>
                            
                            <div class="flex items-center space-x-4 mb-5">
                                <span class="flex items-center text-xs font-bold text-slate-400 uppercase tracking-wide">
                                    <i class="fa fa-map-marker-alt text-blue-500 mr-2"></i> <?= htmlspecialchars($lot['location'] ?? 'Sri Lanka') ?>
                                </span>
                                <span class="flex items-center text-xs font-bold text-slate-400 uppercase tracking-wide">
                                    <i class="fa fa-cube text-blue-500 mr-2"></i> <?= $lot['volume_cuft'] ?? 'N/A' ?> ft³
                                </span>
                            </div>

                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-50">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Price</span>
                                    <span class="text-xl font-black text-slate-900">Rs. <?= number_format($lot['price'] ?? 0) ?></span>
                                </div>
                                <button onclick="window.location.href='<?= base_url('shop/view/'.($lot['type']??'logs').'/'.$lot['id']) ?>'" 
                                        class="p-4 bg-slate-50 text-slate-900 hover:bg-blue-600 hover:text-white rounded-2xl transition-all duration-300 transform group-hover:scale-110 shadow-sm border border-slate-100">
                                    <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <!-- Empty State -->
                    <div id="noResultsCard" class="hidden col-span-full py-20 text-center">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fa fa-search text-3xl text-slate-300"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">No matching items found</h3>
                        <p class="text-slate-500 mb-8">Try adjusting your filters to find what you're looking for.</p>
                        <button onclick="resetFilters()" class="bg-blue-600 text-white font-bold px-8 py-3 rounded-2xl hover:bg-blue-700 transition-colors">
                            Clear All Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- HARDWARE GRID -->
            <div id="hardware-tab" class="tab-content hidden transition-all duration-300">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="hardwareGrid">
                    <?php foreach($hardware as $p): ?>
                    <div class="group bg-white rounded-3xl border border-slate-100 overflow-hidden hover:shadow-2xl hover:shadow-slate-200 transition-all duration-500 lot-card" data-field="hardware" data-price="<?= $p['sell_price'] ?>">
                        <div class="relative h-48 overflow-hidden">
                            <img src="<?= !empty($p['product_image']) ? base_url($p['product_image']) : 'https://images.unsplash.com/photo-1581244277943-fe4a9c777189?auto=format&fit=crop&q=80&w=2000' ?>" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Hardware">
                            <div class="absolute top-4 left-4">
                                <span class="bg-blue-600/90 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full">
                                    <?= htmlspecialchars($p['category_name'] ?? 'Hardware') ?>
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-slate-900 mb-2 truncate group-hover:text-blue-600 transition-colors">
                                <?= htmlspecialchars($p['product_name']) ?>
                            </h3>
                            <div class="flex items-center justify-between mt-6 pt-4 border-t border-slate-50">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Price</span>
                                    <span class="text-xl font-black text-slate-900">Rs. <?= number_format($p['sell_price']) ?></span>
                                </div>
                                <button class="p-4 bg-slate-900 text-white hover:bg-blue-600 rounded-2xl transition-all duration-300 transform group-hover:rotate-12 shadow-lg shadow-slate-100">
                                    <i class="fa fa-shopping-cart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- PROS (SERVICES) GRID -->
            <div id="services-tab" class="tab-content hidden transition-all duration-300">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="servicesGrid">
                    <?php foreach($workers as $w): ?>
                    <div class="group bg-white rounded-3xl border border-slate-100 p-8 flex flex-col items-center text-center hover:shadow-2xl hover:shadow-slate-200 transition-all duration-500 lot-card" data-field="services" data-price="<?= $w['pay_rate'] ?>">
                        <div class="relative mb-6">
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl p-1 shadow-xl transform group-hover:rotate-6 transition-transform">
                                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?= urlencode($w['display_name']) ?>" class="w-full h-full rounded-[22px] bg-white object-cover">
                            </div>
                            <div class="absolute -bottom-2 -right-2 bg-emerald-500 text-white w-8 h-8 rounded-full border-4 border-white flex items-center justify-center text-xs">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-black text-slate-900 mb-1"><?= htmlspecialchars($w['display_name']) ?></h3>
                        <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-6">Verified <?= htmlspecialchars($w['category_name'] ?? 'Expert') ?></span>
                        
                        <div class="w-full bg-slate-50 rounded-2xl p-4 mb-6 group-hover:bg-blue-50 transition-colors">
                            <span class="block text-[10px] text-slate-400 font-bold uppercase mb-1">Expertise Fee</span>
                            <span class="text-lg font-black text-slate-900 group-hover:text-blue-600 transition-colors">Rs. <?= number_format($w['pay_rate']) ?> <small class="text-xs text-slate-400">/ <?= $w['pay_type'] ?></small></span>
                        </div>
                        
                        <button class="w-full bg-slate-900 text-white font-black py-4 rounded-2xl shadow-xl shadow-slate-100 hover:bg-blue-600 transition-all duration-300 transform hover:-translate-y-1">
                            BOOK NOW
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- JOBS GRID -->
            <div id="jobs-tab" class="tab-content hidden transition-all duration-300">
                <div class="grid grid-cols-1 gap-6" id="jobsGrid">
                    <?php foreach($jobs as $j): ?>
                    <div class="group bg-white rounded-3xl border border-slate-100 p-8 flex flex-col md:flex-row items-center gap-8 hover:shadow-2xl transition-all duration-500 lot-card" data-field="jobs">
                        <div class="w-20 h-20 bg-amber-100 rounded-2xl flex items-center justify-center flex-shrink-0 text-amber-600 text-3xl">
                            <i class="fa fa-briefcase"></i>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-2">
                                <span class="bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-amber-100">URGENT</span>
                                <span class="text-xs font-bold text-slate-400 flex items-center"><i class="fa fa-map-marker-alt mr-2 text-blue-500"></i> <?= htmlspecialchars($j['location'] ?? 'Remote') ?></span>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 group-hover:text-blue-600 transition-colors"><?= htmlspecialchars($j['job_title']) ?></h3>
                            <p class="text-sm text-slate-500 mt-2 font-medium line-clamp-1"><?= htmlspecialchars($j['description']) ?></p>
                        </div>
                        <div class="px-8 border-x border-slate-50 hidden lg:block">
                            <span class="block text-[10px] text-slate-400 font-bold uppercase mb-1">Budget Range</span>
                            <span class="text-lg font-black text-slate-900 uppercase">Rs. <?= number_format($j['budget_min']) ?> - <?= number_format($j['budget_max']) ?></span>
                        </div>
                        <button class="bg-slate-900 text-white font-black px-8 py-4 rounded-2xl hover:bg-blue-600 transition-all transform hover:-translate-y-1 shadow-lg shadow-slate-100">
                            VIEW DETAILS
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- QUOTATIONS GRID -->
            <div id="quotes-tab" class="tab-content hidden transition-all duration-300">
                <div class="grid grid-cols-1 gap-6" id="quotesGrid">
                    <?php foreach($quote_requests as $q): ?>
                    <div class="group bg-white rounded-3xl border border-slate-100 p-8 flex flex-col md:flex-row items-center gap-8 hover:shadow-2xl transition-all duration-500 lot-card" data-field="quotes">
                        <div class="w-20 h-20 bg-emerald-100 rounded-2xl flex items-center justify-center flex-shrink-0 text-emerald-600 text-3xl">
                            <i class="fa fa-file-invoice-dollar"></i>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-xl font-black text-slate-900 group-hover:text-emerald-600 transition-colors">Request for <?= htmlspecialchars($q['product_name']) ?></h3>
                            <p class="text-sm text-slate-500 mt-2 font-medium">Quantity Required: <span class="text-slate-900 font-bold"><?= $q['quantity'] ?> units</span></p>
                            <div class="mt-4 flex items-center justify-center md:justify-start gap-4">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-3 py-1 rounded-full border border-slate-100">Reference: #REQ<?= $q['id'] ?></span>
                                <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100 italic">OPEN FOR BIDS</span>
                            </div>
                        </div>
                        <button class="bg-emerald-600 text-white font-black px-10 py-4 rounded-2xl hover:bg-emerald-700 transition-all transform hover:-translate-y-1 shadow-xl shadow-emerald-100">
                            SUBMIT QUOTE
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- ADDITIONAL STYLES -->
<style>
    .filter-pill {
        @apply px-4 py-2 rounded-xl text-[10px] font-extrabold uppercase tracking-wider text-slate-400 border-2 border-slate-100 transition-all duration-200;
    }
    .filter-pill.active {
        @apply bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-100;
    }
    .custom-select {
        @apply w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 cursor-pointer;
    }
    .custom-input {
        @apply w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20;
    }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    
    .tab-content.active { display: block; }
    .tab-content:not(.active) { display: none; }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .lot-card { animation: fadeInUp 0.5s ease backwards; }
    <?php for($i=1;$i<=24;$i++): ?>
    .lot-card:nth-child(<?= $i ?>) { animation-delay: <?= $i * 0.05 ?>s; }
    <?php endfor; ?>
</style>

<script>
    // ===== DATA BRIDGE =====
    const sriLankaLocations = <?= json_encode($locations) ?>;

    function loadDistricts() {
        const prov = document.getElementById('provinceFilter').value;
        const distSelect = document.getElementById('districtFilter');
        distSelect.innerHTML = '<option value="">All Districts</option>';
        
        if (prov && sriLankaLocations[prov]) {
            sriLankaLocations[prov].forEach(d => {
                const opt = document.createElement('option');
                opt.value = d.toLowerCase();
                opt.textContent = d;
                distSelect.appendChild(opt);
            });
        }
    }

    function loadSubCat() {
        const mainId = document.getElementById('mainCatFilter').value;
        const subSelect = document.getElementById('subCatFilter');
        subSelect.innerHTML = '<option value="">Loading...</option>';
        
        if (!mainId) {
            subSelect.innerHTML = '<option value="">Sub Category (Select Main First)</option>';
            return;
        }

        fetch(`<?= site_url('shop/get_subcategories') ?>?cat_id=${mainId}`)
            .then(res => res.json())
            .then(data => {
                subSelect.innerHTML = '<option value="">All Sub Categories</option>';
                data.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value = s.id;
                    opt.textContent = s.title;
                    subSelect.appendChild(opt);
                });
            });
    }

    // ===== TAB ENGINE =====
    function switchTab(tabName) {
        const tabs = document.querySelectorAll('.tab-content');
        const isAll = tabName === 'all';
        
        tabs.forEach(c => {
            if (isAll) {
                c.classList.remove('hidden');
                c.classList.add('active');
            } else {
                c.classList.remove('active');
                c.classList.add('hidden');
            }
        });

        if(!isAll) {
            const target = document.getElementById(tabName + '-tab');
            if(target) {
                target.classList.remove('hidden');
                target.classList.add('active');
            }
        }
        
        // Update Title
        const titles = { 
            all: 'Universal Marketplace',
            timber: 'Timber Marketplace', 
            hardware: 'Hardware Store', 
            services: 'Professionals Hub', 
            quotes: 'Quotation Center', 
            jobs: 'Job Board' 
        };
        document.getElementById('marketTitle').textContent = titles[tabName] || 'Active Listings';
    }

    // ===== FILTER ENGINE =====
    function setFieldFilter(btn, val) {
        document.querySelectorAll('[data-filter="field"]').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        switchTab(val === 'all' ? 'timber' : val);
        applyFilters();
    }

    function resetFilters() {
        document.querySelectorAll('input:not([type="range"]), select').forEach(i => i.value = '');
        document.getElementById('maxDistFilter').value = 0;
        document.getElementById('distanceVal').textContent = 'Any';
        applyFilters();
    }

    function applyFilters() {
        const minP = parseFloat(document.getElementById('minPriceFilter').value) || 0;
        const maxP = parseFloat(document.getElementById('maxPriceFilter').value) || Infinity;
        const prov = document.getElementById('provinceFilter').value.toLowerCase();
        const dist = document.getElementById('districtFilter').value.toLowerCase();
        const mainCat = document.getElementById('mainCatFilter').value;
        const subCat = document.getElementById('subCatFilter').value;
        const sector = document.querySelector('[data-filter="field"].active').dataset.val;

        let visibleCount = 0;
        document.querySelectorAll('.lot-card').forEach(card => {
            const price = parseFloat(card.dataset.price);
            const cardDist = (card.dataset.district || '').toLowerCase();
            const cardProv = (card.dataset.province || '').toLowerCase();
            const cardMainCat = card.dataset.maincat;
            const cardSubCat = card.dataset.subcat;
            const cardSector = card.dataset.field;
            
            let show = true;
            if(sector !== 'all' && cardSector !== sector) show = false;
            if(price < minP || price > maxP) show = false;
            if(prov && cardProv !== prov) show = false;
            if(dist && cardDist !== dist) show = false;
            if(mainCat && cardMainCat !== mainCat) show = false;
            if(subCat && cardSubCat !== subCat) show = false;
            
            card.style.display = show ? 'block' : 'none';
            if(show) visibleCount++;
        });

        document.getElementById('visibleCount').textContent = visibleCount;
        document.getElementById('noResultsCard').classList.toggle('hidden', visibleCount > 0);
    }
    
    // Initial sort
    function sortResults(criteria) {
        const grid = document.getElementById('timberGrid');
        const cards = Array.from(grid.getElementsByClassName('lot-card'));
        
        cards.sort((a, b) => {
            const priceA = parseFloat(a.dataset.price);
            const priceB = parseFloat(b.dataset.price);
            if(criteria === 'price_asc') return priceA - priceB;
            if(criteria === 'price_desc') return priceB - priceA;
            return 0; // default/newest - logic would depend on a date attribute
        });
        
        cards.forEach(card => grid.appendChild(card));
    }
</script>
