
<main class="overflow-x-hidden bg-[rgb(20,21,24)]">
    
    <!-- SECTION 1: HERO - Attention & Desire -->
    <?php include 'includes/sections/hero.php'; ?>
    
    <!-- SECTION 2: TRUST BUILDERS - Credibility -->
    <?php include 'includes/sections/trust_bar.php'; ?>
    
    <!-- SECTION 3: PROBLEM AGITATION - Pain Points -->
    <?php include 'includes/sections/problem_agitation.php'; ?>
    
    <!-- SECTION 4: SOLUTION OVERVIEW - Value Proposition -->
    <?php include 'includes/sections/solution_overview.php'; ?>
    
    <!-- SECTION 5: TIMBERPRO MARKETPLACE - Star Feature -->
    <?php include 'includes/sections/marketplace_highlight.php'; ?>
    
    <!-- SECTION 6: MODULES SHOWCASE - All Features -->
    <?php include 'includes/sections/modules_grid.php'; ?>
    
    <!-- SECTION 7: ROI CALCULATOR - Proof of Value -->
    <?php include 'includes/sections/roi_calculator.php'; ?>
    
    <!-- SECTION 8: HOW IT WORKS - Process -->
    <?php include 'includes/sections/how_it_works.php'; ?>
    
    <!-- SECTION 9: SOCIAL PROOF - Testimonials -->
    <?php include 'includes/sections/testimonials.php'; ?>
    
    <!-- SECTION 10: COMPARISON - Why Us -->
    <?php include 'includes/sections/comparison_table.php'; ?>
    
    <!-- SECTION 11: PRICING - Transparency -->
    <?php include 'includes/sections/pricing_tiers.php'; ?>
    
    <!-- SECTION 12: FAQ - Objection Handling -->
    <?php include 'includes/sections/faq_accordion.php'; ?>
    
    <!-- SECTION 13: FINAL CTA - Last Chance -->
    <?php include 'includes/sections/final_cta.php'; ?>
    
    <!-- FLOATING ELEMENTS -->
    <?php include 'includes/floating.php'; ?>
    
</main>



<style>
/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Section spacing */
main > section {
    scroll-margin-top: 80px; /* Account for fixed header */
}

/* Fade-in animation for sections */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-section {
    animation: fadeInUp 0.6s ease-out;
}

/* Pulse animation for CTAs */
@keyframes pulse-glow {
    0%, 100% {
        box-shadow: 0 0 20px rgba(19, 236, 91, 0.4);
    }
    50% {
        box-shadow: 0 0 40px rgba(19, 236, 91, 0.6);
    }
}

.cta-pulse {
    animation: pulse-glow 2s infinite;
}
</style>

<script>
// Intersection Observer for fade-in animations
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-section');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });
    
    // Observe all sections
    document.querySelectorAll('main > section').forEach(section => {
        observer.observe(section);
    });
});

// Smooth scroll to sections
function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    // Close mobile menu if open
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
        toggleMobileMenu();
    }
}

// Track scroll depth for analytics
let maxScroll = 0;
window.addEventListener('scroll', function() {
    const scrollPercent = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
    if (scrollPercent > maxScroll) {
        maxScroll = Math.round(scrollPercent);
        // Send to analytics (implement when ready)
        // gtag('event', 'scroll_depth', { 'value': maxScroll });
    }
});
</script>
