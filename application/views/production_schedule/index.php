<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card-body">
         <!-- User Guide -->
        <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #6f42c1;">
            <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideSched" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
            </div>
            <div id="guideSched" class="collapse">
                <div class="card-body p-2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_sched">🇬🇧 English</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_sched">🇱🇰 Sinhala</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_sched">IN Tamil</a></li>
                    </ul>
                    <div class="tab-content border p-2 bg-white">
                        <div id="eng_sched" class="tab-pane active">
                            <h6 class="text-primary mt-1 small">Production Scheduling</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>New Batch:</strong> Click 'Create Batch' to start a new production job.</li>
                                <li><strong>Auto:</strong> Use 'Auto Schedule' to assign tasks based on machine availability.</li>
                                <li><strong>Calendar:</strong> View the timeline to track production stages and deadlines.</li>
                            </ol>
                        </div>
                        <div id="sin_sched" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">නිෂ්පාදන කාලසටහන්කරණය</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>නව කාණ්ඩයක්:</strong> නව කාර්යයක් ආරම්භ කිරීමට 'Create Batch' ක්ලික් කරන්න.</li>
                                <li><strong>ස්වයංක්‍රීය:</strong> යන්ත්‍ර ධාරිතාව අනුව කාලසටහන් කිරීමට 'Auto Schedule' භාවිතා කරන්න.</li>
                                <li><strong>දින දර්ශනය:</strong> නිෂ්පාදන පියවර සහ අවසන් දින නිරීක්ෂණය කිරීමට දින දර්ශනය බලන්න.</li>
                            </ol>
                        </div>
                        <div id="tam_sched" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">உற்பத்தி திட்டமிடல்</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>புதிய தொகுதி:</strong> புதிய வேலையைத் தொடங்க 'Create Batch' ஐ கிளிக் செய்யவும்.</li>
                                <li><strong>தானியங்கி:</strong> இயந்திரத் திறனைக் கொண்டு அட்டவணைப்படுத்த 'Auto Schedule' ஐப் பயன்படுத்தவும்.</li>
                                <li><strong>நாள்காட்டி:</strong> உற்பத்தி நிலைகள் மற்றும் காலக்கெடுவைக் கண்காணிக்க நாள்காட்டியைப் பார்க்கவும்.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End User Guide -->
        <h5 class="title"> Production Schedule 
            <a href="<?php echo base_url('production_schedule/create_batch') ?>" class="btn btn-primary btn-sm rounded">Create Batch</a>
            <button id="run_scheduler" class="btn btn-purple btn-sm rounded"><i class="fa fa-magic"></i> Auto Schedule</button>
        </h5>
        <hr>
        <div id="calendar"></div>
    </div>
</div>

<!-- Calendar Assets -->
<link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/vendors/css/calendars/fullcalendar.min.css?v=<?= APPVER ?>">
<script src="<?= assets_url() ?>app-assets/vendors/js/extensions/moment.min.js?v=<?= APPVER ?>"></script>
<script src="<?= assets_url() ?>app-assets/vendors/js/extensions/fullcalendar.min.js?v=<?= APPVER ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: '<?php echo date('Y-m-d'); ?>',
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events: {
                url: '<?php echo site_url('production_schedule/get_calendar_data') ?>',
                error: function () {
                    $('#notify').show();
                    $('.message').html('Error fetching events');
                }
            }
        });

        $('#run_scheduler').click(function() {
            var btn = $(this);
            $(btn).attr('disabled', true).text('Scheduling...');
            $.ajax({
                url: '<?php echo site_url('production_schedule/run_auto_scheduler') ?>',
                type: 'POST',
                dataType: 'json',
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function(data) {
                     $('#notify').show();
                     if(data.status == 'Success') {
                         $('#notify').removeClass('alert-danger').addClass('alert-success');
                         $('.message').text(data.message);
                         $('#calendar').fullCalendar('refetchEvents');
                     } else {
                         $('#notify').removeClass('alert-success').addClass('alert-danger');
                         $('.message').text(data.message);
                     }
                     $(btn).attr('disabled', false).html('<i class="fa fa-magic"></i> Auto Schedule');
                },
                error: function() {
                     $('#notify').show();
                     $('#notify').removeClass('alert-success').addClass('alert-danger');
                     $('.message').text('Server Error');
                     $(btn).attr('disabled', false).html('<i class="fa fa-magic"></i> Auto Schedule');
                }
            });
        });
    });
</script>
