<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Users\Subscribers;

use Arikaim\Core\Events\EventSubscriber;
use Arikaim\Core\Interfaces\Events\EventSubscriberInterface;
use Arikaim\Core\Utils\Utils;
use Arikaim\Core\Db\Model;
use Exception;

/**
 * Execute post signup, login actions 
*/
class UsersSubscriber extends EventSubscriber implements EventSubscriberInterface
{
    /**
     * Constructor
     */
    public function __construct() 
    {
        $this->subscribe('user.signup','signup');
        $this->subscribe('user.login','login');
        $this->subscribe('user.logout','logout');
    }

    /**
     * Run post signup action
     *
     * @param EventInterface $event
     * @return void
     */
    public function signup($event)
    {
        global $arikaim;

        $user = $event->getParameters(); 
        $sendWelcomeEmail = $arikaim->get('options')->get('users.notifications.email.welcome',false);
        $adminNotification = $arikaim->get('options')->get('users.notifications.email.signup',false);
        $sendConfirmEmail = (bool)$arikaim->get('options')->get('users.notifications.email.verification',false);
        $userEmail = $user['email'] ?? '';         

        if (
            ($sendWelcomeEmail == true) && 
            (Utils::isEmail($userEmail) == true) &&
            ($sendConfirmEmail == false)
        ) {
            // send welcome email to user
            try {
                $arikaim->get('mailer')->create('users>welcome',$user)->to($userEmail)->send();
            } catch (Exception $e) {               
            }          
        }

        if ($adminNotification == true) {
            $adminUser = Model::Users()->getControlPanelUser();
            if (Utils::isEmail($adminUser->email) == true) {
                // send email to admin
                try {
                    $arikaim->get('mailer')->create('users>signup',$user)->to($adminUser->email)->send();
                } catch (Exception $e) {               
                }   
            }
        }
    }

    /**
     * Run post login action
     *
     * @param EventInterface $event
     * @return void
     */
    public function login($event)
    {
        // your code here
    }

    /**
     * Run post logout action
     *
     * @param EventInterface $event
     * @return void
     */
    public function logout($event)
    {
        // your code here
    }
}
