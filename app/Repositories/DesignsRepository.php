<?php
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 6/7/15
 * Time: 3:28 PM
 */

namespace App\Repositories;
use App\Models\Design;
use Drapor\CacheRepository\CacheRepository;

class DesignsRepository extends CacheRepository
{

    public function __construct(Design $design){
        parent::__construct($design,'design');
        $this->setRelations(['ratings']);
    }
}