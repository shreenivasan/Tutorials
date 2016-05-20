<?php
ini_set("display_errors", "On");
error_reporting(E_ALL);
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
echo "Connection to server sucessfully";

echo "Server is running: ".$redis->ping();
echo "Server is running: ". $redis->ping();