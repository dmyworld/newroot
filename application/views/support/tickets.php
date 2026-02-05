<article class="content-body">
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-xs-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-body text-xs-left">
                                <h3 class="pink" id="dash_0"></h3>
                                <span><?php echo $this->lang->line('Waiting') ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="fa fa-clock-o pink font-large-2 float-xs-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-xs-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-body text-xs-left">
                                <h3 class="blue" id="dash_1"></h3>
                                <span><?php echo $this->lang->line('Processing') ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="fa fa-refresh blue font-large-2 float-xs-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-xs-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-body text-xs-left">
                                <h3 class="success" id="dash_2"></h3>
                                <span><?php echo $this->lang->line('Solved') ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="fa fa-check-circle success font-large-2 float-xs-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-xs-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-body text-xs-left">
                                <h3 class="cyan"><?php echo $totalt ?></h3>
                                <span><?php echo $this->lang->line('Total') ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="fa fa-pie-chart cyan font-large-2 float-xs-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">
             <!-- User Guide -->
            <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #FF4081;">
                <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideTkt" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                    <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                </div>
                <div id="guideTkt" class="collapse">
                    <div class="card-body p-2">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_tkt">🇬🇧 English</a></li>
                            <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_tkt">🇱🇰 Sinhala</a></li>
                            <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_tkt">IN Tamil</a></li>
                        </ul>
                        <div class="tab-content border p-2 bg-white">
                            <div id="eng_tkt" class="tab-pane active">
                                <h6 class="text-primary mt-1 small">Support Tickets</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>Dashboard:</strong> Monitor tickets by status (Waiting, Processing, Solved).</li>
                                    <li><strong>Action:</strong> Click on a ticket subject to view details and reply.</li>
                                    <li><strong>Filtering:</strong> Use filters to prioritize urgent customer issues.</li>
                                </ol>
                            </div>
                            <div id="sin_tkt" class="tab-pane fade">
                                <h6 class="text-primary mt-1 small">සහාය සේවා (Tickets)</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>පුවරුව:</strong> තත්වය අනුව ටිකට්පත් නිරීක්ෂණය කරන්න (Waiting, Solved).</li>
                                    <li><strong>ක්‍රියාව:</strong> විස්තර බැලීමට සහ පිළිතුරු දීමට මාතෘකාව මත ක්ලික් කරන්න.</li>
                                    <li><strong>පෙරීම:</strong> හදිසි ගැටළු සඳහා ප්‍රමුඛත්වය ලබා දීමට ෆිල්ටර් භාවිතා කරන්න.</li>
                                </ol>
                            </div>
                            <div id="tam_tkt" class="tab-pane fade">
                                <h6 class="text-primary mt-1 small">ஆதரவு டிக்கெட்டுகள்</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>கண்ணோட்டம்:</strong> நிலை அடிப்படையில் டிக்கெட்டுகளைக் கண்காணிக்கவும்.</li>
                                    <li><strong>செயல்:</strong> விவரங்களைக் காண மற்றும் பதிலளிக்க தலைப்பைக் கிளிக் செய்யவும்.</li>
                                    <li><strong>வடிகட்டுதல்:</strong> அவசரமான சிக்கல்களுக்கு முன்னுரிமை அளிக்க வடிப்பான்களைப் பயன்படுத்தவும்.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End User Guide -->
            <div class="header-block">
                <h3 class="title">
                    <?php echo $this->lang->line('Support Tickets') ?>
                </h3></div>


            <p>&nbsp;</p>


            <table id="doctable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                   width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Subject') ?></th>
                    <th><?php echo $this->lang->line('Added') ?></th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th><?php echo $this->lang->line('Action') ?></th>


                </tr>
                </thead>
                <tbody>

                </tbody>

            </table>
        </div>
    </div>
    <input type="hidden" id="dashurl" value="tickets/ticket_stats">
</article>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this ticket') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="tickets/delete_ticket">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('#doctable').DataTable({

            "processing": true,
            "serverSide": true,
            responsive: true,
            "ajax": {
                "url": "<?php if (isset($_GET['filter'])) {
                    $filter = $_GET['filter'];
                } else {
                    $filter = '';
                }    echo site_url('tickets/tickets_load_list?stat=' . $filter)?>",
                "type": "POST",
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },
            ],
            "order": [[2, "desc"]]

        });
        miniDash();
    });
</script>
