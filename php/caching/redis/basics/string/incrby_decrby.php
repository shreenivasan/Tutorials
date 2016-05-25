<?php
/*
 *  We can also increase the values of the counter key by larger integer values 
 *  or we can decrease the value of the counter key with the INCRBY and DECRBY commands. 
 *  */
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->set("counter", 0);

$redis->incrby("counter", 15); // 15
$redis->incrby("counter", 5);  // 20

$redis->decrby("counter", 10); // 10

