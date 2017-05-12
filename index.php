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
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="styles/main-min.css">
    </head>
    <body>
        <header>
            <div class="header-inner">
                <div class="tablet-left">
                    <h3>Where do you want to eat?</h3>
                </div>
                <div class="tablet-right">
                    <div class="form-wrap">
                        <input type="text" name="searchInput" id="searchInput" placeholder="e.g, Taqueria">
                        <button id="searchButton"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </header>

        <div class="page-outer-wrapper">
            <div id="map"></div>
        </div>
        <script src="scripts/mapsetup-min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_api_key; ?>&libraries=places&callback=initMap" async defer></script>
    </body>
</html>