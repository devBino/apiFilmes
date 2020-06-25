<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Ator extends Model
{
    protected $table        = "ator";
    protected $primaryKey   = "id";
    public $incrementing    = true;
    public $timestamps      = false;
}
