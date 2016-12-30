<?php

$host    = "127.0.0.1";
//$host = '192.168.12.119';
$str = '"session_id":"h9oj3k2mmu018t4st9bfokmg56","ip_address":"127.0.0.1"';
$port    = 7777;

$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  

$result = socket_read ($socket, 1024) or die("Could not read server response\n");


echo "Reply From Server  :".$result;
// close socket
//socket_close($socket);

