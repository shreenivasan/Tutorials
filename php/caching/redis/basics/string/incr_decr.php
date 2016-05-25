<?php
/*
 *  INCR and DECR are commands used to either decrease or increase a value.   
 */
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->set("counter", 0);

$redis->incr("counter"); // 1
$redis->incr("counter"); // 2

$redis->decr("counter"); // 1
