<?php
function createXML($data) {
    
    $title = $data['title'];
    $rowCount = count($data['users']);
    
    //create the xml document
    $xmlDoc = new DOMDocument();
    
    $root = $xmlDoc->appendChild($xmlDoc->createElement("user_info"));
    $root->appendChild($xmlDoc->createElement("title",$title));
    $root->appendChild($xmlDoc->createElement("totalRows",$rowCount));
    $tabUsers = $root->appendChild($xmlDoc->createElement('rows'));
    
    foreach($data['users'] as $user){
        if(!empty($user)){
            $tabUser = $tabUsers->appendChild($xmlDoc->createElement('user'));
            foreach($user as $key=>$val){
                $tabUser->appendChild($xmlDoc->createElement($key, $val));
            }
        }
    }
    
    header("Content-Type: text/xml");
    
    //make the output pretty
    $xmlDoc->formatOutput = true;
    
    //save xml file
    $file_name = str_replace(' ', '_',$title).'_'.time().'.xml';
    $xmlDoc->save("files/" . $file_name);
    
    //return xml file name
    return $file_name;
}

$data = array(
    'title' => 'Users Information',
    'users' => array(
        array('name' => 'John Doe', 'email' => 'john@doe.com'),
        array('name' => 'Merry Moe', 'email' => 'merry@moe.com'),
        array('name' => 'Hellary Riss', 'email' => 'hellary@riss.com')
    )
);

echo createXML($data);


//xml file path
$path = "Users_Information_1515751289.xml";

//read entire file into string
$xmlfile = file_get_contents($path);

//convert xml string into an object
$xml = simplexml_load_string($xmlfile);

//convert into json
$json  = json_encode($xml);

//convert into associative array
$xmlArr = json_decode($json, true);
