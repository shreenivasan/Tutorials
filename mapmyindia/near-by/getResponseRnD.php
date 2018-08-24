<?php
$str =  '{"status":"success","data":["{\"suggestedLocations\":[{\"distance\":111,\"eLoc\":\"TRY1PW\",\"email\":\"\",\"entryLatitude\":19.065734,\"entryLongitude\":72.999772,\"keywords\":[\"FINATM\"],\"landlineNo\":\"\",\"latitude\":19.0654280000001,\"longitude\":73.0005310000001,\"mobileNo\":\"\",\"orderIndex\":1,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Standard Chartered ATM\",\"type\":\"POI\"},{\"distance\":111,\"eLoc\":\"RGHJNG\",\"email\":\"\",\"entryLatitude\":19.065494,\"entryLongitude\":73.00061,\"keywords\":[\"FINATM\"],\"landlineNo\":\"\",\"latitude\":19.0654280000001,\"longitude\":73.0005310000001,\"mobileNo\":\"\",\"orderIndex\":2,\"placeAddress\":\"Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Kotak Mahindra ATM\",\"type\":\"POI\"},{\"distance\":111,\"eLoc\":\"DUT173\",\"email\":\"\",\"entryLatitude\":19.065734,\"entryLongitude\":72.999772,\"keywords\":[\"FODPUB\"],\"landlineNo\":\"\",\"latitude\":19.0654280000001,\"longitude\":73.0005310000001,\"mobileNo\":\"\",\"orderIndex\":3,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Color Bar\",\"type\":\"POI\"},{\"distance\":118,\"eLoc\":\"LXS4EO\",\"email\":\"\",\"entryLatitude\":19.065735,\"entryLongitude\":72.999772,\"keywords\":[\"FODPUB\"],\"landlineNo\":\"\",\"latitude\":19.0655610000001,\"longitude\":73.0011960000001,\"mobileNo\":\"\",\"orderIndex\":4,\"placeAddress\":\"First Floor, Above KFC, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Tight Bar\",\"type\":\"POI\"},{\"distance\":149,\"eLoc\":\"KQFU5G\",\"email\":\"info@thechocolateroomindia.com\",\"entryLatitude\":19.065736,\"entryLongitude\":72.999772,\"keywords\":[\"FODBAK\"],\"landlineNo\":\"\",\"latitude\":19.065862,\"longitude\":73.001068,\"mobileNo\":\"\",\"orderIndex\":5,\"placeAddress\":\"2nd Floor, Food Court, Inorbit Mall, Sector 30A, Vasi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"The Chocolate Room\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"8HYO0J\",\"email\":\"cbtlinfiniti@panindiafoods.com\",\"entryLatitude\":19.065739,\"entryLongitude\":72.999771,\"keywords\":[\"FODCOF\"],\"landlineNo\":\"\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":6,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"The Coffee Bean & Tea Leaf\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"8HYS08\",\"email\":\"\",\"entryLatitude\":19.065739,\"entryLongitude\":72.999771,\"keywords\":[\"FODPUB\"],\"landlineNo\":\"\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":7,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Hurrycane\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"2BB7CT\",\"email\":\"infinitiandheri@sapphirefoods.in\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FODFFD\"],\"landlineNo\":\"+913339994444\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":8,\"placeAddress\":\"G-37\/38, Plot No 39, Inorbit Mall, Palm Beach Road, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"KFC\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"PN248L\",\"email\":\"\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FINATM\"],\"landlineNo\":\"\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":9,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"ATM\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"EC1SA3\",\"email\":\"amit.lakhwan@cafecoffeeday.com\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FODCOF\"],\"landlineNo\":\"\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"+919323948283\",\"orderIndex\":10,\"placeAddress\":\"Sector 30, New Bombay Shop No 28 And 28 A, Inorbit Mall, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Cafe Coffee Day\",\"type\":\"POI\"}],\"pageInfo\":{\"pageCount\":1,\"totalHits\":1540,\"totalPages\":154,\"pageSize\":10}}"]}';

$str = json_decode($str , true);

$str = json_decode($str['data'][0],true)['suggestedLocations'];

$query_str = explode(";", trim($_POST['query'],'"'));
$final_response = [];

foreach($str as $k => $v){    
    $key = check_keyword_exists($v['placeName'], $query_str);
    $final_response[$key][] = $v;
}

function check_keyword_exists($value , $ref_array){
    $retur_value = 'others'; 
    foreach($ref_array as $q){
        if (substr_count(strtolower($value), strtolower($q))){
            $retur_value = $q;
        }
    }
    
    return $retur_value;
}
echo json_encode(['status'=>'success','data'=>$final_response]);
die;

