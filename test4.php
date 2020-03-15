<?php

// 孤儿进程的出现
$pid = pcntl_fork();

if ($pid > 0) {
    echo '父进程pid：' . posix_getpid();
    sleep(10);
} elseif ($pid === 0) {
    echo '子进程pid：' . posix_getpid() . PHP_EOL;
    for ($i = 0; $i < 100; $i++) {
        echo '子进程ppid：' . posix_getppid() . PHP_EOL;
        sleep(1);
    }
} else {
    exit('fork fail');
}