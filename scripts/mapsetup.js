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

    // Make the search button emulate pressing enter.
    document.getElementById('searchButton').onclick = function () {
        google.maps.event.trigger(input, 'focus');
        google.maps.event.trigger(input, 'keydown', {
            keyCode: 13
        });
    };

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
