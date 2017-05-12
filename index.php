<?php
/**
 * Created by PhpStorm.
 * User: quarq
 * Date: 5/12/2017
 * Time: 1:45 PM
 *
 * Main application entry point.
 */

// Record Google API key here.  Will be echo'd later in the call to maps API w/places library.
$google_api_key = "AIzaSyBx_PLephaGxpOZjWedxxDX9Esr7g0oHdg";

?>
<html>
    <head>
        <title>iBec Eats</title>
        <meta name="description" content="SEO Meta description...">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link rel="stylesheet" href="styles/main.css">
    </head>
    <body>
        <header>
            <div class="header-inner">
                <div class="tablet-left">
                    <h3>Where do you want to eat?</h3>
                </div>
                <div class="tablet-right">
                    <input type="text" name="searchInput" id="searchInput" placeholder="e.g, Taqueria">
                </div>
            </div>
        </header>

        <div class="page-outer-wrapper">
            <div id="map"></div>
        </div>
        <script>
            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 43.655416, lng: -70.254375},
                    scrollwheel: false,
                    zoom: 17,
                    mapTypeControl: false,
                    streetViewControl: false
                });

                var infowindow = new google.maps.InfoWindow();

                // Designate our search bar in header as places search for this map.
                var input = document.getElementById('searchInput');
                var searchBox = new google.maps.places.SearchBox(input);

                // Make autocomplete results relevant for the map as seen in the current viewport.
                map.addListener('bounds_changed', function() {
                    searchBox.setBounds(map.getBounds());
                });

                var markers = [];
                // Wait for selection.  Upon selection, fetch information for it.
                searchBox.addListener('places_changed', function() {
                    var places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }

                    // Clear out the old markers.
                    markers.forEach(function(marker) {
                        marker.setMap(null);
                    });
                    markers = [];

                    // For each place, get the icon, name and location.
                    var bounds = new google.maps.LatLngBounds();
                    places.forEach(function(place) {
                        if (!place.geometry) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        var icon = {
                            url: place.icon,
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(25, 25)
                        };

                        // Create a marker for each place.
                        var the_marker = new google.maps.Marker({
                            map: map,
                            icon: icon,
                            title: place.name,
                            position: place.geometry.location
                        });

                        /*
                         Popuplate the info window with the restaurant name. It'd be nice to put more information here, but
                         a lot of the details are hidden behind the callback that only gets called when you click an individual
                         result from the search.  Otherwise could include hours/address/etc here.
                        */
                        google.maps.event.addListener(the_marker, 'click', function() {
                            infowindow.setContent(place.name);
                            infowindow.open(map, this);
                        });

                        // Store marker...
                        markers.push(the_marker);

                        if (place.geometry.viewport) {
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                });

            }

        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_api_key; ?>&libraries=places&callback=initMap" async defer></script>
    </body>
</html>