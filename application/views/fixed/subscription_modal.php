<!-- Subscription Upsell Modal -->
<div class="modal fade" id="subscriptionModal" tabindex="-1" role="dialog" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-body p-0">
                <div class="row no-gutters">
                    <!-- Left Side: Visual/Value Prop -->
                    <div class="col-md-5 d-none d-md-block" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; padding: 40px;">
                        <div class="h-100 d-flex flex-column justify-content-center text-center">
                            <i class="fa fa-rocket mb-4" style="font-size: 80px; opacity: 0.9;"></i>
                            <h3 class="font-weight-bold mb-3">Scale Faster</h3>
                            <p style="font-size: 1.1rem; opacity: 0.8;">Join 5,000+ businesses growing with our Premium features.</p>
                            <div class="mt-4 text-left">
                                <p><i class="fa fa-check-circle mr-2 text-success"></i> Unlimited Transactions</p>
                                <p><i class="fa fa-check-circle mr-2 text-success"></i> Priority 24/7 Support</p>
                                <p><i class="fa fa-check-circle mr-2 text-success"></i> Advanced Analytics</p>
                                <p><i class="fa fa-check-circle mr-2 text-success"></i> Custom Branding</p>
                            </div>
                        </div>
                    </div>
                    <!-- Right Side: Action -->
                    <div class="col-md-7 p-5 bg-white">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 20px;">
                            <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                        </button>
                        <div class="text-center mb-4">
                            <h2 id="modal-module-name" class="font-weight-bold" style="color: #111827;">Upgrade to Continue</h2>
                            <p class="text-muted" style="font-size: 1.1rem;">You've reached your free monthly limit for this module.</p>
                        </div>
                        
                        <div class="card border-primary mb-4" style="border-width: 2px;">
                            <div class="card-body text-center py-4">
                                <h4 class="text-primary font-weight-bold mb-1">Premium Plan</h4>
                                <div class="display-4 font-weight-bold my-2" style="font-size: 2.5rem; color: #111827;">$29<small class="text-muted" style="font-size: 1rem;">/mo</small></div>
                                <p class="text-muted">Unleash full potential without limits.</p>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="<?php echo base_url('settings/subscription'); ?>" class="btn btn-primary btn-block btn-lg shadow-lg" style="border-radius: 12px; padding: 15px; font-weight: bold; font-size: 1.2rem;">
                                Upgrade Now & Save 20%
                            </a>
                            <p class="mt-3 text-muted small">Secure payment via Stripe & PayPal. Cancel anytime.</p>
                        </div>

                        <div class="mt-4 pt-4 border-top text-center">
                            <p class="mb-0 text-muted italic">"Best decision for our retail chains. Highly recommended!"</p>
                            <small class="font-weight-bold">- Sarah J., Business Owner</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #subscriptionModal .btn-primary {
        background: #2563eb;
        border: none;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    #subscriptionModal .btn-primary:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
    }
    #subscriptionModal .modal-content {
        animation: modalFadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes modalFadeUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>
