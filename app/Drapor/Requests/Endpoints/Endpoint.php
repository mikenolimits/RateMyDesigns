<?php namespace App\Drapor\Requests\Endpoints;

use App\Drapor\Requests\Endpoints\Contracts\EndpointContract;
use App\Drapor\Requests\Sanitation\Sanitation;
use App\Drapor\Requests\Transformers\Contracts\TransformerContract;
use App\Drapor\Requests\Validation\FormValidator;

/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 10/16/14
 * Time: 4:38 PM
 */
class Endpoint implements EndpointContract
{
    /* Sanitation $sanitation */
    public $sanitation;
    /* Transformer $transformer */
    public $transformer;
    /* Validator $validator */
    public $validator;
    /* array */
    public static $filters;

    /**
     * @return mixed
     */
    public static function getFilters()
    {
        return self::$filters;
    }

    /**
     * @param mixed $filters
     */
    public static function setFilters($filters)
    {
        self::$filters = $filters;
    }


    public function __construct(Sanitation $sanitation, TransformerContract $transformer, FormValidator $validator)
    {
        $this->sanitation  = $sanitation;
        $this->transformer = $transformer;
        $this->validator   = $validator;
    }

    /**
     * @param array $data
     * @return array
     */
    public function sanitise(array $data)
    {
        return $this->sanitation->sanitise($data, $this::$filters);
    }

    /**
     * @param array $model
     * @param null $embed
     *
     * @return mixed
     */
    public function transform($model)
    {
        return $this->transformer->transform($model);
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function transformCollection(array $data)
    {
        $transformer = $this->getTransformer();
        return $transformer->transformCollection($data);
    }

    /**
     * @param array $formData
     * @param $messages
     * @param $type
     */
    public function validate(array $formData, $type = 'auth',$messages = null)
    {
        $this->validator->validate($formData, $type,$messages);
        return $this;
    }

    /**
     * @param mixed $sanitation
     */
    public function setSanitation($sanitation)
    {
        $this->sanitation = $sanitation;
        return $this;
    }

    /**
     * @param mixed $transformer
     */
    public function setTransformer($transformer)
    {
        $this->transformer = $transformer;
        return $this;
    }

    /**
     * @param mixed $validator
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSanitation()
    {
        return $this->sanitation;

    }

    /**
     * @return mixed
     */
    public function getTransformer()
    {
        return $this->transformer;
    }
}

