<?php defined('BASEPATH') OR exit; ?>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <h2 class="content-header-title mb-0">Create Service Request</h2>
        </div>
    </div>

    <div class="content-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-3">
                        <form action="<?= site_url('ring/submit') ?>" method="post">
                            <div class="form-group mb-2">
                                <label for="title">Request Title</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="e.g., Need Timber Delivery for Site A" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label for="request_type">Request Type</label>
                                    <select name="request_type" id="request_type" class="form-control">
                                        <option value="transport">Transport / Logistics</option>
                                        <option value="harvesting">Harvesting Services</option>
                                        <option value="processing">On-site Processing</option>
                                        <option value="consultancy">Expert Consultancy</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label for="budget">Estimated Budget (Rs.)</label>
                                    <input type="number" name="budget" id="budget" class="form-control" step="0.01" value="0.00">
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="description">Detailed Description</label>
                                <textarea name="description" id="description" rows="5" class="form-control" placeholder="Describe what you need..."></textarea>
                            </div>

                            <div class="alert alert-info py-1 mb-2">
                                <i class="ft-info mr-1"></i>
                                Your current location will be broadcasted to nearby providers for better targeting.
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="<?= site_url('ring') ?>" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary px-3">
                                    <i class="ft-wifi mr-1"></i> Broadcast Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