ini_set("display_errors", "1");
$keyword = json_decode($_POST['query'],true);
$lat = json_decode($_POST['current_lat']);
$lng = json_decode($_POST['current_lng']);


$token_url = "https://outpost.mapmyindia.com/api/security/oauth/token?grant_type=client_credentials";

$access_token="";
$token_type="";

$curl_token = curl_init();
curl_setopt($curl_token, CURLOPT_URL, $token_url);
curl_setopt($curl_token, CURLOPT_POST, 1);
curl_setopt($curl_token, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_token, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl_token, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl_token, CURLOPT_POSTFIELDS,
            "client_id=vlTqiZVjoqJJrz5fc3-o2ljgRWLRSn7FNC6I0LwvB2w9MPL9-8fjdMKrNfYp1JQo&client_secret=6g7DQ8CVw4IS4zruZwRfJuQ_jweC47YTFDPIaKsN52vWD23yF1vndsbBeC1Y36YW");
$result_token = curl_exec($curl_token);
$json = json_decode($result_token, true);
$access_token = $json['access_token'];
$token_type = $json['token_type'];
curl_close($curl_token);
print_r($result_token); die;
$url="";
if($lat!="" && $lng!="")
{
	$url="https://atlas.mapmyindia.com/api/places/nearby/json?keywords=".str_replace(" ", "%20", str_replace(";", ";", $keyword))."&refLocation=".$lat.",".$lng."";
}

$header = array();
$header[] = 'Content-length: 0';
$header[] = 'Content-type: application/json';
$header[] = 'Authorization: '.$token_type.' '.$access_token.'';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_VERBOSE, 1);
curl_setopt($curl, CURLOPT_HEADER, 1);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
$result = curl_exec($curl);
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
$response_header[] =explode("\r\n", substr($result, 0, $header_size));
$body[] = substr($result, $header_size);

curl_close($curl);

