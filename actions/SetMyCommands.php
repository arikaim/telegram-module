<?php

namespace Arikaim\Modules\Telegram\Actions;

use Arikaim\Core\Actions\Action;
use Longman\TelegramBot\Request;

/**
* SetMyCommands telegram action
*/
class SetMyCommands extends Action 
{
    /**
     * Init action
     *
     * @return void
    */
    public function init(): void
    {
        $this->name('telegram.set.commands');
    }

    /**
     * Run action
     *
     * @param mixed ...$params
     * @return bool
     */
    public function run(...$params)
    {
        global $arikaim;

        $driver = $arikaim->get('driver')->create('telegram.api');
       
        $commandClasses = $this->getOption('commands',null);
        if (empty($commandClasses) == true) {
            $this->error("Commands list not set");
            return false;
        }

        if (\is_string($commandClasses) == true) {         
            $commandClasses = \explode("\n",str_replace("\r",'',$commandClasses));
        }

        $commands = [];
        foreach ($commandClasses as $commandClass) {
            $command = new $commandClass($driver->telegram());
            if ($command->isSystemCommand() == false) {
                $commands[] = [
                    'command'     => $command->getName(),
                    'description' => $command->getDescription()
                ];
            }
        }

        $response = Request::setMyCommands([
            'commands' => $commands
        ]);

        if ($response->isOk() == false) {
            $this->error($response->getDescription());
        } else {
            $this->result('response',$response);
        }
    }

    /**
     * Init properties descriptor
     *
     * @return void
     */
    protected function initDescriptor(): void
    {
        $this->descriptor->get('options')->property('commands',function($property) {
            $property
                ->title('Commands classes')
                ->type('text-area')                      
                ->readonly(false);              
        }); 
    }
}
