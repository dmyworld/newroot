<?php include_once 'icons.php'; ?>
<header id="main-header" class="fixed top-0 left-0 right-0 z-[100] transition-all duration-300 bg-[rgb(31,32,36)]">
    <nav class="w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center">
                    <a href="index.php" class="flex items-center space-x-3">
                        <img src="assets/images/timberpro-logo.png" alt="TimberPro ERP" class="h-12 w-auto object-contain" width="180" height="50">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-1">
                    <button onclick="scrollToSection('hero')" class="nav-link px-4 py-2 rounded-md font-body font-medium text-base transition-all duration-250 text-gray-300 hover:text-white hover:bg-white/10">Home</button>
                    
                    <!-- Features Dropdown -->
                    <div class="relative group">
                        <button onclick="scrollToSection('modules')" class="nav-link px-4 py-2 rounded-md font-body font-medium text-base transition-all duration-250 text-gray-300 hover:text-white hover:bg-white/10 flex items-center gap-1">
                            Features
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-72 bg-[rgb(40,42,46)] rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="p-4 space-y-2">
                                <a href="#modules" class="block px-3 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 rounded-md transition-all">
                                    <strong class="text-[#13ec5b]">🌟 TimberPro Marketplace</strong><br>
                                    <span class="text-xs">Connect to Premium Buyers</span>
                                </a>
                                <a href="#modules" class="block px-3 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 rounded-md">💰 Financial Management</a>
                                <a href="#modules" class="block px-3 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 rounded-md">📦 Inventory & Stock Control</a>
                                <a href="#modules" class="block px-3 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 rounded-md">⚡ Point of Sale (POS)</a>
                                <a href="#modules" class="block px-3 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 rounded-md">📊 Analytics & Reports</a>
                                <a href="#modules" class="block px-3 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 rounded-md">👥 HR & Payroll</a>
                                <a href="#modules" class="block px-3 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 rounded-md text-[#13ec5b]">View All 15 Modules →</a>
                            </div>
                        </div>
                    </div>

                    <button onclick="scrollToSection('pricing')\" class="nav-link px-4 py-2 rounded-md font-body font-medium text-base transition-all duration-250 text-gray-300 hover:text-white hover:bg-white/10">Pricing</button>
                    <button onclick="scrollToSection('contact')" class="nav-link px-4 py-2 rounded-md font-body font-medium text-base transition-all duration-250 text-gray-300 hover:text-white hover:bg-white/10">Contact</button>
                    
                    <!-- Login Link -->
                    <a href="<?php echo base_url('hub/login'); ?>" class="px-4 py-2 rounded-md font-body font-medium text-base transition-all duration-250 text-gray-300 hover:text-white hover:bg-white/10 border border-gray-600 hover:border-[#13ec5b]">
                        Login
                    </a>

                    <!-- Register Dropdown -->
                    <div class="relative group">
                        <button class="px-5 py-2.5 bg-[#13ec5b] text-black font-bold text-base rounded-md shadow-lg hover:bg-[#10d050] transition-all duration-250 flex items-center gap-2">
                            Register
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-64 bg-[rgb(40,42,46)] rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="p-3 space-y-2">
                                <a href="<?php echo base_url('hub/register_seller'); ?>" class="block px-4 py-3 text-white bg-[#13ec5b]/20 hover:bg-[#13ec5b]/30 rounded-md transition-all border border-[#13ec5b]/30">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-[#13ec5b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <div>
                                            <strong class="text-[#13ec5b]">Register as Seller</strong><br>
                                            <span class="text-xs text-gray-400">Manage & Sell Timber</span>
                                        </div>
                                    </div>
                                </a>
                                <a href="<?php echo base_url('hub/register_buyer'); ?>" class="block px-4 py-3 text-white hover:bg-white/10 rounded-md transition-all">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <div>
                                            <strong>Register as Buyer</strong><br>
                                            <span class="text-xs text-gray-400">Source Premium Logs</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button onclick="toggleMobileMenu()" class="p-2 rounded-md text-foreground hover:bg-muted transition-colors duration-250" aria-label="Toggle menu">
                        <svg id="menu-icon-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-white">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg id="menu-icon-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-white hidden">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-[rgb(40,42,46)] border-t border-gray-700">
            <div class="px-4 py-4 space-y-2">
                <button onclick="scrollToSection('hero')" class="w-full text-left px-4 py-3 rounded-md font-body font-medium text-base text-gray-300 hover:text-white hover:bg-white/10">Home</button>
                <button onclick="scrollToSection('modules')" class="w-full text-left px-4 py-3 rounded-md font-body font-medium text-base text-gray-300 hover:text-white hover:bg-white/10">Features</button>
                <button onclick="scrollToSection('pricing')" class="w-full text-left px-4 py-3 rounded-md font-body font-medium text-base text-gray-300 hover:text-white hover:bg-white/10">Pricing</button>
                <button onclick="scrollToSection('contact')" class="w-full text-left px-4 py-3 rounded-md font-body font-medium text-base text-gray-300 hover:text-white hover:bg-white/10">Contact</button>
                
                <div class="pt-3 border-t border-gray-700 space-y-2">
                    <a href="<?php echo base_url('hub/login'); ?>" class="block w-full text-center px-4 py-3 rounded-md font-body font-medium text-base text-white border border-gray-600 hover:border-[#13ec5b]">
                        Login
                    </a>
                    <a href="<?php echo base_url('hub/register_seller'); ?>" class="block w-full text-center px-4 py-3 rounded-md font-body font-bold text-base bg-[#13ec5b] text-black hover:bg-[#10d050]">
                        Register as Seller
                    </a>
                    <a href="<?php echo base_url('hub/register_buyer'); ?>" class="block w-full text-center px-4 py-3 rounded-md font-body font-medium text-base text-white hover:bg-white/10 border border-gray-600">
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
    
    menu.classList.toggle('hidden');
    iconOpen.classList.toggle('hidden');
    iconClose.classList.toggle('hidden');
}

function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    // Close mobile menu if open
    const menu = document.getElementById('mobile-menu');
    if (!menu.classList.contains('hidden')) {
        toggleMobileMenu();
    }
}
</script>
