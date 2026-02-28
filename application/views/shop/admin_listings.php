<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">My Marketplace Listings</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <table id="listingsTable" class="table table-striped table-bordered base-style" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lots as $index => $lot): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($lot['species'] ?? $lot['lot_name'] ?? 'N/A') ?></td>
                            <td><span class="badge badge-info"><?= strtoupper($lot['lot_type'] ?? 'Logs') ?></span></td>
                            <td><?= htmlspecialchars($lot['location'] ?? $lot['district'] ?? 'Sri Lanka') ?></td>
                            <td>LKR <?= number_format($lot['price'] ?? 0) ?></td>
                            <td><span class="badge badge-success"><?= strtoupper($lot['status'] ?? 'Available') ?></span></td>
                            <td>
                                <a href="<?= base_url('shop/view/'.$lot['type'].'/'.$lot['id']) ?>" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                <button class="btn btn-danger btn-sm" onclick="deleteListing(<?= $lot['id'] ?>, '<?= $lot['type'] ?>')"><i class="fa fa-trash"></i></button>
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
    $('#listingsTable').DataTable({
        'responsive': true
    });
});
</script>
