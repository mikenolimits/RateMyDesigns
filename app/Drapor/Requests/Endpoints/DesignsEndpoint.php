<?php
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 6/7/15
 * Time: 3:53 PM
 */

namespace App\Drapor\Requests\Endpoints;


use App\Drapor\Requests\Sanitation\Sanitation;

class DesignsEndpoint extends Endpoint
{

    public function __construct(Sanitation $sanitation){
      parent::__construct($sanitation);
    }
}