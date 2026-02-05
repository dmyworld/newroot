<div class="content-body">
    <div class="card border-0 shadow-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 12px; overflow: hidden;">
        
        <!-- Artistic Header -->
        <div class="card-header p-0" style="background: linear-gradient(135deg, #1a1412 0%, #2B2000 100%);">
            <div class="row no-gutters">
                <div class="col-md-12 text-center pt-4 pb-2">
                    <h2 class="text-white" style="font-family: 'Cinzel', serif; letter-spacing: 1px;"><?php echo $this->lang->line('Income Transactions') ?></h2>
                    <p class="text-white-50 mb-0">Track Organization Income</p>
                </div>
            </div>
            
            <!-- Artistic Tabs -->
            <ul class="nav nav-tabs nav-justified border-0 mt-3" id="transactionTabs" role="tablist">
                <li class="nav-item">
                     <a class="nav-link py-3 filter-tab" href="<?php echo base_url('transactions') ?>" style="border:none; color: rgba(255,255,255,0.7);">
                        <i class="fa fa-list mr-1"></i> <?php echo $this->lang->line('All') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active py-3 filter-tab" href="#" style="border:none; border-bottom: 4px solid #FFC107; color: #fff; background: rgba(255,255,255,0.1);">
                        <i class="fa fa-arrow-down mr-1 text-success"></i> <?php echo $this->lang->line('Income') ?>
                    </a>
                </li>
                <li class="nav-item">
                   <a class="nav-link py-3 filter-tab" href="<?php echo base_url('transactions/expense') ?>" style="border:none; color: rgba(255,255,255,0.7);">
                         <i class="fa fa-arrow-up mr-1 text-danger"></i> <?php echo $this->lang->line('Expenses') ?>
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
             <!-- User Guide -->
            <div class="card collapsed-card mb-4" style="border: 1px solid #ddd; border-left: 5px solid #28a745;">
                <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideIncome" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                    <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                </div>
                <div id="guideIncome" class="collapse">
                    <div class="card-body p-2">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_inc">🇬🇧 English</a></li>
                            <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_inc">🇱🇰 Sinhala</a></li>
                            <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_inc">IN Tamil</a></li>
                        </ul>
                        <div class="tab-content border p-2 bg-white">
                            <div id="eng_inc" class="tab-pane active">
                                <h6 class="text-primary mt-1 small">Managing Income</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>View:</strong> See all income transactions listed by Date, Account, and Payer.</li>
                                    <li><strong>Search:</strong> Use the search bar to find specific transactions by Date or Name.</li>
                                    <li><strong>Export:</strong> Click 'Excel' button to download the report.</li>
                                    <li><strong>Delete:</strong> Use the Action button to remove incorrect entries if permitted.</li>
                                </ol>
                            </div>
                            <div id="sin_inc" class="tab-pane fade">
                                <h6 class="text-primary mt-1 small">ආදායම් කළමනාකරණය</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>බැලීම:</strong> දිනය සහ ගිණුම අනුව ආදායම් විස්තර බලන්න.</li>
                                    <li><strong>සෙවීම:</strong> සෙවුම් තීරුව (Search) භාවිතා කර විශේෂිත ගනුදෙනු සොයන්න.</li>
                                    <li><strong>Export:</strong> වාර්තාව ලබා ගැනීමට 'Excel' බොත්තම ඔබන්න.</li>
                                    <li><strong>මකා දැමීම:</strong> වැරදි ඇතුලත් කිරීම් ඉවත් කිරීමට Action බොත්තම භාවිතා කරන්න.</li>
                                </ol>
                            </div>
                            <div id="tam_inc" class="tab-pane fade">
                                <h6 class="text-primary mt-1 small">வருமான மேலாண்மை</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>பார்வை:</strong> தேதி மற்றும் கணக்கு வாரியாக வருமானத்தைக் காணவும்.</li>
                                    <li><strong>தேடல்:</strong> குறிப்பிட்ட பரிவர்த்தனைகளைக் கண்டறிய தேடலைப் பயன்படுத்தவும்.</li>
                                    <li><strong>ஏற்றுமதி:</strong> அறிக்கையைப் பதிவிறக்க 'Excel' பொத்தானைக் கிளிக் செய்யவும்.</li>
                                    <li><strong>நீக்குதல்:</strong> தவறான பதிவுகளை நீக்க Action பொத்தானைப் பயன்படுத்தவும்.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End User Guide -->

            <div class="table-responsive">
                <table id="trans_table" class="table table-hover table-striped mb-0 text-dark" cellspacing="0" width="100%">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th class="border-top-0"><?php echo $this->lang->line('Date') ?></th>
                            <th class="border-top-0"><?php echo $this->lang->line('Account') ?></th>
                            <th class="border-top-0"><?php echo $this->lang->line('Debit') ?></th>
                            <th class="border-top-0"><?php echo $this->lang->line('Credit') ?></th>
                            <th class="border-top-0"><?php echo $this->lang->line('Payer') ?></th>
                            <th class="border-top-0"><?php echo $this->lang->line('Method') ?></th>
                            <th class="border-top-0"><?php echo $this->lang->line('Action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot class="bg-light text-muted">
                        <tr>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('Account') ?></th>
                            <th><?php echo $this->lang->line('Debit') ?></th>
                            <th><?php echo $this->lang->line('Credit') ?></th>
                            <th><?php echo $this->lang->line('Payer') ?></th>
                            <th><?php echo $this->lang->line('Method') ?></th>
                            <th><?php echo $this->lang->line('Action') ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Tab Styling */
.nav-tabs .nav-link:hover {
    border: none;
    color: #fff !important;
    background: rgba(255,255,255,0.2);
}
.nav-tabs .nav-link.active {
    background: transparent;
    color: #FFC107 !important;
    border-bottom: 4px solid #FFC107 !important;
}
.table td {
    vertical-align: middle;
}
</style>

<script type="text/javascript">
    $(document).ready(function () {
        $('#trans_table').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            responsive: true,
            "ajax": {
                "url": "<?php echo site_url('transactions/translist?type=income')?>",
                "type": "POST",
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": true,
                },
            ], dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'csvHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }
            ],
        });
    });
</script>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this transaction') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="transactions/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>