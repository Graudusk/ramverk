window.initMap = (function() {
    'use strict';

    var initMap = function(lon, lat, zoomLevel, radius) {
        if (document.getElementById('map')) {
            console.log(lat, lon)
            var mymap = L.map('map').setView([lat, lon], zoomLevel );
            var circle = L.circle([lat, lon], {
                color: 'blue',
                fillColor: '#3573FF',
                fillOpacity: 0.25,
                radius: radius
            }).addTo(mymap);

            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox.streets',
                accessToken: 'pk.eyJ1IjoiZ3JhdWR1c2siLCJhIjoiY2pobHZ4bnNuMmthbDJ6cGVlbmRhcXNwdCJ9.-wVdWFhT7profmLayiMyKw'
            }).addTo(mymap);
        }
    };

    return initMap;
})();
