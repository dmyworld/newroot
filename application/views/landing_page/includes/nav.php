<?php include_once 'icons.php'; ?>
<header id="main-header" class="fixed top-0 left-0 right-0 z-[100] transition-all duration-300 bg-[#1a1c23]/95 backdrop-blur-md border-b border-gray-800 shadow-xl h-28">
    <nav class="w-full h-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex items-center justify-between h-full transition-all duration-300" id="header-content">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center h-full transition-all duration-300" id="logo-container" data-aos="fade-right">
                    <a href="index.php" class="flex items-center h-full group block">
                        <img src="<?php echo base_url('assets/images/timberpro_logo_new.png'); ?>" alt="TimberPro ERP & POS" class="h-full w-auto object-contain py-1" id="header-logo">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-2" data-aos="fade-down" data-aos-delay="100">
                    <button onclick="scrollToSection('hero')" class="nav-link px-4 py-2 rounded-md font-body font-bold text-sm uppercase tracking-wider transition-all duration-250 text-gray-300 hover:text-white hover:bg-white/5 border-b-2 border-transparent hover:border-white">Home</button>
                    
                    <!-- Features Dropdown -->
                    <div class="relative group">
                        <button onclick="scrollToSection('modules')" class="nav-link px-4 py-2 rounded-md font-body font-bold text-sm uppercase tracking-wider transition-all duration-250 text-gray-300 hover:text-white hover:bg-white/5 border-b-2 border-transparent hover:border-white flex items-center gap-1 group-hover:text-white">
                            Features
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <!-- Dropdown Menu -->
                        <div class="absolute left-0 mt-4 w-72 bg-[#252830] rounded-none shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-gray-700 transform translate-y-2 group-hover:translate-y-0">
                            <div class="p-4 space-y-2">
                                 <a href="<?= base_url('marketplace/unified') ?>" class="block px-3 py-3 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-all border-l-2 border-transparent hover:border-[#13ec5b]">
                                     <strong class="text-[#13ec5b] uppercase tracking-wide text-xs block mb-1">Marketplace</strong>
                                     <span class="text-sm font-medium">Timber & Workers • Direct Transaction</span>
                                </a>
                                <a href="#modules" class="block px-3 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-all border-l-2 border-transparent hover:border-blue-500">Financial Management</a>
                                <a href="#modules" class="block px-3 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-all border-l-2 border-transparent hover:border-blue-500">Inventory & Stock</a>
                                <a href="#modules" class="block px-3 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-all border-l-2 border-transparent hover:border-blue-500">Point of Sale (POS)</a>
                                <a href="#modules" class="block px-3 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-all border-l-2 border-transparent hover:border-blue-500">Analytics & Reports</a>
                                <div class="pt-3 border-t border-gray-700 mt-2">
                                    <a href="#modules" class="block px-3 py-2 text-xs font-bold uppercase tracking-wider text-[#13ec5b] hover:text-white transition-colors">View All Modules →</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button onclick="scrollToSection('pricing')" class="nav-link px-4 py-2 rounded-md font-body font-bold text-sm uppercase tracking-wider transition-all duration-250 text-gray-300 hover:text-white hover:bg-white/5 border-b-2 border-transparent hover:border-white">Pricing</button>
                    
                    <!-- Login Link -->
                    <a href="<?php echo base_url('hub/login'); ?>" class="mx-2 px-6 py-2 rounded-none font-body font-bold text-sm uppercase tracking-wider transition-all duration-250 text-white border border-white/20 hover:bg-white hover:text-black hover:border-white">
                        Login
                    </a>

                    <!-- Register Dropdown -->
                    <div class="relative group ml-4">
                        <button class="px-6 py-3 bg-[#13ec5b] text-black font-extrabold text-sm uppercase tracking-wider rounded-none shadow-[0_0_15px_rgba(19,236,91,0.3)] hover:bg-[#10d050] hover:shadow-[0_0_25px_rgba(19,236,91,0.5)] transition-all duration-250 flex items-center gap-2 transform hover:-translate-y-0.5">
                            Get Started
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-4 w-72 bg-[#252830] rounded-none shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-gray-700 transform translate-y-2 group-hover:translate-y-0">
                            <div class="p-1 space-y-1">
                                <a href="<?php echo base_url('hub/register_seller'); ?>" class="block px-4 py-4 bg-[#13ec5b]/10 hover:bg-[#13ec5b]/20 transition-all border-l-4 border-[#13ec5b] group/item">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-[#13ec5b]/20 rounded-full group-hover/item:bg-[#13ec5b]/30 transition-colors">
                                            <svg class="w-5 h-5 text-[#13ec5b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <strong class="text-white block uppercase tracking-wide text-sm font-bold">Register as Seller</strong>
                                            <span class="text-xs text-gray-400">Manage timber business</span>
                                        </div>
                                    </div>
                                </a>
                                <a href="<?php echo base_url('hub/register_buyer'); ?>" class="block px-4 py-4 hover:bg-white/5 transition-all border-l-4 border-transparent hover:border-blue-500 group/item">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-blue-500/10 rounded-full group-hover/item:bg-blue-500/20 transition-colors">
                                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <strong class="text-white block uppercase tracking-wide text-sm font-bold">Register as Buyer</strong>
                                            <span class="text-xs text-gray-400">Buy timber & logs</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center h-full">
                    <button onclick="toggleMobileMenu()" class="p-3 rounded-md text-gray-300 hover:text-white hover:bg-white/10 transition-colors duration-250 border border-gray-700" aria-label="Toggle menu">
                        <svg id="menu-icon-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg id="menu-icon-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 hidden">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-[#1a1c23] border-t border-gray-800 absolute w-full left-0 top-[112px] shadow-xl transition-all duration-300 h-screen overflow-y-auto pb-40">
            <div class="px-6 py-8 space-y-4">
                <button onclick="scrollToSection('hero')" class="w-full text-left px-4 py-4 rounded-none border-b border-gray-800 font-body font-bold uppercase tracking-widest text-lg text-gray-300 hover:text-white hover:bg-white/5 active:bg-white/10 transition-all">Home</button>
                <button onclick="scrollToSection('modules')" class="w-full text-left px-4 py-4 rounded-none border-b border-gray-800 font-body font-bold uppercase tracking-widest text-lg text-gray-300 hover:text-white hover:bg-white/5 flex justify-between items-center">
                    Features <span class="text-xs bg-[#13ec5b]/20 text-[#13ec5b] px-3 py-1 rounded-full normal-case tracking-normal">15 Modules</span>
                </button>
                <button onclick="scrollToSection('pricing')" class="w-full text-left px-4 py-4 rounded-none border-b border-gray-800 font-body font-bold uppercase tracking-widest text-lg text-gray-300 hover:text-white hover:bg-white/5">Pricing</button>
                
                <div class="pt-8 space-y-4 mt-4 px-2">
                    <a href="<?php echo base_url('hub/login'); ?>" class="block w-full text-center px-4 py-4 rounded-none font-body font-bold uppercase tracking-widest text-base text-white border-2 border-white hover:bg-white hover:text-black transition-all">
                        Log In
                    </a>
                    <a href="<?php echo base_url('hub/register_seller'); ?>" class="block w-full text-center px-4 py-4 rounded-none font-body font-extrabold uppercase tracking-widest text-base bg-[#13ec5b] text-black shadow-lg hover:bg-[#10d050] transition-all transform active:scale-95">
                        Register as Seller
                    </a>
                    <a href="<?php echo base_url('hub/register_buyer'); ?>" class="block w-full text-center px-4 py-4 rounded-none font-body font-bold uppercase tracking-widest text-base text-blue-400 hover:text-blue-300 hover:bg-white/5 transition-all">
                        Register as Buyer
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('menu-icon-open');
    const iconClose = document.getElementById('menu-icon-close');
    const header = document.getElementById('main-header');
    
    // Animate opacity
    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        // Prevent scrolling on body when menu is open
        document.body.style.overflow = 'hidden';
        
        iconOpen.classList.add('hidden');
        iconClose.classList.remove('hidden');
        
        // Ensure header background is solid when menu is open
        header.classList.add('bg-[#1a1c23]');
        header.classList.remove('backdrop-blur-md');
    } else {
        menu.classList.add('hidden');
        document.body.style.overflow = '';
        
        iconOpen.classList.remove('hidden');
        iconClose.classList.add('hidden');
        
        // Restore header transparency
        header.classList.remove('bg-[#1a1c23]');
        header.classList.add('backdrop-blur-md');
    }
}

