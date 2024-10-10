<?php

use App\Helpers\GroupNamesAlike;
use App\Http\Controllers\BudgetController;
use App\Imports\AccountStatementImport;
use App\Models\AccountStatement;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Framework\Attributes\Group;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/upload', function() {
    $name = request()->input('account-name') . '-' . now()->unix();
    $accountStatement = AccountStatement::updateOrCreate(['name' => $name]);
    Excel::import(new AccountStatementImport($accountStatement), request()->file('account-statement'));
    $accountStatement->prettifyLineNames();
    return redirect()->route('result', ['accountStatementId' => $accountStatement->id]);
})->name('uploadAccountStatement');


Route::get('/result/{accountStatementId}', function($accountStatementId) {
    $data['accountStatement'] = AccountStatement::with('lines')->find($accountStatementId);
    $data['accountStatementID'] = $accountStatementId;

    return view('result', $data);
})->name('result');


Route::controller(BudgetController::class)->prefix('/budget')->name('budget.')->group(function() {
    Route::get('/', 'list')->name('list');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{budget}', 'edit')->name('edit');
    Route::post('/update/{budget}', 'update')->name('update');
    Route::get('/delete/{budget}', 'delete')->name('delete');
    Route::get('/details/{budget}', 'details')->name('details');

    Route::get('/{budget}/items', 'listItems')->name('items');
    Route::get('/{budget}/items/{item}/categories/{category}', 'showItemCategory')->name('item.category');
});
