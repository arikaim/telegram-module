<?php

namespace Arikaim\Modules\Telegram\Actions;

use Arikaim\Core\Actions\Action;

/**
* DeleteWebhook telegram action
*/
class DeleteWebhook extends Action 
{
    /**
     * Init action
     *
     * @return void
    */
    public function init(): void
    {
        $this->name('telegram.delete.webhook');
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
        
        $response = $driver->telegram()->deleteWebhook();

        if ($response->isOk() == false) {
            $this->error($response->getDescription());
        } else {
            $this->result('response',$response);
        }
    }
}
