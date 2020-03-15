<?php

$workers = 2;

for ($i = 0; $i < $workers; $i++) {
    $pid = pcntl_fork();
    if ($pid < 0) {
        exit("fork error");
    } elseif ($pid > 0) {
        echo "I`m parent process. My pid is " . posix_getpid() . PHP_EOL;
        sleep(1);
    } else {
        $pid = posix_getpid();
        $ppid = posix_getppid();
        echo "I`m children process, my pid is {$pid}. my ppid is {$ppid}" . PHP_EOL;
        exit;
    }
}

$pid = pcntl_fork();
if( $pid > 0 ){
    echo "我是父亲".PHP_EOL;
} else if( 0 == $pid ) {
    echo "我是儿子".PHP_EOL;
} else {
    echo "fork失败".PHP_EOL;
}

//$count = 5;
//forkWorkers();
//function forkWorkers()
//{
//    global $count;
//    while ($count > 0) {
//        $pid = pcntl_fork();
//        if ($pid < 0) {
//            exit('fork error');
//        } elseif ($pid > 0) {
//            $count--;
//            echo "I`m parent process. My pid is " . posix_getpid() . PHP_EOL;
//            exit(0);
//        } else {
//            echo "I`m children process, my pid is {$pid}" . PHP_EOL;
//        }
//    }
//}