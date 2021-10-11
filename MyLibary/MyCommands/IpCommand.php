<?php
namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use MyLibary\MyApi\IP\CheckIp;
use Longman\TelegramBot\Entities\InlineKeyboard;

class IpCommand extends UserCommand{
    protected $name = 'IP';                      		   // Your command's name
    protected $description = 'A command for test IP addr'; // Your command description
    protected $usage = '/ip';                    		   // Usage of your command
    protected $version = '1.0.0';                  		   // Version of your command

    
    public function execute():ServerResponse{
	$message = $this->getMessage();            		   // Get Message object
	$message_id = $message->getMessageId();    		   // Get which chat_text to relay it
    	$chat_id = $message->getChat()->getId();   		   // Get the current Chat ID
    	$message_text = $message->getText(TRUE);               // Get the Message text

	$config = require './config.php';

	//file_put_contents('./message_log_'.date("Y.n.j").'.log', $message_text, FILE_APPEND);

		$data = [
			'reply_to_message_id' => $message_id,
			'chat_id' 			  => $chat_id,                 // Set Chat ID to send the message to
			'text' 				  => 'Group not',					   // Set the text as nothing
		];
	if (!in_array($chat_id,$config['super']['groups'])) {		   // if have one people not our groups' people, using an group to use our telegram-bot, send he/she empty string 
            return Request::sendMessage($data);
        }

		if ($message_text == ''|| $message_text == '0.0.0.0' || $message_text == '127.0.0.1' || $message_text == '192.168.56.1') {
            $data['text'] = '你在開玩笑?';

            return Request::sendMessage($data);
        }
	

		$ip = explode(" ",  $message_text );
        if (!filter_var($ip[0], FILTER_VALIDATE_IP)) {
            $data['text'] = '請再確認你的IP是否輸入正確。';

            return Request::sendMessage($data);
        }

		//file_put_contents('./ipcommand_log_'.date("Y.n.j").'.log', $message, FILE_APPEND);
		$inline_key = new InlineKeyboard([       
	    	['text' => '⭕️','callback_data' => 'accept'],
            ['text' => '❌','callback_data' => 'reject'],
        ]);
	
        $data = [                                  // Set up the new message data
		'reply_to_message_id' => $message_id,
		'chat_id' => $chat_id,                 // Set Chat ID to send the message to
	    'text'    => '是否核准?',                  // Set message to send
		'reply_markup' => $inline_key,
    	];
 
	return Request::sendMessage($data);        // Send message!
	    
    }

}


