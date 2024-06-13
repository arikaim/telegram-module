<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
 */
namespace Arikaim\Modules\Telegram\Console;

use Arikaim\Core\Console\ConsoleCommand;
use Arikaim\Core\Actions\Actions;

/**
 * Get updaes telegram command
 */
class GetUpdatesCommand extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('telegram:updates');
        $this->setDescription('Telegram get updates');    
    }

    /**
     * Run command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function executeCommand($input,$output)
    {
        $this->showTitle();

        $action = Actions::createFromModule('GetUpdates','telegram',[          
        ])->getAction();
       
        $action->run();

        if ($action->hasError() == false) {
            $response = $action->get('response');
            var_dump($response);
            $this->showCompleted();
        } else {
            $this->showError($action->getError());
        }
    }
}
