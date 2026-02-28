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
                            <th>Supplier</th>
                            <th>Species</th>
                            <th>Vol (cuft)</th>
                            <th>Total Price</th>
                            <th>Status</th>
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
        'responsive': true
    });
});
</script>
