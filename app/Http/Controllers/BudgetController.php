<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetItemLineCategory;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function list()
    {
        $data['budgets'] = Budget::paginate(20);
        return view('budget.list', $data);
    }

    public function create()
    {
        return view('budget.create');
    }

    public function store(Request $request)
    {
        Budget::create($request->all());
        return redirect()->route('budget.list');
    }

    public function edit(Budget $budget)
    {
        $data['budget'] = $budget;
        return view('budget.edit', $data);
    }

    public function update(Budget $budget, Request $request)
    {
        $budget->update($request->all());
        return redirect()->route('budget.list');
    }

    public function delete(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budget.list');
    }

    public function details(Budget $budget)
    {
        $data['budget'] = $budget;
        return view('budget.details', $data);
    }

    public function showItemCategory(Budget $budget, $itemId, $categoryId)
    {
        $data['category'] = BudgetItemLineCategory::with('lines')->find($categoryId);
        $data['budget'] = $budget;
        return view('budget.item.details', $data);
    }
}
