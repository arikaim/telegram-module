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
    protected $name = 'message';

    /**
     * @var string
     */
    protected $description = 'Handle message';

    /**
     * @var string
     */
    protected $version = '1.0.0';

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
        $arikaim->get('events')->dispatch('telegram.bot.message',[
            'bot_username' => $this->telegram->getBotUsername(),
            'message'      => $message->getText(true),
            'from'         => $message->getFrom(),
            'chat_id'      => $message->getChat()->getid()
        ]);

        return Request::emptyResponse();
    }
}
