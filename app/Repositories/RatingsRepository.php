<?php
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 6/7/15
 * Time: 3:32 PM
 */

namespace App\Repositories;
use App\Models\Rating;

class RatingsRepository extends Repository
{

    public function __construct(Rating $rating){
        parent::__construct($rating,'rating');
        $this->setRelations(['design']);
    }
}