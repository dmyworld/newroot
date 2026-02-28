function scrollToSection(id) {
    const element = document.getElementById(id);
    if (element) {
        const offsetTop = element.getBoundingClientRect().top + window.scrollY - 80;
        window.scrollTo({
            top: offsetTop,
            behavior: 'smooth'
        });
    }
}

function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('menu-icon-open');
    const iconClose = document.getElementById('menu-icon-close');

    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        iconOpen.classList.add('hidden');
        iconClose.classList.remove('hidden');
    } else {
        menu.classList.add('hidden');
        iconOpen.classList.remove('hidden');
        iconClose.classList.add('hidden');
    }
}

function toggleLanguage() {
    const textElements = document.querySelectorAll('#lang-text, .mobile-lang-text');
    textElements.forEach(el => {
        if (el.innerText === 'English') {
            el.innerText = 'සිංහල';
        } else {
            el.innerText = 'English';
        }
    });

    const current = textElements[0].innerText === 'English' ? 'en' : 'si';
    localStorage.setItem('language', current);
}

function animateCounters() {
    const targets = {
        inventoryErrors: 35,
        timeLost: 20,
        profitLoss: 15
    };
    const duration = 2000;
    const steps = 60;
    const interval = duration / steps;

    let currentStep = 0;
    const timer = setInterval(() => {
        currentStep++;
        const progress = currentStep / steps;

        const el1 = document.getElementById('counter-inventory');
        const el2 = document.getElementById('counter-time');
        const el3 = document.getElementById('counter-profit');

        if (el1) el1.innerText = Math.floor(targets.inventoryErrors * progress) + '%';
        if (el2) el2.innerText = Math.floor(targets.timeLost * progress) + 'h';
        if (el3) el3.innerText = Math.floor(targets.profitLoss * progress) + '%';

        if (currentStep >= steps) {
            clearInterval(timer);
            if (el1) el1.innerText = '35%';
            if (el2) el2.innerText = '20h';
            if (el3) el3.innerText = '15%';
        }
    }, interval);
}

function switchSolution(index) {
    document.querySelectorAll('.solution-btn').forEach(btn => {
        const btnIndex = parseInt(btn.dataset.index);
        const iconContainer = btn.querySelector('.solution-icon-container');
        const icon = btn.querySelector('.solution-icon');
        const desc = btn.querySelector('.solution-desc');

        if (btnIndex === index) {
            btn.className = "solution-btn p-6 rounded-xl border-2 transition-all duration-250 text-left bg-primary text-primary-foreground border-primary shadow-lg scale-105";
            iconContainer.className = "solution-icon-container w-14 h-14 rounded-lg flex items-center justify-center mb-4 bg-primary-foreground/20";
            icon.className = "solution-icon text-primary-foreground";
            desc.className = "solution-desc font-body text-sm text-primary-foreground/80";
        } else {
            btn.className = "solution-btn p-6 rounded-xl border-2 transition-all duration-250 text-left bg-card text-foreground border-border hover:border-primary/30";
            iconContainer.className = "solution-icon-container w-14 h-14 rounded-lg flex items-center justify-center mb-4 bg-primary/10";
            icon.className = "solution-icon text-primary";
            desc.className = "solution-desc font-body text-sm text-muted-foreground";
        }
    });

    document.querySelectorAll('.solution-content').forEach(el => el.classList.add('hidden'));
    const content = document.getElementById('solution-content-' + index);
    if (content) content.classList.remove('hidden');
}

// Demo Section Logic
let demoInterval;
let isDemoAutoPlaying = true;
let currentDemoIndex = 0;
const totalDemoScreens = 5;

