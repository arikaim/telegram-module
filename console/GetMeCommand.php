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
 * GetMe telegram command
 */
class GetMeCommand extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('telegram:getMe');
        $this->setDescription('Telegram getMe command');    
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

        $action = Actions::createFromModule('GetMe','telegram',[          
        ])->getAction();
       
        $action->run();

        if ($action->hasError() == false) {
            $response = $action->get('response');
            $data = $response->jsonSerialize();
            print_r($data);

            $this->showCompleted();
        } else {
            $this->showError($action->getError());
        }
    }
}
