<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Uf extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'uf';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];


}