function switchDemoScreen(index) {
    currentDemoIndex = index;
    // Update dots
    document.querySelectorAll('.demo-dot').forEach(dot => {
        if (parseInt(dot.dataset.index) === index) {
            dot.classList.remove('w-2', 'bg-border');
            dot.classList.add('w-8', 'bg-primary');
        } else {
            dot.classList.remove('w-8', 'bg-primary');
            dot.classList.add('w-2', 'bg-border');
        }
    });

    // Update thumbnails
    document.querySelectorAll('.demo-thumb-btn').forEach(btn => {
        const desc = btn.querySelector('.demo-thumb-desc');
        if (parseInt(btn.dataset.index) === index) {
            btn.className = "demo-thumb-btn p-4 rounded-xl border-2 transition-all duration-250 text-center bg-primary text-primary-foreground border-primary";
            desc.className = "demo-thumb-desc font-body text-xs text-primary-foreground/80";
        } else {
            btn.className = "demo-thumb-btn p-4 rounded-xl border-2 transition-all duration-250 text-center bg-card text-foreground border-border hover:border-primary/30";
            desc.className = "demo-thumb-desc font-body text-xs text-muted-foreground";
        }
    });

    // Update Content
    document.querySelectorAll('.demo-img').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.demo-content').forEach(el => el.classList.add('hidden'));

    document.getElementById('demo-img-' + index).classList.remove('hidden');
    document.getElementById('demo-content-' + index).classList.remove('hidden');

    if (isDemoAutoPlaying) {
        clearInterval(demoInterval);
        startDemoAutoplay();
    }
}

function startDemoAutoplay() {
    demoInterval = setInterval(() => {
        const nextIndex = (currentDemoIndex + 1) % totalDemoScreens;
        switchDemoScreen(nextIndex);
    }, 5000);
}

function toggleDemoAutoplay() {
    isDemoAutoPlaying = !isDemoAutoPlaying;
    const playIcon = document.getElementById('demo-play-icon');
    const pauseIcon = document.getElementById('demo-pause-icon');
    const text = document.getElementById('demo-play-text');

    if (isDemoAutoPlaying) {
        playIcon.classList.add('hidden');
        pauseIcon.classList.remove('hidden');
        text.innerText = 'Pause';
        startDemoAutoplay();
    } else {
        playIcon.classList.remove('hidden');
        pauseIcon.classList.add('hidden');
        text.innerText = 'Play';
        clearInterval(demoInterval);
    }
}

// Comparison Section Logic
function switchComparisonTab(tabId) {
    // Update tabs
    document.querySelectorAll('.comp-tab').forEach(tab => {
        if (tab.id === 'comp-tab-' + tabId) {
            tab.className = "comp-tab active flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all bg-blue-600 text-white shadow-lg scale-105";
        } else {
            tab.className = "comp-tab flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all bg-white text-gray-700 hover:bg-gray-100 shadow";
        }
    });

    // Update content
    document.querySelectorAll('.comp-content').forEach(el => el.classList.add('hidden'));
    document.getElementById('comp-content-' + tabId).classList.remove('hidden');
}

// Benefits Section Logic
function toggleBenefit(id) {
    const details = document.getElementById('benefit-details-' + id);
    const chevron = document.getElementById('benefit-chevron-' + id);

    if (details.classList.contains('hidden')) {
        details.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
    } else {
        details.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
    }
}

function animateBenefits() {
    const duration = 2000;
    const steps = 60;
    const interval = duration / steps;
    let currentStep = 0;

    const timer = setInterval(() => {
        currentStep++;
        const progress = currentStep / steps;

        document.querySelectorAll('.benefit-progress-bar').forEach(bar => {
            const target = parseInt(bar.dataset.target);
            const current = Math.floor(target * progress);
            bar.style.width = current + '%';
        });

        document.querySelectorAll('.benefit-progress-text').forEach(text => {
            const target = parseInt(text.dataset.target);
            text.innerText = Math.floor(target * progress);
        });

        document.querySelectorAll('.benefit-progress-small-text').forEach(text => {
            const target = parseInt(text.dataset.target);
            text.innerText = Math.floor(target * progress);
        });

        if (currentStep >= steps) clearInterval(timer);
    }, interval);
}

document.addEventListener('DOMContentLoaded', () => {
    // ... previous setup ...
    const saved = localStorage.getItem('language');
    if (saved === 'si') {
        const textElements = document.querySelectorAll('#lang-text, .mobile-lang-text');
        textElements.forEach(el => el.innerText = 'සිංහල');
    }

    window.addEventListener('scroll', () => {
        const nav = document.getElementById('main-header');
        if (window.scrollY > 20) {
            nav.classList.add('shadow-md');
        } else {
            nav.classList.remove('shadow-md');
        }
    });

    animateCounters();
    startDemoAutoplay();
    animateBenefits();
});
