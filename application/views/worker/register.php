<div class="content-body">
    <div class="timber-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
        <h1><i class="fa fa-user-plus"></i> <?= $profile ? 'Edit Worker Profile' : 'Register as Worker' ?></h1>
        <p>Join our professional network and connect with employers</p>
    </div>

    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <form id="workerForm">
                        <div class="form-group">
                            <label>Display Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="display_name" value="<?= $profile['display_name'] ?? '' ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Professional Category <span class="text-danger">*</span></label>
                            <select class="form-control" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= ($profile['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                        <?= $cat['val1'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Profile Photo</label>
                            <div class="photo-upload-wrapper">
                                <div class="photo-preview" id="photoPreview" onclick="document.getElementById('photoInput').click()">
                                    <?php if(!empty($profile['photo'])): ?>
                                        <img src="<?= base_url($profile['photo']) ?>" alt="Profile">
                                    <?php else: ?>
                                        <i class="fa fa-camera fa-3x"></i>
                                        <p>Click to upload</p>
                                    <?php endif; ?>
                                </div>
                                <input type="file" class="d-none" name="photo" id="photoInput" accept="image/*">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Experience (Years)</label>
                                    <input type="number" class="form-control" name="experience_years" value="<?= $profile['experience_years'] ?? 0 ?>" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pay Structure</label>
                                    <select class="form-control" name="pay_type" id="payType">
                                        <option value="hourly" <?= ($profile['pay_type'] ?? '') == 'hourly' ? 'selected' : '' ?>>Hourly Rate</option>
                                        <option value="daily" <?= ($profile['pay_type'] ?? '') == 'daily' ? 'selected' : '' ?>>Fixed Daily Wage</option>
                                        <option value="monthly" <?= ($profile['pay_type'] ?? '') == 'monthly' ? 'selected' : '' ?>>Monthly Salary</option>
                                        <option value="project" <?= ($profile['pay_type'] ?? '') == 'project' ? 'selected' : '' ?>>Project Based</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Rate (LKR)</label>
                                    <input type="number" step="0.01" class="form-control" name="pay_rate" id="payRate" value="<?= $profile['pay_rate'] ?? 0 ?>" min="0">
                                </div>
                            </div>
                        </div>
                        <div id="hourlyEquivalent" class="text-muted mb-3" style="font-size: 0.85rem; margin-top: -10px; display: none;">
                            <i class="fa fa-info-circle"></i> Hourly Equivalent: LKR <span id="hourlyVal">0.00</span>
                        </div>

                        <div class="form-group">
                            <label>Skills <small>(Comma separated)</small></label>
                            <div class="d-flex flex-wrap gap-2 mb-2" id="skillSuggestions">
                                <span class="badge badge-outline-primary pointer" onclick="addSkill('Carpentry')">Carpentry</span>
                                <span class="badge badge-outline-primary pointer" onclick="addSkill('Plumbing')">Plumbing</span>
                                <span class="badge badge-outline-primary pointer" onclick="addSkill('Electrical')">Electrical</span>
                                <span class="badge badge-outline-primary pointer" onclick="addSkill('Painting')">Painting</span>
                                <span class="badge badge-outline-primary pointer" onclick="addSkill('Masonry')">Masonry</span>
                                <span class="badge badge-outline-primary pointer" onclick="addSkill('Welding')">Welding</span>
                                <span class="badge badge-outline-primary pointer" onclick="addSkill('Driving')">Driving</span>
                                <span class="badge badge-outline-primary pointer" onclick="addSkill('Machine Op')">Machine Op</span>
                            </div>
                            <input type="text" class="form-control" name="skills" id="skillsInput" value="<?= is_array($skills = json_decode($profile['skills'] ?? '[]', true)) ? implode(', ', $skills) : '' ?>" placeholder="Select above or type e.g., Carpentry, Machine Operation">
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" value="<?= $profile['phone'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" class="form-control" name="location" value="<?= $profile['location'] ?? '' ?>" placeholder="City or Region">
                        </div>

                        <div class="form-group">
                            <label>Bio / About You</label>
                            <textarea class="form-control" name="bio" rows="4" placeholder="Tell employers about your experience and qualifications..."><?= $profile['bio'] ?? '' ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg">
                            <i class="fa fa-save"></i> <?= $profile ? 'Update Profile' : 'Create Profile' ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Pay structure calculations
    function updateHourly() {
        const type = $('#payType').val();
        const rate = parseFloat($('#payRate').val()) || 0;
        let hourly = rate;
        
        if (type === 'daily') hourly = rate / 8;
        else if (type === 'monthly') hourly = rate / 160;
        
        if (type !== 'hourly' && type !== 'project' && rate > 0) {
            $('#hourlyVal').text(hourly.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $('#hourlyEquivalent').fadeIn();
        } else {
            $('#hourlyEquivalent').fadeOut();
        }
    }

    $('#payType, #payRate').on('change keyup', updateHourly);
    updateHourly();

    // Photo preview
    $('#photoInput').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#photoPreview').html('<img src="' + e.target.result + '" alt="Preview">');
            };
            reader.readAsDataURL(file);
        }
    });

    $('#workerForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: '<?= base_url('worker/submit') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'Success') {
                    Swal.fire('Success!', response.message, 'success').then(() => {
                        window.location.href = '<?= base_url('worker') ?>';
                    });
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            }
        });
    });
    });
});

function addSkill(skill) {
    const input = document.getElementById('skillsInput');
    let val = input.value;
    let current = val ? val.split(',').map(s => s.trim()).filter(s => s.length > 0) : [];
    
    if (!current.includes(skill)) {
        current.push(skill);
        input.value = current.join(', ');
    }
}
</script>

<style>
    .timber-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 30px;
        text-align: center;
        color: white;
        border-radius: 8px 8px 0 0;
        margin: -20px -20px 20px -20px;
    }
    .timber-header h1 { font-size: 28px; margin-bottom: 10px; }
    .timber-header p { opacity: 0.9; }
    
    .photo-upload-wrapper {
        text-align: center;
    }
    
    .photo-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 3px dashed #ddd;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #999;
        cursor: pointer;
        overflow: hidden;
        background: #f9f9f9;
    }
    
    .photo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .photo-preview:hover {
        border-color: #2a5298;
        color: #2a5298;
    }
</style>
