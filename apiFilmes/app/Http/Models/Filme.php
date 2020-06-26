<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Filme extends Model
{
    protected $table        = "filme";
    protected $primaryKey   = "id";
    public $incrementing    = true;
    public $timestamps      = false;
}
