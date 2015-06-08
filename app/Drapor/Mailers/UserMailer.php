<?php namespace TheMasqline\Drapor\Mailers;
use TheMasqline\Models\User;

class UserMailer extends Mailer{

    public function welcome(User $user, array $data){
        $view = 'emails.auth.activate';
        $subject = 'Please Activate Your Account To View Your Order Information';
        $this->sendTo($user,$subject,$view,$data);
    }

    public function cancel(User $user, array $data){
        $view = 'emails.cancel';
        $subject = 'Cancelation Email';
        $this->sendTo($user,$subject,$view,$data);
    }

    public function apply(User $user,array $data){
        $view    = 'emails.applyToInstruct';
        $subject = 'An Application To Be An Instructor Has Been Submitted';
        $this->sendTo($user,$subject,$view,$data);
    }


    public function stackTrace(User $user, array $data){
        $view = 'emails.admin.stacktrace';
        $subject = $data['error'];
        $this->sendTo($user,$subject,$view,$data);
    }

	public function notice(User $user, array $data){
		$view = 'emails.admin.notice';
		$subject = "Error Notice";
		$this->sendTo($user,$subject,$view,$data);
	}


}