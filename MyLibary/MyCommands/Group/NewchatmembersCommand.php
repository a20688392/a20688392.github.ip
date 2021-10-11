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
 * New chat members command
 *
 * Gets executed when a new member joins the chat.
 *
 * NOTE: This command must be called from GenericmessageCommand.php!
 * It is only in a separate command file for easier code maintenance.
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class NewchatmembersCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'newchatmembers';

    /**
     * @var string
     */
    protected $description = 'New Chat Members';

    /**
     * @var string
     */
    protected $version = '1.3.0';

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        $message = $this->getMessage();
        $members = $message->getNewChatMembers();
	$chat_id = $message->getChat()->getId();
        
        $NewGroupMessage = "Hi there, this BOT is add id to passive firewall!\n".
                           "Your Group id is ".$chat_id."\n".
                           "Please go to config and add this group id \n".
			               "And Then promote other users be a administrator\n".
			               "then they also can use \n".
                           "I wish you have a nice day ~ ";
        if ($message->botAddedInChat()) {
            return $this->replyToChat($NewGroupMessage);
        }


        $member_names = [];
        foreach ($members as $member) {
            $member_names[] = $member->tryMention();
        }

        return $this->replyToChat('Hi ' . implode(', ', $member_names) . '!');
    }
}
