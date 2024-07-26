<?php

namespace Arikaim\Modules\Telegram\Actions;

use Arikaim\Core\Actions\Action;
use Longman\TelegramBot\Request;

/**
* Send message action
*/
class SendMessage extends Action 
{
    /**
     * Init action
     *
     * @return void
    */
    public function init(): void
    {
        $this->name('telegram.send.message');
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

        $message = $this->getOption('message',null);
        if (empty($message) == true) {
            $this->error("Message is empty");
            return false;
        }

        $chatId = $this->getOption('chat_id',null);
        if (empty($chatId) == true) {
            $this->error("Chat id is empty");
            return false;
        }

        $arikaim->get('driver')->create('telegram.api');

        $response = Request::sendMessage([
            'chat_id' => $chatId,
            'text'    => $message   
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
        $this->descriptor->get('options')->property('message',function($property) {
            $property
                ->title('Message')
                ->type('text-area')                      
                ->readonly(false);              
        }); 

        $this->descriptor->get('options')->property('chat_id',function($property) {
            $property
                ->title('Chat Id')
                ->type('text')                      
                ->readonly(false);              
        }); 
    }
}
