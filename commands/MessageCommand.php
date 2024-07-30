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

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

/**
 * Message command class
 */
class MessageCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'genericmessage';

    /**
     * @var string
     */
    protected $description = 'Message';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Show in Help
     *
     * @var bool
     */
    protected $show_in_help = false;
    
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
        $arikaim->get('event')->dispatch('telegram.bot.message',[
            'message_id'   => $message->getMessageId(),
            'bot_username' => $this->telegram->getBotUsername(),
            'message'      => $message->getText(true),
            'from'         => $message->getFrom(),
            'user_id'      => $message->getFrom()->getId(),
            'chat'         => $message->getChat(),
            'chat_id'      => $message->getChat()->getId()
        ]);

        return Request::emptyResponse();
    }
}
