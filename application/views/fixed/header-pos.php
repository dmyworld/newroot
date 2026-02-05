<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
          content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
          content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
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
    <!-- END VENDOR CSS-->
    <!-- BEGIN STACK CSS-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/<?= LTR ?>/app.css">
    <!-- END STACK CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/<?= LTR ?>/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/<?= LTR ?>/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/<?= LTR ?>/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/<?= LTR ?>/pages/chat-application.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>assets/css/style.css<?= APPVER ?>">
    <?php if (LTR == 'rtl') echo '<link rel="stylesheet" type="text/css" href="' . assets_url() . 'assets/css/style-rtl.css' . APPVER . '">'; ?>
    <link rel="stylesheet" href="<?php echo assets_url('assets/custom/datepicker.min.css') . APPVER ?>">
    <!-- END Custom CSS-->
    <script src="<?= assets_url() ?>app-assets/vendors/js/vendors.min.js"></script>
    <script type="text/javascript" src="<?= assets_url() ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script type="text/javascript"
            src="<?= assets_url() ?>app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
    <script src="<?= assets_url() ?>app-assets/vendors/js/charts/raphael-min.js"></script>
    <script src="<?= assets_url() ?>app-assets/vendors/js/charts/morris.min.js"></script>

    <script type="text/javascript">var baseurl = '<?php echo base_url() ?>';
        var crsf_token = '<?=$this->security->get_csrf_token_name()?>';
        var crsf_hash = '<?=$this->security->get_csrf_hash(); ?>';
    </script>
    <script src="<?php echo assets_url('assets/myjs/mousetrap.min.js') . APPVER; ?>"></script>
    <script src="<?php echo assets_url('assets/myjs/datepicker.min.js') . APPVER; ?>"></script>
    <script src="<?php echo assets_url(); ?>assets/portjs/accounting.min.js" type="text/javascript"></script>
    <?php accounting() ?>
</head>
<body class="horizontal-layout horizontal-menu content-left-sidebar <?php if ($s_mode) echo 'chat-application'; ?>  menu-expanded"
      data-open="hover"
      data-menu="horizontal-menu"
      data-col="2-columns" style="overflow: hidden;">
<span id="hdata"
      data-df="<?php echo $this->config->item('dformat2'); ?>"
      data-curr="<?php echo currency($this->aauth->get_user()->loc); ?>"></span>
