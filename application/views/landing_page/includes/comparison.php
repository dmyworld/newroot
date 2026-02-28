<?php
$comparisonData = [
    'cost' => [
        ['category' => 'Cost Efficiency', 'feature' => 'Initial Setup Cost', 'manual' => ['status' => 'poor', 'description' => 'High labor costs for manual record-keeping staff'], 'competitors' => ['status' => 'poor', 'description' => 'LKR 500,000+ setup fees + customization charges'], 'timberPro' => ['status' => 'excellent', 'description' => 'Starting from LKR 45,000/month - No setup fees', 'advantage' => '40% lower cost']],
        ['category' => 'Cost Efficiency', 'feature' => 'Operational Costs', 'manual' => ['status' => 'poor', 'description' => 'Multiple staff needed, paper costs, storage space'], 'competitors' => ['status' => 'limited', 'description' => 'High per-user licensing + maintenance contracts'], 'timberPro' => ['status' => 'excellent', 'description' => 'Flat monthly rate, unlimited users included', 'advantage' => 'Save LKR 200,000+ annually']],
        ['category' => 'Cost Efficiency', 'feature' => 'Error-Related Losses', 'manual' => ['status' => 'poor', 'description' => 'Frequent errors cost 5-10% of revenue annually'], 'competitors' => ['status' => 'limited', 'description' => 'Generic systems miss timber-specific validations'], 'timberPro' => ['status' => 'excellent', 'description' => 'Built-in timber validations prevent costly mistakes', 'advantage' => 'Reduce losses by 85%']],
        ['category' => 'Cost Efficiency', 'feature' => 'Training & Support', 'manual' => ['status' => 'none', 'description' => 'No structured training, knowledge loss on turnover'], 'competitors' => ['status' => 'limited', 'description' => 'Expensive training sessions, limited local support'], 'timberPro' => ['status' => 'full', 'description' => 'Free training in Sinhala/Tamil, 24/7 local support', 'advantage' => 'Zero training costs']]
    ],
    'speed' => [
        ['category' => 'Processing Speed', 'feature' => 'Inventory Updates', 'manual' => ['status' => 'poor', 'description' => '2-3 days delay for manual ledger updates'], 'competitors' => ['status' => 'partial', 'description' => 'Real-time but requires manual data entry'], 'timberPro' => ['status' => 'excellent', 'description' => 'Instant automated updates with barcode scanning', 'advantage' => '60% faster processing']],
        ['category' => 'Processing Speed', 'feature' => 'Order Processing', 'manual' => ['status' => 'poor', 'description' => '4-6 hours per order with phone calls & paperwork'], 'competitors' => ['status' => 'limited', 'description' => '1-2 hours with generic workflows'], 'timberPro' => ['status' => 'excellent', 'description' => '15 minutes with timber-specific templates', 'advantage' => '75% time reduction']],
        ['category' => 'Processing Speed', 'feature' => 'Report Generation', 'manual' => ['status' => 'poor', 'description' => '2-3 days to compile monthly reports manually'], 'competitors' => ['status' => 'partial', 'description' => 'Automated but requires data cleanup first'], 'timberPro' => ['status' => 'excellent', 'description' => 'Instant reports with one click, always accurate', 'advantage' => 'Real-time insights']],
        ['category' => 'Processing Speed', 'feature' => 'Supplier Communication', 'manual' => ['status' => 'poor', 'description' => 'Phone calls, emails, manual follow-ups'], 'competitors' => ['status' => 'limited', 'description' => 'Email integration only, no local language support'], 'timberPro' => ['status' => 'excellent', 'description' => 'Automated POs in Sinhala/English, SMS alerts', 'advantage' => '90% faster communication']]
    ],
    'compliance' => [
        ['category' => 'Regulatory Compliance', 'feature' => 'Sri Lankan Tax Compliance', 'manual' => ['status' => 'poor', 'description' => 'Manual VAT calculations, frequent errors'], 'competitors' => ['status' => 'limited', 'description' => 'Generic tax modules, not Sri Lanka-specific'], 'timberPro' => ['status' => 'excellent', 'description' => 'Built-in IRD compliance, automated VAT/NBT', 'advantage' => '100% tax accuracy']],
        ['category' => 'Regulatory Compliance', 'feature' => 'Timber Import Documentation', 'manual' => ['status' => 'poor', 'description' => 'Paper-based, missing documents cause delays'], 'competitors' => ['status' => 'none', 'description' => 'No timber-specific import tracking'], 'timberPro' => ['status' => 'excellent', 'description' => 'Digital customs docs, phytosanitary certificates', 'advantage' => 'Zero compliance issues']],
        ['category' => 'Regulatory Compliance', 'feature' => 'Local Sourcing Permits', 'manual' => ['status' => 'poor', 'description' => 'Spreadsheets, expired permits go unnoticed'], 'competitors' => ['status' => 'none', 'description' => 'No Forest Department permit tracking'], 'timberPro' => ['status' => 'excellent', 'description' => 'Automated permit expiry alerts, digital storage', 'advantage' => 'Prevent legal penalties']],
        ['category' => 'Regulatory Compliance', 'feature' => 'Audit Trail', 'manual' => ['status' => 'none', 'description' => 'No transaction history, audit nightmares'], 'competitors' => ['status' => 'partial', 'description' => 'Basic logs, not timber-transaction specific'], 'timberPro' => ['status' => 'full', 'description' => 'Complete audit trail for every timber movement', 'advantage' => 'Pass audits effortlessly']]
    ]
];

