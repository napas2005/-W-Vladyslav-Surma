<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
        'slug',
        'user_id',
        'category_id',
        'priority_id',
        'is_completed',
        'due_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function financials()
    {
        return $this->belongsToMany(TaskFinancial::class);
    }

    public function getDueDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = !empty($value) ? \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d') : null ;
    }
}
