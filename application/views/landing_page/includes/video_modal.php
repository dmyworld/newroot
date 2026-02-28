<!-- Video Modal Backdrop -->
<div id="videoModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Glassmorphism Overlay -->
    <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-md transition-opacity opacity-0" id="videoModalOverlay"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-gray-900 border border-white/10 text-left shadow-[0_0_50px_rgba(0,0,0,0.5)] transition-all sm:my-8 sm:w-full sm:max-w-5xl opacity-0 scale-95" id="videoModalContent">
            
            <!-- Close Button -->
            <button type="button" onclick="closeVideoModal()" class="absolute top-4 right-4 z-10 p-2 bg-black/50 hover:bg-black/70 rounded-full text-white/70 hover:text-white transition-colors">
                <?php echo getIcon('XMarkIcon', 'w-6 h-6'); ?>
            </button>

            <div class="grid lg:grid-cols-3 h-[600px]">
                <!-- Video Player Area (2/3 width) -->
                <div class="lg:col-span-2 bg-black relative flex items-center justify-center group">
                    <div id="videoPlaceholder" class="w-full h-full flex flex-col items-center justify-center text-gray-500 bg-gray-950">
                        <?php echo getIcon('PlayCircleIcon', 'w-20 h-20 text-gray-700 group-hover:text-accent/50 transition-colors duration-300'); ?>
                        <p class="mt-4 font-body text-gray-400">Video Player Loading...</p>
                    </div>
                    <!-- Actual Video iframe or element would go here -->
                    <iframe id="mainVideoFrame" class="w-full h-full absolute inset-0 hidden" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>

                <!-- Playlist Sidebar (1/3 width) -->
                <div class="bg-gray-800 border-l border-white/10 flex flex-col">
                    <div class="p-6 border-b border-white/10">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-accent/10 border border-accent/20 rounded-full mb-3">
                            <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span>
                            <span class="font-body text-xs font-semibold text-accent uppercase tracking-wider">Intelligence Series</span>
                        </div>
                        <h3 class="font-headline text-2xl font-bold text-white mb-1">Seeing is Believing</h3>
                        <p class="font-body text-sm text-gray-400">Watch how psychology drives profit.</p>
                    </div>

                    <div class="flex-1 overflow-y-auto p-4 space-y-3">
                        <!-- Playlist Item 1 -->
                        <button onclick="playVideo('psychology')" id="btn-psychology" class="w-full flex items-start gap-3 p-3 rounded-xl transition-all duration-200 hover:bg-white/5 text-left group active-video-btn">
                            <div class="relative w-24 h-16 bg-gray-900 rounded-lg overflow-hidden flex-shrink-0 border border-white/10 group-hover:border-accent/30">
                                <img src="assets/images/hero-dashboard.png" class="w-full h-full object-cover opacity-60">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-8 h-8 bg-black/50 rounded-full flex items-center justify-center backdrop-blur-sm">
                                        <?php echo getIcon('PlayIcon', 'w-4 h-4 text-white'); ?>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-headline text-sm font-bold text-white mb-1 group-hover:text-accent transition-colors">The Psychology of Sales</h4>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <span>01:00</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-600"></span>
                                    <span>Cognitive Ease</span>
                                </div>
                            </div>
                        </button>

                         <!-- Playlist Item 2 -->
                         <button onclick="playVideo('staff-flow')" id="btn-staff-flow" class="w-full flex items-start gap-3 p-3 rounded-xl transition-all duration-200 hover:bg-white/5 text-left group">
                            <div class="relative w-24 h-16 bg-gray-900 rounded-lg overflow-hidden flex-shrink-0 border border-white/10 group-hover:border-accent/30">
                                <img src="assets/images/pos-interface.jpg" class="w-full h-full object-cover opacity-60">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-8 h-8 bg-black/50 rounded-full flex items-center justify-center backdrop-blur-sm">
                                        <?php echo getIcon('PlayIcon', 'w-4 h-4 text-white'); ?>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-headline text-sm font-bold text-white mb-1 group-hover:text-accent transition-colors">Staff Flow & Dopamine</h4>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <span>00:30</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-600"></span>
                                    <span>Gamification</span>
                                </div>
                            </div>
                        </button>

                         <!-- Playlist Item 3 -->
                         <button onclick="playVideo('health-check')" id="btn-health-check" class="w-full flex items-start gap-3 p-3 rounded-xl transition-all duration-200 hover:bg-white/5 text-left group">
                            <div class="relative w-24 h-16 bg-gray-900 rounded-lg overflow-hidden flex-shrink-0 border border-white/10 group-hover:border-accent/30">
                                <img src="assets/images/dashboard-1767529141730.jpg" class="w-full h-full object-cover opacity-60">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-8 h-8 bg-black/50 rounded-full flex items-center justify-center backdrop-blur-sm">
                                        <?php echo getIcon('PlayIcon', 'w-4 h-4 text-white'); ?>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-headline text-sm font-bold text-white mb-1 group-hover:text-accent transition-colors">Instant Health Check</h4>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <span>00:08</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-600"></span>
                                    <span>Quick Decisions</span>
                                </div>
                            </div>
                        </button>
                    </div>

                    <div class="p-6 bg-gray-900/50 border-t border-white/5">
                        <button onclick="scrollToSection('contact'); closeVideoModal()" class="w-full py-3 bg-accent text-accent-foreground font-cta font-bold rounded-lg hover:bg-accent/90 transition-all duration-200">
                            Get This System Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .active-video-btn {
        background-color: rgba(255, 255, 255, 0.1);
        border-right: 3px solid #DAA520; /* accent color */
    }
    .active-video-btn h4 {
        color: #DAA520;
    }
