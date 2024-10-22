<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'budget_id'];


    public function lines()
    {
        return $this->hasMany(BudgetItemLine::class);
    }

    public function categories()
    {
        return $this->hasMany(BudgetItemLineCategory::class);
    }

    public function getUncategorizedLinesAttribute()
    {
        return $this->lines->where('budget_item_line_category_id', null);
    }

    public function getHasUncategorizedLinesAttribute()
    {
        return $this->uncategorizedLines->count() > 0;
    }

    public function getUncategorizedAmountAttribute()
    {
        return $this->uncategorizedLines->sum('amount');
    }

    public function getMonthlyUncategorizedAmountAttribute()
    {
        return $this->uncategorizedLines->sum('amount') / 12;
    }
}
