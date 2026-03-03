<main class="min-h-screen pt-24 pb-20 px-4 md:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Hero Section -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 mb-6 tracking-tight">
                Find Skilled <span class="text-primary italic">Timber Professionals</span>
            </h1>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto mb-10">
                Connect with verified experts for logging, logistics, and processing across Sri Lanka.
            </p>
            
            <!-- Search & Filter Bar -->
            <div class="bg-white p-2 rounded-2xl shadow-xl shadow-blue-100 flex flex-col md:flex-row gap-2 max-w-4xl mx-auto border border-slate-100">
                <div class="flex-1 flex items-center px-4">
                    <i class="fa fa-search text-slate-400 mr-3"></i>
                    <input type="text" id="searchInput" placeholder="Search by skills, location, or name..." 
                           class="w-full py-4 text-slate-700 bg-transparent outline-none text-lg">
                </div>
                <div class="h-10 w-px bg-slate-200 hidden md:block self-center"></div>
                <div class="flex-none flex items-center px-4 min-w-[200px]">
                    <i class="fa fa-map-marker-alt text-slate-400 mr-3"></i>
                    <select id="locationSelect" class="w-full py-4 text-slate-700 bg-transparent outline-none text-lg cursor-pointer appearance-none">
                        <option value="">All Locations</option>
                        <option value="Colombo">Colombo</option>
                        <option value="Kandy">Kandy</option>
                        <option value="Galle">Galle</option>
                        <option value="Kurunegala">Kurunegala</option>
                    </select>
                </div>
                <button onclick="searchWorkers()" class="bg-primary hover:bg-secondary text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg shadow-blue-200">
                    Find Talent
                </button>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-72 flex-none space-y-8" data-aos="fade-right">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center">
                        <i class="fa fa-layer-group text-primary mr-3"></i> Specialized Fields
                    </h3>
                    <div class="space-y-3">
                        <button onclick="filterByCategory('')" class="w-full text-left px-4 py-3 rounded-xl transition-all duration-200 hover:bg-slate-50 font-medium <?= empty($_GET['category']) ? 'bg-blue-50 text-primary' : 'text-slate-600' ?>">
                            All Professionals
                        </button>
                        <?php foreach($categories as $cat): ?>
                            <button onclick="filterByCategory('<?= $cat['id'] ?>')" class="w-full text-left px-4 py-3 rounded-xl transition-all duration-200 hover:bg-slate-50 font-medium <?= isset($_GET['category']) && $_GET['category'] == $cat['id'] ? 'bg-blue-50 text-primary' : 'text-slate-600' ?>">
                                <?= $cat['val1'] ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-3xl p-8 shadow-2xl text-white relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary opacity-20 rounded-full blur-3xl group-hover:opacity-40 transition-opacity"></div>
                    <h3 class="text-lg font-bold mb-4 relative z-10">Are you a Professional?</h3>
                    <p class="text-slate-400 text-sm mb-6 relative z-10 leading-relaxed">Join Sri Lanka's largest timber network and grow your career.</p>
                    <a href="<?= base_url('worker/register') ?>" class="block w-full bg-white text-slate-900 text-center py-3 rounded-xl font-bold text-sm hover:bg-primary hover:text-white transition-all duration-300 relative z-10">
                        Join Marketplace
                    </a>
                </div>
            </aside>

            <!-- Results Grid -->
            <div class="flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-8" id="workersGrid">
                    <?php if(empty($workers)): ?>
                        <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-dashed border-slate-300">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                                <i class="fa fa-users-slash fa-2x"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">No Workers Found</h3>
                            <p class="text-slate-500">Try adjusting your filters or search terms.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($workers as $worker): 
                            $skills = json_decode($worker['skills'], true) ?? [];
                            $initials = strtoupper(substr($worker['display_name'], 0, 2));
                        ?>
                            <div class="worker-card group bg-white rounded-[2rem] border border-slate-100 hover:border-primary/20 hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 overflow-hidden" 
                                 data-category="<?= $worker['category_id'] ?>" 
                                 data-rating="<?= floor($worker['average_rating']) ?>"
                                 data-location="<?= strtolower($worker['location']) ?>">
                                
                                <div class="p-8">
                                    <div class="flex items-start justify-between mb-8">
                                        <div class="relative">
                                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white text-2xl font-black shadow-lg shadow-blue-200 overflow-hidden transition-transform duration-500 group-hover:scale-110">
                                                <?php if(!empty($worker['photo'])): ?>
                                                    <img src="<?= base_url($worker['photo']) ?>" alt="<?= $worker['display_name'] ?>" class="w-full h-full object-cover">
                                                <?php else: ?>
                                                    <?= $initials ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="absolute -bottom-2 -right-2 w-6 h-6 bg-green-500 border-4 border-white rounded-full"></div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-2xl font-black text-slate-900">LKR <?= number_format($worker['hourly_rate'], 0) ?></div>
                                            <div class="text-xs font-bold text-slate-400 tracking-widest uppercase">Per Hour</div>
                                        </div>
                                    </div>

                                    <h3 class="text-xl font-black text-slate-900 mb-2 truncate group-hover:text-primary transition-colors">
                                        <?= $worker['display_name'] ?>
                                    </h3>
                                    
                                    <div class="flex items-center gap-3 mb-6">
                                        <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-primary text-xs font-bold rounded-lg uppercase tracking-wider">
                                            <?= $worker['category_name'] ?>
                                        </span>
                                        <div class="flex items-center text-amber-500">
                                            <i class="fa fa-star text-xs mr-1"></i>
                                            <span class="text-sm font-black italic"><?= number_format($worker['average_rating'], 1) ?></span>
                                            <span class="text-slate-400 text-xs ml-1 font-bold">(<?= $worker['total_ratings'] ?>)</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap gap-2 mb-8 h-12 overflow-hidden">
                                        <?php foreach(array_slice($skills, 0, 3) as $skill): ?>
                                            <span class="px-3 py-1 bg-slate-50 text-slate-500 text-[10px] font-bold rounded-full uppercase tracking-tighter border border-slate-100"><?= $skill ?></span>
                                        <?php endforeach; ?>
                                        <?php if(count($skills) > 3): ?>
                                            <span class="px-3 py-1 bg-slate-50 text-slate-400 text-[10px] font-bold rounded-full border border-slate-100">+<?= count($skills) - 3 ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 pb-8 border-b border-slate-50 mb-8">
                                        <div class="flex items-center text-slate-500 text-xs font-bold uppercase tracking-wider">
                                            <i class="fa fa-briefcase text-primary/40 mr-2"></i>
                                            <?= $worker['experience_years'] ?> Years Exp
                                        </div>
                                        <div class="flex items-center text-slate-500 text-xs font-bold uppercase tracking-wider">
                                            <i class="fa fa-map-marker-alt text-danger/40 mr-2"></i>
                                            <?= $worker['location'] ?>
                                        </div>
                                    </div>

                                    <div class="flex gap-3">
                                        <a href="<?= base_url('worker/view/' . $worker['id']) ?>" class="flex-1 text-center py-4 bg-slate-50 text-slate-700 rounded-2xl font-black text-sm hover:bg-slate-100 transition-colors">
                                            Details
                                        </a>
                                        <?php if($is_logged_in): ?>
                                            <button onclick="showHireModal(<?= $worker['id'] ?>, '<?= $worker['display_name'] ?>', <?= $worker['hourly_rate'] ?>)" 
                                                    class="flex-[2] py-4 bg-primary text-white rounded-2xl font-black text-sm shadow-lg shadow-blue-200 hover:bg-secondary hover:-translate-y-1 transition-all duration-300">
                                                Hire Now
                                            </button>
                                        <?php else: ?>
                                            <a href="<?= base_url('user/login') ?>" class="flex-[2] text-center py-4 bg-slate-900 text-white rounded-2xl font-black text-sm hover:bg-black transition-all">
                                                Login to Hire
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Hire Modal -->
<div id="hireModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md" onclick="closeModal()"></div>
    <div class="bg-white rounded-[2.5rem] w-full max-w-lg relative z-10 overflow-hidden shadow-2xl transition-all scale-95 opacity-0 duration-300" id="modalContent">
        <div class="h-2 bg-primary"></div>
        <div class="p-10">
            <h2 class="text-3xl font-black text-slate-900 mb-2">Hire Professional</h2>
            <p class="text-slate-500 mb-8">Set terms for <span id="modalWorkerName" class="text-primary font-bold"></span></p>
            
            <form id="hireForm" onsubmit="submitHire(event)">
                <input type="hidden" name="worker_id" id="modalWorkerId">
                
                <div class="space-y-6 mb-10">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Agreed Hourly Rate (LKR)</label>
                        <input type="number" name="salary" id="modalSalary" required class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-primary focus:bg-white rounded-2xl outline-none transition-all text-lg font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Project Commission % (Optional)</label>
                        <input type="number" name="commission" id="modalCommission" value="0" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-primary focus:bg-white rounded-2xl outline-none transition-all text-lg font-bold">
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="button" onclick="closeModal()" class="flex-1 py-4 text-slate-500 font-bold hover:text-slate-900 transition-colors">Cancel</button>
                    <button type="submit" class="flex-[2] py-4 bg-primary text-white rounded-2xl font-black shadow-lg shadow-blue-200 hover:bg-secondary transition-all">
                        Confirm Hiring
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function filterByCategory(catId) {
    const url = new URL(window.location);
    if (catId) url.searchParams.set('category', catId);
    else url.searchParams.delete('category');
    window.location = url;
}

function searchWorkers() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    const loc = document.getElementById('locationSelect').value.toLowerCase();
    const cards = document.querySelectorAll('.worker-card');
    
    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        const cardLoc = card.dataset.location;
        const matchesQuery = text.includes(query);
        const matchesLoc = !loc || cardLoc.includes(loc);
        
        card.style.display = (matchesQuery && matchesLoc) ? 'block' : 'none';
    });
}

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

// Initial AOS Init if available
if (typeof AOS !== 'undefined') {
    AOS.init({
        duration: 800,
        once: true
    });
}
</script>