<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-dark bg-gradient-x-grey-blue navbar-border navbar-brand-center">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item d-md-none"><a class="navbar-brand" href="<?= base_url() ?>dashboard/"><img
                                class="brand-logo" alt="logo"
                                src="<?php echo base_url(); ?>userfiles/theme/logo-header.png">
                    </a></li>
                <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse"
                                                  data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <!-- LEFT SIDE: Navigation & Fullscreen -->
                <ul class="nav navbar-nav float-left align-items-center flex-row">
                    <li class="nav-item d-none d-md-block mr-2"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                                                              href="#"><i class="ft-menu"></i></a></li>
                    
                    <li class="nav-item d-none d-md-block mr-1">
                        <a href="<?= base_url() ?>dashboard" class="btn btn-amber btn-sm shadow-sm rounded t_tooltip" title="Dashboard">
                             <i class="icon-speedometer"></i> <span class="d-none d-lg-inline"><?php echo $this->lang->line('Dashboard') ?></span>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <a class="btn btn-purple btn-sm shadow-sm rounded text-white" id="fullscreen-trigger" title="Fullscreen">
                            <i class="ficon ft-maximize"></i>
                        </a>
                    </li>
                </ul>

                <!-- CENTER: Register Actions -->
                <ul class="nav navbar-nav mx-auto text-center d-none d-md-flex align-items-center">
                     <li class="nav-item mr-1">
                        <a class="btn btn-blue btn-sm shadow-sm rounded t_tooltip px-2" title="View Register" data-toggle="modal" data-target="#register">
                            <i class="icon-drawer mr-1"></i> <?php echo $this->lang->line('Register') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger btn-sm shadow-sm rounded t_tooltip px-2" title="Close Register" data-toggle="modal" data-target="#close_register">
                            <i class="icon-close mr-1"></i> Close
                        </a>
                    </li>
                </ul>

                <!-- RIGHT SIDE: Tools & Profile -->
                <ul class="nav navbar-nav float-right align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="modal" data-target="#shortkeyboard" title="Shortcuts">
                            <i class="fa fa-keyboard-o"></i>
                        </a>
                    </li>
                    
                    <!-- Notifications -->
                    <li class="dropdown dropdown-notification nav-item">
                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                            <i class="ficon ft-bell"></i>
                            <span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="taskcount">0</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0">
                                    <span class="grey darken-2"><?php echo $this->lang->line('Pending Tasks') ?></span>
                                </h6>
                            </li>
                            <li class="scrollable-container media-list" id="tasklist"></li>
                            <li class="dropdown-menu-footer">
                                <a class="dropdown-item text-muted text-center" href="<?php echo base_url('manager/todo') ?>"><?php echo $this->lang->line('Manage tasks') ?></a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown dropdown-notification nav-item">
                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                            <i class="ficon ft-mail"></i>
                            <span class="badge badge-pill badge-default badge-info badge-default badge-up"><?php echo $this->aauth->count_unread_pms() ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0">
                                    <span class="grey darken-2"><?php echo $this->lang->line('Messages') ?></span>
                                </h6>
                            </li>
                            <li class="scrollable-container media-list">
                                <?php $list_pm = $this->aauth->list_pms(6, 0, $this->aauth->get_user()->id, false);
                                foreach ($list_pm as $row) {
                                    echo '<a href="' . base_url('messages/view?id=' . $row->pid) . '">
                                      <div class="media">
                                        <div class="media-left"><span class="avatar avatar-sm rounded-circle"><img src="' . base_url('userfiles/employee/' . $row->picture) . '" alt="avatar"><i></i></span></div>
                                        <div class="media-body">
                                          <h6 class="media-heading">' . $row->name . '</h6>
                                          <p class="notification-text font-small-3 text-muted">' . $row->{'title'} . '</p><small> <time class="media-meta text-muted" datetime="' . $row->{'date_sent'} . '">' . $row->{'date_sent'} . '</time></small>
                                        </div>
                                      </div></a>';
                                } ?>
                            </li>
                            <li class="dropdown-menu-footer">
                                <a class="dropdown-item text-muted text-center" href="<?php echo base_url('messages') ?>"><?php echo $this->lang->line('Read all messages') ?></a>
                            </li>
                        </ul>
                    </li>

                    <!-- Attendance -->
                    <?php if ($this->aauth->auto_attend()) { ?>
                        <li class="dropdown dropdown-d nav-item">
                            <?php if ($this->aauth->clock()) {
                                echo ' <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon spinner icon-clock"></i><span class="badge badge-pill badge-success badge-up">' . $this->lang->line('On') . '</span></a>';
                            } else {
                                echo ' <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon icon-clock"></i><span class="badge badge-pill badge-warning badge-up">' . $this->lang->line('Off') . '</span></a>';
                            } ?>
                            <ul class="dropdown-menu dropdown-menu-right border-primary border-lighten-3 text-xs-center">
                                <span class="p-1 text-bold-300 display-block"><?php echo $this->lang->line('Attendance') ?>:</span>
                                <?php if (!$this->aauth->clock()) {
                                    echo '<a href="' . base_url() . '/dashboard/clock_in" class="btn btn-outline-success btn-sm m-1" ><i class="ficon icon-clock spinner"></i> ' . $this->lang->line('Clock') . ' ' . $this->lang->line('In') . '</a>';
                                } else {
                                    echo '<a href="' . base_url() . '/dashboard/clock_out" class="btn btn-outline-danger btn-sm m-1" >' . $this->lang->line('Clock') . ' ' . $this->lang->line('Out') . '</a>';
                                } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <!-- User Profile -->
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <span class="avatar avatar-online">
                                <img src="<?php echo base_url('userfiles/employee/thumbnail/' . $this->aauth->get_user()->picture) ?>" alt="avatar"><i></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>user/profile"><i class="ft-user"></i> <?php echo $this->lang->line('Profile') ?></a>
                            <a href="<?php echo base_url(); ?>user/attendance" class="dropdown-item"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('Attendance') ?></a>
                            <a href="<?php echo base_url(); ?>user/holidays" class="dropdown-item"><i class="fa fa-hotel"></i> <?php echo $this->lang->line('Holidays') ?></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo base_url('user/logout'); ?>"><i class="ft-power"></i> <?php echo $this->lang->line('Logout') ?></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var fullScreenBtn = document.getElementById("fullscreen-trigger");
    if (fullScreenBtn) {
        fullScreenBtn.addEventListener("click", function(e) {
            e.preventDefault();
            var doc = window.document;
            var docEl = doc.documentElement;

            var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
            var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

            if(!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
                requestFullScreen.call(docEl);
            } else {
                cancelFullScreen.call(doc);
            }
        });
    }
});
</script>

<!-- ////////////////////////////////////////////////////////////////////////////-->
<!-- Horizontal navigation-->

<!-- Horizontal navigation-->
<div id="notify" class="alert" style="display:none;">
    <a href="#" class="close" data-dismiss="alert">&times;</a>

    <div class="message"></div>
</div>
<div id="thermal_a" class="alert alert-success" style="display:none;">
    <a href="#" class="close" data-dismiss="alert">&times;</a>

    <div class="message"></div>
</div>
 
 
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">


<?php