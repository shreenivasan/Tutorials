<?php
function binary_search($x, $list) {
    $left = 0;
    $right = count($list) - 1;

    while ($left <= $right) {
        $mid = ($left + $right)/2;
        
        if ($list[$mid] == $x) {
            return $mid;
        } elseif ($list[$mid] > $x) {
             $right = $mid - 1;
        } elseif ($list[$mid] < $x) {
             $left = $mid + 1;
        }
    }

    return -1;
}

$x=1;
$list=array(2,3,4,5);

echo binary_search($x, $list);