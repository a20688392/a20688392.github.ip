<?php
namespace Longman\TelegramBot\Commands\SystemCommands;

class Openssh{
	
    function ssh_exec($host, $port=22, $ssh_username, $ssh_password, $command) {
	    //file_put_contents('./message_ip_log_'.date("Y.n.j").'.log', $command, FILE_APPEND);
	    $con = ssh2_connect($host, $port);//建立到遠程 SSH 服務器的連接。
	    //file_put_contents('./message_ip_log_'.date("Y.n.j").'.log', $con, FILE_APPEND);
        $auth_methods = ssh2_auth_none($con, $ssh_username);//身份驗證
        if (in_array('password', $auth_methods)) {//是否允許使用密碼登陸
            $auth_methods = ssh2_auth_password($con, $ssh_username, $ssh_password);
        }
        $stdout_stream = ssh2_exec($con, $command);//在遠程服務器上執行命令
        $err_stream = ssh2_fetch_stream($stdout_stream, SSH2_STREAM_STDERR);
    
        stream_set_blocking($stdout_stream, true); //阻塞執行
        stream_set_blocking($err_stream, true);
    
        $result_stdout = stream_get_contents($stdout_stream);
        $result_error = stream_get_contents($err_stream);
    
        fclose($stdout_stream);
        fclose($err_stream);
    
        ssh2_disconnect($con);

    }
}
