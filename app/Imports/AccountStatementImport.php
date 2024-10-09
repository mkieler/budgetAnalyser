<?php

namespace App\Imports;

use App\Models\AccountStatementLine;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class AccountStatementImport implements ToModel
{
    protected $accountStatement;

    public function __construct($accountStatement)
    {
        $this->accountStatement = $accountStatement;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //skip the first row
        if ($row[0] == 'Dato') {
            return null;
        }

        return new AccountStatementLine([
            'account_statement_id' => $this->accountStatement->id,
            'date' => Carbon::parseFromLocale($row[0], 'da')->format('Y-m-d'),
            'description' => $this->parseDescription($row[1]),
            'amount' => $row[2],
        ]);
    }

    private function parseDescription($description)
    {
        $description = strtolower($description);
        //Remove strange prefixes
        if(str_contains($description, 'dk-nota')){
            $description = substr($description, 13);
        } else if(str_contains($description, 'mobilepay')){
            $description = 'MobilePay';
        } else if(str_contains($description, 'forretning')){
            $description = substr($description, 12);
        } 
        return $description;
    }
}
