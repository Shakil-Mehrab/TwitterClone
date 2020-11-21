<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Tweets\Entities\EntityDatabaseCollection;

class Entity extends Model
{
    protected $guarded = [];

    public function newCollection (array $models = []) {//eta mention user er jonno.$tweet->mentions->users() ei relation ta auto collection call kore tai **newCollection()**
        return new EntityDatabaseCollection($models);
    }
}
