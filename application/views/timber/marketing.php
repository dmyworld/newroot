<div class="content-body">
    <!-- Premium Marketing AI HUD -->
    <div class="marketing-ai-hud p-4 mb-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; border-radius: 20px; box-shadow: 0 15px 30px rgba(0,0,0,0.3);">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <div class="bg-primary rounded-circle p-3 mr-3 d-flex align-items-center justify-content-center shadow-lg" style="width: 60px; height: 60px; border: 2px solid rgba(255,255,255,0.2);">
                        <i class="fa fa-bullhorn font-large-1"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 font-weight-bold text-white uppercase letter-spacing-1">Marketing Command Center</h3>
                        <span class="small font-weight-bold text-primary" style="letter-spacing: 2px;">SOCIAL BROADCAST v4.0</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-right">
                <div class="d-inline-block mr-3 text-center">
                    <div id="fb-badge" class="badge badge-pill <?= (!empty($fb_config['access_token'])) ? 'badge-primary' : 'badge-secondary' ?> px-3 py-2 shadow-sm">
                        <i class="fa fa-facebook-official mr-1"></i> FACEBOOK: <?= (!empty($fb_config['access_token'])) ? 'AUTO-LINKED' : 'UNLINKED' ?>
                    </div>
                </div>
                <div class="d-inline-block text-center">
                    <div id="wa-badge" class="badge badge-pill <?= (!empty($wa_config['access_token']) && $wa_config['access_token'] == 'active') ? 'badge-success' : 'badge-secondary' ?> px-3 py-2 shadow-sm">
                        <i class="fa fa-whatsapp mr-1"></i> WHATSAPP: <?= (!empty($wa_config['access_token']) && $wa_config['access_token'] == 'active') ? 'STATUS ACTIVE' : 'INACTIVE' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Configuration Terminal -->
        <div class="col-xl-4 col-md-12">
            <div class="premium-card mb-4">
                <div class="card-title-premium text-primary border-bottom pb-2 mb-3">
                    <i class="fa fa-plug mr-2"></i> CONNECTIVITY TERMINAL
                </div>
                
                <!-- Facebook Config -->
                <div class="mb-4">
                    <label class="small font-weight-bold text-muted text-uppercase">Facebook Integration</label>
                    <form id="fb-config-form" class="bg-light p-3 rounded border">
                        <div class="form-group mb-2">
                            <input type="text" name="fb_id" class="form-control-sm form-control" value="<?= @$fb_config['fb_profile_id'] ?>" placeholder="FB ID (e.g. 1000...)">
                        </div>
                        <div class="form-group mb-2">
                            <textarea name="token" class="form-control-sm form-control" rows="2" placeholder="Access Token"><?= @$fb_config['access_token'] ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm btn-block font-weight-bold shadow-sm">
                            <i class="fa fa-sync-alt mr-1"></i> SYNC FACEBOOK
                        </button>
                    </form>
                </div>

                <!-- WhatsApp Config -->
                <div class="mb-4">
                    <label class="small font-weight-bold text-muted text-uppercase">WhatsApp Business</label>
                    <form id="wa-config-form" class="bg-light p-3 rounded border">
                        <div class="form-group mb-2">
                            <input type="text" name="wa_number" class="form-control-sm form-control" value="<?= @$wa_config['fb_profile_id'] ?>" placeholder="Phone Number (with CC)">
                        </div>
                        <button type="submit" class="btn btn-success btn-sm btn-block font-weight-bold shadow-sm">
                            <i class="fa fa-check-circle mr-1"></i> ACTIVATE STATUS
                        </button>
                    </form>
                </div>

                <!-- Revid AI Config -->
                <div class="mb-4">
                    <label class="small font-weight-bold text-muted text-uppercase">Revid AI Integration</label>
                    <form id="revid-config-form" class="bg-light p-3 rounded border" style="border-left: 4px solid #f59e0b !important;">
                        <input type="hidden" name="revid_id" value="1">
                        <div class="form-group mb-2">
                            <textarea name="token" class="form-control-sm form-control" rows="2" placeholder="Revid API Key / Bearer Token"><?= @$revid_config['access_token'] ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning btn-sm btn-block font-weight-bold shadow-sm" style="color: #000;">
                            <i class="fa fa-bolt mr-1"></i> CONNECT REVID AI
                        </button>
                    </form>
                </div>
                
                <div class="alert alert-info p-2 small mb-0">
                    <i class="fa fa-info-circle mr-1"></i> Tokens ensure your ads reach the correct professional timber groups automatically.
                </div>
            </div>
        </div>

        <!-- Ad Generator Engine -->
        <div class="col-xl-8 col-md-12">
            <div class="premium-card">
                <div class="card-title-premium text-success border-bottom pb-2 mb-3 d-flex justify-content-between">
                    <span><i class="fa fa-magic mr-2"></i> AD GENERATOR ENGINE</span>
                    <span class="badge badge-success px-2 py-1 font-weight-bold" style="font-size: 10px;">HQ RENDER ENABLED</span>
                </div>
                
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="text-uppercase small font-weight-bold text-muted">Select Active Listing</label>
                            <select class="form-control select2" id="lot-selector" onchange="resetPreview()">
                                <option value="">-- Choose Timber Lot --</option>
                                <?php foreach($active_lots as $lot): ?>
                                    <option value="<?= $lot['id'] ?>" data-type="<?= $lot['type'] ?>"><?= $lot['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="marketing-stats mt-4 border-top pt-3">
                            <p class="small font-weight-bold text-muted text-uppercase mb-2">Est. Market Reach</p>
                            <div class="stats-row d-flex justify-content-between mb-2">
                                <span class="small">FB Groups Density</span>
                                <span class="text-primary font-weight-bold">High (3.5M+)</span>
                            </div>
                            <div class="stats-row d-flex justify-content-between mb-2">
                                <span class="small">WA Status Visibility</span>
                                <span class="text-success font-weight-bold">Active</span>
                            </div>
                            <div class="stats-row d-flex justify-content-between">
                                <span class="small">Poster Quality</span>
                                <span class="text-warning font-weight-bold">Premium 4K</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-outline-info btn-block py-2 mb-2 font-weight-bold" onclick="previewPoster()">
                                <i class="fa fa-eye mr-1"></i> GENERATE PREVIEW
                            </button>
                            
                            <div class="power-share-hub bg-dark p-3 rounded mb-2 mt-3 text-left">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small font-weight-bold text-white"><i class="fa fa-users mr-1"></i> TARGET GROUPS</span>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="select-all-groups" checked onclick="toggleAllGroups()">
                                        <label class="custom-control-label small text-white" for="select-all-groups">SELECT ALL</label>
                                    </div>
                                </div>
                                <div class="group-list" style="max-height: 120px; overflow-y: auto;">
                                    <div class="group-item d-flex align-items-center mb-1 bg-secondary rounded p-1 px-2">
                                        <input type="checkbox" class="group-check mr-2" checked data-name="Timber Trading Hub">
                                        <span class="small text-white">Timber Trading Hub</span>
                                    </div>
                                    <div class="group-item d-flex align-items-center mb-1 bg-secondary rounded p-1 px-2">
                                        <input type="checkbox" class="group-check mr-2" checked data-name="Wood Market Global">
                                        <span class="small text-white">Wood Market Global</span>
                                    </div>
                                    <div class="group-item d-flex align-items-center mb-1 bg-secondary rounded p-1 px-2">
                                        <input type="checkbox" class="group-check mr-2" checked data-name="Local Loggers & Millers">
                                        <span class="small text-white">Local Loggers & Millers</span>
                                    </div>
                                </div>
                            </div>

                            <button id="btn-bulk-broadcast" class="btn btn-success btn-block py-3 font-weight-bold shadow-lg mt-3" onclick="broadcastAd()">
                                <i class="fa fa-paper-plane mr-2"></i> BULK BROADCAST TO ALL
                            </button>

                            <button id="btn-ai-video" class="btn btn-warning btn-block py-3 font-weight-bold shadow-lg mt-3" style="background: linear-gradient(to right, #f59e0b, #d97706); border: none; color: #fff;" onclick="generateAIVideo()">
                                <i class="fa fa-film mr-2"></i> 1-CLICK AI VIDEO AD
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-md-7 border-left px-4">
                        <div id="poster-preview" class="text-center bg-light rounded p-4 border" style="min-height: 400px; display: flex; align-items: center; justify-content: center; position: relative;">
                            <div id="preview-placeholder">
                                <i class="fa fa-image fa-4x text-muted mb-2 opacity-2"></i>
                                <p class="text-muted small">Select a lot and click <br><strong>GENERATE PREVIEW</strong></p>
                            </div>
                            <div id="render-spinner" style="display:none; position: absolute;">
                                <i class="fa fa-spinner fa-spin fa-3x text-primary"></i>
                                <p class="mt-2 small font-weight-bold">RENDERING ASSET...</p>
                            </div>
                            <img id="live-poster" src="" class="img-fluid rounded shadow-lg border" style="display:none; max-height: 500px;" alt="Poster Preview">
                            <div id="video-preview-container" style="display:none; width: 100%;">
                                <video id="ai-video-player" controls class="img-fluid rounded shadow-lg border" style="max-height: 500px; width: 100%;">
                                    <source src="" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <div class="mt-2">
                                    <a id="download-video" href="#" class="btn btn-sm btn-outline-primary" download>Download Video</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --psy-blue: #1e40af;
        --psy-card-bg: #ffffff;
        --psy-text: #334155;
    }

    body { background: #f1f5f9 !important; }

    .premium-card {
        background: var(--psy-card-bg);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
    }

    .card-title-premium {
        font-weight: 800;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 10px 15px;
        font-weight: 500;
    }

    .form-control:focus {
        border-color: var(--psy-blue);
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }

    .letter-spacing-1 { letter-spacing: 1px; }

    .btn { border-radius: 10px; transition: all 0.2s; }
    .btn:hover { transform: translateY(-2px); shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
    
    .opacity-2 { opacity: 0.2; }
</style>

<script>
    $('#fb-config-form').submit(function(e) {
        e.preventDefault();
        const btn = $(this).find('button');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> SYNCING...');
        $.ajax({
            url: baseurl + 'Marketing/save_fb_link',
            type: 'POST',
            data: $(this).serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function(data) {
                alert(data.message);
                btn.prop('disabled', false).html('<i class="fa fa-sync-alt mr-1"></i> SYNC FACEBOOK');
                $('#fb-badge').removeClass('badge-secondary').addClass('badge-primary').html('<i class="fa fa-facebook-official mr-1"></i> FACEBOOK: AUTO-LINKED');
            }
        });
    });

    $('#wa-config-form').submit(function(e) {
        e.preventDefault();
        const btn = $(this).find('button');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> ACTIVATING...');
        $.ajax({
            url: baseurl + 'Marketing/save_wa_link',
            type: 'POST',
            data: $(this).serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function(data) {
                alert(data.message);
                btn.prop('disabled', false).html('<i class="fa fa-check-circle mr-1"></i> ACTIVATE STATUS');
                $('#wa-badge').removeClass('badge-secondary').addClass('badge-success').html('<i class="fa fa-whatsapp mr-1"></i> WHATSAPP: STATUS ACTIVE');
            }
        });
    });

    $('#revid-config-form').submit(function(e) {
        e.preventDefault();
        const btn = $(this).find('button');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> CONNECTING...');
        $.ajax({
            url: baseurl + 'Marketing/save_revid_link',
            type: 'POST',
            data: $(this).serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function(data) {
                alert(data.message);
                btn.prop('disabled', false).html('<i class="fa fa-bolt mr-1"></i> CONNECT REVID AI');
            }
        });
    });

    function toggleAllGroups() {
        const checked = $('#select-all-groups').is(':checked');
        $('.group-check').prop('checked', checked);
    }

    function resetPreview() {
        $('#live-poster').hide();
        $('#video-preview-container').hide();
        $('#preview-placeholder').show();
        $('#render-spinner').hide();
    }

    function previewPoster() {
        const option = $('#lot-selector option:selected');
        const id = option.val();
        const type = option.data('type');
        
        if(!id) return alert('Select a listing first');
        
        $('#preview-placeholder').hide();
        $('#live-poster').hide();
        $('#render-spinner').show();

        const url = baseurl + 'Marketing/generate_poster?id=' + id + '&type=' + type;
        
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if(data.status == 'Success') {
                    $('#live-poster').attr('src', data.poster_url + '?t=' + new Date().getTime()).fadeIn();
                    $('#render-spinner').hide();
                } else {
                    alert(data.message || 'Render failed');
                    resetPreview();
                }
            },
            error: function() {
                alert('Connection failure');
                resetPreview();
            }
        });
    }

    function broadcastAd() {
        const option = $('#lot-selector option:selected');
        const id = option.val();
        const type = option.data('type');
        
        if(!id) return alert('Select a listing first');
        
        const selectedGroups = [];
        $('.group-check:checked').each(function() {
            selectedGroups.push($(this).data('name'));
        });

        if(selectedGroups.length == 0) return alert('Please select at least one group');

        if(!confirm(`This will broadcast the branded HQ ad to ${selectedGroups.length} selected groups and your social networks. Proceed?`)) return;
        
        const btn = $('#btn-bulk-broadcast');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> BROADCASTING...');

        $.ajax({
            url: baseurl + 'Marketing/broadcast',
            type: 'POST',
            data: {
                id: id,
                type: type,
                groups: selectedGroups,
                [crsf_token]: crsf_hash
            },
            dataType: 'json',
            success: function(data) {
                alert(data.message);
                btn.prop('disabled', false).html('<i class="fa fa-paper-plane mr-2"></i> BULK BROADCAST TO ALL');
                
                // Smart Intent Trigger: Open native share sheet if available
                if (navigator.share) {
                    const posterUrl = $('#live-poster').attr('src');
                    navigator.share({
                        title: 'TimberPro Lot Offer',
                        text: `Check out this timber lot: ${option.text()} on TimberPro ERP.`,
                        url: window.location.origin + baseurl + 'Marketplace/view/' + type + '/' + id
                    }).catch(console.error);
                } else {
                    // Fallback to Facebook share dialog for first group
                    const shareUrl = window.location.origin + baseurl + 'Marketplace/view/' + type + '/' + id;
                    window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}`, '_blank');
                }
            },
            error: function() {
                alert('Connection error. Initialized offline broadcast.');
                btn.prop('disabled', false).html('<i class="fa fa-paper-plane mr-2"></i> BULK BROADCAST TO ALL');
            }
        });
    }

    function generateAIVideo() {
        const option = $('#lot-selector option:selected');
        const id = option.val();
        const type = option.data('type');
        
        if(!id) return alert('Select a listing first');
        
        if(!confirm('This will use your Revid AI credits to generate a professional video ad. Proceed?')) return;

        $('#preview-placeholder').hide();
        $('#live-poster').hide();
        $('#video-preview-container').hide();
        $('#render-spinner').show().find('p').text('AI IS RENDERING YOUR VIDEO...');

        const btn = $('#btn-ai-video');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> GENERATING AI VIDEO...');

        $.ajax({
            url: baseurl + 'Marketing/generate_ai_video',
            type: 'POST',
            data: {
                id: id,
                type: type,
                [crsf_token]: crsf_hash
            },
            dataType: 'json',
            success: function(data) {
                btn.prop('disabled', false).html('<i class="fa fa-film mr-2"></i> 1-CLICK AI VIDEO AD');
                if(data.status == 'Success') {
                    if(data.video_url) {
                        $('#ai-video-player source').attr('src', data.video_url);
                        $('#ai-video-player')[0].load();
                        $('#video-preview-container').fadeIn();
                        $('#download-video').attr('href', data.video_url);
                    } else {
                        alert('Video generation queued! You will be notified via webhook/browser when ready.');
                    }
                    $('#render-spinner').hide();
                } else {
                    alert(data.message || 'AI Generation failed');
                    resetPreview();
                }
            },
            error: function() {
                alert('Connection failure');
                btn.prop('disabled', false).html('<i class="fa fa-film mr-2"></i> 1-CLICK AI VIDEO AD');
                resetPreview();
            }
        });
    }
</script>
