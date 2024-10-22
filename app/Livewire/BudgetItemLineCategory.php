<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BudgetItemLine;


class BudgetItemLineCategory extends Component
{
    public $category;
    public $budget;
    public $lineName;
    public $lineAmount;
    public $budgetItemId;

    public function render()
    {
        $data['lines'] = $this->category->lines;
        $data['categories'] = $this->budget->items->find($this->budgetItemId)->categories;
        return view('livewire.budget-item-line-category', $data);
    }

    public function createLine(){
        $this->category->lines()->create(['name' => $this->lineName, 'amount' => $this->lineAmount, 'budget_item_id' => $this->category->budget_item_id]);
    }

    public function deleteLine($lineId){
        $this->category->lines()->find($lineId)->delete();
    }

    public function addLineToCategory($lineId, $categoryId){
        BudgetItemLine::where('id', $lineId)->update(['budget_item_line_category_id' => $categoryId]);
    }
}
