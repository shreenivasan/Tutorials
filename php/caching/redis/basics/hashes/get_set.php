<?php
/*
    A hash in Redis is a map between one string field and string values, like a one-to-many relationship. 
    The commands associated with hashes in Redis are:
 
    HSET: sets a key-value on the hash
    HGET: gets a key-value on the hash
    HGETALL: gets all key-values from the hash
    HMSET: mass assigns several key-values to a hash
    HDEL: deletes a key from the object
    HINCRBY: increments a key-value from the hash with a given value.
*/

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$key = 'linus torvalds';
$redis->hset($key, 'age', 44);
$redis->hset($key, 'country', 'finland');
$redis->hset($key, 'occupation', 'software engineer');
$redis->hset($key, 'reknown', 'linux kernel');
$redis->hset($key, 'to delete', 'i will be deleted');

$redis->get($key, 'age'); // 44
$redis->get($key, 'country'); // Finland

$redis->del($key, 'to delete');

$redis->hincrby($key, 'age', 20); // 64

$redis->hmset($key, [
    'age' => 44,
    'country' => 'finland',
    'occupation' => 'software engineer',
    'reknown' => 'linux kernel',
]);

// finally
$data = $redis->hgetall($key);
print_r($data); // returns all key-value that belongs to the hash
