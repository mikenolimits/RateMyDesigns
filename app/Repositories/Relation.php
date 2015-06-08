<?php
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 3/30/15
 * Time: 8:31 PM
 */

namespace App\Repositories;

use App;

class Relation {

    public $name;
    public $columns;

    public $nested;
    /* Indicates weather or not a parent relation exists which needs its
       cache binds cleared when updated.
     */
    public $clearCache;

    /**
     * @return mixed
     */
    public function getClearCache()
    {
        return $this->clearCache;
    }

    /**
     * @param mixed $clearCache
     */
    public function setClearCache($clearCache)
    {
        $this->clearCache = $clearCache;
    }

    public function __construct($name){
        $this->name    = $name;

        $this->nested = str_contains($name, '.') ? true : false;

        if(!$this->nested){
            $name          = str_singular(studly_case($name));

            /** @var \App\Models\BaseModel $model */
            $model         =  App::make(studly_case("App\\Models\\{$name}"));

            //Quickly create an instance of the model and grab its fillable fields from cache.
            $this->columns = $model->getColumns();
        }else{
            $this->columns = [];
        }
    }

    /**
     * @return mixed
     */
    public function getColumns()
    {
        return $this->columns;
    }


}