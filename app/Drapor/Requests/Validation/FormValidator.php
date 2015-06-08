<?php namespace App\Drapor\Requests\Validation;

use Illuminate\Validation\Factory as Validator;

abstract class FormValidator{

    /**
     * @var Validator
     */
    protected $validator;

    public $readRules;
    public $updateRules;
    public $storeRules;
    public $deleteRules;

	/**
	 * @var
	 */
	protected $validation;

    /**
     * @param $validator
     */
    function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }


	/**
	 * @param array $formData
	 * @param null $messages
	 * @param string $type
	 *
	 * @return bool
	 * @throws FormValidationException
	 */
	public function validate(array $formData,$type='auth',$messages = null){
        if(!isset($messages)){
        $this->validation = $this->validator->make($formData, $this->getValidationRules($type));

        }
        if(isset($messages)){
            $this->validation = $this->validator->make($formData, $this->getValidationRules($type),$messages);
        }
        if($this->validation->fails()){
            //\Event::fire('validation.failed',$this->getValidationErrors());
            throw new FormValidationException('Validation Has Failed',$this->getValidationErrors());
            //throw new ValidationException('422',$this->getValidationErrors(),null,null,422);
        }

        return true;
    }

	/**
	 * @param $type
	 *
	 * @return mixed
	 */
	protected  function getValidationRules($type)
    {
       switch($type){
	       case 'auth';
		       return $this->rules();
		       break;
	       case 'create';
		       return $this->storeRules;
	           break;
	       case 'update';
		       return $this->updateRules;
	           break;
	       case 'read';
		       return $this->readRules;
           case 'delete';
               return $this->deleteRules;
	       default:
		       return $this->rules();
		       break;
       }
    }

	/**
	 * @return mixed
	 */
	protected function getValidationErrors(){

        return $this->validation->errors();
    }

    /**
     * @return bool
     */
    public abstract function rules();


}