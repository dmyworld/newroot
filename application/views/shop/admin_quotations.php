<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Received Quotation Requests</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table id="quotesTable" class="table table-striped table-bordered base-style" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Lot Ref</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($quotes as $index => $row): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $row['order_number'] ?></td>
                            <td><?= $this->_get_customer_name($row['customer_id']) ?></td>
                            <td><?= $row['lot_type'] ?> #<?= $row['lot_id'] ?></td>
                            <td><?= date('Y-m-d', strtotime($row['created_at'])) ?></td>
                            <td><span class="badge badge-warning"><?= strtoupper($row['status']) ?></span></td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="viewQuote(<?= $row['id'] ?>)">View & Respond</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    $('#quotesTable').DataTable({
        'responsive': true
    });
});
</script>
