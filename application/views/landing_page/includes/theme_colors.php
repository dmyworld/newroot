<!-- Global Blue & Life Green Theme Styles -->
<style>
/* ========================================
   BLUE & LIFE GREEN THEME - LANDING PAGE
   Matching Owner Dashboard Color Palette
   ======================================== */

/* Color Variables - Extracted from Dashboard */
:root {
    /* Page & Card Backgrounds */
    --landing-bg-page: #eff6ff;        /* Alice Blue (Light Blue BG) */
    --landing-bg-card: #ffffff;         /* Pure White Cards */
    --landing-bg-section-alt: #f8fafc;  /* Subtle Gray for alternating sections */
    
    /* Text Colors */
    --landing-text-primary: #1e3a8a;    /* Navy Blue 900 (Headings) */
    --landing-text-secondary: #334155;  /* Slate 700 (Body Text) */
    --landing-text-muted: #475569;      /* Slate 600 (Muted Text) */
    
    /* Accent Colors */
    --landing-accent-blue: #2563eb;     /* Royal Blue (Primary CTA) */
    --landing-accent-green: #16a34a;    /* Life Green (Success/Income) */
    --landing-accent-danger: #ef4444;   /* Red (Warnings/Losses) */
    --landing-accent-warning: #f59e0b;  /* Amber (Alerts) */
    --landing-accent-info: #0ea5e9;     /* Sky Blue (Info) */
    
    /* Borders & Shadows */
    --landing-border: #bfdbfe;          /* Blue 200 (Soft Blue Border) */
    --landing-border-strong: #93c5fd;   /* Blue 300 (Stronger Border) */
    --landing-shadow: 0 4px 6px -1px rgba(30, 58, 138, 0.1), 0 2px 4px -1px rgba(30, 58, 138, 0.06);
    --landing-shadow-lg: 0 10px 15px -3px rgba(30, 58, 138, 0.1), 0 4px 6px -2px rgba(30, 58, 138, 0.05);
    
    /* Gradients */
    --landing-gradient-blue: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    --landing-gradient-green: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    --landing-gradient-header: linear-gradient(90deg, #f8fafc 0%, #eff6ff 100%);
}

/* Global Overrides */
body {
    background-color: var(--landing-bg-page) !important;
    color: var(--landing-text-secondary) !important;
}

/* Typography */
h1, h2, h3, h4, h5, h6 {
    color: var(--landing-text-primary) !important;
    font-weight: 700;
}

/* Section Backgrounds */
.section-white {
    background-color: var(--landing-bg-card);
}

.section-light-blue {
    background-color: var(--landing-bg-page);
}

.section-light-gray {
    background-color: var(--landing-bg-section-alt);
}

/* Card Styles */
.landing-card {
    background: var(--landing-bg-card);
    border-radius: 16px;
    border: 1px solid var(--landing-border);
    box-shadow: var(--landing-shadow);
    transition: all 0.3s ease;
}

.landing-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--landing-shadow-lg);
    border-color: var(--landing-accent-blue);
}

/* Button Styles */
.btn-primary-blue {
    background: var(--landing-gradient-blue);
    color: white;
    border: none;
    font-weight: 700;
    padding: 16px 32px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    transition: all 0.3s ease;
}

.btn-primary-blue:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
}

.btn-success-green {
    background: var(--landing-gradient-green);
    color: white;
    border: none;
    font-weight: 700;
    padding: 16px 32px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
    transition: all 0.3s ease;
}

.btn-success-green:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(22, 163, 74, 0.4);
}

.btn-outline-blue {
    background: transparent;
    color: var(--landing-accent-blue);
    border: 2px solid var(--landing-accent-blue);
    font-weight: 700;
    padding: 14px 30px;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.btn-outline-blue:hover {
    background: var(--landing-accent-blue);
    color: white;
    transform: translateY(-2px);
}

/* Badge Styles */
.badge-blue {
    background: rgba(37, 99, 235, 0.1);
    color: var(--landing-accent-blue);
    border: 1px solid var(--landing-accent-blue);
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

.badge-green {
    background: rgba(22, 163, 74, 0.1);
    color: var(--landing-accent-green);
    border: 1px solid var(--landing-accent-green);
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

/* Text Utilities */
.text-blue {
    color: var(--landing-accent-blue) !important;
}

.text-green {
    color: var(--landing-accent-green) !important;
}

.text-navy {
    color: var(--landing-text-primary) !important;
}

.text-muted-landing {
    color: var(--landing-text-muted) !important;
}

/* Icon Boxes */
.icon-box-blue {
    width: 60px;
    height: 60px;
    background: rgba(37, 99, 235, 0.1);
    border: 2px solid var(--landing-accent-blue);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--landing-accent-blue);
    font-size: 24px;
}

.icon-box-green {
    width: 60px;
    height: 60px;
    background: rgba(22, 163, 74, 0.1);
    border: 2px solid var(--landing-accent-green);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--landing-accent-green);
    font-size: 24px;
}

/* Progress Bars */
.progress-landing {
    background: #f1f5f9;
    height: 8px;
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar-blue {
    background: var(--landing-gradient-blue);
    height: 100%;
    border-radius: 4px;
}

.progress-bar-green {
    background: var(--landing-gradient-green);
    height: 100%;
    border-radius: 4px;
}

/* Stat Boxes */
.stat-box {
    background: var(--landing-bg-card);
    border: 1px solid var(--landing-border);
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    transition: all 0.3s ease;
}

.stat-box:hover {
    border-color: var(--landing-accent-blue);
    box-shadow: var(--landing-shadow);
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--landing-text-primary);
    line-height: 1;
    margin-bottom: 8px;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--landing-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

/* Feature Boxes */
.feature-box {
    background: var(--landing-bg-card);
    border: 1px solid var(--landing-border);
    border-radius: 16px;
    padding: 32px;
    transition: all 0.3s ease;
    height: 100%;
}

.feature-box:hover {
    transform: translateY(-4px);
    border-color: var(--landing-accent-blue);
    box-shadow: var(--landing-shadow-lg);
}

/* Alert Boxes */
.alert-danger-landing {
    background: rgba(239, 68, 68, 0.1);
    border: 2px solid var(--landing-accent-danger);
    border-radius: 12px;
    padding: 20px;
    color: #991b1b;
}

.alert-success-landing {
    background: rgba(22, 163, 74, 0.1);
    border: 2px solid var(--landing-accent-green);
    border-radius: 12px;
    padding: 20px;
    color: #065f46;
}

.alert-info-landing {
    background: rgba(14, 165, 233, 0.1);
    border: 2px solid var(--landing-accent-info);
    border-radius: 12px;
    padding: 20px;
    color: #075985;
}

/* Animations */
@keyframes float-up {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.float-animation {
    animation: float-up 3s ease-in-out infinite;
}

@keyframes pulse-blue {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.7);
    }
    50% {
        box-shadow: 0 0 0 20px rgba(37, 99, 235, 0);
    }
}

.pulse-blue {
    animation: pulse-blue 2s infinite;
}

@keyframes pulse-green {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7);
    }
    50% {
        box-shadow: 0 0 0 20px rgba(22, 163, 74, 0);
    }
}

.pulse-green {
    animation: pulse-green 2s infinite;
}

/* Responsive Utilities */
@media (max-width: 768px) {
    .stat-value {
        font-size: 2rem;
    }
    
    .feature-box {
        padding: 24px;
    }
}
</style>
