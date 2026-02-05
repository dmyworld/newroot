<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Run Payroll</h5>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal">
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="emp_id">Employee</label>
                        <div class="col-sm-6">
                            <select name="emp_id" class="form-control select-box" id="emp_id">
                                <option value="">Select Employee</option>
                                <?php foreach ($employees as $emp) { ?>
                                    <option value="<?php echo $emp['id'] ?>" data-salary="<?php echo $emp['salary'] ?>"><?php echo $emp['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="period">Period</label>
                        <div class="col-sm-3">
                             <select name="month" class="form-control">
                                <?php 
                                for($m=1; $m<=12; $m++){
                                    $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                    $selected = ($m == date('n')) ? 'selected' : '';
                                    echo "<option value='$m' $selected>$month</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="year" value="<?php echo date('Y') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="basic_salary">Basic Salary</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Basic Salary"
                                   class="form-control margin-bottom b_input" name="basic_salary" id="basic_salary">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="overtime">Overtime Amount</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Overtime"
                                   class="form-control margin-bottom" name="overtime" value="0">
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="bonus">Bonus</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Bonus"
                                   class="form-control margin-bottom" name="bonus" value="0">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="deductions">Deductions</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Deductions"
                                   class="form-control margin-bottom" name="deductions" value="0">
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="tax">Tax</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Tax"
                                   class="form-control margin-bottom" name="tax" value="0">
                        </div>
                    </div>

                    <div class="form-group row">
                         <label class="col-sm-2 col-form-label" for="note">Note</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name="note" rows="2"></textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="Generate Payroll" data-loading-text="Processing...">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#emp_id').change(function() {
            var salary = $(this).find(':selected').data('salary');
            $('#basic_salary').val(salary);
        });
    });
</script>
