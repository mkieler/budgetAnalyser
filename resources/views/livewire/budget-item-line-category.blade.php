<div>
    <table>
        <tr>
            <th>Navn</th>
            <th>Beløb</th>
            <th>Kategori</th>
            <th></th>
        </tr>
        @foreach($lines as $line)
            <tr>
                <td>{{$line->name}}</td>
                <td>{{number_format($line->amount, 2, ',', '.')}}</td>
                <td>
                    <select wire:change='addLineToCategory({{$line}}, $event.target.value)'>
                        <option value="0">Vælg</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <i class="fa-solid fa-pen-to-square" ></i>
                    <i class="fa-solid fa-trash"></i>
                </td>
            </tr>
        @endforeach
        <tr>
            <td>
                <input type="text" wire:model="lineName">
            </td>
            <td>
                <input type="text" wire:model="lineAmount">
            </td>
            <td>
                <button wire:click="createLine">Opret</button>
            </td>
        </tr>
    </table>
</div>
