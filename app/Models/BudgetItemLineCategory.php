<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItemLineCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'budget_item_id'];

    public function lines()
    {
        return $this->hasMany(BudgetItemLine::class);
    }

    public function getTotalAttribute()
    {
        return (float) $this->lines?->sum('amount');
    }
}
