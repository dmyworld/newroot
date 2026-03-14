<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h5>Live Provider Monitoring</h5>
            <hr>
        </div>
    </div>

    <div class="premium-card" style="height: 600px;">
        <div id="live-map" style="width: 100%; height: 100%; border-radius: 15px;"></div>
    </div>
</div>

<!-- Note: Google Maps API key should ideally be in a config file -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY_HERE"></script>

<script type="text/javascript">
    var map;
    var markers = [];

    function initMap() {
        var defaultCenter = {lat: 7.8731, lng: 80.7718}; // Center of Sri Lanka
        map = new google.maps.Map(document.getElementById('live-map'), {
            zoom: 7,
            center: defaultCenter,
            styles: [/* Optional: Premium Dark/Glass style can be added here */]
        });
        
        refreshLocations();
        setInterval(refreshLocations, 10000); // Auto refresh every 10 seconds
    }

    function refreshLocations() {
        $.ajax({
            url: "<?php echo base_url('providers/get_locations') ?>",
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                clearMarkers();
                $.each(data, function(index, provider) {
                    var color = provider.is_online == 1 ? 'green' : 'gray';
                    if (provider.status == 2) color = 'red'; // Busy
                    
                    var marker = new google.maps.Marker({
                        position: {lat: parseFloat(provider.lat), lng: parseFloat(provider.lng)},
                        map: map,
                        title: 'Provider ID: ' + provider.id,
                        icon: 'http://maps.google.com/mapfiles/ms/icons/' + color + '-dot.png'
                    });
                    markers.push(marker);
                });
            }
        });
    }

    function clearMarkers() {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
    }

    $(document).ready(function() {
        initMap();
    });
</script>
