<?php
    $string = 'abcdE';
    function changeCase($string = ''){
        $array = str_split($string);
        $returnString = '';
        foreach($array as $v){
            $v = ord($v);
            if($v >=65 && $v <=90 ){
                $returnString.= chr($v+32);
            }else{
                $returnString.= chr($v - 32);;
            }
        }
        return $returnString;
    }
    echo changeCase($string);
?>

