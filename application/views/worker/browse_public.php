<?php $this->load->view('shop/hero_premium'); ?>
<?php 
// Standardize data for the worker page
$is_logged_in = $this->aauth->is_loggedin();
$macro = $macro ?? 'services';
?>

<!-- SMART FILTER LAYOUT -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- ===== LEFT FILTER SIDEBAR ===== -->
        <aside class="w-full lg:w-72 flex-shrink-0" id="filterSidebar">
            <div class="sticky top-24 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-slate-900 px-6 py-5 flex items-center justify-between">
                    <h5 class="text-white font-bold text-sm flex items-center">
                        <i class="fa fa-sliders-h mr-2 text-blue-400"></i> Workforce Filter
                    </h5>
                    <button onclick="resetFilters()" class="text-[10px] font-bold uppercase tracking-wider text-slate-400 hover:text-white transition-colors">
                        Reset
                    </button>
                </div>

                <div class="p-6 space-y-8 max-h-[calc(100vh-200px)] overflow-y-auto custom-scrollbar">
                    
                    <!-- 1. Category -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Professional Category</label>
                        <select class="custom-select" id="mainCatFilter">
                            <option value="">All Categories</option>
                            <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['val1']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- 2. Location -->
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

                    <!-- 3. Experience -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Experience (Years)</label>
                        <select class="custom-select" id="expFilter">
                            <option value="">Any Experience</option>
                            <option value="1">1+ Year</option>
                            <option value="3">3+ Years</option>
                            <option value="5">5+ Years</option>
                            <option value="10">10+ Years</option>
                        </select>
                    </div>

                    <!-- 4. Price -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Rate Range (LKR)</label>
                        <div class="flex items-center space-x-2">
                            <input type="number" id="minPriceFilter" placeholder="Min" class="custom-input">
                            <span class="text-slate-300">—</span>
                            <input type="number" id="maxPriceFilter" placeholder="Max" class="custom-input">
                        </div>
                    </div>

                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-2xl shadow-lg shadow-blue-200 transition-all duration-300 transform hover:-translate-y-0.5" onclick="applyFilters()">
                        Apply Filters
                    </button>
                    
                    <div class="pt-4 border-t border-slate-50">
                        <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100">
                            <p class="text-xs font-bold text-blue-800 mb-2">Are you a Professional?</p>
                            <p class="text-[10px] text-blue-600 mb-4 leading-relaxed">Join Sri Lanka's largest timber ecosystem and find consistent work.</p>
                            <a href="<?= base_url('worker/register') ?>" class="block text-center bg-blue-600 text-white text-[10px] font-black py-2.5 rounded-xl hover:bg-blue-700 transition-colors uppercase tracking-widest">Register Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ===== MAIN CONTENT AREA ===== -->
        <main class="flex-1 min-w-0">
            
            <!-- MACRO CATEGORY TABS -->
            <div class="flex justify-center mb-10">
                <div class="inline-flex p-1 bg-slate-100 rounded-2xl shadow-inner border border-slate-200">
                    <button onclick="switchMacroTab('services')" id="macro-services-btn" 
                            class="macro-tab-btn px-8 py-3.5 rounded-xl font-black text-sm uppercase tracking-widest transition-all duration-300 <?= ($macro == 'services' || !$macro) ? 'active' : '' ?>">
                        <i class="fa fa-briefcase mr-2"></i> Professionals
                    </button>
                    <button onclick="switchMacroTab('jobs')" id="macro-jobs-btn" 
                            class="macro-tab-btn px-8 py-3.5 rounded-xl font-black text-sm uppercase tracking-widest transition-all duration-300 <?= ($macro == 'jobs') ? 'active' : '' ?>">
                        <i class="fa fa-clipboard-list mr-2"></i> Job Board
                    </button>
                    <button onclick="switchMacroTab('quotes')" id="macro-quotes-btn" 
                            class="macro-tab-btn px-8 py-3.5 rounded-xl font-black text-sm uppercase tracking-widest transition-all duration-300 <?= ($macro == 'quotes') ? 'active' : '' ?>">
                        <i class="fa fa-file-invoice-dollar mr-2"></i> Bids
                    </button>
                </div>
            </div>
            
            <!-- Context Bar -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight" id="marketTitle">Active Professionals</h2>
                    <p class="text-slate-500 text-sm mt-1">Found <span class="font-bold text-slate-900" id="visibleCount"><?= count($workers) ?></span> listings matching your criteria</p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sort By</span>
                    <select onchange="sortResults(this.value)" class="bg-white border-none rounded-xl text-sm font-bold text-slate-700 px-4 py-2 shadow-sm cursor-pointer hover:bg-slate-50 transition-colors focus:ring-2 focus:ring-blue-500/20">
                        <option value="default">Default</option>
                        <option value="rate_asc">Rate: Low to High</option>
                        <option value="rate_desc">Rate: High to Low</option>
                        <option value="exp_desc">Experience: High to Low</option>
                    </select>
                </div>
            </div>

            <!-- WORKERS GRID (SERVICES) -->
            <div id="services-tab" class="tab-content active transition-all duration-300">
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6" id="workerGrid">
                    <?php foreach($workers as $w): ?>
                    <div class="group bg-white rounded-3xl border border-slate-100 p-8 flex flex-col items-center text-center hover:shadow-2xl hover:shadow-slate-200 transition-all duration-500 worker-card" 
                         data-field="services" 
                         data-price="<?= $w['pay_rate'] ?>"
                         data-exp="<?= $w['experience_years'] ?>"
                         data-maincat="<?= $w['category_id'] ?>"
                         data-district="<?= htmlspecialchars(strtolower($w['location'] ?? '')) ?>"
                         onclick="window.location.href='<?= base_url('worker/view/'.$w['id']) ?>'"
                         style="cursor: pointer;">
                        
                        <div class="relative mb-6">
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl p-1 shadow-xl transform group-hover:rotate-6 transition-transform overflow-hidden">
                                <?php if(!empty($w['photo'])): ?>
                                    <img src="<?= base_url($w['photo']) ?>" class="w-full h-full rounded-[22px] bg-white object-cover">
                                <?php else: ?>
                                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?= urlencode($w['display_name']) ?>" class="w-full h-full rounded-[22px] bg-white object-cover">
                                <?php endif; ?>
                            </div>
                            <!-- Status Indicator -->
                            <div class="absolute -bottom-2 -right-2 bg-emerald-500 text-white w-8 h-8 rounded-full border-4 border-white flex items-center justify-center text-xs shadow-lg">
                                <i class="fa <?= $w['category_icon'] ?? 'fa-check' ?>"></i>
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-black text-slate-900 mb-1"><?= htmlspecialchars($w['display_name']) ?></h3>
                        <div class="flex items-center justify-center space-x-2 mb-6">
                            <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest"><?= htmlspecialchars($w['category_name'] ?? 'Expert') ?></span>
                            <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest"><?= $w['experience_years'] ?> Exp.</span>
                        </div>
                        
                        <div class="w-full bg-slate-50 rounded-2xl p-4 mb-6 group-hover:bg-blue-50 transition-colors border border-slate-100">
                            <span class="block text-[10px] text-slate-400 font-bold uppercase mb-1"><?= ucfirst($w['pay_type']) ?> Rate</span>
                            <span class="text-lg font-black text-slate-900 group-hover:text-blue-600 transition-colors uppercase">
                                Rs. <?= number_format($w['pay_rate']) ?> <small class="text-[10px] font-bold text-slate-400">/ <?= $w['pay_type'] ?></small>
                            </span>
                        </div>
                        
                        <div class="flex gap-2 w-full mt-auto">
                            <button onclick="event.stopPropagation(); window.location.href='<?= base_url('worker/view/'.$w['id']) ?>'" 
                                    class="flex-1 bg-slate-50 text-slate-900 font-black py-4 rounded-2xl border border-slate-100 hover:bg-white transition-all">
                                VIEW
                            </button>
                            <?php if($is_logged_in): ?>
                            <button onclick="event.stopPropagation(); showHireModal(<?= $w['id'] ?>, '<?= addslashes($w['display_name']) ?>', <?= $w['pay_rate'] ?>)" 
                                    class="flex-[2] bg-slate-900 text-white font-black py-4 rounded-2xl shadow-xl shadow-slate-100 hover:bg-blue-600 transition-all transform group-hover:shadow-blue-200">
                                HIRE
                            </button>
                            <?php else: ?>
                            <a href="<?= base_url('hub/login') ?>" onclick="event.stopPropagation();"
                               class="flex-[2] bg-slate-900 text-white font-black py-4 rounded-2xl shadow-xl shadow-slate-100 hover:bg-blue-600 transition-all text-center">
                                LOGIN
                            </a>
                            <?php endif; ?>
                        </div>
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
                        <div class="px-8 border-x border-slate-50 hidden lg:block text-center">
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

            <!-- QUOTATIONS GRID (BIDS) -->
            <div id="quotes-tab" class="tab-content hidden transition-all duration-300">
                <div class="grid grid-cols-1 gap-6" id="quotesGrid">
                    <?php foreach($quote_requests as $q): ?>
                    <div class="group bg-white rounded-3xl border border-slate-100 p-8 flex flex-col md:flex-row items-center gap-8 hover:shadow-2xl transition-all duration-500 lot-card" data-field="quotes">
                        <div class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl flex items-center justify-center flex-shrink-0 text-white text-3xl shadow-lg shadow-emerald-100">
                            <i class="fa fa-file-invoice-dollar"></i>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mb-2">
                                <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">OPEN FOR BIDS</span>
                                <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-100">
                                    <i class="fa fa-map-marker-alt mr-1 text-red-400"></i><?= htmlspecialchars($q['district'] ?? 'Sri Lanka') ?>
                                </span>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 group-hover:text-emerald-600 transition-colors">Request for <?= htmlspecialchars($q['product_name']) ?></h3>
                            <p class="text-sm text-slate-500 mt-1"><?= htmlspecialchars(substr($q['description'] ?? '', 0, 100)) ?></p>
                        </div>
                        <button class="border-2 border-emerald-600 text-emerald-600 font-black px-10 py-4 rounded-2xl hover:bg-emerald-600 hover:text-white transition-all transform hover:-translate-y-1">
                            BID NOW
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- Hire Modal -->
<div id="hireModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md" onclick="closeModal()"></div>
    <div class="bg-white rounded-[2.5rem] w-full max-w-lg relative z-10 overflow-hidden shadow-2xl transition-all scale-95 opacity-0 duration-300" id="modalContent">
        <div class="h-2 bg-blue-600"></div>
        <div class="p-10">
            <h2 class="text-3xl font-black text-slate-900 mb-2">Hire Professional</h2>
            <p class="text-slate-500 mb-8">Set terms for <span id="modalWorkerName" class="text-blue-600 font-bold"></span></p>
            
            <form id="hireForm" onsubmit="submitHire(event)">
                <input type="hidden" name="worker_id" id="modalWorkerId">
                
                <div class="space-y-6 mb-10">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Agreed Rate (LKR)</label>
                        <input type="number" name="salary" id="modalSalary" required class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-600 focus:bg-white rounded-2xl outline-none transition-all text-lg font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Project Commission % (Optional)</label>
                        <input type="number" name="commission" id="modalCommission" value="0" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-600 focus:bg-white rounded-2xl outline-none transition-all text-lg font-bold">
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="button" onclick="closeModal()" class="flex-1 py-4 text-slate-500 font-bold hover:text-slate-900 transition-colors">Cancel</button>
                    <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white rounded-2xl font-black shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all">
                        Confirm Hiring
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ADDITIONAL STYLES -->
<style>
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
    
    .macro-tab-btn {
        @apply text-slate-400 hover:text-slate-600;
    }
    .macro-tab-btn.active {
        @apply bg-white text-blue-600 shadow-sm border border-slate-200;
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .worker-card, .lot-card { animation: fadeInUp 0.5s ease backwards; }
    <?php for($i=1;$i<=24;$i++): ?>
    .worker-card:nth-child(<?= $i ?>), .lot-card:nth-child(<?= $i ?>) { animation-delay: <?= $i * 0.05 ?>s; }
    <?php endfor; ?>
</style>

<script>
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

    function switchTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(c => {
            c.classList.remove('active');
            c.classList.add('hidden');
        });
        const target = document.getElementById(tabName + '-tab');
        if(target) {
            target.classList.remove('hidden');
            target.classList.add('active');
        }
        const titles = { services: 'Active Professionals', jobs: 'Project Opportunities', quotes: 'Open Bids' };
        document.getElementById('marketTitle').textContent = titles[tabName] || 'Listings';
    }

    function switchMacroTab(macro) {
        document.querySelectorAll('.macro-tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById(`macro-${macro}-btn`).classList.add('active');
        switchTab(macro);
        applyFilters();
    }

    function resetFilters() {
        document.querySelectorAll('input, select').forEach(i => i.value = '');
        applyFilters();
    }

    function applyFilters() {
        const minP = parseFloat(document.getElementById('minPriceFilter').value) || 0;
        const maxP = parseFloat(document.getElementById('maxPriceFilter').value) || Infinity;
        const dist = document.getElementById('districtFilter').value.toLowerCase();
        const mainCat = document.getElementById('mainCatFilter').value;
        const exp = parseInt(document.getElementById('expFilter').value) || 0;
        
        const activeTab = document.querySelector('.tab-content.active').id;

        let visibleCount = 0;
        document.querySelectorAll('.worker-card, .lot-card').forEach(card => {
            const price = parseFloat(card.dataset.price) || 0;
            const cardDist = (card.dataset.district || '').toLowerCase();
            const cardMainCat = card.dataset.maincat;
            const cardExp = parseInt(card.dataset.exp) || 0;
            
            let show = true;
            if (price < minP || price > maxP) show = false;
            if (dist && cardDist !== dist) show = false;
            if (mainCat && cardMainCat !== mainCat) show = false;
            if (exp && cardExp < exp) show = false;
            
            card.style.display = show ? 'block' : 'none';
            if (show) visibleCount++;
        });
        document.getElementById('visibleCount').textContent = visibleCount;
    }

    function sortResults(criteria) {
        const grid = document.getElementById('workerGrid');
        const cards = Array.from(grid.getElementsByClassName('worker-card'));
        cards.sort((a, b) => {
            if(criteria === 'rate_asc') return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
            if(criteria === 'rate_desc') return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
            if(criteria === 'exp_desc') return parseInt(b.dataset.exp) - parseInt(a.dataset.exp);
            return 0;
        });
        cards.forEach(card => grid.appendChild(card));
    }

    // Modal & Hiring Logic
    function showHireModal(workerId, workerName, rate) {
        document.getElementById('modalWorkerId').value = workerId;
        document.getElementById('modalWorkerName').innerText = workerName;
        document.getElementById('modalSalary').value = rate;
        
        const modal = document.getElementById('hireModal');
        const content = document.getElementById('modalContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('hireModal');
        const content = document.getElementById('modalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    function submitHire(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        
        fetch('<?= base_url("worker/hire") ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'Success') {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message);
            }
        });
    }
</script>
