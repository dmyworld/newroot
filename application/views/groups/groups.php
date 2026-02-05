<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <?php echo $this->lang->line('Client Groups') ?> <a href="<?php echo base_url('clientgroup/create') ?>"
                                                                    class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
                </a>
            </h5>
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
                <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #16D39A;">
                    <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideGrp" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                        <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                    </div>
                    <div id="guideGrp" class="collapse">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_grp">🇬🇧 English</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_grp">🇱🇰 Sinhala</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_grp">IN Tamil</a></li>
                            </ul>
                            <div class="tab-content border p-2 bg-white">
                                <div id="eng_grp" class="tab-pane active">
                                    <h6 class="text-primary mt-1 small">Client Groups</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>Overview:</strong> Segment customers into groups (e.g., VIP, Retail).</li>
                                        <li><strong>Discounts:</strong> Click 'Discount' to apply a default discount rate for the group.</li>
                                        <li><strong>Members:</strong> Click 'View' to see all customers in specific group.</li>
                                    </ol>
                                </div>
                                <div id="sin_grp" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">පාරිභෝගික කණ්ඩායම්</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>දළ විශ්ලේෂණය:</strong> පාරිභෝගිකයින් කණ්ඩායම් වලට බෙදන්න (උදා: VIP, සිල්ලර).</li>
                                        <li><strong>වට්ටම්:</strong> කණ්ඩායම සඳහා වට්ටම් අනුපාතයක් යෙදීමට 'Discount' ක්ලික් කරන්න.</li>
                                        <li><strong>සාමාජිකයින්:</strong> කණ්ඩායමේ සිටින පාරිභෝගිකයින් බැලීමට 'View' ක්ලික් කරන්න.</li>
                                    </ol>
                                </div>
                                <div id="tam_grp" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">வாடிக்கையாளர் குழுக்கள்</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>கண்ணோட்டம்:</strong> வாடிக்கையாளர்களை குழுக்களாக பிரிக்கவும் (எ.கா. VIP).</li>
                                        <li><strong>தள்ளுபடிகள்:</strong> குழுவிற்கான தள்ளுபடி விகிதத்தைப் பயன்படுத்த 'Discount' ஐ கிளிக் செய்யவும்.</li>
                                        <li><strong>உறுப்பினர்கள்:</strong> குறிப்பிட்ட குழுவில் உள்ள வாடிக்கையாளர்களைக் காண 'View' ஐ கிளிக் செய்யவும்.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End User Guide -->

                <table id="cgrtable" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Total Clients') ?></th>

                        <th><?php echo $this->lang->line('Action') ?></th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    foreach ($group as $row) {
                        $cid = $row['id'];
                        $title = $row['title'];
                        $total = $row['pc'];

                        echo "<tr>
                    <td>$i</td>
                    <td>$title</td>
                    <td>$total</td>
                    
                    <td><a href='" . base_url("clientgroup/groupview?id=$cid") . "' class='btn btn-success btn-xs'><i class='fa fa-eye'></i>  " . $this->lang->line('View') . "</a>&nbsp;<a href='" . base_url("clientgroup/editgroup?id=$cid") . "' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a>&nbsp;<a href='#' data-object-id='" . $cid . "'  class='btn btn-info btn-xs discount-object' title='Apply Discount'><i class='fa fa-bolt'></i> " . $this->lang->line('Discount') . "</a> <a href='#' data-object-id='" . $cid . "' class='btn btn-danger btn-xs delete-object' title='Delete'><i class='fa fa-trash'></i></a></td></tr>";
                        $i++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Total Clients') ?></th>

                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('#cgrtable').DataTable({responsive: true});

        });
    </script>

    <div id="pop_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Discount'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="form_model">
                        <p>
                            <?php echo $this->lang->line('you can pre-define the discount') ?>
                        </p>
                        <input type="hidden" id="dobject-id" name="gid" value="">


                        <div class="row">
                            <div class="col mb-1"><label
                                        for="pmethod"><?php echo $this->lang->line('Discount') ?></label>
                                <input name="disc_rate" class="form-control mb-1" type="number"
                                       placeholder="Discount Rate in %">


                            </div>
                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                            <input type="hidden" id="action-url" value="clientgroup/discount_update">
                            <button type="button" class="btn btn-primary"
                                    id="submit_model"><?php echo $this->lang->line('Change Status'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete Customer Group') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this customer group') ?></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="clientgroup/delete_i">
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).on('click', ".discount-object", function (e) {
            e.preventDefault();
            $('#dobject-id').val($(this).attr('data-object-id'));
            $(this).closest('tr').attr('id', $(this).attr('data-object-id'));
            $('#pop_model').modal({backdrop: 'static', keyboard: false});
        });
    </script>