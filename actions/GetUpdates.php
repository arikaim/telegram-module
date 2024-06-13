<?php

namespace Arikaim\Modules\Telegram\Actions;

use Arikaim\Core\Actions\Action;
use Longman\TelegramBot\Request;

/**
* Get updates action
*/
class GetUpdates extends Action 
{
    /**
     * Init action
     *
     * @return void
    */
    public function init(): void
    {
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

        $filter = $this->getOption('filter',null);
        
        $driver = $arikaim->get('driver')->create('telegram.api');
        $driver->telegram()->useGetUpdatesWithoutDatabase();

        $response = $driver->telegram()->handleGetUpdates($filter);

        if ($response->isOk() == false) {
            $this->error($response->getDescription());
        } else {
            $this->result('response',$response);
        }
    }
}
