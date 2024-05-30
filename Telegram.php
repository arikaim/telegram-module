<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Telegram;

use Arikaim\Core\Extension\Module;

/**
 * Telegram module class
 */
class Telegram extends Module
{  
    /**
     * Install module
     *
     * @return void
     */
    public function install()
    {
        $this->installDriver('Arikaim\\Modules\\Telegram\\Drivers\\TelegramApiDriver');          
    }
}
