<?php

namespace App\Livewire;

use App\Models\BudgetItemLineCategory;
use Livewire\Component;

class BudgetItems extends Component
{
    public $budget;
    public $itemName;
    public $categoryName;

    public function render()
    {
        $data['items'] = $this->budget->items()->with('categories')->get();
        return view('livewire.budget-items', $data);
    }

    public function create()
    {
        $this->budget->items()->create(['name' => $this->itemName]);
    }

    public function delete($itemId)
    {
        $this->budget->items()->find($itemId)->delete();
    }

    public function edit($itemId)
    {
        $this->emit('editItem', $this->budget->items()->find($itemId));
    }

    public function createCategory($itemId)
    {
        BudgetItemLineCategory::create(['budget_item_id' => $itemId, 'name' => $this->categoryName]);
    }

    public function deleteCategory($categoryId)
    {
        BudgetItemLineCategory::find($categoryId)->delete();
    }
}
