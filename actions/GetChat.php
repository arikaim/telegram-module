<?php

namespace Arikaim\Modules\Telegram\Actions;

use Arikaim\Core\Actions\Action;
use Longman\TelegramBot\Request;

/**
* Get chat info telegram action
*/
class GetChat extends Action 
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

        $arikaim->get('driver')->create('telegram.api');

        $chatId = $this->getOption('chat_id',null);
        if (empty($chatId) == true) {
            $this->error("Chat id is empty");
            return false;
        }

        $response = Request::getChat([
            'chat_id' => $chatId
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
        $this->descriptor->get('options')->property('chat_id',function($property) {
            $property
                ->title('Chat Id')
                ->type('text')                      
                ->readonly(false);              
        }); 
    }
}
