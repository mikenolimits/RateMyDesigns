<?php namespace TheMasqline\Drapor\Requests\Validation\Validators;
use TheMasqline\Drapor\Requests\Validation\FormValidator;

class AuthenticationValidator extends FormValidator{

    public function rules(){
        return [
            'deviceId' => 'required',
            'timestamp' => 'required|integer|between:' .  strtotime('-1 minutes') . ',' . strtotime('+1 minutes')
        ];
    }


} 