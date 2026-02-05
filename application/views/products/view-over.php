<div class="row">
    <div class="col-md-6">
        <h6 class="text-bold-600"><?php echo $this->lang->line('Product Details') ?></h6>
        <table class="table table-striped table-bordered text-center">
            <tr>
                <th><?php echo $this->lang->line('Name') ?></th>
                <td><?php echo $product['product_name'] ?></td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('Code') ?></th>
                <td><?php echo $product['product_code'] ?></td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('Category') ?></th>
                <td><?php echo $product['category_title'] . ($product['subcategory_title'] ? ' > ' . $product['subcategory_title'] : '') ?></td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('Warehouse') ?></th>
                <td><?php echo $product['warehouse_title'] ?></td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('Stock Quantity') ?></th>
                <td><?php echo number_format($product['qty'],2) ?></td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('Price') ?></th>
                <td><?php echo number_format($product['product_price'],2) ?></td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <div class="text-center">
             <img src="<?php echo base_url('userfiles/product/' . $product['image']) ?>" alt="Product Image" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
        </div>
        <hr>
        <h6 class="text-bold-600"><?php echo $this->lang->line('Description') ?></h6>
        <p><?php echo $product['product_des'] ?></p>
    </div>
</div>

<?php if(isset($product_variations) && !empty($product_variations)) { ?>
<div class="row mt-3">
    <div class="col-12">
        <h6 class="text-bold-600"><?php echo $this->lang->line('Variations') ?></h6>
        <table class="table table-striped table-bordered">
             <thead>
                 <tr>
                     <th>Name</th>
                     <th>Code</th>
                     <th>Qty</th>
                     <th>Price</th>
                 </tr>
             </thead>
             <tbody>
                 <?php foreach($product_variations as $var) { ?>
                 <tr>
                     <td><?php echo $var['product_name'] ?></td>
                     <td><?php echo $var['product_code'] ?></td>
                     <td><?php echo number_format($var['qty'],2) ?></td>
                     <td><?php echo number_format($var['product_price'],2) ?></td>
                 </tr>
                 <?php } ?>
             </tbody>
        </table>
    </div>
</div>
<?php } ?>
