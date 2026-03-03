<div class="content-body">
    <div class="max-w-6xl mx-auto py-12 px-4 md:px-8">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-4">
            <div>
                <div class="inline-flex items-center px-4 py-2 bg-green-50 text-green-600 rounded-full text-xs font-black uppercase tracking-widest mb-4 border border-green-100">
                    <i class="fab fa-whatsapp mr-2 text-base"></i> Automation Center
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">
                    WhatsApp <span class="text-green-500 italic">Messaging</span>
                </h1>
                <p class="text-slate-500 font-medium mt-1">Automated alerts, installment reminders & template management</p>
            </div>
            <div id="save-status" class="hidden px-5 py-3 bg-green-50 text-green-700 rounded-2xl font-bold text-sm border border-green-100 flex items-center gap-2">
                <i class="fa fa-check-circle"></i> Settings Saved!
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            <!-- LEFT: API Settings -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Gateway Config Card -->
                <div class="card bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-8 border-b border-slate-50">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-green-100 text-green-500 rounded-2xl flex items-center justify-center text-xl">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-slate-800 text-lg">Gateway API</h3>
                                <p class="text-slate-400 text-xs font-bold">e.g. UltraMsg, Wati, Gupshup</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-8 space-y-5">
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Gateway URL</label>
                            <input type="text" id="wa_gateway_url" value="<?= $settings['url'] ?? '' ?>" placeholder="https://api.ultramsg.com/instance/messages/chat"
                                   class="w-full px-5 py-3 bg-slate-50 rounded-2xl border-0 font-medium text-sm outline-none focus:bg-white focus:ring-2 focus:ring-primary transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">API Token / Key</label>
                            <input type="text" id="wa_token" value="<?= $settings['key1'] ?? '' ?>" placeholder="your-api-token"
                                   class="w-full px-5 py-3 bg-slate-50 rounded-2xl border-0 font-medium text-sm outline-none focus:bg-white focus:ring-2 focus:ring-primary transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Instance ID (if required)</label>
                            <input type="text" id="wa_instance" value="<?= $settings['key2'] ?? '' ?>" placeholder="instance_123456"
                                   class="w-full px-5 py-3 bg-slate-50 rounded-2xl border-0 font-medium text-sm outline-none focus:bg-white focus:ring-2 focus:ring-primary transition-all">
                        </div>

                        <!-- Toggle: Global Enable/Disable -->
                        <div class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl">
                            <div>
                                <div class="font-black text-slate-700 text-sm">Service Active</div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Enable/disable all WhatsApp sending</div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="wa_active" <?= ($settings['active'] ?? 0) ? 'checked' : '' ?> class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:bg-green-500 transition-all"></div>
                                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow peer-checked:translate-x-5 transition-all"></div>
                            </label>
                        </div>

                        <!-- Toggle: Auto Invoice -->
                        <div class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl">
                            <div>
                                <div class="font-black text-slate-700 text-sm">Auto-send on Invoice</div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Notify customer on new invoice</div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="auto_invoice" <?= ($settings['other'] ?? 0) ? 'checked' : '' ?> class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:bg-green-500 transition-all"></div>
                                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow peer-checked:translate-x-5 transition-all"></div>
                            </label>
                        </div>

                        <button onclick="saveSettings()" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-sm hover:bg-black transition-all flex items-center justify-center gap-2">
                            <i class="fa fa-save"></i> Save API Settings
                        </button>
                    </div>
                </div>

                <!-- Test Message Card -->
                <div class="card bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-8 border-b border-slate-50">
                        <h3 class="font-black text-slate-800">Send a Test Message</h3>
                        <p class="text-slate-400 text-xs font-bold mt-1">Verify your gateway is working correctly</p>
                    </div>
                    <div class="p-8 space-y-4">
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">To (with country code)</label>
                            <input type="text" id="test_to" placeholder="+94712345678"
                                   class="w-full px-5 py-3 bg-slate-50 rounded-2xl border-0 font-medium text-sm outline-none focus:bg-white focus:ring-2 focus:ring-green-300 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Message</label>
                            <textarea id="test_msg" rows="3" placeholder="Hello from Timber Pro!"
                                      class="w-full px-5 py-3 bg-slate-50 rounded-2xl border-0 font-medium text-sm outline-none focus:bg-white focus:ring-2 focus:ring-green-300 transition-all resize-none"></textarea>
                        </div>
                        <button onclick="sendTest()" class="w-full py-4 bg-green-500 text-white rounded-2xl font-black text-sm hover:bg-green-600 transition-all flex items-center justify-center gap-2">
                            <i class="fab fa-whatsapp"></i> Send Test
                        </button>
                        <div id="test-result" class="hidden text-sm font-bold text-center p-3 rounded-xl"></div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Template Management -->
            <div class="lg:col-span-3">
                <div class="card bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                        <div>
                            <h3 class="font-black text-slate-800 text-lg">Message Templates</h3>
                            <p class="text-slate-400 text-xs font-bold mt-1">Use <code class="bg-slate-100 px-2 py-0.5 rounded-lg">{VariableName}</code> for dynamic data</p>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest"><?= count($templates) ?> Templates</span>
                    </div>

                    <div class="divide-y divide-slate-50">
                        <?php foreach($templates as $t): ?>
                        <div class="p-8 group">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-green-100 text-green-600 flex items-center justify-center text-xs font-black">
                                        #<?= $t['id'] ?>
                                    </div>
                                    <div>
                                        <div class="font-black text-slate-800 italic"><?= $t['name'] ?></div>
                                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest capitalize"><?= $t['type'] ?? 'whatsapp' ?></div>
                                    </div>
                                </div>
                                <button onclick="saveTemplate(<?= $t['id'] ?>)" class="opacity-0 group-hover:opacity-100 transition-opacity px-4 py-2 bg-green-500 text-white rounded-xl font-black text-xs hover:bg-green-600">
                                    Save
                                </button>
                            </div>

                            <textarea id="template_<?= $t['id'] ?>" rows="4"
                                      class="w-full px-5 py-4 bg-slate-50 rounded-2xl border-0 font-mono text-sm outline-none focus:bg-white focus:ring-2 focus:ring-green-300 transition-all resize-none text-slate-600"><?= htmlspecialchars($t['other'] ?? '') ?></textarea>

                            <div class="mt-3 flex flex-wrap gap-2">
                                <?php
                                preg_match_all('/\{(\w+)\}/', $t['other'] ?? '', $vars);
                                foreach($vars[1] as $var):
                                ?>
                                <span class="inline-flex px-2 py-1 bg-green-50 text-green-600 text-[9px] font-black rounded-lg uppercase tracking-tighter">
                                    <?= $var ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function saveSettings() {
    $.post('<?= base_url('whatsapp/save_settings') ?>', {
        wa_token: $('#wa_token').val(),
        wa_instance: $('#wa_instance').val(),
        wa_gateway_url: $('#wa_gateway_url').val(),
        auto_invoice: $('#auto_invoice').is(':checked') ? 1 : 0,
        wa_active: $('#wa_active').is(':checked') ? 1 : 0
    }, function(res) {
        var r = JSON.parse(res);
        if (r.status == 'Success') {
            $('#save-status').removeClass('hidden').addClass('flex');
            setTimeout(() => $('#save-status').addClass('hidden').removeClass('flex'), 3000);
        }
    });
}

function saveTemplate(id) {
    $.post('<?= base_url('whatsapp/save_template') ?>', {
        template_id: id,
        template_text: $('#template_' + id).val()
    }, function(res) {
        var r = JSON.parse(res);
        toastr.success(r.message);
    });
}

function sendTest() {
    var btn = event.target;
    btn.innerText = 'Sending...';
    btn.disabled = true;
    $.post('<?= base_url('whatsapp/send_test') ?>', {
        to: $('#test_to').val(),
        message: $('#test_msg').val()
    }, function(res) {
        var r = JSON.parse(res);
        var el = $('#test-result');
        el.removeClass('hidden bg-green-50 text-green-600 bg-red-50 text-red-600');
        if (r.status == 'Success') {
            el.addClass('bg-green-50 text-green-600').text('✓ Message sent successfully!').removeClass('hidden');
        } else {
            el.addClass('bg-red-50 text-red-600').text('✗ ' + r.message).removeClass('hidden');
        }
        btn.innerText = 'Send Test';
        btn.disabled = false;
    });
}
</script>
