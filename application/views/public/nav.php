<header id="main-header" class="fixed top-0 left-0 right-0 z-[100] transition-all duration-300 bg-[#1a1c23]/95 backdrop-blur-md border-b border-gray-800 shadow-xl h-20">
    <nav class="w-full h-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex items-center justify-between h-full">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center h-full">
                    <a href="<?= base_url() ?>" class="flex items-center h-full group block">
                        <img src="<?= base_url('assets/images/timberpro_logo_new.png'); ?>" alt="TimberPro" class="h-12 w-auto object-contain">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="<?= base_url() ?>" class="px-4 py-2 rounded-md font-bold text-sm uppercase tracking-wider text-gray-300 hover:text-white hover:bg-white/5 <?= (uri_string() == '' || uri_string() == 'user') ? 'text-white border-b-2 border-primary' : '' ?>">Home</a>
                    <a href="<?= base_url('shop') ?>" class="px-4 py-2 rounded-md font-bold text-sm uppercase tracking-wider text-gray-300 hover:text-white hover:bg-white/5 <?= (strpos(uri_string(), 'shop') !== false) ? 'text-white border-b-2 border-primary' : '' ?>">Marketplace</a>
                    <a href="<?= base_url('greenfuture') ?>" class="px-4 py-2 rounded-md font-bold text-sm uppercase tracking-wider text-gray-300 hover:text-white hover:bg-white/5 <?= (strpos(uri_string(), 'greenfuture') !== false) ? 'text-white border-b-2 border-success' : '' ?>">Green Future</a>
                    <a href="<?= base_url('shop/calculator') ?>" class="px-4 py-2 rounded-md font-bold text-sm uppercase tracking-wider text-gray-300 hover:text-white hover:bg-white/5">Calculator</a>
                    
                    <div class="flex items-center ml-4 space-x-3">
                        <?php if($this->aauth->is_loggedin()): ?>
                            <a href="<?= base_url('dashboard') ?>" class="px-6 py-2 bg-primary text-white font-bold text-sm uppercase tracking-wider hover:bg-blue-700 transition-all">Dashboard</a>
                        <?php else: ?>
                            <a href="<?= base_url('user') ?>" class="px-6 py-2 border border-white/20 text-white font-bold text-sm uppercase tracking-wider hover:bg-white hover:text-black transition-all">Login</a>
                            <a href="<?= base_url('user') ?>" class="px-6 py-2 bg-success text-black font-extrabold text-sm uppercase tracking-wider hover:bg-green-500 transition-all">Get Started</a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button class="text-gray-300 p-2"><i class="fa-solid fa-bars text-2xl"></i></button>
                </div>
            </div>
        </div>
    </nav>
</header>
<!-- Spacer for fixed header -->
<div class="h-20"></div>
