<?php namespace App\Models;

use Drapor\CacheRepository\Eloquent\BaseModel;
class Rating extends BaseModel {

	protected $fillable = ['design_id','ip'];

    public function design(){
        return $this->belongsTo(Design::class);
    }
}
