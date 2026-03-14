<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="<?= LTR ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <?php if (@$title) {
        echo "<title>$title</title >";
    } else {
        echo "<title>Geo POS</title >";
    }
    ?>
    <link rel="apple-touch-icon" href="<?= assets_url() ?>app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= assets_url() ?>app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
          rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/<?= LTR ?>/vendors.css">
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/vendors/css/extensions/unslider.css">
    <link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/vendors/css/weather-icons/climacons.min.css">
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/fonts/meteocons/style.css">
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/vendors/css/charts/morris.css">
    <link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN STACK CSS-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/<?= LTR ?>/app.css">
    <!-- END STACK CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/<?= LTR ?>/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/<?= LTR ?>/core/colors/palette-gradient.css">
    <link rel="stylesheet" href="<?php echo assets_url('assets/custom/datepicker.min.css') . APPVER ?>">
    <link rel="stylesheet" href="<?php echo assets_url('assets/custom/summernote-bs4.css') . APPVER; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/vendors/css/forms/selects/select2.min.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>assets/css/style.css<?= APPVER ?>">
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>assets/custom/timber.css<?= APPVER ?>">
    <!-- Tailwind CSS (Play CDN for Dynamic Styles) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        premium: {
                            blue: '#1e3c72',
                            green: '#10b981',
                        }
                    }
                }
            }
        }
    </script>
    <!-- END Custom CSS-->
    <script src="<?= assets_url() ?>app-assets/vendors/js/vendors.min.js"></script>
    <script type="text/javascript" src="<?= assets_url() ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script type="text/javascript"
            src="<?= assets_url() ?>app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
    <script src="<?php echo assets_url(); ?>assets/portjs/raphael.min.js" type="text/javascript"></script>
    <script src="<?php echo assets_url(); ?>assets/portjs/morris.min.js" type="text/javascript"></script>
    <script src="<?php echo assets_url('assets/myjs/datepicker.min.js') . APPVER; ?>"></script>
    <script src="<?php echo assets_url('assets/myjs/summernote-bs4.min.js') . APPVER; ?>"></script>
    <script src="<?php echo assets_url('assets/myjs/select2.min.js') . APPVER; ?>"></script>
    <script type="text/javascript">var baseurl = '<?php echo base_url() ?>';
        var crsf_token = '<?=$this->security->get_csrf_token_name()?>';
        var crsf_hash = '<?=$this->security->get_csrf_hash(); ?>';
        <?php 
        $ci =& get_instance();
        $module_id = 0;
        $demo_status = array('is_demo' => false);

        if (isset($ci->aauth) && $ci->aauth->is_loggedin()) {
            $controller = strtolower($ci->router->fetch_class());
            // Basic mapping for major modules
            if (in_array($controller, array('invoices', 'pos_invoices'))) $module_id = 1;
            elseif (in_array($controller, array('products'))) $module_id = 2;
            elseif (in_array($controller, array('projects'))) $module_id = 4;
            elseif (in_array($controller, array('accounts', 'transactions'))) $module_id = 5;
            elseif (in_array($controller, array('quote'))) $module_id = 8;
            elseif (in_array($controller, array('employee'))) $module_id = 9;

            if ($module_id > 0) {
                $demo_status = $ci->aauth->get_demo_status($module_id);
            }
        }
        echo "var demo_status = " . json_encode($demo_status) . ";";
        ?>
    </script>
    <script src="<?php echo assets_url(); ?>assets/portjs/accounting.min.js" type="text/javascript"></script>
    <?php accounting() ?>
    
    <!-- Real-Time Sync (Socket.io) -->
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
    <script type="text/javascript">
        if (typeof io !== 'undefined') {
            var socket = io('http://localhost:3000');
            var r_biz_id = '<?php echo isset($ci->aauth) ? ($ci->aauth->get_user()->business_id ?: 0) : 0; ?>';
            var r_loc_id = '<?php echo isset($ci->aauth) ? ($ci->aauth->get_user()->loc ?: 0) : 0; ?>';
            
            socket.on('connect', function() {
                console.log('Real-Time Sync Connected');
                socket.emit('join_room', {business_id: r_biz_id, location_id: r_loc_id});
            });

            // Handle Ledger / Transaction Updates
            socket.on('new_transaction', function(data) {
                console.log('Real-Time Ledger Update:', data);
                show_rt_notification('New Transaction: ' + data.amount + ' (' + data.type + ')');
            });

            // Handle Ring Updates
            socket.on('new_ring', function(data) {
                console.log('New Active Ring:', data);
                show_rt_notification('New Gig Request! Title: ' + data.title);
            });

            // Handle GPS Updates
            socket.on('gps_update', function(data) {
                console.log('Live GPS Data:', data);
                // If dashboard has a map update function, call it
                if (typeof update_live_map === 'function') {
                    update_live_map(data);
                }
            });

            // Display floating notification
            function show_rt_notification(message) {
                var toast = document.createElement('div');
                toast.style.position = 'fixed';
                toast.style.bottom = '20px';
                toast.style.right = '20px';
                toast.style.backgroundColor = '#10C888';
                toast.style.color = '#fff';
                toast.style.padding = '15px 25px';
                toast.style.borderRadius = '5px';
                toast.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
                toast.style.zIndex = '9999';
                toast.style.fontSize = '14px';
                toast.style.fontWeight = 'bold';
                toast.innerText = message;
                document.body.appendChild(toast);
                setTimeout(function() {
                    toast.remove();
                }, 5000);
            }
        }
    </script>
</head>
<?php
if (MENU) {
    include_once('header-va.php');
} else {
    include_once('header-ha.php');
}