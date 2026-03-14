<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h5>Add New Service</h5>
            <hr>
        </div>
    </div>

    <div class="premium-card">
        <div class="card-content">
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="service_name">Service Name</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Service Name" class="form-control margin-bottom b_input required" name="service_name" id="service_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="service_desc">Description</label>
                        <div class="col-sm-8">
                            <textarea placeholder="Description" class="form-control margin-bottom b_input" name="service_desc" rows="6" id="service_desc"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="cat_id">Main Category</label>
                        <div class="col-sm-6">
                            <select name="cat_id" class="form-control" id="cat_id">
                                <option value="">-- Select Category --</option>
                                <?php foreach ($main_cats as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="sub_cat_id">Sub Category</label>
                        <div class="col-sm-6">
                            <select name="sub_cat_id" class="form-control" id="sub_cat_id">
                                <option value="0">-- Select Sub Category --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="admin_commission_pc">Admin Commission (%)</label>
                        <div class="col-sm-6">
                            <input type="number" step="0.01" placeholder="0.00" class="form-control margin-bottom b_input" name="admin_commission_pc" id="admin_commission_pc">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="min_price">Minimum Price (Worker)</label>
                        <div class="col-sm-6">
                            <input type="number" step="0.01" placeholder="0.00" class="form-control margin-bottom b_input" name="min_price" id="min_price">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="max_price">Maximum Price (Worker)</label>
                        <div class="col-sm-6">
                            <input type="number" step="0.01" placeholder="0.00" class="form-control margin-bottom b_input" name="max_price" id="max_price">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-premium btn-primary-glass" value="Add Service" data-loading-text="Adding...">
                            <input type="hidden" value="services/add" id="action-url">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#cat_id').on('change', function () {
            var cat_id = $(this).val();
            if (cat_id) {
                $.ajax({
                    url: "<?php echo base_url('services/get_sub_cats') ?>",
                    type: 'POST',
                    data: {cat_id: cat_id, '<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    dataType: 'json',
                    success: function (data) {
                        $('#sub_cat_id').html('<option value="0">-- Select Sub Category --</option>');
                        $.each(data, function (key, value) {
                            $('#sub_cat_id').append('<option value="' + value.id + '">' + value.title + '</option>');
                        });
                    }
                });
            } else {
                $('#sub_cat_id').html('<option value="0">-- Select Sub Category --</option>');
            }
        });
    });
</script>
