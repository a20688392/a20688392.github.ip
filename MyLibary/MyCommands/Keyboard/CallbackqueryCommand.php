<?php
/**
 * This file is part of the PHP Telegram Bot example-bot package.
 * https://github.com/php-telegram-bot/example-bot/
 *
 * (c) PHP Telegram Bot Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Callback query command
 *
 * This command handles all callback queries sent via inline keyboard buttons.
 *
 * @see InlinekeyboardCommand.php
 */   
namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;


class CallbackqueryCommand extends SystemCommand{                       //This command handles all callback queries sent via inline keyboard buttons.

/**
     * @var string
     */
    protected $name = 'callbackquery';

    /**
     * @var string
     */
    protected $description = 'Handle the callback query';

    /**
     * @var string
     */
    protected $version = '1.2.0';

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws \Exception
     */
    
    private $chatId;
    private $userId;

    public function execute(): ServerResponse{
        // Callback query data can be fetched and handled accordingly.
        
	    $callback_query = $this->getCallbackQuery();                 // Get Callbackquery object
        
        $message = $callback_query->getMessage();                    // Get Message object

        $replyToMessage = $message->getReplyToMessage();             // Get Replymessage object       
        $command = $replyToMessage->getCommand();                    // Get command to determine command(not contain '/')

        $this -> userId = $callback_query->getFrom()->getId();
	    $this->chatId = $message->getChat()->getId();                // Get the current Chat ID	

	$config = require './config.php';

        $chatUser = Request::getChatMember([
            'user_id' => $this->userId,
            'chat_id' => $this->chatId,
        ])->getResult();
        $userPermission = $chatUser->getStatus();                       //是否是管理員或創建者
        
	    //file_put_contents('./callbackeditlog_'.date("Y.n.j").'.log', $callback_query, FILE_APPEND);

        if (!in_array($command, $config['super'][ 'commands'])) {
            $answer = [];

            return $callback_query->answer($answer);
        }

        $text = '預設空白';
        switch ($command) {                                             //for choose run which command                        
            case 'ip':
                if (!in_array($userPermission, $config['super']['maneger'])) {// check this people have permission
                    $text = '權限不足';
                    
                    break;
		}
		require_once '/var/www/html/MyLibary/MyApi/IP/EditIpCommand.php';
		//require './MyLibary/MyApi/IP/EditIpCommand.php';
                $edit = new EditIpCommand($callback_query);
                $text=$edit->GetText();

                break;
            
            default:
                $text = '操作異常';
        
                break;
        }

        return $callback_query->answer([
            'text'       => $text,
            'show_alert' => true,
            'cache_time' => 5,
        ]);
    }  
}	