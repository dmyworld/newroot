<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h3><?php echo $title . ': ' . $project['project_name']; ?></h3>
            <a href="<?php echo base_url('project_command/explore?id=' . $project['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back to Project</a>
            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#uploadDocumentModal"><i class="fa fa-upload"></i> Upload Document</button>
        </div>
        <div class="card-body">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Uploaded By</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($documents)) { ?>
                        <tr><td colspan="6" class="text-center">No documents found.</td></tr>
                    <?php } else { foreach ($documents as $d) { ?>
                    <tr>
                        <td><?php echo dateformat($d['upload_date']); ?></td>
                        <td><a href="<?php echo base_url('userfiles/project_docs/' . $d['filename']); ?>" target="_blank"><?php echo $d['title']; ?></a></td>
                        <td><?php echo strtoupper(str_replace('.', '', $d['file_type'])); ?></td>
                        <td><?php echo $d['uploader_name']; ?></td>
                        <td><?php echo $d['notes']; ?></td>
                        <td>
                            <a href="<?php echo base_url('userfiles/project_docs/' . $d['filename']); ?>" class="btn btn-info btn-sm" download><i class="fa fa-download"></i></a>
                            <button class="btn btn-danger btn-sm delete-document" data-id="<?php echo $d['id']; ?>"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadDocumentModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Document</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form id="upload_document_form" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="pid" value="<?php echo $project['id']; ?>">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">File</label>
                        <div class="col-sm-10">
                            <input type="file" name="userfile" class="form-control" required>
                        </div>
                    </div>
                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Notes</label>
                        <div class="col-sm-10">
                            <textarea name="notes" class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary" id="save_document">Upload</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        
        $('#save_document').click(function(){
            var formData = new FormData($("#upload_document_form")[0]);
            
            $.ajax({
                url: "<?php echo base_url('project_command/upload_document'); ?>",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var result = JSON.parse(data);
                    if(result.status == 'Success'){
                        location.reload();
                    } else {
                        alert(result.message);
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        $('.delete-document').click(function(){
            if(confirm('Delete Document? This cannot be undone.')){
                var id = $(this).data('id');
                $.post("<?php echo base_url('project_command/delete_document'); ?>", {id: id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}, function(data){
                     var result = JSON.parse(data);
                     if(result.status == 'Success'){
                        location.reload();
                     } else {
                        alert(result.message);
                     }
                });
            }
        });
    });
</script>
