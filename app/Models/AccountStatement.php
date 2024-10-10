<?php

namespace App\Models;

use App\Helpers\GroupNamesAlike;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountStatement extends Model
{
    use HasFactory, GroupNamesAlike;

    protected $fillable = ['name'];


    public function lines()
    {
        return $this->hasMany(AccountStatementLine::class);
    }


    public function getPositiveGroupsAttribute()
    {
        return $this->lines->groupBy('description')
            ->filter(fn($lines) => $lines->sum('amount') > 0)
            ->map(function($lines) {
                $group = new \stdClass;
                $group->description = $lines->first()->description;
                $group->amount = $lines->sum('amount');
                $group->isMultiple = $lines->count() > 2;
                $group->lines = $lines;
                return $group;
            });
    }

    public function getNegativeGroupsAttribute()
    {
        return $this->lines->groupBy('description')
            ->filter(fn($lines) => $lines->sum('amount') < 0)
            ->map(function($lines) {
                $group = new \stdClass;
                $group->description = $lines->first()->description;
                $group->amount = $lines->sum('amount');
                $group->isMultiple = $lines->count() >= 2;
                $group->lines = $lines;
                return $group;
            });
    }

    public function prettifyLineNames()
    {
        $names = $this->namesAlike();
        $this->prettify($names);
    }
}
