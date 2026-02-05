<div class="row">
    <div class="col-md-12">
        <div class="card bg-white">
            <div class="card-body">
                <!-- User Guide -->
                <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #ffc107;">
                    <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideAI" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                        <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                    </div>
                    <div id="guideAI" class="collapse">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_ai">🇬🇧 English</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_ai">🇱🇰 Sinhala</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_ai">IN Tamil</a></li>
                            </ul>
                            <div class="tab-content border p-2 bg-white">
                                <div id="eng_ai" class="tab-pane active">
                                    <h6 class="text-primary mt-1 small">AI Decision Support</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>Updates:</strong> Check the feed for automated production alerts.</li>
                                        <li><strong>Analyze:</strong> Click 'Run AI Analysis' for real-time risk assessment.</li>
                                        <li><strong>Action:</strong> Click 'Dismiss' after reviewing or resolving an alert.</li>
                                    </ol>
                                </div>
                                <div id="sin_ai" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">AI තීරණ සහායක</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>යාවත්කාලීන:</strong> ස්වයංක්‍රීය නිෂ්පාදන අනතුරු ඇඟවීම් සඳහා පරීක්ෂා කරන්න.</li>
                                        <li><strong>විශ්ලේෂණය:</strong> අවදානම් තක්සේරුව සඳහා 'Run AI Analysis' ක්ලික් කරන්න.</li>
                                        <li><strong>ක්‍රියාව:</strong> පණිවිඩය කියවීමෙන් පසු 'Dismiss' ක්ලික් කරන්න.</li>
                                    </ol>
                                </div>
                                <div id="tam_ai" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">AI முடிவு ஆதரவு</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>புதுப்பிப்புகள்:</strong> தானியங்கி உற்பத்தி விழிப்பூட்டல்களைச் சரிபார்க்கவும்.</li>
                                        <li><strong>பகுப்பாய்வு:</strong> ஆபத்து மதிப்பீட்டிற்காக 'Run AI Analysis' ஐ கிளிக் செய்யவும்.</li>
                                        <li><strong>செயல்:</strong> விழிப்பூட்டலைப் பார்த்த பிறகு 'Dismiss' ஐ கிளிக் செய்யவும்.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End User Guide -->
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="text-primary"><i class="fa fa-lightbulb-o"></i> AI Decision Support</h2>
                        <p class="text-muted">Proactive insights, risk detection, and forecasting.</p>
                    </div>
                    <div class="col-md-4 text-right">
                        <button id="run_ai" class="btn btn-success btn-lg"><i class="fa fa-refresh"></i> Run AI Analysis</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="alert_feed">
    <?php if(empty($alerts)) { ?>
        <div class="col-md-12 text-center">
            <div class="alert alert-info">No Active Alerts. Systems Normal.</div>
        </div>
    <?php } else { ?>
        <?php foreach($alerts as $alert) { 
            $bg = "bg-info";
            if($alert['severity'] == "High") $bg = "bg-danger text-white";
            if($alert['severity'] == "Medium") $bg = "bg-warning";
        ?>
        <div class="col-md-4 alert-card" id="alert-<?php echo $alert['id']; ?>">
            <div class="card <?php echo $bg; ?>">
                <div class="card-body">
                    <button type="button" class="close dismiss-btn" data-id="<?php echo $alert['id']; ?>" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="card-title"><i class="fa fa-exclamation-triangle"></i> <?php echo $alert['title']; ?></h5>
                    <p class="card-text"><?php echo $alert['message']; ?></p>
                    <small><?php echo $alert['created_at']; ?></small>
                </div>
            </div>
        </div>
        <?php } ?>
    <?php } ?>
</div>

<script>
    $('#run_ai').click(function(){
        $(this).html('<i class="fa fa-spinner fa-spin"></i> Analyzing...');
        $.ajax({
            url: "<?php echo site_url('production_intelligence/run_analysis')?>",
            type: 'GET',
            dataType: 'json',
            success: function(data){
                alert(data.message);
                location.reload();
            }
        });
    });

    $('.dismiss-btn').click(function(){
        var id = $(this).data('id');
        $.ajax({
            url: "<?php echo site_url('production_intelligence/dismiss')?>",
            type: 'POST',
            data: {
                id: id,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function(data){
                $('#alert-'+id).fadeOut();
            }
        });
    });
</script>
