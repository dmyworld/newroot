<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h5>Edit Service Category</h5>
            <hr>
        </div>
    </div>

    <div class="premium-card">
        <div class="card-content">
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $cat['id'] ?>">
                    <input type="hidden" name="old_icon" value="<?php echo $cat['icon'] ?>">
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="title">Category Name</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Category Name" class="form-control margin-bottom b_input required" name="title" id="title" value="<?php echo $cat['title'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="extra">Description</label>
                        <div class="col-sm-6">
                            <textarea placeholder="Description" class="form-control margin-bottom b_input" name="extra" rows="4"><?php echo $cat['extra'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="c_type">Type</label>
                        <div class="col-sm-6">
                            <select name="c_type" class="form-control" id="c_type">
                                <option value="0" <?php if($cat['c_type'] == 0) echo 'selected' ?>>Main Category</option>
                                <option value="1" <?php if($cat['c_type'] == 1) echo 'selected' ?>>Sub Category</option>
                            </select>
                        </div>
                    </div>
                    <div id="rel_id_div" class="form-group row" <?php if($cat['c_type'] == 0) echo 'style="display:none;"' ?>>
                        <label class="col-sm-2 col-form-label" for="rel_id">Main Category</label>
                        <div class="col-sm-6">
                            <select name="rel_id" class="form-control">
                                <?php foreach ($main_cats as $row) {
                                    $sel = ($row['id'] == $cat['rel_id']) ? 'selected' : '';
                                    echo '<option value="' . $row['id'] . '" '.$sel.'>' . $row['title'] . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="icon">Icon / Image</label>
                        <div class="col-sm-6">
                            <img src="<?php echo base_url("userfiles/service_categories/".$cat['icon']) ?>" class="img-responsive rounded mb-1" style="max-height: 100px;">
                            <input type="file" name="icon" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-premium btn-primary-glass" value="Update Category" data-loading-text="Updating...">
                            <input type="hidden" value="servicecategories/edit" id="action-url">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#c_type').on('change', function () {
            if ($(this).val() == 1) {
                $('#rel_id_div').show();
            } else {
                $('#rel_id_div').hide();
            }
        });
    });
</script>
