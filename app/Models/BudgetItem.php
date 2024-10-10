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
}
