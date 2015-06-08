<?php namespace TheMasqline\Drapor\Authentication;
use Input;
use Request;
use TheMasqline\Drapor\Requests\Endpoints\AuthenticationEndpoint;
class Authentication {


    protected $validation;
    protected $data;
    protected $errorException;

    public function __construct(AuthenticationEndpoint $authenticationEndpoint){
        $this->authenticationEndpoint = $authenticationEndpoint;
    }

    public static function generateHash(){

        $key      = $_ENV['secretkey'];
        $method   = Request::method();
        $url      = Request::url();
        $deviceId = Input::get('deviceId');
        $time     = Input::get('timestamp');

     $data =  $deviceId . $method . $url . $time;

     $hash = hash_hmac('sha256',$data,$key);

     return $hash;
    }

    public function validateHash(){

        $input = Input::all();

        $this->authenticationEndpoint->validate($input,NULL,"auth");

    }













}
