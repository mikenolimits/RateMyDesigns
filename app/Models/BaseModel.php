<?php
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 3/15/15
 * Time: 12:24 AM
 */

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
     protected $guarded = ['id'];
     public    $columns;

    public $timestamps  = true;

    /* @var $columns array */
     public function __construct($attributes = array()){
         parent::__construct($attributes);
         $this->setColumns();
     }

    public function setColumns(){

        if(count($this->fillable) >= 1){
            return $this->fillable;
        }

        $table = $this->getTable();
        $this->columns = Cache::rememberForever($table,function() use ($table){
            return \Schema::getColumnListing($table);
        });

        return $this;
    }

    public function getColumns(){
        return $this->columns;
    }
}