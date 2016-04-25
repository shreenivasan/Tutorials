<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <title>Simple Polylines</title>
        <style>
          html, body, #map-canvas {
            height: 100%;
            margin: 0px;
            padding: 0px
          }
        </style>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
        <script>    
            var myLatlng = new google.maps.LatLng(19.965019,73.668254);
            var flightPlanCoordinates_str="";
            var flightPlanCoordinates=[];
        function initialize() {
          var mapOptions = {
            zoom: 10,
            center: myLatlng,
           mapTypeId: google.maps.MapTypeId.ROADMAP
          };

    var map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
//    marker = new google.maps.Marker({
//        position: myLatlng,
//        map: map
//    });
  
  google.maps.event.addListener(map, "click", function(event) {
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
  
  var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(clickLat,clickLon),
                        map: map
                     });
  
            });
  
}

google.maps.event.addDomListener(window, 'load', initialize);  


        </script>
  </head>
    <body>
        <table width="100%" height="700px">
            <tr>
                <td width="50%" height="700px">
                    <div id="map-canvas"></div>
                </td>
                <td width="50%">
                    
                </td>
            </tr>
        </table>
  </body>
</html>