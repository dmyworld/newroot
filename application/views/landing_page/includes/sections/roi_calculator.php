<!-- SECTION 7: ROI CALCULATOR - Interactive Tool -->
<section id="roi-calculator" class="py-20 section-white" data-aos="fade-up" data-aos-duration="1000">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <div class="badge-green mb-4 inline-block" data-aos="zoom-in">
                💰 CALCULATE YOUR SAVINGS
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-navy mb-4">
                See How Much <span class="text-green">Money You'll Save</span> with TimberPro
            </h2>
            <p class="text-xl text-secondary max-w-3xl mx-auto">
                Use our interactive calculator to estimate your monthly and yearly savings
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Left: Input Form -->
            <div class="landing-card p-8" data-aos="fade-right">
                <h3 class="text-2xl font-bold text-navy mb-6">Your Business Details</h3>
                
                <div class="space-y-6">
                    <!-- Monthly Revenue -->
                    <div>
                        <label class="block text-navy font-semibold mb-2">Monthly Revenue (LKR)</label>
                        <input type="number" id="monthly-revenue" value="1000000" 
                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:border-blue-400 focus:outline-none"
                               onchange="calculateROI()">
                    </div>

                    <!-- Number of Staff -->
                    <div>
                        <label class="block text-navy font-semibold mb-2">Number of Staff</label>
                        <input type="number" id="staff-count" value="5" 
                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:border-blue-400 focus:outline-none"
                               onchange="calculateROI()">
                    </div>

                    <!-- Stock Value -->
                    <div>
                        <label class="block text-navy font-semibold mb-2">Total Stock Value (LKR)</label>
                        <input type="number" id="stock-value" value="2000000" 
                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:border-blue-400 focus:outline-none"
                               onchange="calculateROI()">
                    </div>

                    <!-- Current System -->
                    <div>
                        <label class="block text-navy font-semibold mb-2">Current System</label>
                        <select id="current-system" 
                                class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:border-blue-400 focus:outline-none"
                                onchange="calculateROI()">
                            <option value="manual">Manual / Excel</option>
                            <option value="basic">Basic Software</option>
                            <option value="none">No System</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Right: Results -->
            <div class="landing-card p-8 bg-gradient-to-br from-green-50 to-blue-50" data-aos="fade-left">
                <h3 class="text-2xl font-bold text-navy mb-6">Your Estimated Savings</h3>
                
                <div class="space-y-6">
                    <!-- Monthly Savings -->
                    <div class="bg-white rounded-lg p-6 border-2 border-green-200">
                        <p class="text-muted-landing text-sm mb-2">Monthly Savings</p>
                        <p class="text-5xl font-bold text-green mb-2" id="monthly-savings">LKR 173,000</p>
                        <p class="text-sm text-secondary">from prevented losses & increased efficiency</p>
                    </div>

                    <!-- Yearly Savings -->
                    <div class="bg-white rounded-lg p-6 border-2 border-blue-200">
                        <p class="text-muted-landing text-sm mb-2">Yearly Savings</p>
                        <p class="text-5xl font-bold text-blue mb-2" id="yearly-savings">LKR 2,076,000</p>
                        <p class="text-sm text-secondary">total profit protection per year</p>
                    </div>

                    <!-- ROI -->
                    <div class="bg-white rounded-lg p-6 border-2 border-green-200">
                        <p class="text-muted-landing text-sm mb-2">Return on Investment (ROI)</p>
                        <p class="text-5xl font-bold text-green mb-2" id="roi-percentage">693%</p>
                        <p class="text-sm text-secondary">TimberPro pays for itself in <strong id="payback-period">4 days</strong></p>
                    </div>

                    <!-- Breakdown -->
                    <div class="bg-white rounded-lg p-6">
                        <h4 class="font-bold text-navy mb-4">Savings Breakdown:</h4>
                        <ul class="space-y-3 text-sm">
                            <li class="flex justify-between">
                                <span class="text-secondary">Theft Prevention</span>
                                <span class="font-bold text-green" id="theft-savings">LKR 50,000</span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-secondary">Fraud Elimination</span>
                                <span class="font-bold text-green" id="fraud-savings">LKR 42,000</span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-secondary">Time Savings</span>
                                <span class="font-bold text-green" id="time-savings">LKR 35,000</span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-secondary">Marketplace Revenue</span>
                                <span class="font-bold text-green" id="marketplace-revenue">LKR 46,000</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center mt-12">
            <a href="<?php echo base_url('hub/register_seller'); ?>" class="btn-success-green inline-block text-lg px-12 py-6">
                Start Saving Money Today →
            </a>
            <p class="text-muted-landing mt-4">
                Join 850+ businesses already saving with TimberPro
            </p>
        </div>
    </div>
</section>

<script>
function calculateROI() {
    const revenue = parseFloat(document.getElementById('monthly-revenue').value) || 1000000;
    const staff = parseInt(document.getElementById('staff-count').value) || 5;
    const stock = parseFloat(document.getElementById('stock-value').value) || 2000000;
    const system = document.getElementById('current-system').value;
    
    // Calculate savings based on business size
    const theftSavings = Math.round(stock * 0.025); // 2.5% of stock value
    const fraudSavings = Math.round(revenue * 0.042); // 4.2% of revenue
    const timeSavings = staff * 7000; // LKR 7K per staff member
    const marketplaceRevenue = Math.round(revenue * 0.046); // 4.6% revenue increase
    
    // System multiplier
    let multiplier = 1.0;
    if (system === 'basic') multiplier = 0.7;
    if (system === 'manual') multiplier = 1.0;
    if (system === 'none') multiplier = 1.2;
    
    const monthlySavings = Math.round((theftSavings + fraudSavings + timeSavings + marketplaceRevenue) * multiplier);
    const yearlySavings = monthlySavings * 12;
    const timberproCost = 25000; // Professional plan
    const roi = Math.round((monthlySavings / timberproCost) * 100);
    const paybackDays = Math.round((timberproCost / monthlySavings) * 30);
    
    // Update UI
    document.getElementById('monthly-savings').textContent = `LKR ${monthlySavings.toLocaleString()}`;
    document.getElementById('yearly-savings').textContent = `LKR ${yearlySavings.toLocaleString()}`;
    document.getElementById('roi-percentage').textContent = `${roi}%`;
    document.getElementById('payback-period').textContent = `${paybackDays} days`;
    
    document.getElementById('theft-savings').textContent = `LKR ${Math.round(theftSavings * multiplier).toLocaleString()}`;
    document.getElementById('fraud-savings').textContent = `LKR ${Math.round(fraudSavings * multiplier).toLocaleString()}`;
    document.getElementById('time-savings').textContent = `LKR ${Math.round(timeSavings * multiplier).toLocaleString()}`;
    document.getElementById('marketplace-revenue').textContent = `LKR ${Math.round(marketplaceRevenue * multiplier).toLocaleString()}`;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', calculateROI);
</script>
