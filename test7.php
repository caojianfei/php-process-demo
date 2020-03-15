<?php
// 使用进程信号的方式回收子进程
$pid = pcntl_fork();
if( $pid > 0 ){
    pcntl_signal( SIGCHLD, function() use( $pid ) {
        echo "收到子进程退出".PHP_EOL;
        pcntl_waitpid( $pid, $status, WNOHANG );
    } );
    cli_set_process_title('php father process');
    while( true ){
        sleep( 1 );
        pcntl_signal_dispatch();
    }
} else if( 0 == $pid ) {
    cli_set_process_title('php child process');
    // 让子进程休息10秒钟，但是进程结束后，父进程不对子进程做任何处理工作，这样这个子进程就会变成僵尸进程
    sleep(10);
} else {
    exit('fork error.'.PHP_EOL);
}
