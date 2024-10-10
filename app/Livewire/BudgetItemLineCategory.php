<?php

namespace App\Livewire;

use Livewire\Component;

class BudgetItemLineCategory extends Component
{
    public $category;
    public $budget;
    public $lineName;
    public $lineAmount;

    public function render()
    {
        $data['lines'] = $this->category->lines;
        return view('livewire.budget-item-line-category', $data);
    }

    public function createLine(){
        $this->category->lines()->create(['name' => $this->lineName, 'amount' => $this->lineAmount, 'budget_item_id' => $this->category->budget_item_id]);
    }
}
