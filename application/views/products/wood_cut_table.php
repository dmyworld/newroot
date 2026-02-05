<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover mixed-data shadow-z-1">
        <thead class="bg-timber-secondary white">
        <tr>
            <th class="text-center" style="vertical-align: middle;"><?php echo $this->lang->line('Product Name') ?></th>
            <th class="text-center" style="vertical-align: middle;"><?php echo $this->lang->line('Stock') ?></th>
            <th class="text-center" style="vertical-align: middle;"><?php echo $this->lang->line('Action') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td class="text-center font-weight-bold"><?php echo $row['product_name']; ?></td>
                <td class="text-center"><span class="badge badge-success"><?php echo number_format($row['qty'], 2); ?></span></td>
                <td class="text-center">
                    <a href="<?php echo base_url('products/woodcut?id=' . $productid . '&pcat=' . $row['pcat'] . '&pcutsizeid=' . $row['pid'] . '&pcutsizestock=' . $row['qty'] . '&pcutsizelength=' . $row['product_des'] . '&pcutsizename=' . $row['product_name'] . '&cutblance=ok'); ?>" class="btn btn-timber-primary btn-sm btn-glow">
                        <i class="fa fa-mouse-pointer"></i> <?php echo $this->lang->line('Select') ?>
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div><?php
if(empty($result)) {
    echo '<div class="alert alert-info text-center shadow-z-1"><i class="fa fa-info-circle"></i> No matching cut sizes found.</div>';
}
?>
