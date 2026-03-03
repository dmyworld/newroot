<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Slab Inventory (Sawmill Byproducts)</h4>
            <div class="heading-elements">
                <a href="<?php echo base_url('sawmill/new_job') ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Sawing Job</a>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <select class="form-control" id="filterLocation">
                            <option value="">All Locations</option>
                            <?php foreach ($locations as $loc): ?>
                                <option value="<?= $loc['id'] ?>"><?= $loc['cname'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <table id="slabsTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Volume (CF)</th>
                            <th>Date Created</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    var table = $('#slabsTable').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": "<?php echo site_url('sawmill/ajax_slabs_list') ?>",
            "type": "POST",
            "data": function(d) {
                d.loc = $('#filterLocation').val();
                d.<?=$this->security->get_csrf_token_name()?> = '<?=$this->security->get_csrf_hash()?>';
            },
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "product_name" },
            { "data": "qty" },
            { "data": "created_at" },
            { 
                "data": "status",
                "render": function(data) {
                    return '<span class="badge badge-success">' + data.toUpperCase() + '</span>';
                }
            },
            {
                "data": "id",
                "render": function(data) {
                    return '<button class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button>';
                }
            }
        ]
    });

    $('#filterLocation').change(function() {
        table.ajax.reload();
    });
});
</script>
