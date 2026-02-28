<div class="content-body">
    <div class="card">
        <div class="card-header bg-gradient-x-purple-blue white">
            <h4 class="card-title">Timber Industry Job Portal</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-8">
                        <p class="text-muted">Explore career opportunities in the timber industry. Connect with top employers and skilled workers.</p>
                    </div>
                    <?php if ($this->aauth->get_user()->roleid >= 3) { ?>
                    <div class="col-md-4 text-right">
                        <a href="<?php echo base_url('jobs/post'); ?>" class="btn btn-success btn-md">
                            <i class="ft-plus"></i> Post a Job
                        </a>
                    </div>
                    <?php } ?>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-primary white">
                            <tr>
                                <th>Job Title</th>
                                <th>Department</th>
                                <th>Location</th>
                                <th>Rate (Hourly)</th>
                                <th>Posted</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($jobs)) {
                                foreach ($jobs as $job) { ?>
                                    <tr>
                                        <td>
                                            <span class="text-bold-600"><?php echo $job['title']; ?></span>
                                            <br><small class="text-muted"><?php echo substr(strip_tags($job['description']), 0, 100); ?>...</small>
                                        </td>
                                        <td><span class="badge badge-info"><?php echo $job['dept_name']; ?></span></td>
                                        <td><i class="ft-map-pin"></i> <?php echo $job['location']; ?></td>
                                        <td class="text-success text-bold-600">
                                            <?php echo amountFormat_s($job['hourly_rate_min']); ?> - <?php echo amountFormat_s($job['hourly_rate_max']); ?>
                                        </td>
                                        <td><?php echo date('d-M-Y', strtotime($job['created_at'])); ?></td>
                                        <td class="text-right">
                                            <button onclick="applyJob(<?php echo $job['id']; ?>)" class="btn btn-outline-primary btn-sm">Apply Now</button>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="6" class="text-center p-3">No open job vacancies at the moment.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h5 class="modal-title">Job Application</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="apply_form">
                    <input type="hidden" name="job_id" id="job_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Cover Letter (Optional)</label>
                                <textarea name="cover_letter" class="form-control" rows="5" placeholder="Tell us why you are a good fit..."></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="submit_application" class="btn btn-success">Submit Application</button>
            </div>
        </div>
    </div>
</div>

<script>
function applyJob(id) {
    $('#job_id').val(id);
    $('#applyModal').modal('show');
}
</script>
