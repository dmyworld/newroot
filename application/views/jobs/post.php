<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .jobs-container { max-width: 900px; margin: 40px auto; padding: 20px; }
        .post-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 40px; }
        .post-header { border-bottom: 1px solid #eee; margin-bottom: 30px; padding-bottom: 20px; }
        .post-header h2 { color: #2a5298; font-weight: 700; }
        .form-label { font-weight: 600; color: #444; margin-bottom: 8px; }
        .form-control { border-radius: 8px; padding: 12px; border: 1px solid #ddd; transition: all 0.3s; }
        .form-control:focus { border-color: #13ec5b; box-shadow: 0 0 10px rgba(19, 236, 91, 0.2); }
        .btn-post { background: linear-gradient(135deg, #13ec5b 0%, #0fc94d 100%); color: white; border: none; padding: 15px 40px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.3s; }
        .btn-post:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(19, 236, 91, 0.4); }
        .rate-group { display: flex; gap: 20px; }
        .rate-group > div { flex: 1; }
    </style>
</head>
<body>
<div class="jobs-container">
    <div class="post-card">
        <div class="post-header">
            <h2><i class="fa fa-briefcase"></i> Post a New Job Vacancy</h2>
            <p class="text-muted">Hire the best timber industry talent for your branch.</p>
        </div>

        <form id="jobPostForm">
            <div class="form-group mb-4">
                <label class="form-label">Job Title</label>
                <input type="text" name="title" class="form-control" placeholder="e.g. Master Carpenter, Sawmill Operator" required>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label class="form-label">Department</label>
                        <select name="dept_id" class="form-control" required>
                            <?php foreach ($departments as $dept) { ?>
                                <option value="<?= $dept['id'] ?>"><?= $dept['val1'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label class="form-label">Branch / Location</label>
                        <input type="text" name="location" class="form-control" placeholder="e.g. Colombo Yard, Galle Hub" required>
                    </div>
                </div>
            </div>

            <div class="rate-group mb-4">
                <div>
                    <label class="form-label">Min Hourly Rate (LKR)</label>
                    <input type="number" name="hourly_rate_min" class="form-control" placeholder="800" required>
                </div>
                <div>
                    <label class="form-label">Max Hourly Rate (LKR)</label>
                    <input type="number" name="hourly_rate_max" class="form-control" placeholder="1200" required>
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="form-label">Job Description & Requirements</label>
                <textarea name="description" class="form-control" rows="8" placeholder="Outline responsibilities, required skills, and experience..." required></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a href="<?= base_url('jobs/manage') ?>" class="text-muted"><i class="fa fa-arrow-left"></i> Back to management</a>
                <button type="submit" class="btn-post">Publish Vacancy</button>
            </div>
        </form>
    </div>
</div>

<script>
    $('#jobPostForm').submit(function(e) {
        e.preventDefault();
        $.post('<?= base_url('jobs/submit') ?>', $(this).serialize(), function(res) {
            alert(res.message);
            if(res.status === 'Success') {
                window.location.href = '<?= base_url('jobs/manage') ?>';
            }
        }, 'json');
    });
</script>
</body>
</html>
