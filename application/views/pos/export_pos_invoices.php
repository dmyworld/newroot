<div class="content-body">
    <div class="card card-body">
        <div class="">
            <h4>Monthly TAX Summary</h4>
                 
                        <?php $id = $_GET['id'] ?? null;
                        
                        if ($id == 'v2'): ?>
                              <a href="<?php echo base_url('pos_invoices/export_pos_invoices?id=1') ?>">Go Back</a>
                        <?php else: ?>
                              <a href="<?php echo base_url('pos_invoices/export_pos_invoices?id=v2') ?>">V2</a>
                        <?php endif; ?>
            <div class="card ">


                <div class="row ">
                    <div class="col-md-12 m-1">
                        <?php
if (($_GET['id'] ?? null) == 'v2') {
    ?>
      <form action="<?php echo base_url('pos_invoices/export_pos_invoices_v2') ?>" method="post" role="form">
    <?php
} else {
        ?>
      <form action="<?php echo base_url('pos_invoices/export_pos_invoices') ?>" method="post" role="form">
    <?php
}
?>
                        
                            
                            
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                   value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input name="id" type="hidden" value="<?php echo $product['id'] ?>">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('Type') ?></label>
                       
                                <div class="col-md-4">
                                    <select id="price_second" name="price_second" class="form-control">

                                                       
 <option value="0">0%</option>              
  <option value="5">5%</option>
  <option value="10">10%</option>
  <option value="15">15%</option>
  <option value="20">20%</option>
  <option value="25">25%</option>
  <option value="30">30%</option>
  <option value="35">35%</option>
  <option value="40">40%</option>
  <option value="45">45%</option>
  <option value="50">50%</option>
  <option value="55">55%</option>              
  <option value="60">60%</option>
  <option value="65">65%</option>
  <option value="70">70%</option>
  <option value="75">75%</option>
  <option value="80">80%</option>
  <option value="85">85%</option>
  <option value="90">90%</option>
  <option value="95">95%</option>
  <option value="100">100%</option>
                                       

                                    </select>


                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-md-2 control-label"
                                       for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                                <div class="col-md-4">
                                    <input type="text" class="form-control required"
                                           placeholder="Start Date" name="s_date" id="sdate"
                                           autocomplete="false">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-md-2 control-label"
                                       for="edate"><?php echo $this->lang->line('To Date') ?></label>

                                <div class="col-md-4">
                                    <input type="text" class="form-control required"
                                           placeholder="End Date" name="e_date"
                                           data-toggle="datepicker" autocomplete="false">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" for="pay_cat"></label>

                                <div class="col-md-4">
                                    <input type="submit" class="btn btn-primary btn-md" value="View">


                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>