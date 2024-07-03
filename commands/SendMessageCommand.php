<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Telegram\Commands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

/**
 * Send message command class
 */
class SendMessageCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'message';

    /**
     * @var string
     */
    protected $description = 'Send message';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Show in Help
     *
     * @var bool
     */
    protected $show_in_help = true;
    
    /**
     * Run command
     *
     * @return ServerResponse
     */
    public function execute(): ServerResponse
    {
        global $arikaim;

        $message = $this->getMessage();
     
        // trigger event
        $arikaim->get('event')->dispatch('telegram.bot.command',[
            'message_id'   => $message->getMessageId(),
            'bot_username' => $this->telegram->getBotUsername(),
            'message'      => $message->getText(true),
            'command'      => $message->getCommand(),
            'from'         => $message->getFrom(),
            'chat_id'      => $message->getChat()->getId()
        ]);

        return Request::emptyResponse();
    }
}
