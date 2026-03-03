<?php defined('BASEPATH') OR exit; ?>
<div class="content-wrapper">
     <div class="content-header row">
        <div class="content-header-left col-12 mb-2 text-center">
            <h2 class="content-header-title mb-0">Claim Your Referral Rewards</h2>
        </div>
    </div>

    <div class="content-body">
        <div class="row justify-content-center">
            <!-- Referral Code Card -->
            <div class="col-md-6 mb-3">
                <div class="card text-center py-4" style="background:#f1f5f9; border-radius:24px;">
                    <div class="card-body">
                        <h6 class="text-muted mb-2">Share your code to earn rewards</h6>
                        <div class="display-4 font-weight-bold text-primary mb-3" id="refCode" style="letter-spacing:4px; font-family:monospace;">
                            <?= $my_code ?>
                        </div>
                        <button class="btn btn-primary px-3 rounded-pill" onclick="copyCode()">
                            <i class="ft-copy mr-1"></i> Copy Link
                        </button>
                        <div class="mt-3">
                            <h4 class="text-success"><?= $stats['rewarded'] ?> Rewards Paid</h4>
                            <p class="text-muted small">You have <?= $stats['qualified'] - $stats['rewarded'] ?> pending rewards to claim.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Referrals Table -->
        <div class="card">
             <div class="card-header"><h4 class="card-title">Referral Activity</h4></div>
             <div class="card-body">
                 <div class="table-responsive">
                     <table class="table table-hover">
                         <thead class="thead-light">
                             <tr>
                                 <th>Signed Up At</th>
                                 <th>Referred User ID</th>
                                 <th>Status</th>
                                 <th>Reward Status</th>
                                 <th>Action</th>
                             </tr>
                         </thead>
                         <tbody>
                            <?php if(empty($my_referrals)): ?>
                                <tr><td colspan="5" class="text-center">Start referring to see activity here!</td></tr>
                            <?php else: foreach($my_referrals as $row): ?>
                                <tr>
                                    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                                    <td>User #<?= $row['referred_user_id'] ?></td>
                                    <td>
                                        <span class="badge badge-<?= $row['status'] == 'qualified' ? 'success' : 'secondary' ?>">
                                            <?= strtoupper($row['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= $row['referrer_rewarded'] ? '<span class="text-success"><i class="ft-check mr-1"></i>PAID</span>' : '<span class="text-muted">PENDING</span>' ?>
                                    </td>
                                    <td>
                                        <?php if($row['status'] == 'qualified' && !$row['referrer_rewarded']): ?>
                                            <a href="<?= site_url('referral/claim_reward/'.$row['id']) ?>" class="btn btn-sm btn-success">Claim Rs. 500</a>
                                        <?php else: ?>
                                            —
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                         </tbody>
                     </table>
                 </div>
             </div>
        </div>
    </div>
</div>

<script>
function copyCode() {
    const code = "<?= base_url('user/registration?ref=' . $my_code) ?>";
    navigator.clipboard.writeText(code);
    alert('Referral link copied to clipboard!');
}
</script>
