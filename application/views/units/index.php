<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card-body">
         <!-- User Guide -->
        <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #17a2b8;">
            <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideUnit" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
            </div>
            <div id="guideUnit" class="collapse">
                <div class="card-body p-2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_unit">🇬🇧 English</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_unit">🇱🇰 Sinhala</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_unit">IN Tamil</a></li>
                    </ul>
                    <div class="tab-content border p-2 bg-white">
                        <div id="eng_unit" class="tab-pane active">
                            <h6 class="text-primary mt-1 small">Measurement Units</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>Setup:</strong> Define units like kg, meters, pieces for product tracking.</li>
                                <li><strong>Code:</strong> Use short codes (e.g., 'm' for meters) for quick reference.</li>
                                <li><strong>Usage:</strong> These units will appear when adding new products.</li>
                            </ol>
                        </div>
                        <div id="sin_unit" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">මිනුම් ඒකක (Units)</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>පිහිටුවීම:</strong> භාණ්ඩ සඳහා ඒකක (kg, m, pcs) අර්ථ දක්වන්න.</li>
                                <li><strong>කේතය:</strong> පහසුවෙන් හඳුනා ගැනීමට කෙටි කේත භාවිතා කරන්න.</li>
                                <li><strong>භාවිතය:</strong> නව භාණ්ඩ එකතු කිරීමේදී මෙම ඒකක දිස්වනු ඇත.</li>
                            </ol>
                        </div>
                        <div id="tam_unit" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">அளவீட்டு அலகுகள்</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>அமைப்பு:</strong> பொருட்களைக் கண்காணிக்க அலகுகளை (kg, m) வரையறுக்கவும்.</li>
                                <li><strong>குறியீடு:</strong> குறிப்புக்கு குறுகிய குறியீடுகளைப் பயன்படுத்தவும்.</li>
                                <li><strong>பயன்பாடு:</strong> புதிய தயாரிப்புகளைச் சேர்க்கும்போது இந்த அலகுகள் தோன்றும்.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End User Guide -->
        <h5 class="title"> <?php echo $this->lang->line('Measurement Unit') ?> <a
                    href="<?php echo base_url('units/create') ?>"
                    class="btn btn-primary btn-sm rounded">
                <?php echo $this->lang->line('Add new') ?>
            </a>
        </h5>

        <hr>
        <table id="catgtable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('Name') ?></th>
                <th><?php echo $this->lang->line('Code') ?></th>
                <th><?php echo $this->lang->line('Action') ?></th>


            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach ($units as $row) {
                $cid = $row['id'];
                $name = $row['name'];
                $code = $row['code'];


                echo "<tr>
                    <td>$i</td>
                    <td>$name</td>
                    <td>$code</td>
                 
                    <td><a href='" . base_url("units/edit?id=$cid") . "' class='btn btn-warning btn-xs'><i class='icon-pencil'></i> " . $this->lang->line('Edit') . "</a>&nbsp;<a href='#' data-object-id='" . $cid . "' class='btn btn-danger btn-xs delete-object' title='Delete'><i class='fa fa-trash'></i></a></td></tr>";
                $i++;
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('Name') ?></th>
                <th><?php echo $this->lang->line('Code') ?></th>
                <th><?php echo $this->lang->line('Action') ?></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#catgtable').DataTable({responsive: true});

    });
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this location') ?></strong></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="units/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>