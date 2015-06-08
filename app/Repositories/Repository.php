<?php namespace App\Repositories;

use App\Models\BaseModel;
use Cache;
use App\Repositories\Contracts\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
class Repository implements EloquentRepositoryInterface
{
    /*
     * Why would you use this class instead of a regular repository?
     * 1. Your database is probably not on the same server as your codebase
     * therefore hitting the cache is N times faster than a DB request.
     *
     */

    /* @var $model \Eloquent */
    protected $model;
    /* @var $query \Eloquent */
    protected $query;

    private  $name;
    /* @var $relations Collection */
    public   $relations;

    /* @var $writeableRelations array */
    public   $writeableRelations;

    /* @var $cacheLifeTime int   */
    public   $cacheLifeTime;


    /**
     * @param BaseModel $model
     * @param $name
     */
    public function __construct(BaseModel $model, $name)
    {
        $this->model = $model;
        $this->name  = str_singular($name);
        $this->allK  = "{$this->name}.all";
    }

    /**
     * @return int
     */
    public function getCacheLifeTime()
    {
        return $this->cacheLifeTime;
    }

    /**
     * @param int $cacheLifeTime
     * @return void
     */
    public function setCacheLifeTime($cacheLifeTime)
    {
        $this->cacheLifeTime = $cacheLifeTime;
    }

    /**
     * @return BaseModel|static[]
     */
    public function get(){
        return $this->query->get();
    }


    /**
     * @return BaseModel|static[]
     */
    public function first(){
        return $this->query->first();
    }

    /**
     * @return array
     */
    public function toArray(){
        return $this->query->toArray();
    }

    /**
     * @return BaseModel
     */
    public function newQuery(){
        $this->query =  new $this->model;
        return $this->query;
    }

    /**
     * @return array
     */
    public function getFillable()
    {
        return $this->model->getFillable();
    }

    /**
     * @param mixed $relations
     */
    public function setRelations(array $relations)
    {
        $collection = [];
        foreach($relations as $relation){
            if(!is_array($relation)) {
                $collection[$relation] = new Relation($relation);
            }else{
                $r = new Relation($relation['name']);
                if(array_key_exists('clearcache',$relation)) {
                    $r->setClearCache(true);
                }
                $collection[$r->name] = $r;
            }
        }
        $this->relations = new Collection($collection);
    }

    /**
     * @return Relation[]|array
     */
    public function getRelations()
    {
        if(count($this->relations) >= 1){
            return $this->relations->lists('name');
        }else{
            return [];
        }
    }

    /**
     * @param $perPage
     * @param array $searchArgs
     * @return $this
     */
    public function paginate($perPage, array $searchArgs = [])
    {
        //We Want To Check That the array being passed has at least
        //one term to search by...

        $nameOfRelations = $this->getRelations();

        $argsCount = count($searchArgs);

        if ($argsCount > 0) {

            $model = $this->newQuery()
                ->with($nameOfRelations);

            $model = $this->getModelFromSearch($searchArgs, $argsCount, $model);

            $this->query =  $model->paginate($perPage);

            return $this->query;
        }
        $this->query = $this->newQuery()
            ->with($nameOfRelations)
            ->paginate($perPage);

        return $this->query;
    }

    /**
     * @param $id
     * @param array $data
     * @return $this
     */
    public function update($id, array $data)
    {
        $old = $this->retrieveCachedModel($id);
        //dd($old->toArray());

        $this->forgetCachedModelById($this->name, $id);

        $filtered = $this->filterModelData($data);
        //dd($filtered);
        //Update the current Model

        $old->update($filtered[0]);

        //Wipe any possible cache bindings to parent relationships specified as such
        //in setRelations()
        $this->forgetParentModels($old);

        //Attempt to update the related models
        $this->updateRelation($filtered[1], $old);

        return $this->find($id);

    }

    /**
     * @param array $data
     * @return $this
     */
    public function create(array $data)
    {
        $filtered        = $this->filterModelData($data);
        $model           = $this->model->create($filtered[0]);

        //Call Find to retrieve related.
        $model           = $this->find($model->id);

        //Find returns a query, but we need the whole Object
        //in order to clear cache bindings.
        $this->forgetParentModels($model->first());

        //Finally, return the query for method chaining.
        return $model;
    }

    public function all(){
        return $this->model->with($this->getRelations())->get();
    }
     /**
     * @param $id
     * @return BaseModel
     */
    public function find($id)
    {
        //Cache forever.
        $this->setCacheLifeTime(0);
        //Retrieve first model model from array.
        $this->query = $this->whereCached('id',$id);

        return $this->first();
    }


    /**
     * If the resource was deleted this will return false
     * @param $id
     * @return bool|void
     */
    public function destroy($id){
        $this->forgetCachedModelById($this->name,$id);
        return $this->model->destroy($id) === 0;
    }

    /**
     * This resolves out of the cache unlike paginated calls.
     * Accurate data should use the regular where().
     * @param $key
     * @param $value
     * @param $operator
     * @return Collection
     */
    public function whereCached($key, $value,$operator = '=')
    {
        if($this->getCacheLifeTime() === 0) {
            //This callback will just set the current query so we can retrieve it later.
            return Cache::rememberForever("{$this->name}.{$key}:{$value}", function () use ($key, $value, $operator) {
                /** @var Collection $model */
                return $this->where($key, $value, $operator);
            });
        }else{
          return Cache::remember("{$this->name}.{$key}:{$value}",$this->getCacheLifeTime(), function () use ($key, $value, $operator) {
                return $this->where($key,$value,$operator);
            });
        }

    }

