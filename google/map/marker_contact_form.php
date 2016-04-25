<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Info windows</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script>
         var myLatlng = new google.maps.LatLng(19.965019,73.668254);
// This example displays a marker at the center of Australia.
// When the user clicks the marker, an info window opens.
$(document).ready(function(){    
    $("#btn").click(function(){
        alert("Hi");
        
    });
    
});
function initialize() {
  
  var mapOptions = {
    zoom: 10,
    center: myLatlng
  };

  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  var contentString = '<form action="" method="get"><div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h1 id="firstHeading" class="firstHeading">Contact Us</h1>'+
      '<div id="bodyContent">'+
      '<p>Name : <input type="text" name="fname" id="fname" value="" /></p>'+
      '<p>Email : <input type="text" name="email" id="email" value="" /></p>'+
      '<p>Query : <textarea name="query" id="query" rows="3" cols="50"></textarea></p>'+            
      '<p><button type="submit" id="btn">Submit</button></p>'+            
      '</div>'+
      '</div></form>';

  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Uluru (Ayers Rock)'
  });
  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>

