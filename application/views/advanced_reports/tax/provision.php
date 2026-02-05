<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>Tax Provision Estimate</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="get" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Start Date</label>
                            <input type="date" name="start" class="form-control" value="<?= $tax_data['start'] ?>">
                        </div>
                        <div class="col-md-4">
                            <label>End Date</label>
                            <input type="date" name="end" class="form-control" value="<?= $tax_data['end'] ?>">
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label><br>
                            <button type="submit" class="btn btn-primary">Recalculate</button>
                        </div>
                    </div>
                </form>
                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th>Total Revenue</th>
                                <td class="text-right"><?= amountFormat($tax_data['income']) ?></td>
                            </tr>
                            <tr>
                                <th>Total Deductible Expenses</th>
                                <td class="text-right"><?= amountFormat($tax_data['expense']) ?></td>
                            </tr>
                            <tr class="bg-light font-weight-bold">
                                <th>Net Profit / (Loss)</th>
                                <td class="text-right"><?= amountFormat($tax_data['net_profit']) ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h5>Estimated Tax Liability</h5>
                                <div class="form-group mt-2">
                                    <label>Effective Tax Rate (%)</label>
                                    <input type="number" id="taxRate" class="form-control" value="20" onkeyup="calsTax()">
                                </div>
                                <hr>
                                <h3 class="text-danger text-center" id="taxProvision">
                                    <?= amountFormat($tax_data['net_profit'] > 0 ? $tax_data['net_profit'] * 0.20 : 0) ?>
                                </h3>
                                <p class="text-center text-muted">Estimated Provision</p>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function calsTax() {
                        var profit = <?= $tax_data['net_profit'] ?>;
                        var rate = document.getElementById('taxRate').value;
                        if(profit > 0) {
                            var tax = profit * (rate / 100);
                            document.getElementById('taxProvision').innerText = tax.toLocaleString('en-US', {style: 'currency', currency: 'USD'}); 
                            // Note: Logic simplified for display, actual formatting should match server-side currency symbol
                        } else {
                            document.getElementById('taxProvision').innerText = "0.00";
                        }
                    }
                </script>

            </div>
        </div>
    </div>
</div>
