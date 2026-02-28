<section id="roi-calculator" class="py-20 bg-[rgb(31,32,36)]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Calculate Your <span class="text-[#13ec5b]">Savings</span>
            </h2>
            <p class="text-xl text-gray-400">
                See how much money you're losing every month - and how TimberPro can stop it.
            </p>
        </div>

        <div class="bg-gradient-to-br from-[rgb(40,42,46)] to-[rgb(30,31,34)] border border-gray-700 rounded-2xl p-8 shadow-2xl">
            <!-- Input Section -->
            <div class="mb-8">
                <label class="block text-white font-semibold mb-3 text-lg">
                    What's your monthly revenue? (LKR)
                </label>
                <input 
                    type="number" 
                    id="monthly-revenue" 
                    class="w-full px-6 py-4 bg-[rgb(50,52,56)] border-2 border-gray-600 rounded-lg text-white text-2xl font-bold focus:border-[#13ec5b] focus:outline-none transition-all"
                    placeholder="500,000"
                    value="500000"
                    oninput="calculateROI()"
                >
            </div>

            <!-- Results Section -->
            <div id="roi-results" class="space-y-6">
                <!-- Stock Theft/Loss -->
                <div class="bg-red-900/20 border border-red-500/30 rounded-lg p-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-300 font-medium">Stock Theft & Wastage (5-10%)</span>
                        <span class="text-red-400 text-2xl font-bold" id="theft-loss">LKR 37,500</span>
                    </div>
                    <div class="text-sm text-gray-500">Industry average: 7.5% of revenue lost to theft and wastage</div>
                </div>

                <!-- Staff Fraud -->
                <div class="bg-red-900/20 border border-red-500/30 rounded-lg p-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-300 font-medium">Staff Fraud & Errors (3-5%)</span>
                        <span class="text-red-400 text-2xl font-bold" id="fraud-loss">LKR 20,000</span>
                    </div>
                    <div class="text-sm text-gray-500">Pricing errors, fake invoices, unauthorized discounts</div>
                </div>

                <!-- Time Wastage -->
                <div class="bg-red-900/20 border border-red-500/30 rounded-lg p-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-300 font-medium">Manual Work Time (20+ hours/week)</span>
                        <span class="text-red-400 text-2xl font-bold" id="time-loss">LKR 40,000</span>
                    </div>
                    <div class="text-sm text-gray-500">Staff time wasted on paperwork instead of selling</div>
                </div>

                <!-- Poor Pricing -->
                <div class="bg-red-900/20 border border-red-500/30 rounded-lg p-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-300 font-medium">Lost Sales (No Marketplace Access)</span>
                        <span class="text-red-400 text-2xl font-bold" id="pricing-loss">LKR 25,000</span>
                    </div>
                    <div class="text-sm text-gray-500">Selling below market price, missing premium buyers</div>
                </div>

                <!-- Total Loss -->
                <div class="bg-gradient-to-r from-red-900/40 to-red-800/40 border-2 border-red-500 rounded-xl p-6 mt-8">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-gray-300 text-lg font-semibold mb-1">Total Monthly Loss</div>
                            <div class="text-gray-500 text-sm">Money disappearing from your business</div>
                        </div>
                        <div class="text-right">
                            <div class="text-red-400 text-4xl font-bold" id="total-loss">LKR 122,500</div>
                            <div class="text-red-300 text-sm mt-1" id="yearly-loss">LKR 1,470,000/year</div>
                        </div>
                    </div>
                </div>

                <!-- Savings with TimberPro -->
                <div class="bg-gradient-to-r from-[#13ec5b]/20 to-[#13ec5b]/10 border-2 border-[#13ec5b] rounded-xl p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-white text-lg font-semibold mb-1">💰 Your Savings with TimberPro</div>
                            <div class="text-gray-400 text-sm">Stop 80% of losses + Earn 15% more from marketplace</div>
                        </div>
                        <div class="text-right">
                            <div class="text-[#13ec5b] text-4xl font-bold" id="savings">LKR 173,000</div>
                            <div class="text-[#13ec5b] text-sm mt-1" id="yearly-savings">LKR 2,076,000/year</div>
                        </div>
                    </div>
                </div>

                <!-- ROI -->
                <div class="text-center mt-8 p-6 bg-[rgb(50,52,56)] rounded-lg">
                    <div class="text-gray-400 text-sm mb-2">Return on Investment (ROI)</div>
                    <div class="text-white text-3xl font-bold mb-2" id="roi-percentage">3,460%</div>
                    <div class="text-gray-500 text-sm">TimberPro pays for itself in <span class="text-[#13ec5b] font-bold" id="payback-days">2 days</span></div>
                </div>
            </div>

            <!-- CTA -->
            <div class="mt-10 text-center">
                <a href="<?php echo base_url('hub/register_seller'); ?>" class="inline-block px-10 py-5 bg-[#13ec5b] text-black font-bold text-xl rounded-lg shadow-2xl hover:bg-[#10d050] transition-all transform hover:scale-105">
                    Stop Losing Money - Start Free Trial →
                </a>
                <p class="text-gray-500 text-sm mt-4">
                    ✓ No credit card required  ✓ Full access to all 15 modules  ✓ Cancel anytime
                </p>
            </div>
        </div>
    </div>
</section>

<script>
function calculateROI() {
    const revenue = parseFloat(document.getElementById('monthly-revenue').value) || 0;
    
    // Calculate losses
    const theftLoss = revenue * 0.075; // 7.5%
    const fraudLoss = revenue * 0.04; // 4%
    const timeLoss = revenue * 0.08; // 8% (20 hours/week opportunity cost)
    const pricingLoss = revenue * 0.05; // 5%
    
    const totalLoss = theftLoss + fraudLoss + timeLoss + pricingLoss;
    const yearlyLoss = totalLoss * 12;
    
    // Calculate savings (80% of losses prevented + 15% revenue increase from marketplace)
    const lossReduction = totalLoss * 0.8;
    const marketplaceGain = revenue * 0.15;
    const totalSavings = lossReduction + marketplaceGain;
    const yearlySavings = totalSavings * 12;
    
    // Calculate ROI (assuming LKR 5,000/month subscription)
    const monthlyCost = 5000;
    const netSavings = totalSavings - monthlyCost;
    const roi = (netSavings / monthlyCost) * 100;
    const paybackDays = Math.ceil((monthlyCost / totalSavings) * 30);
    
    // Update UI
    document.getElementById('theft-loss').textContent = `LKR ${formatNumber(theftLoss)}`;
    document.getElementById('fraud-loss').textContent = `LKR ${formatNumber(fraudLoss)}`;
    document.getElementById('time-loss').textContent = `LKR ${formatNumber(timeLoss)}`;
    document.getElementById('pricing-loss').textContent = `LKR ${formatNumber(pricingLoss)}`;
    document.getElementById('total-loss').textContent = `LKR ${formatNumber(totalLoss)}`;
    document.getElementById('yearly-loss').textContent = `LKR ${formatNumber(yearlyLoss)}/year`;
    document.getElementById('savings').textContent = `LKR ${formatNumber(totalSavings)}`;
    document.getElementById('yearly-savings').textContent = `LKR ${formatNumber(yearlySavings)}/year`;
    document.getElementById('roi-percentage').textContent = `${formatNumber(roi)}%`;
    document.getElementById('payback-days').textContent = `${paybackDays} days`;
}

function formatNumber(num) {
    return Math.round(num).toLocaleString('en-US');
}

// Calculate on page load
document.addEventListener('DOMContentLoaded', calculateROI);
</script>