    /**
     * @param array $data
     * @return array
     */
    public function filterModelData(array $data)
    {
        $filtered = [];
        $notUsed  = [];
        //Basically prevent failure by using the valid columns to make sure
        //that any input passed in actually exists in the DB.
        foreach ($data as $key => $attribute) {
            if (in_array($key, $this->getFillableColumns(),true)) {
                $filtered[$key] = $attribute;
            } else {
                $notUsed[$key] = $attribute;
            }
        }
        return [$filtered, $notUsed];
    }

    /**
     * @return array
     */
    public function getFillableColumns()
    {
        return Cache::rememberForever("{$this->name}.fillable", function () {
            $fillableColumns = [];
            //Get All The Columns From The Related Models
            foreach ($this->relations->toArray() as $relation) {
                if(!$relation->nested) {
                    /** @var BaseModel $relatedModel */
                    $name = $relation->name;
                    $relatedModel = $this->newQuery()->$name()->first();

                    if ($relatedModel !== null) {
                        $gaurded = $relatedModel->getGuarded();
                        $fillableColumns[] = $relation->getColumns();

                        //Unset properties that have been explicitly marked as gaurded.
                        foreach($gaurded as $k => $v){
                            unset($fillableColumns[$k]);
                        }
                    }

                }
            }
            $modelColumns =  $this->newQuery()->getFillable();
            //Get All The Columns From The Current Model
            foreach($modelColumns as $key => $col){
                $fillableColumns[$key] = $col;
             }


            return $fillableColumns;
        });
    }

    /**
     * @param $filtered
     * @param $model
     * @return BaseModel
     */
    private function updateRelation($filtered,$model)
    {
        if (count($filtered) > 0) {
            foreach ($this->relations->toArray() as $relation) {
                $fieldsToUpdateForRelation = [];
                /** @var BaseModel $relatedModel */

                $name         = $relation->name;
                $relatedModel = $model->$name;

                if(array_key_exists($name,$filtered)){
                    /** @var array $modelFields */
                    $modelFields = $filtered[$name];
                    foreach ($modelFields as $key => $possibleFieldToUpdate) {
                        if(in_array($key,$relation->columns,true)){
                            $fieldsToUpdateForRelation[$key] = $possibleFieldToUpdate;
                        }
                    }
                }

                if (count($fieldsToUpdateForRelation) > 0) {
                    $relatedModel->update($fieldsToUpdateForRelation);

                    $model->$name  = $relatedModel;
                }
            }
        }
        return $model;
    }

    /**
     * @param String $key
     * @param String $value
     * @param string $operator
     * @return Collection|static[]
     */
    public function where($key, $value, $operator = '=')
    {
        $namesOfRelations = $this->getRelations();

        /** @var BaseModel $model */
        $model = $this->newQuery()->with($namesOfRelations);

        //Cast K/V to arrays so we can support multiple conditions.

        $key   = (array)$key;
        $value = (array)$value;

        $c     = count($key);

        for($i = 0; $i < $c; $i++) {
            $model = $model->where($key[$i], $operator, $value[$i]);
        }

        return $this->query = $model->get();

    }



    /**
     * @param $name
     * @param $id
     * @return bool
     */
    public function forgetCachedModelById($name,$id)
    {
        $name = str_singular($name);
        $key = "{$name}.id:{$id}";
        if(Cache::has($key)) {
            Cache::forget($key);
            return true;
        }else{
            return false;
        }
    }


    /**
     * @param $id
     * @return BaseModel
     */
    private function retrieveCachedModel($id){

        $namesOfRelations = $this->getRelations();

        return $this->newQuery()->with($namesOfRelations)->find($id);

    }

    /**
     * @param $model
     */
    public function forgetParentModels($model)
    {
        foreach ($this->relations->toArray() as $relation) {
            if ($relation->clearCache) {

                $nameOfRelated = $relation->name;
                $oldId         = $model->$nameOfRelated->id;

                $this->forgetCachedModelById(str_singular($relation->name), $oldId);
            }
        }
    }

    public static function timestamps($data){

        $copy = $data;

        $now = \Carbon\Carbon::createFromTimestamp(time());
        $copy['created_at'] = $now;
        $copy['updated_at'] = $now;

        return $copy;
    }

    /**
     * @param array $searchArgs
     * @param $argsCount
     * @param $model
     * @return mixed
     */
    private function getModelFromSearch(array $searchArgs, $argsCount, $model)
    {
        for ($i = 0; $i < $argsCount; $i++) {
            if (in_array($searchArgs[$i]['key'], $this->getFillableColumns(), true)) {

                if ($i <= 0) {
                    $model = $model->where($searchArgs[$i]['key'],
                        $searchArgs[$i]['operator'],
                        $searchArgs[$i]['value']
                    );
                } else {
                    $model = $model->where($searchArgs[$i]['key'],
                        $searchArgs[$i]['operator'],
                        $searchArgs[$i]['value'],
                        $searchArgs[$i]['keyword']
                    );
                }
            }
        }
        return $model;
    }


}
