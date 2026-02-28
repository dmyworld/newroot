<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Sawn Timber Inventory (Retail Ready)</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table id="sawnInventoryTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Species</th>
                            <th>Dimensions</th>
                            <th>Qty (Pieces)</th>
                            <th>Total Vol (cuft)</th>
                            <th>Location</th>
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
    $('#sawnInventoryTable').DataTable({
        'responsive': true
    });
});
</script>
