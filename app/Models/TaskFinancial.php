<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskFinancial extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'title',
        'amount',
        'currency',
        'transaction_date'
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function getTransactionDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d.m.Y'); // Формат дати
    }

    public function setTransactionDateAttribute($value)
    {
        $this->attributes['transaction_date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $value);
    }
}
