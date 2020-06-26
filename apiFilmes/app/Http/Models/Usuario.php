<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table        = "usuario";
    protected $primaryKey   = "id";
    public $incrementing    = true;
    public $timestamps      = false;

}
