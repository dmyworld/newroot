<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Dual Entry') . ' & ' . $this->lang->line('Accounting') ?></h5>
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
                <form method="post" id="product_action" class="form-horizontal">
                    <div class="card card-block">


                        <p class="alert alert-danger">Please do not enable this feature without proper understanding of
                            dual entry accounting system.</p>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="dual"><?php echo $this->lang->line('Dual Entry') ?></label>

                            <div class="col-sm-6">
                                <select name="dual" class="form-control">
                                    <option value="<?= $discship['key1'] ?>">
                                        *<?php if ($discship['key1']) echo $this->lang->line('Yes'); else  echo $this->lang->line('No') ?>
                                        *
                                    </option>
                                    <option value="1"><?php echo $this->lang->line('Yes') ?> </option>
                                    <option value="0"><?php echo $this->lang->line('No') ?></option>


                                </select>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="dual_inv"><?php echo $this->lang->line('Default') . ' ' . $this->lang->line('Invoice') . ' ' . $this->lang->line('Account') ?></label>

                            <div class="col-sm-6">
                                <select name="dual_inv" class="form-control">
                                    <?php foreach ($acclist as $row) {
                                        $selected = ($row['id'] == $discship['key2']) ? 'selected' : '';
                                        echo '<option value="' . $row['id'] . '" '.$selected.'>' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="dual_pur"><?php echo $this->lang->line('Default') . ' ' . $this->lang->line('Purchase Order') . ' ' . $this->lang->line('Account') ?></label>

                            <div class="col-sm-6">
                                <select name="dual_pur" class="form-control">
                                    <?php foreach ($acclist as $row) {
                                        $selected = ($row['id'] == $discship['url']) ? 'selected' : '';
                                        echo '<option value="' . $row['id'] . '" '.$selected.'>' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>


                        <hr>
                        <h4 class="mb-2">Category-Specific Dual Entry Mappings & Performance</h4>
                        <p>Analyze the financial impact (Debit/Credit) of each category and manage mappings. Use the filters to view values by branch and date.</p>
                        
                        <!-- Filters -->
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-inline bg-light p-2 rounded">
                                    <div class="form-group mr-2">
                                        <label class="mr-1 mt-0">Branch:</label>
                                        <select id="f_branch" name="branch" class="form-control form-control-sm">
                                            <option value="0">All Branches</option>
                                            <?php foreach ($locations as $loc) {
                                                $selected = ($filter['branch'] == $loc['id']) ? 'selected' : '';
                                                echo '<option value="' . $loc['id'] . '" '.$selected.'>' . $loc['cname'] . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mr-2">
                                        <label class="mr-1 mt-0">From:</label>
                                        <input type="text" id="f_s_date" name="s_date" class="form-control form-control-sm datepicker" value="<?php echo @$this->input->get('s_date'); ?>">
                                    </div>
                                    <div class="form-group mr-2">
                                        <label class="mr-1 mt-0">To:</label>
                                        <input type="text" id="f_e_date" name="e_date" class="form-control form-control-sm datepicker" value="<?php echo @$this->input->get('e_date'); ?>">
                                    </div>
                                    <button type="button" id="apply_dual_filters" class="btn btn-primary btn-sm">Apply filters</button>
                                    <a href="<?php echo base_url('settings/dual_entry'); ?>" class="btn btn-secondary btn-sm ml-1">Reset</a>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Transaction Category</th>
                                            <th>Secondary Dual Entry Account Mapping</th>
                                            <th class="text-right">Debit Value</th>
                                            <th class="text-right">Credit Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($catlist)) { 
                                            foreach($catlist as $cat) { 
                                                $t_deb = isset($cat_totals[$cat['id']]) ? amountFormat_s($cat_totals[$cat['id']]['total_debit'], 0, $this->aauth->get_user()->loc) : '0.00';
                                                $t_cre = isset($cat_totals[$cat['id']]) ? amountFormat_s($cat_totals[$cat['id']]['total_credit'], 0, $this->aauth->get_user()->loc) : '0.00';
                                                ?>
                                            <tr>
                                                <td><strong><?php echo $cat['name']; ?></strong></td>
                                                <td>
                                                    <select name="cat_mapping[<?php echo $cat['id']; ?>]" class="form-control">
                                                        <option value="0">-- Use Global Default --</option>
                                                        <?php foreach ($acclist as $acc) {
                                                            $selected = ($acc['id'] == $cat['dual_acid']) ? 'selected' : '';
                                                            echo '<option value="' . $acc['id'] . '" '.$selected.'>' . $acc['holder'] . ' / ' . $acc['acn'] . '</option>';
                                                        } ?>
                                                    </select>
                                                </td>
                                                <td class="text-right text-danger"><strong><?php echo $t_deb; ?></strong></td>
                                                <td class="text-right text-success"><strong><?php echo $t_cre; ?></strong></td>
                                            </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"></label>

                            <div class="col-sm-4">
                                <input type="submit" id="billing_update" class="btn btn-success margin-bottom"
                                       value="<?php echo $this->lang->line('Update') ?>"
                                       data-loading-text="Updating...">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#billing_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/dual_entry';
        actionProduct(actionurl);
    });

    $("#apply_dual_filters").click(function() {
        var branch = $("#f_branch").val();
        var s_date = $("#f_s_date").val();
        var e_date = $("#f_e_date").val();
        window.location.href = baseurl + 'settings/dual_entry?branch=' + branch + '&s_date=' + s_date + '&e_date=' + e_date;
    });
</script>

