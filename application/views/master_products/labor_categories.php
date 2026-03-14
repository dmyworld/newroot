<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h2><?php echo $this->lang->line('Labor Categories') ?></h2>
        </div>
        <div class="header-actions">
            <a href="<?php echo base_url('master_products/add_labor_category') ?>" class="btn-premium btn-success-glass">
                 <i class="fa fa-plus"></i> Add New Category
            </a>
        </div>
    </div>

    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>

    <div class="premium-card">
        <div class="table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Title') ?></th>
                    <th>Description</th>
                    <th>Commission Rate (%)</th>
                    <th><?php echo $this->lang->line('Settings') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; foreach ($categories as $row) {
                    echo "<tr>
                        <td>$i</td>
                        <td>" . $row['title'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td>" . $row['commission_rate'] . "%</td>
                        <td>
                            <a href='" . base_url("master_products/edit_labor_category?id=" . $row['id']) . "' class='btn btn-primary btn-sm'><i class='fa fa-pencil'></i></a>
                            <a href='#' data-object-id='" . $row['id'] . "' class='btn btn-danger btn-sm delete-object'><i class='fa fa-trash'></i></a>
                        </td>
                    </tr>";
                    $i++;
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this labor category?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="master_products/delete_labor_category">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
