<?php
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 3/26/15
 * Time: 11:23 PM
 */

namespace App\Drapor\Requests\Endpoints\Contracts;
interface EndpointContract {

    /**
     * @param mixed $filters
     */
    public static function setFilters($filters);
    /**
     * @param array $model
     * @return array
     */
    public function transform($model);

    /**
     * @param array $data
     * @return array
     */
    public function transformCollection(array $data);

    /**
     * @param array $data
     * @return array
     */
    public function sanitise(array $data);

    /**
     * @param array $formData
     * @param string $type
     * @param null $messages
     * @return mixed
     */
    public function validate(array $formData, $type = 'auth',$messages = null);

    /*
     *
     * @return \TheMasqline\Drapor\Requests\Transformers\Contracts|TransformerContract
     */
    public function getTransformer();
}