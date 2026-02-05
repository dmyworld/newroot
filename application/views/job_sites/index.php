<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Job Sites') ?></h5>
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
                <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #795548;">
                    <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideSite" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                        <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                    </div>
                    <div id="guideSite" class="collapse">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_site">🇬🇧 English</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_site">🇱🇰 Sinhala</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_site">IN Tamil</a></li>
                            </ul>
                            <div class="tab-content border p-2 bg-white">
                                <div id="eng_site" class="tab-pane active">
                                    <h6 class="text-primary mt-1 small">Job Sites Management</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>Add Site:</strong> Create new locations for specific client projects.</li>
                                        <li><strong>Selection:</strong> Choose a client first to view or add their sites.</li>
                                        <li><strong>Details:</strong> Enter precise address and region info for delivery tracking.</li>
                                    </ol>
                                </div>
                                <div id="sin_site" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">වැඩ බිම් කළමනාකරණය</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>එක් කරන්න:</strong> විශේෂිත පාරිභෝගික ව්‍යාපෘති සඳහා නව ස්ථාන සාදන්න.</li>
                                        <li><strong>තෝරාගැනීම:</strong> ඔවුන්ගේ වැඩබිම් බැලීමට හෝ එක් කිරීමට පළමුව පාරිභෝගිකයෙකු තෝරන්න.</li>
                                        <li><strong>විස්තර:</strong> බෙදාහැරීම් නිරීක්ෂණය සඳහා නිශ්චිත ලිපිනය සහ ප්‍රාදේශීය තොරතුරු ඇතුළත් කරන්න.</li>
                                    </ol>
                                </div>
                                <div id="tam_site" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">பணி தளங்கள் மேலாண்மை</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>தளம் சேர்:</strong> குறிப்பிட்ட வாடிக்கையாளர் திட்டங்களுக்கு புதிய இடங்களை உருவாக்கவும்.</li>
                                        <li><strong>தேர்வு:</strong> தளங்களைக் காண அல்லது சேர்க்க முதலில் வாடிக்கையாளரைத் தேர்ந்தெடுக்கவும்.</li>
                                        <li><strong>விவரங்கள்:</strong> டெலிவரி கண்காணிப்புக்கு துல்லியமான முகவரி மற்றும் பிராந்தியத் தகவலை உள்ளிடவும்.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End User Guide -->
                <div class="row">
                    <div class="col-md-4">
                        <?php if(!empty($cid)) { ?>
                        <form id="add_site_form">
                            <input type="hidden" name="customer_id" value="<?php echo $cid; ?>">
                            <div class="form-group">
                                <label for="name">Site Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" name="address" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" name="city">
                            </div>
                             <div class="form-group">
                                <label for="region">Region</label>
                                <input type="text" class="form-control" name="region">
                            </div>
                             <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" name="country">
                            </div>
                             <div class="form-group">
                                <label for="postbox">Postbox</label>
                                <input type="text" class="form-control" name="postbox">
                            </div>
                            <button type="submit" class="btn btn-primary" id="submit-data">Add Site</button>
                        </form>
                         <?php } else { ?>
                             <div class="alert alert-info">
                                 Select a client or use <a href="<?php echo base_url('jobsites/create') ?>">Add Site</a> page to create new.
                             </div>
                         <?php } ?>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($sites as $site) { ?>
                                <tr>
                                    <td><?php echo $site['name']; ?></td>
                                    <td><?php echo $site['address']; ?></td>
                                    <td><?php echo $site['city']; ?></td>
                                    <td><a href="#" data-object-id="<?php echo $site['id']; ?>" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!empty($cid)) { ?>
<script type="text/javascript">
    $("#submit-data").on("click", function (e) {
        e.preventDefault();
        var o_data =  $("#add_site_form").serialize();
        var action_url = baseurl + 'jobsites/create';
        addObject(o_data, action_url);
    });
</script>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.table').DataTable({
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true
                },
                {
                    extend: 'csvHtml5',
                    footer: true
                }
            ]
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
                <p><?php echo $this->lang->line('delete_this') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="jobsites/delete">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
