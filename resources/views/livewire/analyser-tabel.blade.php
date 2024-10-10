<div>
    <select wire:change='updateBudget'>
        @foreach($budgets as $budget)
            <option value="{{$budget->id}}">{{$budget->name}}</option>
        @endforeach
    </select>
    Negative
    <table class="striped">
        <thead>
            <tr>
                <th></th>
                <th>Tilføj til budget</th>
                <th>Ekskluder</th>
                <th>Gruppe</th>
                <th>Beløb</th>
                <th>Muligt abbonoment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accountStatement->negativeGroups->sortByDesc('isMultiple') as $groupName => $group)
                <tr>
                    <td>{{ $loop->index }}</td>
                    <td>
                        @if ($selectedBudget)
                            <select wire:change='setBudgetItemForLines($event.target.value, "{{$group->description}}", "{{$group->amount}}")'>
                                <option value="0">Vælg</option>
                                @foreach($selectedBudget->items as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </td>
                    <td><i class="fa-solid fa-trash" wire:click='excludeLines({{$group->lines->pluck('id')}})'></i></td>
                    <td>{{$group->description}}</td>
                    <td>{{number_format($group->amount, 2, ',', '.')}}</td>
                    <td>{{$group->isMultiple}}</td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td>Total</td>
                <td>{{number_format($accountStatement->negativeGroups->sum('amount'), 2, ',', '.')}}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    Positive
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Gruppe</th>
                <th>Beløb</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($accountStatement->positiveGroups as $groupName => $group)
                <tr>
                    <td>{{ $loop->index }}</td>
                    <td>{{$group->description}}</td>
                    <td>{{number_format($group->amount, 2, ',', '.')}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
