<?php
/**
 * Scanner Modal for Barcode/QR Code scanning
 * Uses html5-qrcode library
 */
?>
<!-- Scanner Modal -->
<div id="scannerModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-gradient-directional-blue white">
                <h4 class="modal-title"><i class="fa fa-barcode"></i> Scan Barcode / QR Code</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <div id="reader-container" style="border: 2px dashed #ccc; border-radius: 10px; padding: 10px; background: #f9f9f9;">
                    <div id="reader" style="width: 100%;"></div>
                </div>
                <div id="scanner-status" class="mt-2 text-muted small">Initialising camera...</div>
                <div class="mt-2">
                    <button type="button" class="btn btn-warning btn-sm" id="btn-flip-camera" style="display:none;">
                        <i class="fa fa-refresh"></i> Flip Camera
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="stopScannerBtn">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script type="text/javascript">
    let html5QrCode;
    let targetInputId;
    let currentFacingMode = "environment";

    function startScanner(inputId) {
        targetInputId = inputId;
        $('#scannerModal').modal('show');
    }

    $('#scannerModal').on('shown.bs.modal', function () {
        initScanner();
    });

    $('#scannerModal').on('hidden.bs.modal', function () {
        stopScanner();
    });

    $('#stopScannerBtn').click(function() {
        stopScanner();
    });

    function initScanner() {
        $('#scanner-status').text('Accessing camera...').removeClass('text-danger');
        
        if(html5QrCode) {
            stopScanner();
        }

        html5QrCode = new Html5Qrcode("reader");
        const config = { 
            fps: 15, 
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0
        };

        html5QrCode.start(
            { facingMode: currentFacingMode }, 
            config, 
            (decodedText, decodedResult) => {
                // Handle success
                console.log(`Scan result: ${decodedText}`);
                $('#' + targetInputId).val(decodedText);
                
                // Trigger events for reactive fields
                $('#' + targetInputId).trigger('change').trigger('keyup').trigger('blur');
                
                // Visual/Audio Feedback
                if(typeof beep === 'function') {
                    beep();
                }
                
                // Close modal
                $('#scannerModal').modal('hide');
            }, 
            (errorMessage) => {
                // parse error, ignore
            }
        ).then(() => {
            $('#scanner-status').text('Align barcode within the square');
            $('#btn-flip-camera').show();
        }).catch((err) => {
            $('#scanner-status').text('Error: ' + err).addClass('text-danger');
            console.error(err);
        });
    }

    function stopScanner() {
        if (html5QrCode && html5QrCode.isScanning) {
            html5QrCode.stop().then((ignore) => {
                console.log("Scanner stopped");
                html5QrCode.clear();
            }).catch((err) => {
                console.warn("Unable to stop scanning.", err);
            });
        }
    }

    $("#btn-flip-camera").click(function() {
        currentFacingMode = currentFacingMode === "environment" ? "user" : "environment";
        initScanner();
    });

    // Audio feedback helper
    function beep() {
        try {
            const beepAudio = new Audio("<?= assets_url() ?>assets/js/beep.wav");
            beepAudio.play().catch(e => console.log('Audio play blocked'));
        } catch(e) {
            console.log('Audio error', e);
        }
    }
</script>

<style>
    #reader video {
        border-radius: 8px;
        width: 100% !important;
    }
    #reader__scan_region {
        background: white !important;
    }
    #reader__dashboard {
        display: none !important;
    }
</style>
