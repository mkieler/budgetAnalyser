<div>
    <fieldset role="group"> 
        <input type="text" wire:model="itemName">
        <button wire:click="create">Opret</button>
    </fieldset>

    @foreach($items as $item)
        <article>
            <header>
                <nav>
                    <ul>
                        <li><h4>{{$item->name}}</h4></li>
                        <li>{{$item->total}}</li>
                    </ul>
                    
                    <ul>
                        <li><button wire:click="edit({{$item->id}})">Rediger</button></li>
                        <li><button wire:click="delete({{$item->id}})">Slet</button></li>
                    </ul>
                </nav>
            </header>
            

            <table>
                <tr>
                    <th>Navn</th>
                    <th>Beløb</th>
                    <th></th>
                </tr>
                @foreach($item->categories as $category)
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>{{number_format($category->total, 2, ',', '.')}}</td>
                        <td>
                            <a href="{{route('budget.item.category', [$budget->id, $item->id, $category->id])}}"<i class="fa-solid fa-eye"></i></a>
                            <i class="fa-solid fa-pen-to-square" ></i>
                            <i class="fa-solid fa-trash" wire:click='deleteCategory({{$category->id}})'></i>
                        </td>
                    </tr>
                @endforeach
                @if($item->hasUncategorizedLines)
                    <tr>
                        <td>Ukategoriseret</td>
                        <td>{{number_format($item->MonthlyUncategorizedAmount, 2, ',', '.')}}</td>
                        <td>
                            <a href="{{route('budget.item.category', [$budget->id, $item->id, 'uncategorized'])}}"<i class="fa-solid fa-eye"></i></a>
                            <i class="fa-solid fa-pen-to-square" ></i>
                            <i class="fa-solid fa-trash" wire:click='deleteUncategorized({{$item->id}})'></i>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td><input type="text" wire:model="categoryName.{{$item->id}}"></td>
                    <td>0</td>
                    <td><button wire:click="createCategory({{$item->id}})">Opret</button></td>
                </tr>
            </table>
        </article> 
    @endforeach
</div>
