<?php
/*
    The list of commands associated with sets include: – 
 *   SADD: adds a N number of values to the key  
 *   SREM: removes N number of values from a key 
 *   SISMEMBER: if a value exists – 
 *   SMEMBERS: lists of values in the set.
 *  */
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$key = "countries";
$redis->sadd($key, 'china');
$redis->sadd($key, ['england', 'france', 'germany']);
$redis->sadd($key, 'china'); // this entry is ignored

$redis->srem($key, ['england', 'china']);

echo $redis->sismember($key, 'england')?"Y":"N"; // false

$array = $redis->smembers($key); // ['france', 'germany']
print_r($array);