function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        // If not on homepage (or section not found), redirect to homepage
        if (window.location.pathname.indexOf('index.php') === -1 && window.location.pathname !== '/') {
             window.location.href = 'index.php#' + sectionId;
        }
    }
    
    // Close mobile menu if open
    const menu = document.getElementById('mobile-menu');
    if (!menu.classList.contains('hidden')) {
        toggleMobileMenu();
    }
}

// Shrinking Header Effect on Scroll
window.addEventListener('scroll', function() {
    const header = document.getElementById('main-header');
    const logo = document.getElementById('header-logo');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (window.scrollY > 50) {
        // Scrolled Down State
        header.classList.remove('h-28');
        header.classList.add('h-20', 'shadow-2xl');
        
        // Use h-full object-contain, so we rely on container height or padding
        logo.style.height = '100%'; 
        logo.classList.remove('py-1');
        logo.classList.add('py-2'); // Add padding on shrink to prevent touching edge too much
        
        if(mobileMenu) mobileMenu.style.top = '80px';
    } else {
        // Top State
        header.classList.remove('shadow-2xl', 'h-20');
        header.classList.add('h-28');
        
        logo.style.height = '100%';
        logo.classList.remove('py-2');
        logo.classList.add('py-1'); // Minimal padding at top for max size
        
        if(mobileMenu) mobileMenu.style.top = '112px';
    }
});
</script>
