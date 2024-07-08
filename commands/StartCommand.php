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

/**
 * Start command class
 */
class StartCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'start';

    /**
     * @var string
     */
    protected $description = 'Start command';

    /**
     * @var string
     */
    protected $usage = '/start';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * @var bool
     */
    protected $private_only = false;

    /**
     * Show in Help
     *
     * @var bool
     */
    protected $show_in_help = true;

    /**
     * Run command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        global $arikaim;

        $message = $this->getMessage();

        // trigger event
        $arikaim->get('event')->dispatch('telegram.bot.command',[
            'command'      => $message->getCommand(),
            'bot_username' => $this->telegram->getBotUsername(),
            'from'         => $message->getFrom(),
            'user_id'      => $message->getFrom()->getId(),
            'chat'         => $message->getChat(),
            'chat_id'      => $message->getChat()->getId(),
            'message'      => $message->getText(true),
        ]);

        return $this->replyToChat(
            'Hi!' . PHP_EOL . 'Type /help for bot help!'
        );
    }
}
