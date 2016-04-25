<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
<title>MapsApi</title>

<style>
      #map_canvas {
        width: 100%;
        height: 700px;
        background-color: #CCC;
      }

      #menu_bar{
        width: 100%;
        height: 150px;
        position:absolute;
        bottom:0px;
        background-color: #CCC;
        border-top:1px solid red;
      }
      body{
        padding:0px;
        margin:0px;

      }
</style>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
var map;
var markers = [];
var flightPlanCoordinates=[];
 var myLatlng = new google.maps.LatLng(19.965019,73.668254);
 function initialize() 
 {    
    var mapOptions = 
            {
                zoom: 15,
                center: myLatlng
            }
    var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
    google.maps.event.addListener(map, "click", function(event) 
    {
        var clickLat = event.latLng.lat();
        var clickLon = event.latLng.lng();
        flightPlanCoordinates.push(new google.maps.LatLng(clickLat,clickLon));
        var flightPath = new google.maps.Polyline
                        ({
                                path: flightPlanCoordinates,
                                geodesic: true,
                                strokeColor: '#0000FF',
                                strokeOpacity: 1.0,
                                strokeWeight: 2
                        });

        flightPath.setMap(map);
    });
    google.maps.event.addListener(map, 'click', function(event) 
    {
        addMarker(event.latLng);
    });


    // add marker to positon
    function addMarker(location) 
    {
        var marker = new google.maps.Marker(
        {
            position: location,
            map: map
        });
        google.maps.event.addListener(marker, 'click', function(event) 
        {
            this.setMap(null);
        });
        markers.push(marker);
    }

    // Sets the map on all markers in the array.
        function setAllMap(map) 
        {
          for (var i = 0; i < markers.length; i++) 
          {
            markers[i].setMap(map);
          }
        }
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>


</head>

<body>
<div id="map_canvas"></div>
<div id="menu_bar">
</div>



</body>
</html>