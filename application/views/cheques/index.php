<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="content-header row mb-1">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0 font-weight-bolder text-primary">💼 Cheque Registry</h3>
            <div class="grey-text mt-1">Track, manage and approve your incoming & outgoing payments.</div>
        </div>
        <div class="content-header-right col-md-6 col-12 text-md-right">
            <a href="<?php echo base_url('ChequeManager/add'); ?>" class="btn btn-primary shadow-sm rounded-pill font-weight-bold" style="padding: 10px 25px;">
                <i class="fa fa-plus-circle mr-1"></i> Add New Cheque
            </a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="row mb-2">
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card bg-gradient-x-info white shadow-sm" style="border-radius: 15px;">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="font-large-1 mb-0"><?php echo amountExchange($stats['amount_pdc_in'], 0, $this->aauth->get_user()->loc); ?></h3>
                                <span class="text-uppercase font-small-3">PDC In (Receivable)</span>
                            </div>
                            <div class="align-self-center">
                                <i class="fa fa-arrow-circle-o-down white font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card bg-gradient-x-danger white shadow-sm" style="border-radius: 15px;">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="font-large-1 mb-0"><?php echo amountExchange($stats['amount_pdc_out'], 0, $this->aauth->get_user()->loc); ?></h3>
                                <span class="text-uppercase font-small-3">PDC Out (Payable)</span>
                            </div>
                            <div class="align-self-center">
                                <i class="fa fa-arrow-circle-o-up white font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card bg-gradient-x-success white shadow-sm" style="border-radius: 15px;">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="font-large-1 mb-0"><?php echo $stats['total_cleared']; ?></h3>
                                <span class="text-uppercase font-small-3">Cleared This Month</span>
                            </div>
                            <div class="align-self-center">
                                <i class="fa fa-check-circle-o white font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card bg-gradient-x-warning white shadow-sm" style="border-radius: 15px;">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="font-large-1 mb-0"><?php echo $stats['total_returned']; ?></h3>
                                <span class="text-uppercase font-small-3">Returned / Bounced</span>
                            </div>
                            <div class="align-self-center">
                                <i class="fa fa-exclamation-triangle white font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-header border-0 pb-0">
                <h4 class="card-title font-weight-bold">Transaction History</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-white-space table-hover mb-0" id="cheque_table">
                            <thead class="bg-light">
                                <tr class="text-uppercase text-muted font-small-3">
                                    <th class="border-top-0">Due Date</th>
                                    <th class="border-top-0">Ref #</th>
                                    <th class="border-top-0">Type</th>
                                    <th class="border-top-0">Party (Payee/Payer)</th>
                                    <th class="border-top-0">Amount</th>
                                    <th class="border-top-0">Status</th>
                                    <th class="border-top-0 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($cheques)): ?>
                                    <tr><td colspan="7" class="text-center py-4 text-muted border-0">No cheque records found for the current filter.</td></tr>
                                <?php else: ?>
                                    <?php foreach($cheques as $cheque): ?>
                                    <tr class="align-middle">
                                        <td class="font-weight-bold text-dark">
                                            <div class="d-flex flex-column">
                                                <span><?php echo dateformat($cheque['clear_date']); ?></span>
                                                <small class="text-muted">Issued: <?php echo dateformat($cheque['issue_date']); ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-primary font-weight-bold">#<?php echo $cheque['cheque_number'] ?: $cheque['id']; ?></span>
                                        </td>
                                        <td>
                                            <?php if(strtolower($cheque['type']) == 'incoming'): ?>
                                                <span class="badge badge-pill badge-light-success text-uppercase font-weight-bold" style="padding: 6px 12px; font-size: 0.7rem;">
                                                    <i class="fa fa-arrow-down mr-1"></i> Incoming
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-pill badge-light-danger text-uppercase font-weight-bold" style="padding: 6px 12px; font-size: 0.7rem;">
                                                    <i class="fa fa-arrow-up mr-1"></i> Outgoing
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-rgba-primary p-50 mr-1" style="width: 32px; height: 32px; border-radius: 50%; background: #f0f3ff; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-user text-primary" style="font-size: 0.8rem;"></i>
                                                </div>
                                                <span class="font-weight-bold"><?php echo ($cheque['type'] == 'Incoming' ? $cheque['customer_name'] : $cheque['supplier_name']) ?: $cheque['payee']; ?></span>
                                            </div>
                                        </td>
                                        <td class="font-weight-bolder text-dark h5 mb-0">
                                            <?php echo amountExchange($cheque['amount'], 0, $this->aauth->get_user()->loc); ?>
                                        </td>
                                        <td>
                                            <?php 
                                                $b_class = 'warning';
                                                $status = $cheque['status'];
                                                switch(strtolower($status)) {
                                                    case 'cleared': $b_class = 'success'; break;
                                                    case 'bounced': 
                                                    case 'returned': $b_class = 'danger'; break;
                                                    case 'issued': 
                                                    case 'signed': $b_class = 'info'; break;
                                                    case 'pending': $b_class = 'warning'; break;
                                                }
                                            ?>
                                            <span class="badge bg-<?php echo $b_class; ?> rounded-pill text-white" style="padding: 5px 15px; font-size: 0.7rem; font-weight: 800;"><?php echo strtoupper($status); ?></span>
                                        </td>
                                        <td class="text-right">
                                            <div class="btn-group">
                                                <a href="<?php echo base_url('ChequeManager/edit?id=' . $cheque['id']); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-2" title="View / Approve">
                                                    <i class="fa fa-eye mr-1"></i> Details
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-rgba-primary { background-color: rgba(98, 110, 212, 0.12) !important; }
    .badge-light-success { background-color: #e3f9eb; color: #39da8a !important; }
    .badge-light-danger { background-color: #ffebf0; color: #ff5b5c !important; }
    .table thead th { border-bottom: none !important; }
    .table td { border-top: 1px solid #f1f3f8 !important; vertical-align: middle; }
    .card { transition: transform 0.3s ease; }
    .card:hover { transform: translateY(-3px); }
</style>

<script>
$(document).ready(function() {
    // Optional: Add sorting or searching logic here if not using server-side datatables
});
</script>
