<?php
// 僵尸进程的出现

$pid = pcntl_fork();

if ($pid > 0) {
    echo '父进程pid：' . posix_getpid() . PHP_EOL;
    sleep(30);
} elseif ($pid === 0) {
    echo '子进程pid：' . posix_getpid() . PHP_EOL;
    sleep(10);
} else {
    exit('fork fail');
}