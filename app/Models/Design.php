<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends BaseModel {

	//

    protected $fillable = ['name','description','image','user_id'];

    public function ratings(){
        return $this->hasMany(Rating::class);
    }
}
