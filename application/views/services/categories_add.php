<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h5>Add Service Category</h5>
            <hr>
        </div>
    </div>

    <div class="premium-card">
        <div class="card-content">
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="title">Category Name</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Category Name" class="form-control margin-bottom b_input required" name="title" id="title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="extra">Description</label>
                        <div class="col-sm-6">
                            <textarea placeholder="Description" class="form-control margin-bottom b_input" name="extra" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="c_type">Type</label>
                        <div class="col-sm-6">
                            <select name="c_type" class="form-control" id="c_type">
                                <option value="0">Main Category</option>
                                <option value="1">Sub Category</option>
                            </select>
                        </div>
                    </div>
                    <div id="rel_id_div" class="form-group row" style="display:none;">
                        <label class="col-sm-2 col-form-label" for="rel_id">Main Category</label>
                        <div class="col-sm-6">
                            <select name="rel_id" class="form-control">
                                <?php foreach ($main_cats as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="icon">Icon / Image</label>
                        <div class="col-sm-6">
                            <input type="file" name="icon" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-premium btn-primary-glass" value="Add Category" data-loading-text="Adding...">
                            <input type="hidden" value="servicecategories/add" id="action-url">
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
