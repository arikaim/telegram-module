<?php

namespace Arikaim\Modules\Telegram\Drivers;

use Longman\TelegramBot\Telegram;

use Arikaim\Core\Driver\Traits\Driver;
use Arikaim\Core\Interfaces\Driver\DriverInterface;
use Arikaim\Core\Http\Url;

/**
 * Driver class
 */
class TelegramApiDriver implements DriverInterface
{   
    use Driver;

    /**
     * Telegram api instance
     *
     * @var object|null
     */
    protected $telegram;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDriverParams(
            'telegram.api',
            'telegram',
            'Telegram Api Client',
            'Telegram api client driver'
        );      
    }

    /**
     * Get telegram api instance
     *
     * @return object|null
     */
    public function telegram(): ?object
    {
        return $this->telegram;
    }

    /**
     * Initialize driver
     *
     * @return void
     */
    public function initDriver($properties)
    {
        $apiKey = \trim($properties->getValue('api_key',''));
        $botUsername = \trim($properties->getValue('bot_username',''));

        $this->telegram = new Telegram($apiKey,$botUsername);
    }

    /**
     * Create driver config properties array
     *
     * @param Arikaim\Core\Collection\Properties $properties
     * @return void
     */
    public function createDriverConfig($properties)
    {
        $properties->property('webhook_url',function($property) {
            $property
                ->title('Webhook url')
                ->type('text')   
                ->value(Url::BASE_URL)               
                ->readonly(true);              
        });  

        $properties->property('api_key',function($property) {
            $property
                ->title('Api Key')
                ->type('key')                      
                ->readonly(false);              
        }); 

        $properties->property('bot_username',function($property) {
            $property
                ->title('Bot username')
                ->type('text')                      
                ->readonly(false);              
        }); 
    }
}
