<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Marketplace Orders</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table id="ordersTable" class="table table-striped table-bordered base-style" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $index => $row): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $row['order_number'] ?></td>
                            <td><?= htmlspecialchars($row['name'] ?? 'Guest') ?></td>
                            <td>LKR <?= number_format($row['total']) ?></td>
                            <td><span class="badge badge-info"><?= strtoupper($row['status']) ?></span></td>
                            <td>
                                <a href="<?= base_url('shop/view_order/'.$row['id']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
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
    $('#ordersTable').DataTable({
        'responsive': true
    });
});
</script>
