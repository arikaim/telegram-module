<?php

namespace Arikaim\Modules\Telegram\Actions;

use Arikaim\Core\Actions\Action;
use Longman\TelegramBot\Request;

/**
* Get webhook info telegram action
*/
class GetWebhookInfo extends Action 
{
    /**
     * Init action
     *
     * @return void
    */
    public function init(): void
    {
        $this->name('telegram.get.webhookinfo');
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

        $arikaim->get('driver')->create('telegram.api');

        $response = Request::getWebhookInfo([]);

        if ($response->isOk() == false) {
            $this->error($response->getDescription());
        } else {
            $this->result('response',$response);
        }
    }
}
