<div class="content-body">
    <div class="row">
        <div class="col-xl-6 col-md-12">
            <div class="card overflow-hidden">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="bg-primary p-2 media-middle">
                            <i class="fa fa-briefcase font-large-2 white"></i>
                        </div>
                        <div class="media-body p-2">
                            <h4><?php echo $this->lang->line('Balance') ?></h4>
                            <span><?php echo $this->lang->line('Total') ?></span>
                        </div>
                        <div class="media-right p-2 media-middle">
                            <h1 class="success"><span
                                        id="dash_0"></span></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="bg-warning p-2 media-middle">
                            <i class="fa fa-list-alt font-large-2  white"></i>
                        </div>
                        <div class="media-body p-2">
                            <h4><?php echo $this->lang->line('Accounts') ?></h4>
                            <span><?php echo $this->lang->line('Total') ?></span>
                        </div>
                        <div class="media-right p-2 media-middle">
                            <h1 class="cyan" id="dash_1">0</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Accounts') ?> <a
                        href="<?php echo base_url('accounts/add') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?></a></h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">

                 <!-- User Guide -->
                <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #00B5B8;">
                    <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideAcc" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                        <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                    </div>
                    <div id="guideAcc" class="collapse">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_acc">🇬🇧 English</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_acc">🇱🇰 Sinhala</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_acc">IN Tamil</a></li>
                            </ul>
                            <div class="tab-content border p-2 bg-white">
                                <div id="eng_acc" class="tab-pane active">
                                    <h6 class="text-primary mt-1 small">Financial Accounts</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>Balance:</strong> View real-time balances for all business accounts.</li>
                                        <li><strong>Management:</strong> Click 'Add New' to register bank or cash accounts.</li>
                                        <li><strong>History:</strong> Use 'View' to see detailed transaction logs for any account.</li>
                                    </ol>
                                </div>
                                <div id="sin_acc" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">මූල්‍ය ගිණුම්</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>ශේෂය:</strong> සියලුම ව්‍යාපාරික ගිණුම්වල තත්‍ය කාලීන ශේෂයන් බලන්න.</li>
                                        <li><strong>කළමනාකරණය:</strong> බැංකු හෝ මුදල් ගිණුම් ලියාපදිංචි කිරීමට 'Add New' ක්ලික් කරන්න.</li>
                                        <li><strong>ඉතිහාසය:</strong> ඕනෑම ගිණුමක ගනුදෙනු ලැයිස්තුව බැලීමට 'View' භාවිතා කරන්න.</li>
                                    </ol>
                                </div>
                                <div id="tam_acc" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">நிதிக் கணக்குகள்</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>இருப்பு:</strong> அனைத்து வணிகக் கணக்குகளின் நிகழ்நேர இருப்பைக் காண்க.</li>
                                        <li><strong>மேலாண்மை:</strong> வங்கி அல்லது பணக் கணக்குகளைப் பதிவு செய்ய 'Add New' ஐ கிளிக் செய்யவும்.</li>
                                        <li><strong>வரலாறு:</strong> எந்தவொரு கணக்கின் பரிவர்த்தனை தகவலைக் காண 'View' ஐப் பயன்படுத்தவும்.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End User Guide -->


                <div class="table-responsive">
                    <table id="acctable" class="table table-hover mb-1" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('Account No') ?></th>
                            <th><?php echo $this->lang->line('Name') ?></th>
                            <th><?php echo $this->lang->line('Balance') ?></th>
                            <th><?php echo $this->lang->line('Type') ?></th>
                            <th><?php echo $this->lang->line('Actions') ?></th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;
                        foreach ($accounts as $row) {
                            $aid = $row['id'];
                            $acn = $row['acn'];
                            $holder = $row['holder'];
                            $balance = amountExchange($row['lastbal'], 0, $this->aauth->get_user()->loc);
                            $type = $row['account_type'];
                            $qty = $row['adate'];
                            echo "<tr>
                    <td>$i</td>
                    <td>$acn</td>
                    <td>$holder</td>
                 
                    <td>$balance</td>
                     <td>$type</td>
                    <td><a href='" . base_url("accounts/view?id=$aid") . "' class='btn btn-success btn-xs'><i class='fa fa-eye'></i>  " . $this->lang->line('View') . "</a>&nbsp;<a href='" . base_url("accounts/edit?id=$aid") . "' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i>  " . $this->lang->line('Edit') . "</a>&nbsp;<a href='#' data-object-id='" . $aid . "' class='btn btn-danger btn-xs delete-object' title='Delete'><i class='fa fa-trash'></i></a></td></tr>";
                            $i++;
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('Account No') ?></th>
                            <th><?php echo $this->lang->line('Name') ?></th>
                            <th><?php echo $this->lang->line('Balance') ?></th>
                            <th><?php echo $this->lang->line('Type') ?></th>
                            <th><?php echo $this->lang->line('Actions') ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <input type="hidden" id="dashurl" value="accounts/account_stats">
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('#acctable').DataTable({
                responsive: true, dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    }
                ],
            });
            miniDash();

        });
    </script>
    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete Account') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('Delete account message') ?></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="accounts/delete_i">
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>