<?php
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 6/7/15
 * Time: 3:32 PM
 */

namespace App\Repositories;
use App\Models\Rating;
use Drapor\CacheRepository\CacheRepository;

class RatingsRepository extends CacheRepository
{

    public function __construct(Rating $rating){
        parent::__construct($rating,'rating');
        $this->setRelations(['design']);
    }
}