</style>

<script>
    const videos = {
        'psychology': { type: 'placeholder', title: 'The Psychology of Sales' }, // replace with real IDs/URLs later
        'staff-flow': { type: 'placeholder', title: 'Staff Flow & Dopamine' },
        'health-check': { type: 'placeholder', title: 'Instant Health Check' }
    };

    function openVideoModal() {
        const modal = document.getElementById('videoModal');
        const overlay = document.getElementById('videoModalOverlay');
        const content = document.getElementById('videoModalContent');
        
        modal.classList.remove('hidden');
        // Small timeout to allow removing 'hidden' to take effect before opacity transition
        setTimeout(() => {
            overlay.classList.remove('opacity-0');
            content.classList.remove('opacity-0', 'scale-95');
            content.classList.add('opacity-100', 'scale-100');
        }, 10);
        
        playVideo('psychology'); // Auto load first video
    }

    function closeVideoModal() {
        const modal = document.getElementById('videoModal');
        const overlay = document.getElementById('videoModalOverlay');
        const content = document.getElementById('videoModalContent');

        overlay.classList.add('opacity-0');
        content.classList.remove('opacity-100', 'scale-100');
        content.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            // reset player
            document.getElementById('mainVideoFrame').classList.add('hidden');
            document.getElementById('videoPlaceholder').classList.remove('hidden');
        }, 300);
    }

    function playVideo(videoId) {
        // Reset active states
        document.querySelectorAll('#videoModal button[id^="btn-"]').forEach(btn => {
            btn.classList.remove('active-video-btn');
        });
        document.getElementById('btn-' + videoId).classList.add('active-video-btn');

        // Logic to switch video source
        // For now, we simulate loading since we don't have real URLs
        const player = document.getElementById('mainVideoFrame');
        const placeholder = document.getElementById('videoPlaceholder');
        const placeholderText = placeholder.querySelector('p');

        player.classList.add('hidden');
        placeholder.classList.remove('hidden');
        placeholderText.textContent = "Playing: " + videos[videoId].title + " (Demo Mockup)";
    }
</script>
