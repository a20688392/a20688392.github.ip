<?php
namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class GroupidCommand extends UserCommand{
    protected $name = 'groupid';                      // Your command's name
    protected $description = 'tell the group id'; // Your command description
    protected $usage = '/groupid';                    // Usage of your command
    protected $version = '1.0.0';                  // Version of your command

    public function execute():ServerResponse{
        $message = $this->getMessage();            // Get Message object
        $chat_id = $message->getChat()->getId();   // Get the current Chat ID
            //file_put_contents('./message_log_'.date("Y.n.j").'.log',$message, FILE_APPEND);
        $data = [                                  // Set up the new message data
            'chat_id' => $chat_id,                 // Set Chat ID to send the message to
            'text'    => 'Group id : '.$chat_id, // Set message to send
        ];

        return Request::sendMessage($data);        // Send message!
    }
}

?>

