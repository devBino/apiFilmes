<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Diretor extends Model
{
    protected $table        = "diretor";
    protected $primaryKey   = "id";
    public $incrementing    = true;
    public $timestamps      = false;
}
