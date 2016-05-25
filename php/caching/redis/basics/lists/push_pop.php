<?php
/*
 * There are a few basic Redis commands for working with lists and they are:

    LPUSH: adds an element to the beginning of a list
    RPUSH: add an element to the end of a list
    LPOP: removes the first element from a list and returns it
    RPOP: removes the last element from a list and returns it
    LLEN: gets the length of a list
    LRANGE: gets a range of elements from a list

 */

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$redis->rpush("languages", "french"); // [french]
$redis->rpush("languages", "arabic"); // [french, arabic]

$redis->lpush("languages", "english"); // [english, french, arabic]
$redis->lpush("languages", "swedish"); // [swedish, english, french, arabic]

$redis->lpop("languages"); // [english, french, arabic]
$redis->rpop("languages"); // [english, french]

$redis->llen("languages"); // 2

$array1 = $redis->lrange("languages", 0, -1); // returns all elements

$array2 = $redis->lrange("languages", 0, 1); // [english, french]

echo '<pre>';
print_r($array1);
print_r($array2);