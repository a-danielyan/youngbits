<style>
    #map {
        height: 90vh;
    }
</style>

<div id="map" ></div>

<script>
 function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 5,
            center: {lat: 170, lng: 0}
        });
        var geocoder = new google.maps.Geocoder();

        <?php foreach ($users as $user) { ?>
        var sContent ='<div style="padding: 15px 10px 10px 10px"><h2> <?= $user->user_city ?></h2>';
         sContent +='<h5 class="text-center" style="padding-top: 5px"> <?= $user->user_company ?></h5></div>';
        geocodeAddress(geocoder, map,"<?= $user->user_city ?>",sContent);



        <?php } ?>


    }

    function geocodeAddress(geocoder, resultsMap,address,sContent = 'dfsfdawef') {
        // var address = document.getElementById('address').value;
        infoWindow = new google.maps.InfoWindow({ content: sContent });

        geocoder.geocode({'address': address}, function(results, status) {
            if (status === 'OK') {
                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location,
                    title:    'asd',
                    info:     sContent
                });

            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }



            google.maps.event.addListener( marker, 'click', function() {

                infoWindow.setContent( this.info );
                infoWindow.open( map, this );

            });


        });


    }
</script>


<script async defer  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7j6mXfg0ltUcJXfmJF1KN6p4mJiOfUBM&callback=initMap"> </script>