function getStatusIcon($status) {
    switch ($status) {
        case 'excellent': case 'full':
            return ['icon' => 'CheckCircleIcon', 'color' => 'text-green-600'];
        case 'partial': case 'limited':
            return ['icon' => 'ExclamationTriangleIcon', 'color' => 'text-yellow-600'];
        case 'poor': case 'none':
            return ['icon' => 'XCircleIcon', 'color' => 'text-red-600'];
        default:
            return ['icon' => 'MinusCircleIcon', 'color' => 'text-gray-400'];
    }
}
?>
<section id="comparison" class="py-20 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Why TimberPro Outperforms the Competition
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                See how TimberPro delivers superior value compared to manual processes and generic ERP systems
            </p>
        </div>

        <div class="mb-12 rounded-2xl overflow-hidden shadow-2xl">
            <img src="assets/images/ERP_interface-1767410714316.jpg" alt="TimberPro ERP interface" class="w-full h-auto">
        </div>

        <div class="flex flex-wrap justify-center gap-4 mb-12">
            <button onclick="switchComparisonTab('cost')" id="comp-tab-cost" class="comp-tab active flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all bg-blue-600 text-white shadow-lg scale-105">
                <?php echo getIcon('CurrencyDollarIcon', 'w-5 h-5'); ?>
                Cost Savings
            </button>
            <button onclick="switchComparisonTab('speed')" id="comp-tab-speed" class="comp-tab flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all bg-white text-gray-700 hover:bg-gray-100 shadow">
                <?php echo getIcon('BoltIcon', 'w-5 h-5'); ?>
                Speed & Efficiency
            </button>
            <button onclick="switchComparisonTab('compliance')" id="comp-tab-compliance" class="comp-tab flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all bg-white text-gray-700 hover:bg-gray-100 shadow">
                <?php echo getIcon('ShieldCheckIcon', 'w-5 h-5'); ?>
                Compliance
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                <div class="p-6 font-bold text-lg border-r border-blue-500">Feature</div>
                <div class="p-6 font-bold text-lg border-r border-blue-500">Manual Process</div>
                <div class="p-6 font-bold text-lg border-r border-blue-500">Generic ERP Systems</div>
                <div class="p-6 font-bold text-lg bg-blue-800">TimberPro ERP</div>
            </div>

            <div class="divide-y divide-gray-200">
                <?php foreach ($comparisonData as $tabId => $items): ?>
                <div id="comp-content-<?php echo $tabId; ?>" class="comp-content <?php echo $tabId === 'cost' ? '' : 'hidden'; ?>">
                    <?php foreach ($items as $item): 
                        $manual = getStatusIcon($item['manual']['status']);
                        $comp = getStatusIcon($item['competitors']['status']);
                        $timber = getStatusIcon($item['timberPro']['status']);
                    ?>
                    <div class="grid grid-cols-1 md:grid-cols-4 hover:bg-gray-50 transition-colors border-b border-gray-200 last:border-0">
                        <div class="p-6 font-semibold text-gray-900 border-r border-gray-200 bg-gray-50">
                            <?php echo $item['feature']; ?>
                        </div>
                        <div class="p-6 border-r border-gray-200">
                            <div class="flex items-start gap-2 mb-2">
                                <?php echo getIcon($manual['icon'], 'w-5 h-5 flex-shrink-0 mt-0.5 ' . $manual['color']); ?>
                                <span class="text-sm text-gray-700"><?php echo $item['manual']['description']; ?></span>
                            </div>
                        </div>
                        <div class="p-6 border-r border-gray-200">
                            <div class="flex items-start gap-2 mb-2">
                                <?php echo getIcon($comp['icon'], 'w-5 h-5 flex-shrink-0 mt-0.5 ' . $comp['color']); ?>
                                <span class="text-sm text-gray-700"><?php echo $item['competitors']['description']; ?></span>
                            </div>
                        </div>
                        <div class="p-6 bg-blue-50">
                            <div class="flex items-start gap-2 mb-2">
                                <?php echo getIcon($timber['icon'], 'w-5 h-5 flex-shrink-0 mt-0.5 ' . $timber['color']); ?>
                                <span class="text-sm text-gray-900 font-medium">
                                    <?php echo $item['timberPro']['description']; ?>
                                </span>
                            </div>
                            <div class="mt-2 inline-block bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">
                                ✓ <?php echo $item['timberPro']['advantage']; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center gap-3 mb-2">
                    <?php echo getIcon('CurrencyDollarIcon', 'w-8 h-8'); ?>
                    <h3 class="text-2xl font-bold">40% Cost Reduction</h3>
                </div>
                <p class="text-green-100">Save LKR 200,000+ annually compared to competitors</p>
            </div>
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center gap-3 mb-2">
                    <?php echo getIcon('BoltIcon', 'w-8 h-8'); ?>
                    <h3 class="text-2xl font-bold">60% Faster Processing</h3>
                </div>
                <p class="text-blue-100">Process orders and inventory in minutes, not days</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center gap-3 mb-2">
                    <?php echo getIcon('ShieldCheckIcon', 'w-8 h-8'); ?>
                    <h3 class="text-2xl font-bold">100% Compliance</h3>
                </div>
                <p class="text-purple-100">Built-in Sri Lankan regulations and timber standards</p>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-lg text-gray-700 mb-6">
                Join 50+ Sri Lankan timber businesses already saving time and money with TimberPro
            </p>
            <button onclick="scrollToSection('contact')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg shadow-lg transition-all hover:scale-105">
                Request Your Free Demo Today
            </button>
        </div>
    </div>
</section>
