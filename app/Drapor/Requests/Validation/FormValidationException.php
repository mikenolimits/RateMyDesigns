<?php namespace App\Drapor\Requests\Validation;

use Illuminate\Support\MessageBag;
use Illuminate\Contracts\Support\MessageProvider;

class FormValidationException extends \Exception implements MessageProvider {

    /**
     * @var MessageBag
     */
    protected $errors;

    /**
     * @param string     $message
     * @param MessageBag $errors
     */
    function __construct($message, MessageBag $errors)
    {
        $this->errors = $errors;

        parent::__construct($message);
    }

    /**
     * Get form validation errors
     *
     * @return MessageBag
     */
    public function getMessageBag()
    {
        return $this->errors;
    }

}