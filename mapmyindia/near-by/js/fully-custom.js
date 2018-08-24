var url_result;
var marker = new Array();
var all_result = [];
var map;
var show_marker = new Array();

var centre = new L.LatLng('19.064520','73.000970');
map = new MapmyIndia.Map('map-container', {center: centre, zoomControl: true, hybrid: true});
map.setView(centre, 18);
MapmyIndia.geo(map_o[0]);

get_near_by_result('19.064520', '73.000970');


function get_near_by_result(lat, lng) {
    var keyword = 'mall;atm;petrol;coffee;bar';
    $('#result').html('<div style="padding: 0 12px; color: #777">Loading..</div>');
    getUrlResult(keyword, lat, lng);
}

function getUrlResult(keyword, lat, lng) {
    $.ajax({
        type: "POST",
        dataType: 'text',
        url: "getResponseRnD.php",
        async: false,
        data: {
            query: JSON.stringify(keyword),
            current_lat: JSON.stringify(lat),
            current_lng: JSON.stringify(lng)
        },
        success: function (result) {
            var resdata = JSON.parse(result);
            var jsondata;
            if (resdata.status == 'success') {

                try {
                    jsondata = resdata.data;
                } catch (e) {
                    var error_response = "No Result"
                    $('#result').html(error_response + '</ul></div>');
                    return false;
                }

                if (Object.keys(jsondata).length > 0) {
                    /*success*/
                    display_near_by_result(jsondata);/*display results on success*/
                }
                /*handle the error codes and put the responses in divs.Error codes can be found in the documentation*/
                else {
                    var error_response = "No Result"
                    $('#result').html( error_response + '</ul></div>');/***put response result in div****/
                }
            } else {
                var error_message = resdata.data;
                $('#result').html( error_message + '</ul></div>');
                remove_markers();
            }
        }
    });
}

function display_near_by_result(data) {
    details = [];
    var keys = Object.keys(data);
    var result_string = '<div style="padding: 0 12px;color:green;font-size:13px">POI</div><div style="font-size: 13px">\n\
                                    <ul style="list-style-type:decimal;color:green; padding:2px 2px 0 30px">';
    var num = 1;
    keys.forEach(function (k) {

        result_string += "<li class='li-item' style='list-style-type: circle;text-transform:capitalize'>" + k + " (" + data[k].length + ") ";
        result_string += "<ul>";
        data[k].forEach(function (item) {

            if (item != '' && item != null && item != "undefined") {

                var lng = item.longitude;
                var lat = item.latitude;
                var pos = new L.LatLng(lat, lng);/***position of marker*****/
                var content = new Array();
                if (item.eLoc != '')
                    content.push('<tr><td style="white-space:nowrap">eLoc</td><td width="10px">:</td><td>' + item.eLoc + '</td></tr>');
                if (item.placeName != '')
                    content.push('<tr><td style="white-space:nowrap">placeName</td><td width="10px">:</td><td width="70%" style="word-wrap: break-word;">' + item.placeName + '</td></tr>');
                if (item.placeAddress != '')
                    content.push('<tr><td style="white-space:nowrap">placeAddress</td><td width="10px">:</td><td style="width: 75% !important; word-wrap: break-word;">' + item.placeAddress + '</td></tr>');
                if (item.type != '')
                    content.push('<tr><td style="white-space:nowrap">type</td><td width="10px">:</td><td>' + item.type + '</td></tr>');
                if (item.latitude != '')
                    content.push('<tr><td style="white-space:nowrap">latitude</td><td width="10px">:</td><td>' + item.latitude + '</td></tr>');
                if (item.longitude != '')
                    content.push('<tr><td style="white-space:nowrap">longitude</td><td width="10px">:</td><td>' + item.longitude + '</td></tr>');
                if (item.distance != '')
                    content.push('<tr><td style="white-space:nowrap">distance</td><td width="10px">:</td><td>' + item.distance + '</td></tr>');
                if (item.placeName == 'Kotak Mahindra ATM')
                    content.push('<tr><td style="white-space:nowrap">placeName</td><td width="10px">:</td><td width="70%" style="word-wrap: break-word;"><img height="100" height="100" src="http://rajkot.getdetail.in/Businesspic/kotak_2406201705233234.jpg"  /></td></tr>');
                details.push(content.join(""));

                show_markers(num, pos);/**display markers***/
                result_string += '<li class="places-li" style="display:none;" onclick="show_place_details(' + (num++) + ',' + lng + ',' + lat + ')">' + item.placeName+'</li>';
            } else {
                var error_response = "Not found.";
                result_string += "</li>";
                $('#result').html(error_response + '</ul></div>');
            }
        });
        result_string += "</ul></li>";


    });

    $('#result').html(result_string + '</ul></div>');/***put geocode result in div****/
    mapmyindia_fit_markers_into_bound(); /***fit map in marker area***/
}

function show_markers(num, pos) {
    if (num > 9)
    {
        var icon = L.divIcon({
            className: 'my-div-icon',
            html: "<img class='map_marker'  src=" + "'https://maps.mapmyindia.com/images/2.png'>" + '<span class="my-div-span" style="left:1.3em !important;">' + (num) + '</span>',
            iconSize: [10, 10],
            popupAnchor: [12, -10]
        });
    } else
    {
        var icon = L.divIcon({
            className: 'my-div-icon',
            html: "<img class='map_marker'  src=" + "'https://maps.mapmyindia.com/images/2.png'>" + '<span class="my-div-span" style="left:1.6em; top:1.4em;">' + (num) + '</span>',
            iconSize: [10, 10],
            popupAnchor: [12, -10]
        });
    }/*function that creates a div over a icon and display content on the div*/

    marker[num] = L.marker(pos, {icon: icon}).bindPopup(createPopup(num - 1)).addTo(map);
    show_marker.push(marker[num]);
}

function createPopup(num) {
    return '<table class="popup-tab">' + details[num] + '</table>';
}

function mapmyindia_fit_markers_into_bound() {
    var group = new L.featureGroup(show_marker);
    map.fitBounds(group.getBounds());
}

function show_place_details(num, lng, lat) {
    var pos1 = new L.LatLng(lat, lng);
    map.setView(pos1, 18);
    show_info_window(pos1, num - 1, marker[num]);
}

function show_info_window(pos, num, marker) {
    marker.bindPopup("");
    var popup = marker.getPopup();
    popup.setContent(createPopup(num)).update();
    marker.openPopup();
}

$(document).ready(function(){
    $(".li-item").on('click',function(){
       $(this).find('ul>li').each(function(){  $(this).css('display','block') });
    });
});