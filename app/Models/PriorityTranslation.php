<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriorityTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'locale'
    ];
}
