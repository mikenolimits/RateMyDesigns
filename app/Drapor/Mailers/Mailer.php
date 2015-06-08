<?php namespace TheMasqline\Drapor\Mailers;

use \Mail;
use TheMasqline\Models\User;

abstract class Mailer{
    protected $mail;

    public function __construct(Mail $mail){
        $this->mail = $mail;
    }

    /**
     * @param User $user
     * @param $subject
     * @param $view
     * @param array $data
     */
    public function sendTo(User $user, $subject, $view, $data = array()){


        $user = $user->toArray();
        Mail::queue($view,$data,function($message) use ($user,$subject){
            $message->to($user['email'], $user['first_name'] . ' ' .$user['last_name'])
                ->subject($subject);
        });
    }
}