<?php
namespace Longman\TelegramBot\Commands\SystemCommands;

include 'Openssh.php';
use Longman\TelegramBot\Request;
class EditIpCommand{

    private $last_text='try';
    private $chatId;
    private $messageId;
    private $firstName;

    function  __construct($callback_query){
	    
        $message = $callback_query->getMessage();                    // Get Message object
        $this->chatId = $message->getChat()->getId();                // Get the current Chat ID
        $this->messageId = $message->getMessageId();                 // Get which chat_text to relay it
        
        $replyToMessage = $message->getReplyToMessage();             // Get Replymessage object
        //$command = $replyToMessage->getCommand();                    // Get command to determine command(not contain '/')
        $argument = $replyToMessage->getText(TRUE);                  // Get command back's text

        $this->firstName = $callback_query->getFrom()->getFirstName();//當誰審核過用
        $callbackData  = $callback_query->getData();
        $this->last_text=$this->EditIp($callbackData, $argument);
	     
    }

    private function EditIp($callbackData, $argument) {
        if($callbackData !== 'accept') {
            $text = $this->firstName . '已拒絕';
            self::replyMessage($text);

            return $text;
        }

        $ip = explode(" ", $argument)[0];
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            $text = '請再確認你的IP是否輸入正確';
            self::replyMessage($text);

            return $text;
        }

	$text = $this->firstName . '已核准，進行開通中';
	self::myssh($ip);
        self::replyMessage($text);

        return $text;
    }

    private function replyMessage($text = '') {
        Request::editMessageText([
            'chat_id'    => $this->chatId,
            'message_id' => $this->messageId,
            'text'       => $text,
        ]);
    }
    public function GetText(){
        return $this->last_text;
    }
    private function myssh($IpString){
	    $config = require './config.php';
	    
	    $tossh = new Openssh();
	    $tossh->ssh_exec(
            $config['ssh_connect']['ip'],
            $config['ssh_connect']['port'],
            $config['ssh_connect']['user'],
            $config['ssh_connect']['password'],
            'iptables -A INPUT -s ' .$IpString. ' -p all -j ACCEPT');
    
        }
}
