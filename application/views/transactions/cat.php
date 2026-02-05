<article class="content-body">
    <div class="card border-0 shadow-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 12px; overflow: hidden;">
        
        <!-- Artistic Header -->
        <div class="card-header p-0" style="background: linear-gradient(135deg, #1a1412 0%, #2B2000 100%);">
            <div class="row no-gutters align-items-center">
                <div class="col-md-8 pl-4 py-4">
                     <h2 class="text-white" style="font-family: 'Cinzel', serif; letter-spacing: 1px;"><?php echo $this->lang->line('Transactions Categories') ?></h2>
                     <p class="text-white-50 mb-0">Manage Payment Categories</p>
                </div>
                 <div class="col-md-4 text-right pr-4 py-4">
                     <a href="<?php echo base_url('transactions/createcat') ?>" class="btn btn-outline-warning btn-md rounded shadow-sm font-weight-bold">
                        <i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('Add new') ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 text-dark" cellspacing="0" width="100%">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th class="border-top-0 pl-4"><?php echo $this->lang->line('Name') ?></th>
                            <th class="border-top-0 text-right pr-4"><?php echo $this->lang->line('Action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($catlist as $row) {
                            $cid = $row['id'];
                            echo "<tr>
                                    <td class='pl-4 font-weight-bold'>" . $row['name'] . "</td>
                                    <td class='text-right pr-4'>
                                        <a href='" . base_url("transactions/editcat?id=$cid") . "' class='btn btn-outline-primary btn-sm rounded shadow-sm mr-1'><i class='icon-pencil'></i> " . $this->lang->line('Edit') . "</a>
                                        <a href='#' data-object-id='" . $cid . "' class='btn btn-outline-danger btn-sm rounded shadow-sm delete-object' title='Delete'><i class='fa fa-trash'></i></a>
                                    </td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</article>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this Transaction Category') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="transactions/delete_cat">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>