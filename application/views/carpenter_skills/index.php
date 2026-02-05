<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card-body">
         <!-- User Guide -->
        <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #e83e8c;">
            <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideSkill" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
            </div>
            <div id="guideSkill" class="collapse">
                <div class="card-body p-2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_skill">🇬🇧 English</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_skill">🇱🇰 Sinhala</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_skill">IN Tamil</a></li>
                    </ul>
                    <div class="tab-content border p-2 bg-white">
                        <div id="eng_skill" class="tab-pane active">
                            <h6 class="text-primary mt-1 small">Skill Management</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>Manage:</strong> Users 'Manage Skills' button to add new skill definitions.</li>
                                <li><strong>Assign:</strong> Click 'Assign Skill' to link an employee to a skill.</li>
                                <li><strong>Rate:</strong> Rate proficiency (1-5) and Productivity Score for routing logic.</li>
                            </ol>
                        </div>
                        <div id="sin_skill" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">නිපුණතා කළමනාකරණය</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>කළමනාකරණය:</strong> නව නිපුණතා එක් කිරීමට 'Manage Skills' භාවිතා කරන්න.</li>
                                <li><strong>පැවරීම:</strong> සේවකයෙකුට නිපුණතාවයක් පැවරීමට 'Assign Skill' ක්ලික් කරන්න.</li>
                                <li><strong>ශ්‍රේණිගත කිරීම:</strong> දක්ෂතාවය (1-5) සහ ඵලදායිතා ලකුණු සටහන් කරන්න.</li>
                            </ol>
                        </div>
                        <div id="tam_skill" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">திறன் மேலாண்மை</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>மேலாண்மை:</strong> புதிய திறன்களைச் சேர்க்க 'Manage Skills' ஐப் பயன்படுத்தவும்.</li>
                                <li><strong>ஒதுக்கீடு:</strong> பணியாளருக்குத் திறனை ஒதுக்க 'Assign Skill' ஐ கிளிக் செய்யவும்.</li>
                                <li><strong>மதிப்பீடு:</strong> திறமை (1-5) மற்றும் உற்பத்தி மதிப்பெண்ணை மதிப்பிடவும்.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End User Guide -->
        <h5 class="title"> Carpenter Skill Matrix <a
                    href="<?php echo base_url('carpenter_skills/assign') ?>"
                    class="btn btn-primary btn-sm rounded">
                Assign Skill
            </a>
            <button class="btn btn-info btn-sm rounded" data-toggle="modal" data-target="#addSkillModal">
                Manage Skills
            </button>
        </h5>
        <hr>
        <table id="matrix_table" class="table table-striped table-bordered zero-configuration" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Employee Name</th>
                <th>Skill</th>
                <th>Proficiency (1-5)</th>
                <th>Productivity Score</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
                <th>#</th>
                <th>Employee Name</th>
                <th>Skill</th>
                <th>Proficiency (1-5)</th>
                <th>Productivity Score</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Modal for Adding New Skill Definitions -->
<div id="addSkillModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Skill</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="skill_form">
                    <div class="form-group">
                        <label for="skill_name">Skill Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="skill_desc">Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <button type="button" id="save_skill" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#matrix_table').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'responsive': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('carpenter_skills/get_matrix')?>",
                'type': 'POST',
                'data': {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
        });
        
        $('#save_skill').click(function() {
            $.ajax({
                url: "<?php echo site_url('carpenter_skills/manage_skills')?>",
                type: 'POST',
                data: $('#skill_form').serialize() + '&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
                dataType: 'json',
                success: function(data) {
                    $('#addSkillModal').modal('hide');
                    alert(data.message);
                    location.reload(); // Reload to refresh dropdowns if needed elsewhere, primarily just to close.
                }
            });
        });
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
                <p>Delete this assignment?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="carpenter_skills/delete_assignment">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
