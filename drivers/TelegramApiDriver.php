<?php

namespace Arikaim\Modules\Telegram\Drivers;

use Longman\TelegramBot\Telegram;

use Arikaim\Core\Driver\Traits\Driver;
use Arikaim\Core\Interfaces\Driver\DriverInterface;
use Arikaim\Core\Http\Url;

/**
 * Telegram driver class
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
     * Bot username
     *
     * @var string|null
     */
    protected $botUsername;

    /**
     * Web hook secret token
     *
     * @var string|null
     */
    protected $secretToken;

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
     * Get web hook secret token
     *
     * @return string|null
     */
    public function getSecretToken(): ?string
    {
        return $this->secretToken;
    }

    /**
     * Get bot username
     *
     * @return string
     */
    public function getBotUsername(): string
    {
        return $this->botUsername;
    }

    /**
     * Initialize driver
     *
     * @return void
     */
    public function initDriver($properties)
    {
        $apiKey = \trim($properties->getValue('api_key',''));
        $this->botUsername = \trim($properties->getValue('bot_username',''));
        $this->secretToken = $properties->getValue('secret_token',null);

        if (empty($apiKey) == false && empty($this->botUsername) == false) {
            $this->telegram = new Telegram($apiKey,$this->botUsername);
        }
    }

    /**
     * get webhook url
     *
     * @return string
     */
    public function getWebhookUrl(): string
    {
        return Url::BASE_URL . '/api/telegram/webhook/' . ($this->botUsername ?? '');
    }

    /**
     * Create driver config properties array
     *
     * @param Arikaim\Core\Collection\Properties $properties
     * @return void
     */
    public function createDriverConfig($properties)
    {
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

        $properties->property('secret_token',function($property) {
            $property
                ->title('Webhook secret token')
                ->type('text')                      
                ->readonly(false);              
        }); 
    }
}
