<?php
$faqs = [
    [
        'id' => '1',
        'question' => 'How long does implementation take?',
        'answer' => 'Implementation typically takes 2-4 weeks depending on your business size and complexity. Our team handles data migration, system configuration, and staff training. Most businesses are fully operational within 30 days.',
        'category' => 'Implementation'
    ],
    [
        'id' => '2',
        'question' => 'Do you provide training for our staff?',
        'answer' => 'Yes! We provide comprehensive on-site and online training for all users. This includes hands-on workshops, video tutorials, and ongoing support. We ensure your team is confident using the system before go-live.',
        'category' => 'Training'
    ],
    [
        'id' => '3',
        'question' => 'What is the typical ROI timeline?',
        'answer' => 'Most clients see positive ROI within 6-9 months through reduced operational costs, fewer inventory errors, and improved efficiency. Our average client saves Rs. 2.4M annually in operational costs.',
        'category' => 'ROI'
    ],
    [
        'id' => '4',
        'question' => 'Can the system handle both local and imported timber?',
        'answer' => 'Absolutely! TimberPro ERP is specifically designed for Sri Lankan timber businesses managing both local sourcing and imported inventory. The system tracks origin, compliance documents, and supplier information for all timber types.',
        'category' => 'Features'
    ],
    [
        'id' => '5',
        'question' => 'What happens if we need technical support?',
        'answer' => 'We offer multiple support channels including phone, email, and WhatsApp. Professional and Enterprise plans include priority support with guaranteed response times. Our local Sri Lankan support team is available during business hours.',
        'category' => 'Support'
    ],
    [
        'id' => '6',
        'question' => 'Is our data secure and backed up?',
        'answer' => 'Yes! We use bank-level encryption and store data in secure Sri Lankan data centers. Automated daily backups ensure your data is always protected. We are fully compliant with local data protection regulations.',
        'category' => 'Security'
    ],
    [
        'id' => '7',
        'question' => 'Can we customize the system for our specific needs?',
        'answer' => 'Yes! Enterprise plans include custom integrations and workflow modifications. We can adapt the system to match your existing processes and integrate with your current tools.',
        'category' => 'Customization'
    ],
    [
        'id' => '8',
        'question' => 'What if we are not satisfied with the system?',
        'answer' => 'We offer a 30-day money-back guarantee. If you are not completely satisfied within the first month, we will provide a full refund. No questions asked.',
        'category' => 'Guarantee'
    ]
];
?>
<section class="py-16 lg:py-24 bg-background" id="faq">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 rounded-full mb-6">
                <?php echo getIcon('QuestionMarkCircleIcon', 'w-5 h-5 text-primary'); ?>
                <span class="font-body text-sm font-medium text-primary">Got Questions?</span>
            </div>
            <h2 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-bold text-foreground mb-4">
                Frequently Asked Questions
            </h2>
            <p class="font-body text-lg text-muted-foreground">
                Find answers to common questions about TimberPro ERP implementation and features.
            </p>
        </div>

        <div class="mb-8">
            <div class="relative">
                <input type="text" id="faq-search" onkeyup="filterFAQ()" placeholder="Search questions..." class="w-full px-6 py-4 pl-12 bg-card border border-border rounded-lg font-body text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground">
                    <?php echo getIcon('MagnifyingGlassIcon', 'w-5 h-5'); ?>
                </div>
            </div>
        </div>

        <div class="space-y-4" id="faq-list">
            <?php foreach ($faqs as $index => $faq): ?>
            <div class="faq-item bg-card rounded-xl border border-border overflow-hidden hover:border-primary/30 transition-all duration-250" data-question="<?php echo strtolower($faq['question']); ?>" data-answer="<?php echo strtolower($faq['answer']); ?>">
                <button onclick="toggleFAQ(<?php echo $index; ?>)" class="w-full px-6 py-5 flex items-center justify-between text-left">
                    <div class="flex-1 pr-4">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="px-2 py-1 bg-primary/10 text-primary font-body text-xs font-medium rounded">
                                <?php echo $faq['category']; ?>
                            </span>
                        </div>
                        <h3 class="font-body text-lg font-semibold text-foreground">
                            <?php echo $faq['question']; ?>
                        </h3>
                    </div>
                    <div class="flex-shrink-0 w-8 h-8 bg-muted rounded-lg flex items-center justify-center">
                        <div id="faq-icon-<?php echo $index; ?>" class="transition-transform duration-200">
                             <?php echo getIcon('ChevronDownIcon', 'w-5 h-5 text-foreground'); ?>
                        </div>
                    </div>
                </button>

                <div id="faq-answer-<?php echo $index; ?>" class="hidden px-6 pb-5 border-t border-border">
                    <p class="font-body text-base text-muted-foreground leading-relaxed pt-4">
                        <?php echo $faq['answer']; ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div id="no-faq-results" class="hidden text-center py-12">
            <div class="w-16 h-16 bg-muted rounded-full flex items-center justify-center mx-auto mb-4">
                <?php echo getIcon('MagnifyingGlassIcon', 'w-8 h-8 text-muted-foreground'); ?>
            </div>
            <h3 class="font-body text-lg font-semibold text-foreground mb-2">No results found</h3>
            <p class="font-body text-sm text-muted-foreground">
                Try adjusting your search query or contact our support team.
            </p>
        </div>

        <div class="mt-12 bg-gradient-to-r from-primary/5 to-accent/5 rounded-2xl p-8 border border-border text-center">
            <h3 class="font-body text-xl font-semibold text-foreground mb-2">
                Still have questions?
            </h3>
            <p class="font-body text-base text-muted-foreground mb-6">
                Our team is here to help. Get in touch and we will answer all your questions.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="window.location.href='tel:+94112345678'" class="px-6 py-3 bg-primary text-primary-foreground font-body font-semibold rounded-lg hover:bg-primary/90 transition-all duration-250 flex items-center justify-center gap-2">
                    <?php echo getIcon('PhoneIcon', 'w-5 h-5'); ?>
                    <span>Call Us</span>
                </button>
                <button onclick="scrollToSection('contact')" class="px-6 py-3 bg-card text-foreground font-body font-semibold rounded-lg border-2 border-border hover:border-primary/30 transition-all duration-250 flex items-center justify-center gap-2">
                    <?php echo getIcon('ChatBubbleLeftRightIcon', 'w-5 h-5'); ?>
                    <span>Live Chat</span>
                </button>
            </div>
        </div>
    </div>
