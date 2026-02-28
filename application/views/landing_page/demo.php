<?php
$pageTitle = "Book Free ERP Demo Sri Lanka | Profit Protection ERP";
$metaDescription = "Book your free 30‑minute demo & see how much money your business loses daily. Stop profit leak now.";
include 'includes/header.php';
include_once 'includes/icons.php';
include 'includes/nav.php';
?>

<main class="overflow-x-hidden">
    <!-- Split Screen Design for Demo Booking -->
    <div class="min-h-screen bg-gray-50 flex flex-col lg:flex-row pt-20">
        <!-- Left Side: Content -->
        <div class="lg:w-1/2 p-8 lg:p-16 flex flex-col justify-center bg-gray-900 text-white relative overflow-hidden">
             <div class="absolute inset-0 z-0 opacity-20">
                <!-- Background Pattern -->
                 <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                     <path d="M0 100 C 20 0 50 0 100 100 Z" fill="#2D5016"></path>
                 </svg>
            </div>
            
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 rounded-full mb-6">
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                    <span class="text-sm font-medium">Slots Available This Week</span>
                </div>
                
                <h1 class="font-headline text-4xl lg:text-6xl font-bold mb-6">
                    Stop the Bleeding. <br>
                    <span class="text-accent">See the Cure.</span>
                </h1>
                
                <p class="text-xl text-gray-300 mb-8 max-w-md">
                    In just 30 minutes, we'll show you exactly where your profit is leaking and how our "Psychological Command Center" plugs the holes.
                </p>

                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                         <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center border border-white/10">
                             <?php echo getIcon('ComputerDesktopIcon', 'w-6 h-6 text-accent'); ?>
                         </div>
                         <div>
                             <div class="font-bold">Live System Walkthrough</div>
                             <div class="text-sm text-gray-400">See the actual software, not slides.</div>
                         </div>
                    </div>
                     <div class="flex items-center gap-4">
                         <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center border border-white/10">
                             <?php echo getIcon('ChartBarIcon', 'w-6 h-6 text-accent'); ?>
                         </div>
                         <div>
                             <div class="font-bold">Personalized Profit Audit</div>
                             <div class="text-sm text-gray-400">We calculate your potential savings.</div>
                         </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Booking Form -->
        <div class="lg:w-1/2 p-8 lg:p-16 flex items-center justify-center">
            <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                <h2 class="font-headline text-2xl font-bold text-gray-900 mb-2">Book Your Strategy Session</h2>
                <p class="text-gray-500 text-sm mb-6">No pressure. No obligation. Just insight.</p>
                
                <form action="#" method="POST" class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" placeholder="John Doe">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
                        <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" placeholder="077 123 4567">
                    </div>
                    <div>
                        <label for="business" class="block text-sm font-medium text-gray-700 mb-1">Business Type</label>
                        <select id="business" name="business" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all bg-white">
                            <option value="" disabled selected>Select your industry</option>
                            <option value="timber">Timber / Sawmill</option>
                            <option value="hardware">Hardware Store</option>
                            <option value="paint">Paint Shop</option>
                            <option value="retail">General Retail</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full py-4 bg-primary text-primary-foreground font-cta font-bold rounded-xl shadow-lg hover:bg-primary/90 transition-all flex items-center justify-center gap-2">
                        <?php echo getIcon('CalendarDaysIcon', 'w-5 h-5'); ?>
                        Confirm Booking
                    </button>
                    <p class="text-xs text-center text-gray-400 mt-4">
                        We respect your privacy. data encrypted.
                    </p>
                </form>
            </div>
        </div>
    </div>
    
    <?php include 'includes/clients.php'; ?>
</main>

<?php include 'includes/footer.php'; ?>
