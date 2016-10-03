<?php
error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();

$address = '127.0.0.1';
//$address = '192.168.12.119';
$str = '{"session_id":"h9oj3k2mmu018t4st9bfokmg56","ip_address":"127.0.0.1"}';
$port    = 7777;

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

if ($sock === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
}

if (socket_bind($sock, $address, $port) === false) {
    
    echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}

if (socket_listen($sock, 5) === false) {
    echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}

do {
    if (($msgsock = socket_accept($sock)) === false) {
        echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        break;
    }
    /* Send instructions. */
    $msg = "\nWelcome to the PHP Test Server. \n" .
        "To quit, type 'quit'. To shut down the server type 'shutdown'.\n";
    socket_write($msgsock, $msg, strlen($msg));

    do {
        if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
            echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($msgsock)) . "\n";
            break 2;
        }
        if (!$buf = trim($buf)) {
            continue;
        }
        if ($buf == $str) {
            echo "success";            break;
            socket_close($msgsock);
        }
        if ($buf == 'quit') {
            break;
        }
        if ($buf == 'shutdown') {
            socket_close($msgsock);
            break 2;
        }
        $talkback = "PHP: You said '$buf'.\n";
        socket_write($msgsock, $talkback, strlen($talkback));
        echo "$buf\n";
    } while (true);
    socket_close($msgsock);
} while (true);

socket_close($sock);



//// set some variables
//$host = '192.168.12.241';
//$str = '"session_id":"h9oj3k2mmu018t4st9bfokmg56","ip_address":"127.0.0.1"';
//$port    = 7234;
//
//$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
//$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
//
//$result = socket_listen($socket, 3) or die("Could not set up socket listener\n");
//$spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
//$input = socket_read($spawn, 1024) or die("Could not read input\n");
//// clean up input string
//$input = trim($input);
//echo "Client Message : ".$input;
//// reverse client input and send back
//$output = strrev($input) . "\n";
//socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");
//// close sockets
//socket_close($spawn);
//socket_close($socket);

