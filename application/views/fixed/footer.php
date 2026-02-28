</div>
</div>
</div>
<!-- BEGIN VENDOR JS-->
<script type="text/javascript">
    $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        format: '<?php echo $this->config->item('dformat2'); ?>'
    });
    $('[data-toggle="datepicker"]').datepicker('setDate', '<?php echo dateformat(date('Y-m-d')); ?>');

    $('#sdate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('#sdate').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');
    $('.date30').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('.date30').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');


</script>
<script src="<?= assets_url() ?>app-assets/vendors/js/extensions/unslider-min.js"></script>
<script src="<?= assets_url() ?>app-assets/vendors/js/timeline/horizontal-timeline.js"></script>
<script src="<?= assets_url() ?>app-assets/js/core/app-menu.js"></script>
<script src="<?= assets_url() ?>app-assets/js/core/app.js"></script>
<script type="text/javascript" src="<?= assets_url() ?>app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
<script src="<?php echo assets_url(); ?>assets/myjs/jquery-ui.js"></script>
<script src="<?php echo assets_url(); ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

<script type="text/javascript">var dtformat = $('#hdata').attr('data-df');
    var currency = $('#hdata').attr('data-curr');
    ;</script>
<script src="<?php echo assets_url('assets/myjs/custom.js') . APPVER; ?>"></script>
<script src="<?php echo assets_url('assets/myjs/basic.js') . APPVER; ?>"></script>
<script src="<?php echo assets_url('assets/myjs/control.js') . APPVER; ?>"></script>

<script type="text/javascript">
    $.ajax({

        url: baseurl + 'manager/pendingtasks',
        dataType: 'json',
        success: function (data) {
            $('#tasklist').html(data.tasks);
            $('#taskcount').html(data.tcount);

        },
        error: function (data) {
            $('#response').html('Error')
        }

    });


</script>

<script type="text/javascript">
    $(document).ready(function() {
        if (typeof demo_status !== 'undefined' && demo_status.is_demo) {
            // 1. Add usage indicator to page title or header
            var indicator = $('<div class="alert alert-warning text-center mb-0" style="padding: 5px; font-size: 0.9rem; border-radius: 0;">' +
                '<i class="fa fa-info-circle"></i> <strong>Demo Mode:</strong> ' + demo_status.name + ' usage: ' + demo_status.count + '/' + demo_status.limit + 
                ' (Remaining: ' + demo_status.remaining + ') &nbsp; <a href="<?php echo base_url('settings/subscription'); ?>" class="btn btn-sm btn-danger py-0">Upgrade Now</a>' +
                '</div>');
            $('.content-wrapper').prepend(indicator);

            // 2. Intercept "Add" or "Submit" actions if limit reached
            if (demo_status.count >= demo_status.limit) {
                // Intercept clicks on links that look like "Add"
                $('a[href*="/add"]').on('click', function(e) {
                    e.preventDefault();
                    $('#modal-module-name').text(demo_status.name + ' Limit Reached');
                    $('#subscriptionModal').modal('show');
                });

                // Intercept form submissions for creation
                $('form').on('submit', function(e) {
                    // Check if the current URL is an "add" page or action
                    if (window.location.href.indexOf('/add') > -1 || window.location.href.indexOf('/create') > -1) {
                         e.preventDefault();
                         $('#modal-module-name').text(demo_status.name + ' Limit Reached');
                         $('#subscriptionModal').modal('show');
                    }
                });
            }
        }
    });
</script>

<?php $this->load->view('fixed/subscription_modal'); ?>
</body>
</html>
