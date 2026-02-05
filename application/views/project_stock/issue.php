<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Issue Stock to Project</h5>
        </div>
        <div class="card-content">
             <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">

                 <!-- User Guide -->
                <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #607D8B;">
                    <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guidePStock" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                        <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                    </div>
                    <div id="guidePStock" class="collapse">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_ps">🇬🇧 English</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_ps">🇱🇰 Sinhala</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_ps">IN Tamil</a></li>
                            </ul>
                            <div class="tab-content border p-2 bg-white">
                                <div id="eng_ps" class="tab-pane active">
                                    <h6 class="text-primary mt-1 small">Issue Stock to Project</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>Project:</strong> Select the destination project for the materials.</li>
                                        <li><strong>Product:</strong> Search and select products to issue.</li>
                                        <li><strong>Confirm:</strong> Review types and quantities before clicking 'Issue Stock'.</li>
                                    </ol>
                                </div>
                                <div id="sin_ps" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">ව්‍යාපෘතියට තොග නිකුත් කිරීම</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>ව්‍යාපෘතිය:</strong> ද්‍රව්‍ය සඳහා ගමනාන්ත ව්‍යාපෘතිය තෝරන්න.</li>
                                        <li><strong>නිෂ්පාදනය:</strong> නිකුත් කිරීමට නිෂ්පාදන සොයන්න සහ තෝරන්න.</li>
                                        <li><strong>තහවුරු කරන්න:</strong> 'Issue Stock' ක්ලික් කිරීමට පෙර වර්ග සහ ප්‍රමාණයන් පරීක්ෂා කරන්න.</li>
                                    </ol>
                                </div>
                                <div id="tam_ps" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">திட்டத்திற்கு பங்கு வெளியீடு</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>திட்டம்:</strong> பொருட்களுக்கான இலக்கு திட்டத்தைத் தேர்ந்தெடுக்கவும்.</li>
                                        <li><strong>தயாரிப்பு:</strong> வெளியிட வேண்டிய தயாரிப்புகளைத் தேடித் தேர்ந்தெடுக்கவும்.</li>
                                        <li><strong>உறுதிப்படுத்தவும்:</strong> 'Issue Stock' ஐ கிளிக் செய்வதற்கு முன் வகைகள் மற்றும் அளவுகளை மதிப்பாய்வு செய்யவும்.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End User Guide -->
                <form id="data_form">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="project_id">Select Project</label>
                        <div class="col-sm-6">
                            <select name="project_id" class="form-control margin-bottom select2">
                                <?php foreach ($projects as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="product_cat">Search Product</label>
                            <input type="text" class="form-control" name="product_cat" id="product_cat" placeholder="Enter Product Name">
                             <div id="product_suggestions" class="list-group" style="position:absolute; z-index:1000; width:90%;"></div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-12">
                             <table class="table" id="pos_items">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Items will be added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <input type="hidden" name="products_l" id="products_l">
                    <input type="hidden" name="products_qty" id="products_qty">

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="Issue Stock" data-loading-text="Issuing...">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // Initialize Select2
    $(document).ready(function () {
        $('.select2').select2();
    });

    $("#product_cat").on("keyup", function () {
        var keyword = $(this).val();
        if (keyword.length > 2) {
             $.ajax({
                type: "POST",
                url: baseurl + "project_materials/search_products",
                data: {keyword: keyword, '<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                dataType: 'json',
                success: function (products) {
                    var html = '';
                    if(products && products.length > 0) {
                        $.each(products, function (key, value) {
                            html += '<a href="#" class="list-group-item list-group-item-action product-add" data-pid="' + value.pid + '" data-name="' + value.product_name + '">' + value.product_name + '</a>';
                        });
                    } else {
                        html = '<a href="#" class="list-group-item list-group-item-action disabled">No results found</a>';
                    }
                    $("#product_suggestions").html(html);
                },
                error: function(xhr, status, error) {
                    console.error("Search Error:", error);
                    console.log("Response:", xhr.responseText);
                }
            });
        } else {
            $("#product_suggestions").html('');
        }
    });

    $(document).on("click", ".product-add", function (e) {
        e.preventDefault();
        var pid = $(this).data('pid');
        var name = $(this).data('name');
        
        var html = '<tr class="item-row"><td>' + name + '</td><td><input type="number" class="form-control qty" value="1" data-pid="'+pid+'"></td><td><button class="btn btn-danger btn-sm remove"><i class="fa fa-trash"></i></button></td></tr>';
        
        $("#pos_items tbody").append(html);
        $("#product_suggestions").html('');
        $("#product_cat").val('');
        update_ids();
    });

    $(document).on("click", ".remove", function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        update_ids();
    });
    
    $(document).on("change", ".qty", function (e) {
        update_ids();
    });

    function update_ids() {
        var pids = [];
        var qtys = [];
        $(".qty").each(function() {
            pids.push($(this).data('pid'));
            qtys.push($(this).val());
        });
        $("#products_l").val(pids.join(','));
        $("#products_qty").val(qtys.join(','));
    }

    $("#submit-data").on("click", function (e) {
        e.preventDefault();
        update_ids();
        var o_data =  $("#data_form").serialize();
        var action_url = 'project_stock/process_issue';
        addObject(o_data, action_url);
    });
</script>
