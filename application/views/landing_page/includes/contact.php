<?php
$contactInfo = [
    ['icon' => 'PhoneIcon', 'title' => 'Phone', 'value' => '+94 11 234 5678', 'link' => 'tel:+94112345678'],
    ['icon' => 'EnvelopeIcon', 'title' => 'Email', 'value' => 'info@timberpro.lk', 'link' => 'mailto:info@timberpro.lk'],
    ['icon' => 'MapPinIcon', 'title' => 'Office', 'value' => '123 Galle Road, Colombo 03, Sri Lanka', 'link' => 'https://maps.google.com/?q=6.9271,79.8612'],
    ['icon' => 'ClockIcon', 'title' => 'Business Hours', 'value' => 'Mon-Fri: 9:00 AM - 6:00 PM', 'link' => null]
];
?>
<section id="contact" class="py-16 lg:py-24 bg-muted">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-accent/10 border border-accent/20 rounded-full mb-6">
                <?php echo getIcon('ChatBubbleLeftRightIcon', 'w-5 h-5 text-accent'); ?>
                <span class="font-body text-sm font-medium text-accent">Get In Touch</span>
            </div>
            <h2 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-bold text-foreground mb-4">
                Ready to Transform Your Business?
            </h2>
            <p class="font-body text-lg text-muted-foreground max-w-3xl mx-auto">
                Schedule your free demo today and see how TimberPro ERP can revolutionize your timber operations.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            <div>
                <div class="bg-card rounded-2xl p-8 border border-border mb-8">
                    <h3 class="font-body text-xl font-semibold text-foreground mb-6">
                        Contact Information
                    </h3>
                    <div class="space-y-6">
                        <?php foreach ($contactInfo as $info): ?>
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                <?php echo getIcon($info['icon'], 'w-6 h-6 text-primary'); ?>
                            </div>
                            <div>
                                <div class="font-body text-sm text-muted-foreground mb-1"><?php echo $info['title']; ?></div>
                                <?php if ($info['link']): ?>
                                    <a href="<?php echo $info['link']; ?>" class="font-body text-base font-semibold text-foreground hover:text-primary transition-colors duration-250">
                                        <?php echo $info['value']; ?>
                                    </a>
                                <?php else: ?>
                                    <div class="font-body text-base font-semibold text-foreground"><?php echo $info['value']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-primary to-primary/80 rounded-2xl p-8 text-primary-foreground">
                    <h3 class="font-body text-xl font-semibold mb-4">
                        Risk-Free Trial Guarantee
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <?php echo getIcon('CheckCircleIcon', 'w-6 h-6 flex-shrink-0 mt-0.5'); ?>
                            <p class="font-body text-sm">30-day money-back guarantee</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <?php echo getIcon('CheckCircleIcon', 'w-6 h-6 flex-shrink-0 mt-0.5'); ?>
                            <p class="font-body text-sm">Free implementation support</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <?php echo getIcon('CheckCircleIcon', 'w-6 h-6 flex-shrink-0 mt-0.5'); ?>
                            <p class="font-body text-sm">Comprehensive staff training included</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <?php echo getIcon('CheckCircleIcon', 'w-6 h-6 flex-shrink-0 mt-0.5'); ?>
                            <p class="font-body text-sm">Local Sri Lankan support team</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-card rounded-2xl p-8 border border-border">
                <h3 class="font-body text-xl font-semibold text-foreground mb-6">
                    Request Your Free Demo
                </h3>

                <div id="contact-success" class="text-center py-12 hidden">
                    <div class="w-20 h-20 bg-success/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <?php echo getIcon('CheckCircleIcon', 'w-12 h-12 text-success'); ?>
                    </div>
                    <h4 class="font-body text-2xl font-semibold text-foreground mb-2">
                        Thank You!
                    </h4>
                    <p class="font-body text-base text-muted-foreground mb-6">
                        We have received your demo request. Our team will contact you within 24 hours to schedule your personalized demonstration.
                    </p>
                    <button onclick="resetContactForm()" class="px-6 py-3 bg-primary text-primary-foreground font-body font-semibold rounded-lg hover:bg-primary/90 transition-all duration-250">
                        Submit Another Request
                    </button>
                </div>

                <form id="contact-form" onsubmit="submitContactForm(event)" class="space-y-6">
                    <div>
                        <label for="name" class="block font-body text-sm font-medium text-foreground mb-2">Full Name *</label>
                        <input type="text" id="name" name="name" required class="w-full px-4 py-3 bg-background border border-border rounded-lg font-body text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your full name">
                    </div>

                    <div>
                        <label for="email" class="block font-body text-sm font-medium text-foreground mb-2">Email Address *</label>
                        <input type="email" id="email" name="email" required class="w-full px-4 py-3 bg-background border border-border rounded-lg font-body text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary" placeholder="your.email@company.com">
                    </div>

                    <div>
                        <label for="phone" class="block font-body text-sm font-medium text-foreground mb-2">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" required class="w-full px-4 py-3 bg-background border border-border rounded-lg font-body text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary" placeholder="0771234567">
                    </div>

                    <div>
                        <label for="company" class="block font-body text-sm font-medium text-foreground mb-2">Company Name *</label>
                        <input type="text" id="company" name="company" required class="w-full px-4 py-3 bg-background border border-border rounded-lg font-body text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Your company name">
                    </div>

                    <div>
                        <label for="message" class="block font-body text-sm font-medium text-foreground mb-2">Message (Optional)</label>
                        <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 bg-background border border-border rounded-lg font-body text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary resize-none" placeholder="Tell us about your timber business needs..."></textarea>
                    </div>

                    <button type="submit" id="submit-btn" class="w-full px-6 py-4 bg-accent text-accent-foreground font-cta font-bold text-lg rounded-lg shadow-cta hover:bg-accent/90 transition-all duration-250 flex items-center justify-center gap-2">
                        <span>Request Free Demo</span>
                        <?php echo getIcon('ArrowRightIcon', 'w-5 h-5'); ?>
                    </button>
                    
                    <p class="font-body text-xs text-center text-muted-foreground">
                        By submitting this form, you agree to our privacy policy and terms of service.
                    </p>
                </form>
            </div>
        </div>

        <div class="mt-12 bg-card rounded-2xl overflow-hidden border border-border">
            <iframe width="100%" height="400" loading="lazy" title="TimberPro ERP Office Location" src="https://www.google.com/maps?q=6.9271,79.8612&z=14&output=embed" class="w-full"></iframe>
        </div>
    </div>
</section>

<script>
function submitContactForm(e) {
    e.preventDefault();
    const btn = document.getElementById('submit-btn');
    const originalContent = btn.innerHTML;
    
    // Simulate loading
    btn.disabled = true;
    btn.innerHTML = '<?php echo getIcon("ArrowPathIcon", "w-5 h-5 animate-spin"); ?> <span>Submitting...</span>';
    
    setTimeout(() => {
        document.getElementById('contact-form').classList.add('hidden');
        document.getElementById('contact-success').classList.remove('hidden');
        btn.disabled = false;
        btn.innerHTML = originalContent; // Reset button content for next time (though hidden)
    }, 1500);
}

function resetContactForm() {
    document.getElementById('contact-form').reset();
    document.getElementById('contact-success').classList.add('hidden');
    document.getElementById('contact-form').classList.remove('hidden');
}
</script>
