<?php

//一段很垃圾的进程通信

$signal = '';
if ($argv[1] === '-s') {
    $signal = $argv[2];
    if (empty($signal) || !in_array($signal, ['start', 'stop'])) {
        exit('参数错误');
    }
} else {
    exit('错误的调用');
}

$pidFile = __DIR__ . '/test.pid';

if ($signal == 'start') {
    umask( 0 );
    $pid = pcntl_fork();
    if ($pid < 0) {
        exit('fork error');
    }
    if ($pid > 0) {
        exit();
    }

    if (posix_setsid() === -1) {
        exit('setsid error');
    }

    $pid = pcntl_fork();
    if ($pid < 0) {
        exit('fork error');
    }
    if ($pid > 0) {
        exit();
    }

    if (file_exists($pidFile)) {
        exit('程序已经启动');
    }
    touch($pidFile);
    file_put_contents($pidFile, posix_getpid());
    $logFile = __DIR__ . '/test/test9.log';
    if (!file_exists($logFile)) {
        touch($logFile);
    }
    $stop = false;
    // 装个信号去退出程序
    pcntl_signal(SIGQUIT, function () {
        echo "收到进程退出信号";
        global $stop;
        $stop = true;
    });

    $i = 0;
    while (true) {
        file_put_contents($logFile, $i . PHP_EOL, FILE_APPEND);
        pcntl_signal_dispatch();
        $i++;
        sleep(1);
        if ($stop == true) {
            echo "退出";
            break;
        }
    }
}

if ($signal == 'stop') {
    if (!is_file($pidFile)) {
        exit('程序未启动');
    }
    $pid = file_get_contents($pidFile);
    $kill = posix_kill(intval($pid), SIGQUIT);
    if (!$kill) {
        exit('停止失败');
    }
    unlink($pidFile);
    exit(0);
}
