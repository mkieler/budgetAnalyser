@extends('layouts.app')

@section('content')
    <nav>
        <ul>
            <li><h1>Budgetter</h1></li>
            <li><a role="button" href="{{route('budget.create')}}">Opret budget</a></li>
        </ul>
    </nav>

    <table>
        <tr>
            <th>Navn</th>
            <th></th>
        </tr>
        @foreach($budgets as $budget)
            <tr>
                <td><a href="{{route('budget.details', $budget->id)}}">{{$budget->name}}</a></td>
                <td>
                    <a href="{{route('budget.edit', $budget->id)}}"><i class="fa-solid fa-edit"></i></a>
                    <a onclick="return confirm('Er du sikker?')" href="{{route('budget.delete', $budget->id)}}"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
    </table>

@endsection