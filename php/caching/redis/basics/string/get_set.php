<?php

/*
 *          In Redis, the most important commands are SET, GET and EXISTS. 
 *          These commands are used to store, check, and retrieve data from a Redis server. 
 *          Just like the commands, the Predis class can be used to perform Redis operations 
 *          by methods with the same name as commands.
 *  
 */


   $redis = new Redis();
   $redis->connect('127.0.0.1', 6379);
$redis->set('message', 'Hello world');

// gets the value of message
$value = $redis->get('message');

// Hello world
print($value); 

echo ($redis->exists('message')) ? "Oui" : "please populate the message key";

