<?php

namespace Arikaim\Modules\Telegram\Actions;

use Arikaim\Core\Actions\Action;
use Longman\TelegramBot\Request;

/**
* getMe telegram action
*/
class GetMe extends Action 
{
    /**
     * Init action
     *
     * @return void
    */
    public function init(): void
    {
        $this->name('telegram.get.me');
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

        $response = Request::getMe([]);

        if ($response->isOk() == false) {
            $this->error($response->getDescription());
        } else {
            $this->result('response',$response);
        }
       
    }
}
