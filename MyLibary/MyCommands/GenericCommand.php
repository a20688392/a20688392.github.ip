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

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

/**
 * Generic command
 *
 * Gets executed for generic commands, when no other appropriate one is found.
 */
class GenericCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'generic';

    /**
     * @var string
     */
    protected $description = 'Handles generic commands or is executed by default when a command is not found';

    /**
     * @var string
     */
    protected $version = '1.1.0';
    //protected $usage = '/';
    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
	    if(!empty($this->getUpdate()->getMyChatMember())){
		    return parent::execute();
	    }    
	//$xx = $this->getUpdate();
	//$message = $xx->getMyChatMember();
	//$messsage = json_encode($message);
		
	$message = $this->getMessage();
	//$user_id = $message->getFrom()->getId();

	$chat_id = $message->getChat()->getId();                   // Get the current Chat ID
	$command = $message->getCommand();
	$config = require './config.php';
	//file_put_contents('./message_log_'.date("Y.n.j").'.log', $message, FILE_APPEND);
	//file_put_contents('./message_log_'.date("Y.n.j").'.log',$command, FILE_APPEND);
    // To enable proper use of the /whois command.
    // If the user is an admin and the command is in the format "/whoisXYZ", call the /whois command
    //if (stripos($command, 'whois') === 0 && $this->telegram->isAdmin($user_id)) {
    //        return $this->telegram->executeCommand('whois');
	//}

	 //if (stripos($command, 'test')) {
    //        return $this->replyToChat("whois");
	//}
	
	if(!in_array($chat_id,$config['super']['groups'])) {              // if have one people not our groups' people, using an group to use our telegram-bot, send he/she empty string 
		//return parent::execute();
		return $this->replyToChat("Group not");

	}

	return $this->replyToChat("Command /{$command} not found.. :(");
    }
}
