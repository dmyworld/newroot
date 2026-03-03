<div class="max-w-6xl mx-auto px-6 py-20">
    
    <!-- HEADER -->
    <div class="text-center mb-20">
        <div class="inline-flex items-center space-x-3 px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-[0.2em] border border-emerald-100 mb-8">
            <i class="fa fa-hand-holding-heart"></i>
            <span>Guardian Support Program</span>
        </div>
        <h1 class="text-4xl lg:text-6xl font-black text-slate-900 leading-tight tracking-tight mb-6">
            Nurture the Forest, <br>
            <span class="text-emerald-600">Earn with Purpose.</span>
        </h1>
        <p class="text-lg text-slate-500 max-w-2xl mx-auto font-body">
            Join our community of guardians. Care for trees in your locality and receive a monthly stipend for your commitment to sustainability.
        </p>
    </div>

    <!-- MAIN FORM CONTAINER -->
    <div class="bg-white rounded-[40px] shadow-2xl shadow-slate-100 border border-slate-100 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12">
            
            <!-- Information Panel -->
            <div class="lg:col-span-4 bg-slate-900 p-10 lg:p-12 text-white flex flex-col justify-between">
                <div class="space-y-12">
                    <div>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-emerald-400 mb-6">Program Benefits</h3>
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center border border-white/10 shrink-0">
                                    <i class="fa fa-money-bill-wave text-emerald-400"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm">Monthly Stipend</h4>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">Direct bank transfers for every verified batch of healthy trees.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center border border-white/10 shrink-0">
                                    <i class="fa fa-mobile-screen text-emerald-400"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm">Simple Verification</h4>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">Just upload a monthly photo to confirm tree survival.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-emerald-600/10 border border-emerald-400/20 rounded-3xl">
                        <p class="text-xs text-emerald-300 italic leading-relaxed">
                            "By caring for these trees, you are building a greener Sri Lanka for generations to come."
                        </p>
                    </div>
                </div>

                <div class="mt-12 flex items-center gap-4 border-t border-white/10 pt-8">
                    <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-xs font-black">TP</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-tight">
                        TimberPro CSR <br> Initiative
                    </div>
                </div>
            </div>

            <!-- Application Form -->
            <div class="lg:col-span-8 p-10 lg:p-16">
                <form action="<?= site_url('greenfuture/submit_maintenance') ?>" method="POST" enctype="multipart/form-data" class="space-y-12">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                    <!-- Personal -->
                    <section>
                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center">
                            <span class="w-8 h-px bg-slate-100 mr-4"></span> Applicant Info
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest ml-1">Full Name</label>
                                <input type="text" name="applicant_name" required class="form-input" placeholder="ඔබගේ සම්පූර්ණ නම">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest ml-1">Phone / WhatsApp</label>
                                <input type="tel" name="applicant_phone" required class="form-input" placeholder="07X XXX XXXX">
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest ml-1">Residential Address</label>
                                <textarea name="applicant_address" rows="2" class="form-input" placeholder="Your postal address..."></textarea>
                            </div>
                        </div>
                    </section>

                    <!-- Location -->
                    <section>
                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center">
                            <span class="w-8 h-px bg-slate-100 mr-4"></span> Tree Location
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest ml-1">Province</label>
                                <select name="province" required class="form-input cursor-pointer">
                                    <option value="">Select Province</option>
                                    <?php foreach(['Western','Central','Southern','Northern','Eastern','North Western','North Central','Uva','Sabaragamuwa'] as $p): ?>
                                    <option><?= $p ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest ml-1">District</label>
                                <input type="text" name="district" required class="form-input" placeholder="e.g. Galle">
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest ml-1">Tree Count & Details</label>
                                <div class="flex flex-col md:flex-row gap-4">
                                    <input type="number" name="tree_count" required class="form-input md:w-48" placeholder="Number of Trees" min="1">
                                    <input type="text" name="location_description" class="form-input flex-1" placeholder="Roadside, field edge, etc...">
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Verification -->
                    <section>
                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center">
                            <span class="w-8 h-px bg-slate-100 mr-4"></span> Visual Proof
                        </h4>
                        <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-[32px] p-8 text-center group hover:border-emerald-200 hover:bg-emerald-50/30 transition-all">
                            <i class="fa fa-camera text-slate-300 text-3xl mb-4 group-hover:text-emerald-400 group-hover:scale-110 transition-all"></i>
                            <div class="space-y-1">
                                <p class="text-sm font-bold text-slate-900">Upload Site Photo</p>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest">Max 2MB (JPG/PNG)</p>
                            </div>
                            <input type="file" name="photo" required class="mt-6 mx-auto text-xs text-slate-400 file:bg-white file:border-slate-200 file:rounded-full file:px-4 file:py-2 file:mr-4 file:font-bold file:text-slate-700 hover:file:bg-slate-50 cursor-pointer">
                        </div>
                    </section>

                    <!-- Banking -->
                    <section>
                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center">
                            <span class="w-8 h-px bg-slate-100 mr-4"></span> Payment Details
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest ml-1">Bank</label>
                                <input type="text" name="bank_name" class="form-input" placeholder="e.g. BOC">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest ml-1">Account No.</label>
                                <input type="text" name="bank_account_no" class="form-input" placeholder="000XXXX">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest ml-1">Branch</label>
                                <input type="text" name="bank_branch" class="form-input" placeholder="Branch">
                            </div>
                        </div>
                    </section>

                    <div class="flex flex-col md:flex-row items-center gap-6 pt-4">
                        <button type="submit" class="w-full md:w-auto px-12 py-5 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-[24px] shadow-2xl shadow-emerald-200 transition-all duration-300 transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3">
                            <i class="fa fa-paper-plane text-xs"></i> SUBMIT APPLICATION
                        </button>
                        <a href="<?= site_url('greenfuture') ?>" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-600">Cancel & Return</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-input {
        @apply w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-emerald-500/10 transition-all placeholder:text-slate-300 shadow-sm border border-transparent;
    }
</style>
