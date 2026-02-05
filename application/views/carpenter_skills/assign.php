<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card card-block ">
        <form method="post" id="data_form" class="card-body">
            <h5>Assign Skill to Carpenter</h5>
            <hr>
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="employee_id">Carpenter/Employee</label>
                <div class="col-sm-6">
                    <select name="employee_id" class="form-control margin-bottom round required">
                        <option value="">Select Employee</option>
                        <?php foreach($employees as $emp){ ?>
                            <option value="<?php echo $emp['id'] ?>"><?php echo $emp['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="skill_id">Skill</label>
                <div class="col-sm-6">
                    <select name="skill_id" class="form-control margin-bottom round required">
                        <option value="">Select Skill</option>
                        <?php foreach($skills as $skill){ ?>
                            <option value="<?php echo $skill->id ?>"><?php echo $skill->name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="proficiency">Proficiency</label>
                <div class="col-sm-6">
                    <select name="proficiency" class="form-control margin-bottom round">
                         <option value="1">1 - Novice</option>
                         <option value="2">2 - Advanced Beginner</option>
                         <option value="3">3 - Competent</option>
                         <option value="4">4 - Proficient</option>
                         <option value="5">5 - Expert</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="score">Productivity Score (0-100)</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Score"
                           class="form-control margin-bottom round" name="score" value="0.00">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="Assign Skill" data-loading-text="Assigning...">
                    <input type="hidden" value="carpenter_skills/assign" id="action-url">
                </div>
            </div>
        </form>
    </div>
</div>
