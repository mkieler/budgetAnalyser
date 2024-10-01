<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountStatementLine extends Model
{
    use HasFactory;
    protected $fillable = ['account_statement_id', 'date', 'description', 'amount'];

}
