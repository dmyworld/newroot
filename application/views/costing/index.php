<div class="card card-block">
    <div class="card-body">
         <!-- User Guide -->
        <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #6610f2;">
            <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideCost" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
            </div>
            <div id="guideCost" class="collapse">
                <div class="card-body p-2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_cost">🇬🇧 English</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_cost">🇱🇰 Sinhala</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_cost">IN Tamil</a></li>
                    </ul>
                    <div class="tab-content border p-2 bg-white">
                        <div id="eng_cost" class="tab-pane active">
                            <h6 class="text-primary mt-1 small">Production Costing</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>Select Batch:</strong> Choose a completed batch from the list.</li>
                                <li><strong>View Sheet:</strong> Click 'View Cost Sheet' to see detailed breakdown.</li>
                                <li><strong>Details:</strong> Analyzes Material, Labor, Machine, and Overhead costs per unit.</li>
                            </ol>
                        </div>
                        <div id="sin_cost" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">නිෂ්පාදන පිරිවැය (Costing)</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>තෝරා ගැනීම:</strong> ලැයිස්තුවෙන් නිම කළ කාණ්ඩයක් තෝරන්න.</li>
                                <li><strong>පිරිවැය පත්‍රය:</strong> විස්තර බැලීමට 'View Cost Sheet' ක්ලික් කරන්න.</li>
                                <li><strong>විස්තර:</strong> ඒකකයක් සඳහා ද්‍රව්‍ය, ශ්‍රමය සහ යන්ත්‍ර පිරිවැය විශ්ලේෂණය කරයි.</li>
                            </ol>
                        </div>
                        <div id="tam_cost" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">உற்பத்தி செலவு</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>தேர்வு:</strong> பட்டியலிலிருந்து முடிக்கப்பட்ட தொகுதியைத் தேர்ந்தெடுக்கவும்.</li>
                                <li><strong>பார்வை:</strong> விரிவான விவரங்களைக் காண 'View Cost Sheet' ஐ கிளிக் செய்யவும்.</li>
                                <li><strong>விவரங்கள்:</strong> ஒரு அலகுக்கான பொருள், உழைப்பு மற்றும் இயந்திரச் செலவுகளைப் பகுப்பாய்வு செய்கிறது.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End User Guide -->
        <h5 class="title"> Production Costing <small class="text-muted">Select Batch to View Cost Sheet</small></h5>
        <hr>
        <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                    <th>Batch ID</th>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>Qty</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($batches as $batch) { ?>
                <tr>
                    <td>#<?php echo $batch['id']; ?></td>
                    <td><?php echo $batch['name']; ?></td>
                    <td><?php echo $batch['start_date']; ?></td>
                    <td><?php echo $batch['items_qty']; ?></td>
                    <td>
                        <a href="<?php echo site_url('production_costing/batch_summary?id='.$batch['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-money"></i> View Cost Sheet</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
