<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal fade" id="marketingShareModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
            <div class="modal-header bg-primary text-white p-3">
                <h5 class="modal-title font-weight-bold"><i class="fa fa-bullhorn mr-2"></i> BROADCAST AD GENERATOR</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6 text-center border-right">
                        <h6 class="text-uppercase small font-weight-bold text-muted mb-3">AI GEN AD POSTER</h6>
                        <?php if($poster_url): ?>
                            <img src="<?= $poster_url ?>" class="img-fluid rounded shadow-lg mb-3" id="generatedPoster" style="max-height: 450px;">
                            <a href="<?= $poster_url ?>" download="timber_ad.jpg" class="btn btn-outline-primary btn-sm btn-block">
                                <i class="fa fa-download"></i> Download Poster
                            </a>
                        <?php else: ?>
                            <div class="p-5 bg-light rounded text-muted">
                                <i class="fa fa-spinner fa-spin fa-3x mb-2"></i>
                                <p>Generating Ad...</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-uppercase small font-weight-bold text-muted mb-3">One-Click Share Hub</h6>
                        <p class="small text-muted mb-2">Select your professional networks for automated broadcast.</p>
                        
                        <div class="power-share-hub bg-dark p-3 rounded mb-3 text-left">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small font-weight-bold text-white"><i class="fa fa-users mr-1"></i> TARGET GROUPS</span>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="m-select-all" checked onclick="toggleMAll()">
                                    <label class="custom-control-label small text-white" for="m-select-all">SELECT ALL</label>
                                </div>
                            </div>
                            <div class="group-list" style="max-height: 100px; overflow-y: auto;">
                                <div class="group-item d-flex align-items-center mb-1 bg-secondary rounded p-1 px-2">
                                    <input type="checkbox" class="m-group-check mr-2" checked data-name="Timber Trading Hub">
                                    <span class="small text-white">Timber Trading Hub</span>
                                </div>
                                <div class="group-item d-flex align-items-center mb-1 bg-secondary rounded p-1 px-2">
                                    <input type="checkbox" class="m-group-check mr-2" checked data-name="Wood Market Global">
                                    <span class="small text-white">Wood Market Global</span>
                                </div>
                                <div class="group-item d-flex align-items-center mb-1 bg-secondary rounded p-1 px-2">
                                    <input type="checkbox" class="m-group-check mr-2" checked data-name="Local Loggers & Millers">
                                    <span class="small text-white">Local Loggers & Millers</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 bg-white rounded border">
                            <p class="small text-muted mb-3"><i class="fa fa-info-circle"></i> Posting to your authenticated session groups.</p>
                            <button type="button" id="btn-broadcast-all-market" class="btn btn-success btn-block py-2 font-weight-bold shadow-sm" onclick="executeRealBroadcastMarket(<?= $id ?>, '<?= $type ?>')">
                                <i class="fa fa-paper-plane mr-1"></i> BROADCAST TO SELECTED
                            </button>
                        </div>
                        <div id="broadcast-confirm-market" class="mt-2 p-2 rounded bg-success text-white small" style="display:none; font-weight: 600;">
                            <i class="fa fa-check-circle"></i> BROADCAST VERIFIED SUCCESSFULLY!
                        </div>

                        <div class="p-3 bg-light rounded mt-3">
                            <label class="small font-weight-bold text-muted text-uppercase d-block">Direct URL</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" value="<?= base_url('Marketplace/view/'.$type.'/'.$id) ?>" readonly id="copyTarget">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="button" onclick="copyUrl()">COPY</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-light p-2">
            <button type="button" class="btn btn-secondary font-weight-bold px-4" data-dismiss="modal">CLOSE</button>
        </div>
    </div>
</div>
</div>

<script>
function toggleMAll() {
    const checked = $('#m-select-all').is(':checked');
    $('.m-group-check').prop('checked', checked);
}

function copyUrl() {
    var copyText = document.getElementById("copyTarget");
    copyText.select();
    document.execCommand("copy");
    alert("URL Copied to clipboard!");
}

function executeRealBroadcastMarket(id, type) {
    const btn = $('#btn-broadcast-all-market');
    const selectedGroups = [];
    $('.m-group-check:checked').each(function() {
        selectedGroups.push($(this).data('name'));
    });

    if(selectedGroups.length == 0) return alert('Select at least one group');
    
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> BROADCASTING...');

    $.ajax({
        url: baseurl + 'Marketing/broadcast',
        type: 'POST',
        data: { id: id, type: type, groups: selectedGroups, [crsf_token]: crsf_hash },
        dataType: 'json',
        success: function(data) {
            btn.html('<i class="fa fa-check"></i> AD SENT!');
            $('#broadcast-confirm-market').text(data.message).fadeIn();
            
            // Smart Intent: Trigger native share sheet
            const shareUrl = $('#copyTarget').val();
            if (navigator.share) {
                navigator.share({
                    title: 'TimberPro Lot Offer',
                    text: `Check out this ${type} lot on TimberPro ERP.`,
                    url: shareUrl
                }).catch(console.error);
            } else {
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}`, '_blank');
            }
        },
        error: function() {
            btn.prop('disabled', false).html('<i class="fa fa-paper-plane mr-1"></i> BROADCAST TO SELECTED');
            alert('Broadcast incomplete. Retrying...');
        }
    });
}
</script>
