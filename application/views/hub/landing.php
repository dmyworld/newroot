<?php
// Translation logic for the landing page blueprint
$lang_id = isset($_GET['lang']) ? $_GET['lang'] : 'si';
$trans = [
    'en' => [
        'hero_title' => 'One Platform. Complete Timber & Construction Ecosystem.',
        'hero_subtitle' => 'Manage raw materials, workers, logistics, marketplace sales, and enterprise services—all in one connected system.',
        'hero_cta_primary' => 'Start Free Trial →',
        'hero_cta_secondary' => 'Request Demo',
        'hero_microtrust' => 'No credit card required • Setup in 5 mins • Cancel anytime',
        'prob_title' => 'How much do you lose with manual systems?',
        'prob_subtitle' => 'Traditional methods leak profit. Digital transformation secures it.',
        'prob_manual' => 'Manual Systems',
        'prob_digital' => 'Digital Ecosystem',
        'loss_volume' => 'Lost timber volume due to errors',
        'loss_billing' => 'Billing mistakes & forgotten debts',
        'loss_workforce' => 'Delay in workforce availability',
        'loss_wastage' => 'Wastage in materials',
        'win_ai' => 'AI log & material calculations',
        'win_sync' => 'Mobile billing & inventory sync',
        'win_hiring' => 'Instant workforce hiring',
        'win_market' => 'Marketplace & automated sales',
        'win_esg' => 'Real-time ESG / sustainability tracking',
        'eco_hub_title' => 'Your entire operations, connected in one platform.',
        'eco_marketplace' => 'Marketplace',
        'eco_finance' => 'Financials & Accounting',
        'eco_logistics' => 'Inventory & Logistics',
        'eco_workforce' => 'Workforce & Recruitment',
        'eco_ai' => 'AI Automation & Analytics',
        'eco_esg' => 'ESG Tracker',
        'ai_section_title' => 'Innovation that Drives Credibility',
        'ai_log_title' => 'AI Log & Volume Calculation',
        'ai_log_desc' => 'Instant timber volume calculations using advanced log scanning.',
        'ai_const_title' => 'AI Material Estimation',
        'ai_const_desc' => 'Predictive material needs for construction projects.',
        'ai_marketing_title' => 'Automated Marketing Ads',
        'ai_marketing_desc' => 'Generate AI-powered video ads for your inventory instantly.',
        'ai_predictive_title' => 'Predictive Analytics',
        'ai_predictive_desc' => 'Forecasting reports to optimize your next procurement cycle.',
        'market_section_title' => 'Marketplace & Services',
        'market_subtitle' => 'Connect instantly to buyers and skilled workers nationwide.',
        'market_raw' => 'Raw Materials & Timber',
        'market_const' => 'Construction Supplies',
        'market_bidding' => 'Real-time Bidding & Offers',
        'market_hiring' => 'Instant Workforce Recruitment',
        'esg_title' => 'Build a Sustainable Future',
        'esg_subtitle' => 'Every transaction helps restore our environment.',
        'esg_impact' => 'Tree Planting Tracker',
        'esg_contribution' => 'Impact Dashboard',
        'mod_title' => 'One Ecosystem. 15+ Powerful Modules.',
        'mod_subtitle' => 'Everything your timber, construction, and enterprise business needs.',
        'cat_ops' => 'Operations',
        'cat_fin' => 'Finance',
        'cat_growth' => 'Growth',
        'cat_work' => 'Workforce',
        'cat_intel' => 'Intelligence',
        'res_title' => 'Performance & Results',
        'met_wastage_manual' => '15–20%',
        'met_wastage_pro' => '< 1%',
        'met_speed_manual' => '15 mins',
        'met_speed_pro' => '2.4s',
        'met_hiring_manual' => '2–3 days',
        'met_hiring_pro' => 'Instant',
        'final_cta_title' => 'Start Your Timber & Construction Business Transformation Today',
        'recommended' => 'Recommended',
    ],
    'si' => [
        'hero_title' => 'එකම විසඳුමයි. පරිපූර්ණ දැව සහ ඉදිකිරීම් Ecosystem එකයි.',
        'hero_subtitle' => 'අමුද්‍රව්‍ය, සේවකයන්, ප්‍රවාහනය, වෙලඳපොළ සහ ව්‍යාපාරික අවශ්‍යතා සියල්ල එකම පද්ධතියකින් කළමනාකරණය කරන්න.',
        'hero_cta_primary' => 'නොමිලේ අත්හදා බලන්න →',
        'hero_cta_secondary' => 'Request Demo',
        'hero_microtrust' => 'Credit Card අවශ්‍ය නැත • විනාඩි 5කින් සක්‍රීය වේ • ඕනෑම විටක අවලංගු කළ හැක',
        'prob_title' => 'පැරණි ක්‍රම නිසා ඔබට කොපමණ අහිමි වෙනවාද?',
        'prob_subtitle' => 'සාම්ප්‍රදායික ක්‍රම මගින් ලාභය අහිමි වන අතර, ඩිජිටල් පරිවර්තනය එය සුරක්ෂිත කරයි.',
        'prob_manual' => 'පැරණි ක්‍රමය',
        'prob_digital' => 'Digital Ecosystem එක',
        'loss_volume' => 'ගණනය කිරීම් වැරදි නිසා දැව අහිමි වීම',
        'loss_billing' => 'බිල්පත් වැරදීම් සහ අමතක වන ණය',
        'loss_workforce' => 'සේවකයන් සොයාගැනීමේ ප්‍රමාදය',
        'loss_wastage' => 'අමුද්‍රව්‍ය අනවශ්‍ය ලෙස නාස්ති වීම',
        'win_ai' => 'AI මගින් දැව සහ අමුද්‍රව්‍ය ගණනය කිරීම',
        'win_sync' => 'Mobile හරහා බිල්පත් සහ තොග කළමනාකරණය',
        'win_hiring' => 'සේවකයන් කඩිනමින් බඳවා ගැනීම',
        'win_market' => 'Marketplace සහ ස්වයංක්‍රීය අලෙවිය',
        'win_esg' => 'සජීවීව පෙන්වන පාරිසරික බලපෑම් (ESG Tracker)',
        'eco_hub_title' => 'ඔබේ මුළු ව්‍යාපාරයම දැන් එකම මධ්‍යස්ථානයකට සම්බන්ධයි.',
        'eco_marketplace' => 'වෙළඳපොළ',
        'eco_finance' => 'මූල්‍ය සහ ගිණුම්කරණය',
        'eco_logistics' => 'තොග සහ ප්‍රවාහනය',
        'eco_workforce' => 'සේවක හිමිකම සහ බඳවා ගැනීම්',
        'eco_ai' => 'AI සහ ස්වයංක්‍රීයකරණය',
        'eco_esg' => 'ESG Tracker (පාරිසරික බලපෑම)',
        'ai_section_title' => 'විශ්වසනීයත්වය තහවුරු කරන නවීන තාක්‍ෂණය',
        'ai_log_title' => 'AI මගින් දැව කොට ගණනය කිරීම',
        'ai_log_desc' => 'ස්කෑන් කිරීම මගින් ක්ෂණිකව දැව පරිමාව ගණනය කරන්න.',
        'ai_const_title' => 'AI අමුද්‍රව්‍ය ඇස්තමේන්තුව',
        'ai_const_desc' => 'ඉදිකිරීම් ව්‍යාපෘති සඳහා අවශ්‍ය ද්‍රව්‍ය කල්තියා නිගමනය කරන්න.',
        'ai_marketing_title' => 'AI වෙළඳ දැන්වීම්',
        'ai_marketing_desc' => 'ඔබේ තොග සඳහා AI හරහා වීඩියෝ දැන්වීම් සැකසීම.',
        'ai_predictive_title' => 'අනාගත අනාවැකි (Predictive Analytics)',
        'ai_predictive_desc' => 'ඊළඟ වාරයට අවශ්‍ය තොග කලින් හඳුනා ගැනීම.',
        'market_section_title' => 'Marketplace සහ සේවාවන්',
        'market_subtitle' => 'ගැනුම්කරුවන් සහ සේවකයන් සමඟ දැන්ම සම්බන්ධ වන්න.',
        'market_raw' => 'දැව සහ අමුද්‍රව්‍ය',
        'market_const' => 'ඉදිකිරීම් ද්‍රව්‍ය',
        'market_bidding' => 'සජීවී ලංසු තැබීම (Bidding)',
        'market_hiring' => 'කඩිනමින් සේවකයන් බඳවා ගැනීම',
        'esg_title' => 'තිරසාර අනාගතයක් ගොඩනගමු',
        'esg_subtitle' => 'සෑම ගනුදෙනුවක්ම පරිසරය සුරැකීමට දායක වේ.',
        'esg_impact' => 'ගස් සිටුවීමේ ලුහුබැඳීම',
        'esg_contribution' => 'පාරිසරික බලපෑම් වාර්තාව',
        'mod_title' => 'එකම Ecosystem එකක්. ප්‍රබල මොඩියුල 15+ ක්.',
        'mod_subtitle' => 'ඔබේ දැව සහ ඉදිකිරීම් ව්‍යාපාරයට අවශ්‍ය සියලුම පහසුකම්.',
        'cat_ops' => 'මෙහෙයුම් (Operations)',
        'cat_fin' => 'මූල්‍ය (Finance)',
        'cat_growth' => 'වර්ධනය (Growth)',
        'cat_work' => 'සේවක බලකාය (Workforce)',
        'cat_intel' => 'තාක්‍ෂණය (Intelligence)',
        'res_title' => 'කාර්යසාධනය සහ ප්‍රතිඵල',
        'met_wastage_manual' => '15–20%',
        'met_wastage_pro' => '1% කට අඩු',
        'met_speed_manual' => 'විනාඩි 15',
        'met_speed_pro' => 'තත්පර 2.4',
        'met_hiring_manual' => 'දින 2–3',
        'met_hiring_pro' => 'ක්ෂණිකව',
        'final_cta_title' => 'ඔබේ ව්‍යාපාරය අදම ඩිජිටල් යුගයට රැගෙන යන්න',
        'recommended' => 'නිර්දේශිතයි',
    ]
];
$t = isset($trans[$lang_id]) ? $trans[$lang_id] : $trans['si'];
?>

