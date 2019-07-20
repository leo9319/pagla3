<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['id', 'bank_reference', 'image', 'created_at', 'updated_at'];
}
