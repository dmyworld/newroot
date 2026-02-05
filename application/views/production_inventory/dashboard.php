<div class="content-body">
    <!-- User Guide -->
    <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #17a2b8;">
        <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideInv" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
            <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
        </div>
        <div id="guideInv" class="collapse">
            <div class="card-body p-2">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_inv">🇬🇧 English</a></li>
                    <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_inv">🇱🇰 Sinhala</a></li>
                    <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_inv">IN Tamil</a></li>
                </ul>
                <div class="tab-content border p-2 bg-white">
                    <div id="eng_inv" class="tab-pane active">
                        <h6 class="text-primary mt-1 small">Production Inventory</h6>
                        <ol class="small pl-3 mb-0">
                            <li><strong>Overview:</strong> Monitor stock levels across Store, Shop Floor, and Finishing areas.</li>
                            <li><strong>Transfer:</strong> Click 'Transfer / Move Stock' to move items between locations.</li>
                            <li><strong>Tracking:</strong> Real-time updates of Work-in-Progress (WIP) materials.</li>
                        </ol>
                    </div>
                    <div id="sin_inv" class="tab-pane fade">
                        <h6 class="text-primary mt-1 small">නිෂ්පාදන ඉන්වෙන්ටරි</h6>
                        <ol class="small pl-3 mb-0">
                            <li><strong>දළ විශ්ලේෂණය:</strong> ගබඩාව සහ නිෂ්පාදන අංශවල තොග මට්ටම් නිරීක්ෂණය කරන්න.</li>
                            <li><strong>මාරු කිරීම:</strong> ස්ථාන අතර බඩු ගෙන යාමට 'Transfer / Move Stock' ක්ලික් කරන්න.</li>
                            <li><strong>ලුහුබැඳීම:</strong> නිෂ්පාදන ක්‍රියාවලියේ පවතින (WIP) ද්‍රව්‍ය පිළිබඳ යාවත්කාලීන තොරතුරු.</li>
                        </ol>
                    </div>
                    <div id="tam_inv" class="tab-pane fade">
                        <h6 class="text-primary mt-1 small">உற்பத்தி இருப்பு</h6>
                        <ol class="small pl-3 mb-0">
                            <li><strong>கண்ணோட்டம்:</strong> வெவ்வேறு இடங்களில் உள்ள இருப்பு நிலைகளைக் கண்காணிக்கவும்.</li>
                            <li><strong>பரிமாற்றம்:</strong> பொருட்களை மாற்ற 'Transfer / Move Stock' ஐ கிளிக் செய்யவும்.</li>
                            <li><strong>கண்காணிப்பு:</strong> வேலையில் உள்ள பொருட்களின் (WIP) நிகழ்நேர அறிவிப்புகள்.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End User Guide -->
    <div class="row">
        <div class="col-12 text-right mb-1">
             <a href="<?php echo site_url('production_inventory/transfer'); ?>" class="btn btn-primary btn-lg"><i class="fa fa-exchange"></i> Transfer / Move Stock</a>
        </div>
    </div>
    <div class="row">
        <?php foreach($locations as $loc) { ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo $loc['name']; ?> <span class="badge badge-secondary float-right"><?php echo $loc['type']; ?></span></h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                           <tr>
                               <th>Product</th>
                               <th class="text-right">Qty</th>
                           </tr>
                        </thead>
                        <tbody>
                            <?php foreach($loc['stock'] as $item) { ?>
                            <tr>
                                <td><?php echo $item['product_name']; ?></td>
                                <td class="text-right font-weight-bold"><?php echo $item['current_qty']; ?></td>
                            </tr>
                            <?php } ?>
                            <?php if(empty($loc['stock'])) { ?>
                                <tr><td colspan="2" class="text-muted text-center">Empty</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