if($http_status=='200')
{
	$res['status']='success';
    $res['data']=$body;
    echo json_encode($res);
}
elseif($http_status=='400'){
    
    $res['status']='fail';
    $res['data']="No result found";
    echo '{"status":"success","data":["{\"suggestedLocations\":[{\"distance\":111,\"eLoc\":\"RGHJNG\",\"email\":\"\",\"entryLatitude\":19.065494,\"entryLongitude\":73.00061,\"keywords\":[\"FINATM\"],\"landlineNo\":\"\",\"latitude\":19.0654280000001,\"longitude\":73.0005310000001,\"mobileNo\":\"\",\"orderIndex\":1,\"placeAddress\":\"Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Kotak Mahindra ATM\",\"type\":\"POI\"},{\"distance\":111,\"eLoc\":\"TRY1PW\",\"email\":\"\",\"entryLatitude\":19.065734,\"entryLongitude\":72.999772,\"keywords\":[\"FINATM\"],\"landlineNo\":\"\",\"latitude\":19.0654280000001,\"longitude\":73.0005310000001,\"mobileNo\":\"\",\"orderIndex\":2,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Standard Chartered ATM\",\"type\":\"POI\"},{\"distance\":149,\"eLoc\":\"KQFU5G\",\"email\":\"info@thechocolateroomindia.com\",\"entryLatitude\":19.065736,\"entryLongitude\":72.999772,\"keywords\":[\"FODBAK\"],\"landlineNo\":\"\",\"latitude\":19.065862,\"longitude\":73.001068,\"mobileNo\":\"\",\"orderIndex\":3,\"placeAddress\":\"2nd Floor, Food Court, Inorbit Mall, Sector 30A, Vasi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"The Chocolate Room\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"8HYO0J\",\"email\":\"cbtlinfiniti@panindiafoods.com\",\"entryLatitude\":19.065739,\"entryLongitude\":72.999771,\"keywords\":[\"FODCOF\"],\"landlineNo\":\"\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":4,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"The Coffee Bean & Tea Leaf\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"2BB7CT\",\"email\":\"infinitiandheri@sapphirefoods.in\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FODFFD\"],\"landlineNo\":\"+913339994444\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":5,\"placeAddress\":\"G-37\/38, Plot No 39, Inorbit Mall, Palm Beach Road, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"KFC\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"EC1SA3\",\"email\":\"amit.lakhwan@cafecoffeeday.com\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FODCOF\"],\"landlineNo\":\"\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"+919323948283\",\"orderIndex\":6,\"placeAddress\":\"Sector 30, New Bombay Shop No 28 And 28 A, Inorbit Mall, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Cafe Coffee Day\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"PN248L\",\"email\":\"\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FINATM\"],\"landlineNo\":\"\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":7,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"ATM\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"SST57S\",\"email\":\"\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FODCOF\"],\"landlineNo\":\"+912240137257\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":8,\"placeAddress\":\"26 And 27, Ground Floor, Inorbit Mall, Near Vashi Railway Station, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Costa Coffee\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"D21FD2\",\"email\":\"\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FINATM\"],\"landlineNo\":\"\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":9,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"ICICI ATM\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"QZWRGC\",\"email\":\"\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FINATM\"],\"landlineNo\":\"\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":10,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Citibank ATM\",\"type\":\"POI\"}],\"pageInfo\":{\"pageCount\":1,\"totalHits\":1045,\"totalPages\":105,\"pageSize\":10}}"]}';
}
else{

	$res['status']='fail';
    $res['data']=str_replace("message:", "", $response_header[0][6]);
    echo '{"status":"success","data":["{\"suggestedLocations\":[{\"distance\":111,\"eLoc\":\"RGHJNG\",\"email\":\"\",\"entryLatitude\":19.065494,\"entryLongitude\":73.00061,\"keywords\":[\"FINATM\"],\"landlineNo\":\"\",\"latitude\":19.0654280000001,\"longitude\":73.0005310000001,\"mobileNo\":\"\",\"orderIndex\":1,\"placeAddress\":\"Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Kotak Mahindra ATM\",\"type\":\"POI\"},{\"distance\":111,\"eLoc\":\"TRY1PW\",\"email\":\"\",\"entryLatitude\":19.065734,\"entryLongitude\":72.999772,\"keywords\":[\"FINATM\"],\"landlineNo\":\"\",\"latitude\":19.0654280000001,\"longitude\":73.0005310000001,\"mobileNo\":\"\",\"orderIndex\":2,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Standard Chartered ATM\",\"type\":\"POI\"},{\"distance\":149,\"eLoc\":\"KQFU5G\",\"email\":\"info@thechocolateroomindia.com\",\"entryLatitude\":19.065736,\"entryLongitude\":72.999772,\"keywords\":[\"FODBAK\"],\"landlineNo\":\"\",\"latitude\":19.065862,\"longitude\":73.001068,\"mobileNo\":\"\",\"orderIndex\":3,\"placeAddress\":\"2nd Floor, Food Court, Inorbit Mall, Sector 30A, Vasi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"The Chocolate Room\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"8HYO0J\",\"email\":\"cbtlinfiniti@panindiafoods.com\",\"entryLatitude\":19.065739,\"entryLongitude\":72.999771,\"keywords\":[\"FODCOF\"],\"landlineNo\":\"\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":4,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"The Coffee Bean & Tea Leaf\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"2BB7CT\",\"email\":\"infinitiandheri@sapphirefoods.in\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FODFFD\"],\"landlineNo\":\"+913339994444\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":5,\"placeAddress\":\"G-37\/38, Plot No 39, Inorbit Mall, Palm Beach Road, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"KFC\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"EC1SA3\",\"email\":\"amit.lakhwan@cafecoffeeday.com\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FODCOF\"],\"landlineNo\":\"\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"+919323948283\",\"orderIndex\":6,\"placeAddress\":\"Sector 30, New Bombay Shop No 28 And 28 A, Inorbit Mall, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Cafe Coffee Day\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"PN248L\",\"email\":\"\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FINATM\"],\"landlineNo\":\"\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":7,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"ATM\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"SST57S\",\"email\":\"\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FODCOF\"],\"landlineNo\":\"+912240137257\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":8,\"placeAddress\":\"26 And 27, Ground Floor, Inorbit Mall, Near Vashi Railway Station, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Costa Coffee\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"D21FD2\",\"email\":\"\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FINATM\"],\"landlineNo\":\"\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":9,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"ICICI ATM\",\"type\":\"POI\"},{\"distance\":155,\"eLoc\":\"QZWRGC\",\"email\":\"\",\"entryLatitude\":19.065737,\"entryLongitude\":72.999772,\"keywords\":[\"FINATM\"],\"landlineNo\":\"\",\"latitude\":19.065904,\"longitude\":73.0007590000001,\"mobileNo\":\"\",\"orderIndex\":10,\"placeAddress\":\"Inorbit Bypass, Inorbit Mall, Sector 30A, Vashi, Navi Mumbai, Maharashtra, 400703\",\"placeName\":\"Citibank ATM\",\"type\":\"POI\"}],\"pageInfo\":{\"pageCount\":1,\"totalHits\":1045,\"totalPages\":105,\"pageSize\":10}}"]}';
}
?>
