<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title"> <?php echo $this->lang->line('Business Locations') ?> <a
                        href="<?php echo base_url('locations/create') ?>"
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
                <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #ff0018;">
                    <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideLoc" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                        <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                    </div>
                    <div id="guideLoc" class="collapse">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_loc">🇬🇧 English</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_loc">🇱🇰 Sinhala</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_loc">IN Tamil</a></li>
                            </ul>
                            <div class="tab-content border p-2 bg-white">
                                <div id="eng_loc" class="tab-pane active">
                                    <h6 class="text-primary mt-1 small">Business Locations</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>Warehouses:</strong> Register physical locations/branches where stock is kept.</li>
                                        <li><strong>Management:</strong> Assign stock and employees to specific locations.</li>
                                        <li><strong>Address:</strong> Keep accurate contact details for each branch.</li>
                                    </ol>
                                </div>
                                <div id="sin_loc" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">ව්‍යාපාරික ස්ථාන</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>ගබඩා:</strong> තොග තබා ඇති ස්ථාන/ශාඛා ලියාපදිංචි කරන්න.</li>
                                        <li><strong>කළමනාකරණය:</strong> නිශ්චිත ස්ථාන වෙත තොග සහ සේවකයින් පවරන්න.</li>
                                        <li><strong>ලිපිනය:</strong> සෑම ශාඛාවක් සඳහාම නිවැරදි විස්තර තබා ගන්න.</li>
                                    </ol>
                                </div>
                                <div id="tam_loc" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">வணிக இருப்பிடங்கள்</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>கிடங்குகள்:</strong> இருப்பு வைக்கப்பட்டுள்ள இடங்களைப் பதிவு செய்யவும்.</li>
                                        <li><strong>மேலாண்மை:</strong> குறிப்பிட்ட இடங்களுக்கு பங்கு மற்றும் பணியாளர்களை நியமிக்கவும்.</li>
                                        <li><strong>முகவரி:</strong> ஒவ்வொரு கிளைக்கும் சரியான விவரங்களை வைத்திருக்கவும்.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End User Guide -->


                <hr>
                <table id="catgtable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Address') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    foreach ($locations as $row) {
                        $cid = $row['id'];
                        $name = $row['cname'];
                        $addr = $row['address'] . ', ' . $row['city'];


                        echo "<tr>
                    <td>$i</td>
                    <td>$name</td>
                    <td>$addr</td>
                 
                    <td><a href='" . base_url("locations/edit?id=$cid") . "' class='btn btn-warning btn-xs'><i class='icon-pencil'></i> " . $this->lang->line('Edit') . "</a>&nbsp;<a href='#' data-object-id='" . $cid . "' class='btn btn-danger btn-xs delete-object' title='Delete'><i class='fa fa-trash'></i></a></td></tr>";
                        $i++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Address') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
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
                <input type="hidden" id="action-url" value="locations/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>