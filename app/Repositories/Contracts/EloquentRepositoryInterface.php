<?php
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 3/25/15
 * Time: 8:37 PM
 */

namespace App\Repositories\Contracts;

use App\Models\BaseModel;
interface EloquentRepositoryInterface {


    /**
     * @return array
     */
    public function getFillable();

    /**
     * @param mixed $relations
     */
    public function setRelations(array $relations);

    /**
     * @return BaseModel|static[]
     */
    public function get();

    /**
     * @return BaseModel|static[]
     */
    public function first();

    /**
     * @return array
     */
    public function toArray();

    /**
     * @param $perPage
     * @param $searchArgs
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage,array $searchArgs = []);

    /**
     * @param $id
     * @param array $data
     * @return $this
     */
    public function update($id,array $data);


    /**
     * @param $id
     * @return bool
     */
    public function destroy($id);

    /**
     * @param array $data
     * @return BaseModel
     */
    public function create(array $data);


    /**
     * @param $id
     * @return BaseModel
     */
    public function find($id);

    /**
     * @param String $key
     * @param String $value
     * @param String $operator
     * @return \Illuminate\Support\Collection
     */
    public function whereCached($key,$value,$operator = '=');

    /**
     * @param Int $minutes
     * @return Void
     */
    public function setCacheLifeTime($minutes);

    /**
     * @param String $key
     * @param String $value
     * @param String $operator
     * @return BaseModel
     */
    public function where($key,$value,$operator = '=');

    /**
     * @param array $data
     * @return array
     */
    public function filterModelData(array $data);
}