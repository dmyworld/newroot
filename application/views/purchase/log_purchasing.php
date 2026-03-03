<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Raw Log Purchasing (Timber Operations)</h4>
            <div class="heading-elements">
                <button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Log Purchase</button>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table id="logPurchasingTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order #</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th>Vol (cuft)</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Action</th>
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
    $('#logPurchasingTable').DataTable({
        'processing': true,
        'serverSide': true,
        'stateSave': true,
        'responsive': true,
        'ajax': {
            'url': "<?php echo site_url('purchase/ajax_list2') ?>",
            'type': 'POST',
            'data': "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>"
        },
        'columnDefs': [
            {
                'targets': [0],
                'orderable': false,
            },
        ],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                footer: true,
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }
        ],
    });
});
</script>
