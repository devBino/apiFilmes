<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Elenco extends Model
{
    protected $table        = "elenco";
    protected $primaryKey   = "id";
    public $incrementing    = true;
    public $timestamps      = false;
}