<style>
    :root {
        --tp-success: #22c55e;
        --tp-primary: #3b82f6;
    }

    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    @keyframes bounce-slow {
        0%, 100% { transform: translateY(-5%); animation-timing-function: cubic-bezier(0.8, 0, 1, 1); }
        50% { transform: translateY(0); animation-timing-function: cubic-bezier(0, 0, 0.2, 1); }
    }

    .animate-spin-slow { animation: spin 12s linear infinite; }
    .animate-spin-reverse { animation: spin-reverse 15s linear infinite; }

    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    @keyframes spin-reverse { from { transform: rotate(360deg); } to { transform: rotate(0deg); } }

    .hero-title {
        background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .dark-glass {
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>

<!-- 1. Blueprint Hero Section -->
<section class="relative min-h-[90vh] flex items-center pt-20 overflow-hidden bg-slate-950">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="<?= base_url('assets/images/hero_ecosystem_bg.png') ?>" class="w-full h-full object-cover opacity-40" alt="Ecosystem Background">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950 via-slate-950/40 to-slate-950"></div>
    </div>

    <div class="absolute inset-0 z-1 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-green-500/10 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-500/10 rounded-full blur-[100px] animate-pulse" style="animation-delay: 2s;"></div>
        <svg class="absolute inset-0 w-full h-full opacity-10" viewBox="0 0 100 100">
            <circle cx="50" cy="50" r="40" stroke="currentColor" fill="none" stroke-width="0.05" class="text-slate-700 animate-spin-slow" />
            <circle cx="50" cy="50" r="30" stroke="currentColor" fill="none" stroke-width="0.05" class="text-slate-600 animate-spin-reverse" />
        </svg>
    </div>

    <div class="container mx-auto px-6 relative z-10 py-12">
        <div class="max-w-4xl mx-auto text-center reveal">
            <h1 class="text-5xl md:text-7xl font-bold tracking-tighter mb-6 hero-title leading-[1.1]">
                <?= $t['hero_title'] ?>
            </h1>
            <p class="text-xl md:text-2xl text-slate-300 mb-10 leading-relaxed max-w-2xl mx-auto">
                <?= $t['hero_subtitle'] ?>
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
                <a href="<?= base_url('register') ?>" class="w-full sm:w-auto px-10 py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-2xl transition-all shadow-xl shadow-green-500/20 hover:scale-105 active:scale-95 text-lg">
                    <?= $t['hero_cta_primary'] ?>
                </a>
                <a href="#demo" class="w-full sm:w-auto px-10 py-4 bg-white/10 hover:bg-white/20 text-white font-bold rounded-2xl border border-white/20 backdrop-blur-md transition-all hover:scale-105 active:scale-95 text-lg">
                    <?= $t['hero_cta_secondary'] ?>
                </a>
            </div>

            <div class="flex items-center justify-center gap-6 text-sm text-slate-400 font-medium opacity-80">
                <div class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500"></i> <?= explode(' • ', $t['hero_microtrust'])[0] ?></div>
                <div class="hidden sm:flex items-center gap-2"><i class="fas fa-bolt text-amber-500"></i> <?= explode(' • ', $t['hero_microtrust'])[1] ?></div>
                <div class="hidden md:flex items-center gap-2"><i class="fas fa-times-circle text-red-400"></i> <?= explode(' • ', $t['hero_microtrust'])[2] ?></div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Problem Awareness Section -->
<section class="py-24 bg-white border-y border-slate-100 overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl mx-auto text-center mb-20 reveal">
            <span class="inline-block px-4 py-1.5 bg-red-50 text-red-600 text-sm font-bold tracking-widest uppercase rounded-full mb-4">Loss Aversion</span>
            <h2 class="text-4xl md:text-5xl font-bold tracking-tight mb-4 text-slate-900"><?= $t['prob_title'] ?></h2>
            <p class="text-lg text-slate-600"><?= $t['prob_subtitle'] ?></p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto reveal">
            <!-- Manual -->
            <div class="p-10 rounded-[2.5rem] bg-slate-50 border border-slate-200 relative">
                <h3 class="text-2xl font-bold mb-8 flex items-center gap-3 text-red-600">
                    <span class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                        <i class="fas fa-times"></i>
                    </span>
                    <?= $t['prob_manual'] ?>
                </h3>
                <ul class="space-y-6">
                    <li class="flex items-start gap-4 text-slate-500">
                        <i class="fas fa-minus-circle mt-1 text-red-300"></i>
                        <span><?= $t['loss_volume'] ?></span>
                    </li>
                    <li class="flex items-start gap-4 text-slate-500">
                        <i class="fas fa-minus-circle mt-1 text-red-300"></i>
                        <span><?= $t['loss_billing'] ?></span>
                    </li>
                    <li class="flex items-start gap-4 text-slate-500">
                        <i class="fas fa-minus-circle mt-1 text-red-300"></i>
                        <span><?= $t['loss_workforce'] ?></span>
                    </li>
                    <li class="flex items-start gap-4 text-slate-500">
                        <i class="fas fa-minus-circle mt-1 text-red-300"></i>
                        <span><?= $t['loss_wastage'] ?></span>
                    </li>
                </ul>
            </div>

            <!-- Digital -->
            <div class="p-10 rounded-[2.5rem] bg-slate-900 border border-slate-800 relative shadow-2xl">
                <h3 class="text-2xl font-bold mb-8 flex items-center gap-3 text-green-400">
                    <span class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center text-green-400">
                        <i class="fas fa-check"></i>
                    </span>
                    <?= $t['prob_digital'] ?>
                </h3>
                <ul class="space-y-6 text-slate-300">
                    <li class="flex items-start gap-4">
                        <i class="fas fa-plus-circle mt-1 text-green-400"></i>
                        <span><?= $t['win_ai'] ?></span>
                    </li>
                    <li class="flex items-start gap-4">
                        <i class="fas fa-plus-circle mt-1 text-green-400"></i>
                        <span><?= $t['win_sync'] ?></span>
                    </li>
                    <li class="flex items-start gap-4">
                        <i class="fas fa-plus-circle mt-1 text-green-400"></i>
                        <span><?= $t['win_hiring'] ?></span>
                    </li>
                    <li class="flex items-start gap-4">
                        <i class="fas fa-plus-circle mt-1 text-green-400"></i>
                        <span><?= $t['win_market'] ?></span>
                    </li>
                    <li class="flex items-start gap-4">
                        <i class="fas fa-plus-circle mt-1 text-green-400"></i>
                        <span><?= $t['win_esg'] ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- 3. Ecosystem Overview (Diagram) -->
<section class="py-24 bg-slate-50 overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl mx-auto text-center mb-20 reveal">
            <h2 class="text-4xl md:text-5xl font-bold tracking-tight mb-4 text-slate-900"><?= $t['eco_hub_title'] ?></h2>
            <div class="w-20 h-1.5 bg-green-500 mx-auto rounded-full"></div>
        </div>

        <div class="relative max-w-5xl mx-auto aspect-video flex items-center justify-center reveal">
            <!-- Center Hub -->
            <div class="z-20 w-48 h-48 bg-white glass-card rounded-full flex flex-col items-center justify-center shadow-2xl border-2 border-green-500/20 text-center p-4">
                <img src="<?= base_url('assets/images/logo.png') ?>" class="w-24 mb-2 grayscale" alt="TimberPro">
                <span class="text-sm font-bold text-slate-900 uppercase tracking-widest leading-none">TimberPro Platform</span>
            </div>

            <!-- Nodes -->
            <div class="absolute inset-0 flex items-center justify-center">
                <?php 
                $nodes = [
                    ['icon' => 'shopping-cart', 'label' => 'eco_marketplace', 'pos' => 'top-0 left-1/2 -translate-x-1/2'],
                    ['icon' => 'calculator', 'label' => 'eco_finance', 'pos' => 'top-1/4 right-0'],
                    ['icon' => 'truck', 'label' => 'eco_logistics', 'pos' => 'bottom-1/4 right-0'],
                    ['icon' => 'users', 'label' => 'eco_workforce', 'pos' => 'bottom-0 left-1/2 -translate-x-1/2'],
                    ['icon' => 'brain', 'label' => 'eco_ai', 'pos' => 'bottom-1/4 left-0'],
                    ['icon' => 'leaf', 'label' => 'eco_esg', 'pos' => 'top-1/4 left-0'],
                ];
                foreach ($nodes as $node): ?>
                <div class="absolute <?= $node['pos'] ?> w-40 p-4 transition-all hover:scale-110">
                    <div class="bg-white/80 p-4 rounded-3xl border border-slate-200 shadow-xl text-center group">
                        <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-green-500 group-hover:text-white transition-all">
                            <i class="fas fa-<?= $node['icon'] ?>"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-700"><?= $t[$node['label']] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Connection Lines (Visual decor only) -->
            <svg class="absolute inset-0 w-full h-full z-0 opacity-20 pointer-events-none" viewBox="0 0 100 60">
                <line x1="50" y1="30" x2="50" y2="5" stroke="green" stroke-width="0.1" stroke-dasharray="1 1" />
                <line x1="50" y1="30" x2="85" y2="15" stroke="green" stroke-width="0.1" stroke-dasharray="1 1" />
                <line x1="50" y1="30" x2="85" y2="45" stroke="green" stroke-width="0.1" stroke-dasharray="1 1" />
                <line x1="50" y1="30" x2="50" y2="55" stroke="green" stroke-width="0.1" stroke-dasharray="1 1" />
                <line x1="50" y1="30" x2="15" y2="45" stroke="green" stroke-width="0.1" stroke-dasharray="1 1" />
                <line x1="50" y1="30" x2="15" y2="15" stroke="green" stroke-width="0.1" stroke-dasharray="1 1" />
            </svg>
        </div>
    </div>
</section>

<!-- 4. AI & Automation (Authority Bias) -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl mx-auto text-center mb-20 reveal">
            <h2 class="text-4xl md:text-5xl font-bold tracking-tight mb-4 text-slate-900"><?= $t['ai_section_title'] ?></h2>
        </div>

        <div class="grid lg:grid-cols-2 gap-16 items-center max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 reveal">
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:border-green-500/30 transition-all">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-lg flex items-center justify-center text-green-600 mb-6">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-2 text-slate-900"><?= $t['ai_log_title'] ?></h4>
                    <p class="text-sm text-slate-500 leading-relaxed"><?= $t['ai_log_desc'] ?></p>
                </div>
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:border-blue-500/30 transition-all">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-lg flex items-center justify-center text-blue-600 mb-6">
                        <i class="fas fa-drafting-compass"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-2 text-slate-900"><?= $t['ai_const_title'] ?></h4>
                    <p class="text-sm text-slate-500 leading-relaxed"><?= $t['ai_const_desc'] ?></p>
                </div>
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:border-amber-500/30 transition-all">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-lg flex items-center justify-center text-amber-600 mb-6">
                        <i class="fas fa-video"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-2 text-slate-900"><?= $t['ai_marketing_title'] ?></h4>
                    <p class="text-sm text-slate-500 leading-relaxed"><?= $t['ai_marketing_desc'] ?></p>
                </div>
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:border-purple-500/30 transition-all">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-lg flex items-center justify-center text-purple-600 mb-6">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-2 text-slate-900"><?= $t['ai_predictive_title'] ?></h4>
                    <p class="text-sm text-slate-500 leading-relaxed"><?= $t['ai_predictive_desc'] ?></p>
                </div>
            </div>
            
            <!-- AI Scan Visual Simulation -->
            <div class="reveal relative">
                <div class="bg-slate-900 rounded-[3rem] p-4 shadow-2xl aspect-square overflow-hidden border-8 border-slate-800">
                    <div class="absolute inset-0 bg-gradient-to-t from-green-500/20 to-transparent"></div>
                    <div class="absolute top-1/2 left-0 w-full h-0.5 bg-green-500 shadow-[0_0_20px_#22c55e] animate-bounce" style="animation-duration: 4s;"></div>
                    <div class="flex items-center justify-center h-full opacity-30">
                        <i class="fas fa-tree text-[200px] text-green-400"></i>
                    </div>
                    <div class="absolute bottom-10 left-10 right-10 p-6 dark-glass rounded-2xl">
                        <div class="flex justify-between items-center text-white">
                            <span class="text-xs font-bold uppercase tracking-widest text-green-400">AI SCANNING LOGS</span>
                            <span class="text-xs font-mono">ID: TP-8832</span>
                        </div>
                        <div class="mt-2 text-2xl font-mono text-white">99.8% VOL ACCURACY</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. Marketplace & 6. ESG -->
<section class="py-24 bg-slate-950 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_20%,rgba(34,197,94,0.1),transparent)]"></div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="grid lg:grid-cols-2 gap-24 items-center">
            <div class="reveal">
                <h2 class="text-4xl md:text-5xl font-bold mb-6"><?= $t['market_section_title'] ?></h2>
                <p class="text-xl text-slate-400 mb-12"><?= $t['market_subtitle'] ?></p>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-6 bg-white/5 border border-white/10 rounded-2xl">
                        <h5 class="font-bold text-green-400 mb-2"><?= $t['market_raw'] ?></h5>
                        <p class="text-xs text-slate-500">Instant sourcing nationwide.</p>
                    </div>
                    <div class="p-6 bg-white/5 border border-white/10 rounded-2xl">
                        <h5 class="font-bold text-blue-400 mb-2"><?= $t['market_const'] ?></h5>
                        <p class="text-xs text-slate-500">Enterprise grade supplies.</p>
                    </div>
                    <div class="p-6 bg-white/5 border border-white/10 rounded-2xl">
                        <h5 class="font-bold text-amber-400 mb-2"><?= $t['market_bidding'] ?></h5>
                        <p class="text-xs text-slate-500">Dynamic pricing engine.</p>
                    </div>
                    <div class="p-6 bg-white/5 border border-white/10 rounded-2xl">
                        <h5 class="font-bold text-purple-400 mb-2"><?= $t['market_hiring'] ?></h5>
                        <p class="text-xs text-slate-500">Verified skilled workers.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 p-12 rounded-[3.5rem] reveal">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 bg-green-500/20 rounded-2xl flex items-center justify-center text-green-500">
                        <i class="fas fa-leaf text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold"><?= $t['esg_title'] ?></h4>
                        <p class="text-slate-400"><?= $t['esg_subtitle'] ?></p>
                    </div>
                </div>
                
                <div class="space-y-8">
                    <div>
                        <div class="flex justify-between mb-4">
                            <span class="text-sm font-bold opacity-60 uppercase tracking-widest"><?= $t['esg_impact'] ?></span>
                            <span class="text-green-400 font-bold">12,482 Trees</span>
                        </div>
                        <div class="h-3 w-full bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-green-500 to-emerald-400 w-3/4 animate-pulse"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-6 bg-white/5 rounded-2xl">
                        <span class="font-bold"><?= $t['esg_contribution'] ?></span>
                        <a href="<?= base_url('greenfuture') ?>" class="text-xs font-bold text-green-400 uppercase tracking-widest border-b border-green-500/20 hover:border-green-500 transition-all">View Full Data</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 7. Filterable Modules -->
<section id="modules" class="py-24 bg-slate-50">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl mx-auto text-center mb-16 reveal">
            <h2 class="text-4xl md:text-5xl font-bold tracking-tight mb-4 text-slate-900"><?= $t['mod_title'] ?></h2>
            <p class="text-lg text-slate-600"><?= $t['mod_subtitle'] ?></p>
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap justify-center gap-3 mb-16 reveal">
            <button class="filter-btn px-8 py-3 bg-slate-900 text-white rounded-full font-bold text-sm transition-all shadow-lg shadow-slate-900/10" data-filter="all">All Modules</button>
            <button class="filter-btn px-8 py-3 bg-white text-slate-600 hover:bg-slate-100 rounded-full font-bold text-sm transition-all border border-slate-200" data-filter="Operations"><?= $t['cat_ops'] ?></button>
            <button class="filter-btn px-8 py-3 bg-white text-slate-600 hover:bg-slate-100 rounded-full font-bold text-sm transition-all border border-slate-200" data-filter="Finance"><?= $t['cat_fin'] ?></button>
            <button class="filter-btn px-8 py-3 bg-white text-slate-600 hover:bg-slate-100 rounded-full font-bold text-sm transition-all border border-slate-200" data-filter="Growth"><?= $t['cat_growth'] ?></button>
            <button class="filter-btn px-8 py-3 bg-white text-slate-600 hover:bg-slate-100 rounded-full font-bold text-sm transition-all border border-slate-200" data-filter="Workforce"><?= $t['cat_work'] ?></button>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 reveal">
            <?php 
            $all_mods = [
                ['name' => 'Inventory Pro', 'cat' => 'Operations', 'icon' => 'box', 'feat' => true],
                ['name' => 'Sync Billing', 'cat' => 'Finance', 'icon' => 'file-invoice-dollar', 'feat' => true],
                ['name' => 'Market Ads', 'cat' => 'Growth', 'icon' => 'ad', 'feat' => false],
                ['name' => 'Instant Hiring', 'cat' => 'Workforce', 'icon' => 'user-plus', 'feat' => true],
                ['name' => 'Sawmill Engine', 'cat' => 'Operations', 'icon' => 'industry', 'feat' => false],
                ['name' => 'ESG Dashboard', 'cat' => 'Intelligence', 'icon' => 'globe', 'feat' => false],
                ['name' => 'Project Hub', 'cat' => 'Operations', 'icon' => 'tasks', 'feat' => false],
                ['name' => 'Digital QC', 'cat' => 'Intelligence', 'icon' => 'shield-alt', 'feat' => true],
            ];
            foreach ($all_mods as $m): ?>
            <div class="module-card p-8 rounded-[2rem] bg-white border border-slate-200 hover:border-green-500/30 transition-all group relative overflow-hidden" data-category="<?= $m['cat'] ?>">
                <?php if($m['feat']): ?>
                <div class="absolute -top-6 -right-6 w-20 h-20 bg-green-500/10 rounded-full blur-2xl group-hover:bg-green-500/20 transition-all"></div>
                <div class="absolute top-4 right-4 text-[10px] font-black uppercase tracking-widest text-green-600 bg-green-50 px-3 py-1 rounded-full">⭐ Featured</div>
                <?php endif; ?>
                <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-900 mb-6 group-hover:bg-slate-900 group-hover:text-white transition-all">
                    <i class="fas fa-<?= $m['icon'] ?> text-xl"></i>
                </div>
                <h5 class="text-xl font-bold mb-2 text-slate-900"><?= $m['name'] ?></h5>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4"><?= $m['cat'] ?></p>
                <div class="w-8 h-1 bg-slate-100 group-hover:bg-green-500 group-hover:w-full transition-all duration-500"></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
    .module-card.hidden-mod {
        display: none;
    }
</style>

<!-- 8. Performance & 9. Testimonials -->
<section class="py-24 bg-white border-t border-slate-100">
    <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-20 items-center max-w-6xl mx-auto">
            <div class="reveal">
                <h2 class="text-4xl font-bold mb-10"><?= $t['res_title'] ?></h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-6 bg-slate-50 rounded-2xl">
                        <span class="font-bold text-slate-600">Timber Wastage</span>
                        <div class="flex items-center gap-4">
                            <span class="text-slate-400 line-through"><?= $t['met_wastage_manual'] ?></span>
                            <span class="text-green-600 font-bold"><?= $t['met_wastage_pro'] ?></span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-6 bg-slate-50 rounded-2xl">
                        <span class="font-bold text-slate-600">Billing Speed</span>
                        <div class="flex items-center gap-4">
                            <span class="text-slate-400 line-through"><?= $t['met_speed_manual'] ?></span>
                            <span class="text-blue-600 font-bold"><?= $t['met_speed_pro'] ?></span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-6 bg-slate-50 rounded-2xl">
                        <span class="font-bold text-slate-600">Hiring Delay</span>
                        <div class="flex items-center gap-4">
                            <span class="text-slate-400 line-through"><?= $t['met_hiring_manual'] ?></span>
                            <span class="text-purple-600 font-bold"><?= $t['met_hiring_pro'] ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="reveal">
                <div class="p-12 rounded-[3.5rem] bg-slate-900 text-white relative shadow-2xl">
                    <div class="absolute -top-6 -left-6 w-16 h-16 bg-green-500 rounded-full flex items-center justify-center text-3xl">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="text-2xl italic leading-relaxed mb-8 opacity-90">
                        "Using TimberPro, I reduced timber wastage, completed projects on time, and got new buyers instantly."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-slate-800 rounded-full flex items-center justify-center text-xl font-bold border-2 border-green-500/50">SM</div>
                        <div>
                            <p class="font-bold">Sunil Mendis</p>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Manager, Nittambuwa Sawmill</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 10. Pricing & 11. Final CTA -->
<section id="pricing" class="py-24 bg-slate-50 overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto grid lg:grid-cols-3 gap-8 items-end reveal">
            <!-- Starter -->
            <div class="p-10 rounded-[2.5rem] bg-white border border-slate-200">
                <p class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-6">Starter</p>
                <div class="mb-8">
                    <span class="text-5xl font-black">Free</span>
                </div>
                <ul class="space-y-4 mb-10 text-slate-500 text-sm">
                    <li><i class="fas fa-check text-green-500 mr-2"></i> Single User</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i> basic Inventory</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i> Limited Marketplace</li>
                </ul>
                <a href="<?= base_url('register') ?>" class="block w-full py-4 px-6 border border-slate-200 text-slate-900 font-bold rounded-2xl text-center hover:bg-slate-50 transition-all">Start Free</a>
            </div>

            <!-- Standard -->
            <div class="p-12 rounded-[3rem] bg-slate-900 text-white shadow-2xl relative lg:scale-110 z-10">
                <div class="absolute top-0 right-10 -translate-y-1/2 px-6 py-2 bg-green-500 text-slate-900 rounded-full text-xs font-black uppercase tracking-widest"><?= $t['recommended'] ?></div>
                <p class="text-sm font-bold uppercase tracking-widest opacity-60 mb-6">Standard</p>
                <div class="mb-8">
                    <span class="text-5xl font-black">LKR 15,000</span>
                    <span class="opacity-40">/mo</span>
                </div>
                <ul class="space-y-4 mb-10 text-slate-400 text-sm">
                    <li><i class="fas fa-check text-green-400 mr-2"></i> Full AI Modules</li>
                    <li><i class="fas fa-check text-green-400 mr-2"></i> Unlimited Marketplace</li>
                    <li><i class="fas fa-check text-green-400 mr-2"></i> 24/7 SMS Alerts</li>
                    <li><i class="fas fa-check text-green-400 mr-2"></i> Multi-branch Sync</li>
                </ul>
                <a href="<?= base_url('register') ?>" class="block w-full py-5 px-6 bg-green-500 text-slate-950 font-black rounded-2xl text-center hover:bg-green-400 transition-all shadow-xl shadow-green-500/20">Go Pro Now</a>
            </div>

            <!-- Enterprise -->
            <div class="p-10 rounded-[2.5rem] bg-white border border-slate-200">
                <p class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-6">Enterprise</p>
                <div class="mb-8 text-5xl font-black italic">Custom</div>
                <ul class="space-y-4 mb-10 text-slate-500 text-sm">
                    <li><i class="fas fa-check text-green-500 mr-2"></i> Custom Integrations</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i> Personal Account Manager</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i> On-site Training</li>
                </ul>
                <a href="#contact" class="block w-full py-4 px-6 border border-slate-200 text-slate-900 font-bold rounded-2xl text-center hover:bg-slate-50 transition-all">Contact Sales</a>
            </div>
        </div>

        <!-- Final CTA Action Trigger -->
        <div class="mt-32 max-w-5xl mx-auto rounded-[3.5rem] bg-gradient-to-br from-green-600 to-emerald-700 p-16 text-center text-white relative overflow-hidden reveal shadow-2xl shadow-green-900/40">
            <div class="absolute inset-0 z-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 Q 25 50 50 100 Q 75 150 100 100" fill="none" stroke="white" stroke-width="0.5" />
                </svg>
            </div>
            <div class="relative z-10">
                <h2 class="text-4xl md:text-5xl font-bold mb-8 leading-tight tracking-tight max-w-2xl mx-auto"><?= $t['final_cta_title'] ?></h2>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                    <a href="<?= base_url('register') ?>" class="px-12 py-5 bg-white text-green-700 font-black rounded-2xl hover:scale-105 active:scale-95 transition-all shadow-2xl text-lg">Start Free Trial</a>
                    <a href="#demo" class="px-12 py-5 bg-green-800/30 backdrop-blur-md border border-white/20 text-white font-bold rounded-2xl hover:bg-green-800/50 transition-all text-lg">Request Demo</a>
                </div>
                <p class="mt-8 text-sm font-bold opacity-60 uppercase tracking-widest"><?= $t['hero_microtrust'] ?></p>
            </div>
        </div>
    </div>
</section>

<script>
    // Reveal Intersection Observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));

    // Module Filtering Logic
    const filterButtons = document.querySelectorAll('.filter-btn');
    const moduleCards = document.querySelectorAll('.module-card');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update button styles
            filterButtons.forEach(b => {
                b.classList.remove('bg-slate-900', 'text-white', 'shadow-lg', 'shadow-slate-900/10');
                b.classList.add('bg-white', 'text-slate-600', 'border', 'border-slate-200');
            });
            btn.classList.add('bg-slate-900', 'text-white', 'shadow-lg', 'shadow-slate-900/10');
            btn.classList.remove('bg-white', 'text-slate-600', 'border-slate-200');

            const filter = btn.getAttribute('data-filter');

            moduleCards.forEach(card => {
                const category = card.getAttribute('data-category');
                
                if (filter === 'all' || category === filter) {
                    card.classList.remove('hidden-mod');
                    // Re-trigger reveal animation if needed
                    setTimeout(() => card.classList.add('active'), 50);
                } else {
                    card.classList.add('hidden-mod');
                }
            });
        });
    });

    // Simple smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if(target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
</script>
