<?php
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 5/28/15
 * Time: 4:03 PM
 */

namespace App\Drapor\Requests\Transformers\Contracts;


interface TransformerContract {

    public function transform($item);
}