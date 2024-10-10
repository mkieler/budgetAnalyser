<?php

namespace App\Livewire;

use App\Models\AccountStatement;
use App\Models\AccountStatementLine;
use App\Models\Budget;
use Livewire\Component;

class AnalyserTabel extends Component
{
    public $accountStatementID;
    public $selectedBudget;

    public function render()
    {
        $this->selectedBudget = Budget::find($this->selectedBudget) ?? Budget::first();

        $data['accountStatement'] = AccountStatement::with(['lines' => fn($query) => $query->where('exclude', false)])->find($this->accountStatementID);
        $data['budgets'] = Budget::all('id', 'name');
        return view('livewire.analyser-tabel', $data);
    }

    public function excludeLines($lineIds)
    {
        foreach ($lineIds as $lineId) {
            $line = AccountStatementLine::find($lineId);
            $line->exclude = true;
            $line->save();
        }
    }

    public function updateBudget($id){
        $this->selectedBudget = Budget::find($id);
    }

    public function setBudgetItemForLines($budgetItemId, $name, $amount)
    {
        $this->selectedBudget->items()->find($budgetItemId)->lines()->create(['name' => $name, 'amount' => $amount]);
    }
}