</section>

<script>
function toggleFAQ(index) {
    const answer = document.getElementById('faq-answer-' + index);
    const icon = document.getElementById('faq-icon-' + index);
    
    // Close others
    /* // (Optional: Accordion style - close others when opening one)
    document.querySelectorAll('[id^=faq-answer-]').forEach(el => {
        if(el.id !== 'faq-answer-' + index) el.classList.add('hidden');
    });
    document.querySelectorAll('[id^=faq-icon-]').forEach(el => {
        if(el.id !== 'faq-icon-' + index) el.style.transform = 'rotate(0deg)';
    });
    */

    if (answer.classList.contains('hidden')) {
        answer.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        answer.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

function filterFAQ() {
    const query = document.getElementById('faq-search').value.toLowerCase();
    const items = document.querySelectorAll('.faq-item');
    let hasResults = false;

    items.forEach(item => {
        const question = item.dataset.question;
        const answer = item.dataset.answer;
        
        if (question.includes(query) || answer.includes(query)) {
            item.classList.remove('hidden');
            hasResults = true;
        } else {
            item.classList.add('hidden');
        }
    });

    if (!hasResults) {
        document.getElementById('no-faq-results').classList.remove('hidden');
    } else {
        document.getElementById('no-faq-results').classList.add('hidden');
    }
}
</script>
