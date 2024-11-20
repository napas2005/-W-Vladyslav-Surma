<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use CrudTrait;
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'active',
    ];

    protected $translatedAttributes = [
        'locale',
        'title',
        'slug',
        'description'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function scopeActive(Builder $query, bool $active = true)
    {
        return $query->where('active', (int)$active);
    }
}
