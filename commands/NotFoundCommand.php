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

/**
 * Command not found command class
 */
class NotFoundCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'generic';

    /**
     * @var string
     */
    protected $description = 'Command not found';

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
        $from = $message->getFrom();

        // trigger event
        $arikaim->get('event')->dispatch('telegram.bot.command',[
            'command'      => $message->getCommand(),
            'bot_username' => $this->telegram->getBotUsername(),
            'from'         => $from,
            'user_id'      => $from->getId(),
            'name'         => $from->getFirstName() . ' ' . $from->getLastName(),
            'chat'         => $message->getChat(),
            'chat_id'      => $message->getChat()->getId(),
            'message'      => $message->getText(true),
        ]);

        return $this->replyToChat(
            'Command not found!' . PHP_EOL . 'Type /help for bot help!'
        );
    }
}
