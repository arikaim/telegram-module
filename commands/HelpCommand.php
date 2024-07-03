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
use Longman\TelegramBot\Commands\Command;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

/**
 * Bot help command class
 */
class HelpCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'help';

    /**
     * @var string
     */
    protected $description = 'Help';

    /**
     * @var string
     */
    protected $usage = '/help or /help <command>';

    /**
     * @var string
     */
    protected $version = '1.0.1';

    /**
     * Show in Help
     *
     * @var bool
     */
    protected $show_in_help = true;

     /**
     * @var bool
     */
    protected $private_only = false;

    /**
     * Run command
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        global $arikaim;

        $message = $this->getMessage();
        $commandText = \trim($message->getText(true));
        $commandText = \str_replace('/','',$commandText);

        $commandClasses = $this->telegram->getCommandClasses();
        $commands = [];
        $text = 'Commands:' . PHP_EOL;
        foreach ($commandClasses[Command::AUTH_USER] as $commandName => $commandClass) {
            $command = $this->telegram->getCommandObject($commandName);
            if ($command != null) {
                if ($command->showInHelp() == true) {
                    $commands[$commandName] = $command;
                    $text .= '/' . $command->getName() . ' - ' . $command->getDescription() . PHP_EOL;
                }
            }
        }

        if (empty($commandText) == true) {
            $text .= PHP_EOL . 'For command help type: /help <command>';
            return $this->replyToChat($text);
        }

        if (isset($commands[$commandText]) == true) {
            $command = $commands[$commandText];

            return $this->replyToChat(sprintf(
                'Command: %s (v%s)' . PHP_EOL .
                'Description: %s' . PHP_EOL .
                'Usage: %s',
                $command->getName(),
                $command->getVersion(),
                $command->getDescription(),
                $command->getUsage()
            ));
        }

        return $this->replyToChat('No help: Command /' . $commandText . ' not found');
    }
}
