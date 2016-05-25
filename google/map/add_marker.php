<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>Show Google Map with Latitude and Longitude in asp.net website</title>
<style type="text/css">
html { height: 100% }
body { height: 100%; margin: 0; padding: 0 }
#map_canvas { height: 50% }
</style>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6v5-2uaq_wusHDktM9ILcqIrlPtnZgEk&sensor=false"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
 var map;
 var LocationArray=[];
 var lats=[];
 var longs=[];
 var flightPlanCoordinates_str ="";
 var myLatlng = new google.maps.LatLng(19.965019,73.668254);
  var myOptions = {
                zoom:10,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            
  //var map = new google.maps.Map(document.getElementById('gmap'),mapOptions);
        function initialize() {
            var myLatlng = new google.maps.LatLng(19.965019,73.668254);
            var myOptions = {
                zoom:10,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("gmap"), myOptions);
            
            marker = new google.maps.Marker({
                position: myLatlng,
                map: map
            });

            google.maps.event.addListener(map, "click", function(event) {
                // get lat/lon of click
                var clickLat = event.latLng.lat();
                var clickLon = event.latLng.lng();

                // show in input box
                document.getElementById("lat").value = clickLat.toFixed(5);
                document.getElementById("lon").value = clickLon.toFixed(5);
                myFunction(clickLat,clickLon);
                flightPlanCoordinates_str +=new google.maps.LatLng(document.getElementById("lat").value , document.getElementById("lon").value)+","
                
                
                var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(clickLat,clickLon),
                        map: map
                     });
            });
    }   
    function myFunction(lat,long) {
    var table = document.getElementById("myTable");
    var x = document.getElementById("myTable").rows.length;
    var row = table.insertRow(x);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    cell1.innerHTML = ""+lat;
    cell2.innerHTML = ""+long;
}
    window.onload = function () { initialize() };   
    
    $(document).ready(function(){
        
        $("#showRoute").click(function(){
           var i=0;
           var h= $("table#myTable > tbody > tr > td").each(function()
           { 
               
             //LocationArray[]=console.log($(this).html())
             if(i!=0 && i!=1)
             {
                 LocationArray.push($(this).html());
                 
                 if(i%2==0)
                 {
                     lats.push($(this).html());
                 }
                 else if(i%2==1)
                 {
                     longs.push($(this).html());
                 }
             }
             //console.log($(this).html());
             
             
             
             i++;
            });
           
           str="";
           for(j=0;j<LocationArray.length-1;j++)
           {               
               str=new google.maps.LatLng(lats[j],longs[j])+",";
           }
           
           mystr=flightPlanCoordinates_str.slice(0,-1);
           //console.log(flightPlanCoordinates_str.slice(0,-1));
           
           
             var flightPlanCoordinates = [mystr];
  var flightPath = new google.maps.Polyline({
    path: flightPlanCoordinates,
    geodesic: true,
    strokeColor: '#FF0000',
    strokeOpacity: 1.0,
    strokeWeight: 2
  });

  flightPath.setMap(map);
           return false; 
        });
        
    });
</script>
     <style>
     div#gmap 
     {
            width: 100%;
            height: 500px;
            border:double;
     }
    </style>
</head>

<body>
    <form id="form1" runat="server" >    
    <table style="width:100%;" border="1" >
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td style="width:50%;">
                <div id="gmap"></div>
            </td>
            <td style="width:50%;">
                <table id="myTable">
                    <tr>
                        <td>A</td>                        
                        <td>A</td>                        
                    </tr>                    
                </table>
                <button id="showRoute">Show Route</button>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            lat:<input type="text" id='lat'></span>
            lon:<input type="text" id='lon'></span>
    </td>
        </tr>
    </table>
    </form>
</body>

</html>