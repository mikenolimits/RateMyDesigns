<?php namespace App\Models;


class Rating extends BaseModel {

	protected $fillable = ['design_id','ip'];

    public function design(){
        return $this->belongsTo(Design::class);
    }
}
