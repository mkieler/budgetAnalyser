<?php

use App\Imports\AccountStatementImport;
use App\Models\AccountStatement;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/upload', function() {
    $name = request()->input('account-name') . '-' . now()->unix();
    $accountStatement = AccountStatement::updateOrCreate(['name' => $name]);
    Excel::import(new AccountStatementImport($accountStatement), request()->file('account-statement'));
    return redirect()->route('result', ['accountStatementId' => $accountStatement->id]);
})->name('uploadAccountStatement');


Route::get('/result/{accountStatementId}', function($accountStatementId) {
    $data['accountStatement'] = AccountStatement::with('lines')->find($accountStatementId);
    $data['accountStatement']->negativeGroups = $data['accountStatement']->lines->groupBy('description')
        ->filter(fn($lines) => $lines->sum('amount') < 0)
        ->map(fn($lines) => $lines->sum('amount'));
    $data['accountStatement']->positiveGroups = $data['accountStatement']->lines->groupBy('description')
        ->filter(fn($lines) => $lines->sum('amount') > 0)
        ->map(fn($lines) => $lines->sum('amount'));
    return view('result', $data);
})->name('result');
