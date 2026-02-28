<div class="content-body">
    <div class="timber-header" style="background: linear-gradient(135deg, #13ec5b 0%, #0fa84b 100%) !important;">
        <h1><i class="fa fa-users"></i> Browse Available Workers</h1>
        <p>Find skilled professionals ready to join your team</p>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5><i class="fa fa-filter"></i> Filters</h5>
                    <hr>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="filterCategory">
                            <option value="">All Categories</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['val1'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" class="form-control" id="filterLocation" placeholder="Enter location">
                    </div>
                    <button class="btn btn-primary btn-block" onclick="applyFilters()">
                        <i class="fa fa-search"></i> Apply Filters
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <?php if(empty($workers)): ?>
                <div class="text-center p-5">
                    <i class="fa fa-users fa-4x text-muted mb-3"></i>
                    <h3>No Workers Available</h3>
                    <p>Check back later for new talent</p>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach($workers as $worker): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card worker-card shadow-sm border-0 h-100">
                                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);">
                                    <h5 class="text-white mb-0">
                                        <i class="fa fa-user-circle"></i> <?= $worker['display_name'] ?>
                                        <span class="badge badge-success float-right">Available</span>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Category:</strong> <?= $worker['category_name'] ?></p>
                                    <p><strong>Experience:</strong> <?= $worker['experience_years'] ?> years</p>
                                    <p><strong>Rate:</strong> $<?= number_format($worker['hourly_rate'], 2) ?>/hour</p>
                                    <p><strong>Location:</strong> <?= $worker['location'] ?: 'Not specified' ?></p>
                                    
                                    <?php 
                                    $skills = json_decode($worker['skills'], true);
                                    if ($skills && count($skills) > 0): 
                                    ?>
                                    <p><strong>Skills:</strong></p>
                                    <div class="mb-3">
                                        <?php foreach($skills as $skill): ?>
                                            <span class="badge badge-info mr-1"><?= $skill ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>

                                    <div class="mt-3">
                                        <a href="<?= base_url('worker/view/' . $worker['id']) ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-eye"></i> View Profile
                                        </a>
                                        <button onclick="showHireModal(<?= $worker['id'] ?>, '<?= $worker['display_name'] ?>')" class="btn btn-success btn-sm float-right">
                                            <i class="fa fa-handshake-o"></i> Hire Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Hire Modal -->
<div class="modal fade" id="hireModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hire <span id="workerName"></span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="hireForm">
                    <input type="hidden" name="worker_id" id="workerId">
                    <div class="form-group">
                        <label>Monthly Salary</label>
                        <input type="number" class="form-control" name="salary" required>
                    </div>
                    <div class="form-group">
                        <label>Commission Rate (%)</label>
                        <input type="number" step="0.01" class="form-control" name="commission" value="0">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="confirmHire()">Confirm Hire</button>
            </div>
        </div>
    </div>
</div>

<script>
function applyFilters() {
    var category = $('#filterCategory').val();
    var location = $('#filterLocation').val();
    window.location.href = '<?= base_url('worker') ?>?category=' + category + '&location=' + location;
}

function showHireModal(id, name) {
    $('#workerId').val(id);
    $('#workerName').text(name);
    $('#hireModal').modal('show');
}

function confirmHire() {
    $.ajax({
        url: '<?= base_url('worker/hire') ?>',
        type: 'POST',
        data: $('#hireForm').serialize(),
        dataType: 'json',
        success: function(response) {
            $('#hireModal').modal('hide');
            if (response.status === 'Success') {
                Swal.fire('Success!', response.message, 'success').then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire('Error!', response.message, 'error');
            }
        }
    });
}
</script>

<style>
    .worker-card {
        transition: all 0.3s ease;
        border-radius: 8px;
        overflow: hidden;
    }
    .worker-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .timber-header {
        padding: 30px;
        text-align: center;
        color: white;
        border-radius: 8px;
        margin-bottom: 20px;
    }
</style>
