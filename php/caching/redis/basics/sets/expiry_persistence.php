<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$key = "expire in 1 hour";
$redis->expire($key, 3600); // expires in 1 hour
$redis->expireat($key, time() + 3600); // expires in 1 hour
$redis->ttl($key); // 3000, ergo expires in 50 minutes

$redis->persist($key); // this will never expire.

