<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItemLine extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'amount', 'budget_item_id'];
}
