<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use CrudTrait;
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'color',
    ];

    protected $translatedAttributes = [
        'title',
        'locale'
    ];

    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
