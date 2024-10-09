@extends('layouts.app')

@section('content')
    <h1>Result</h1>
    <p>Account Name: {{$accountStatement->name}}</p>
    
    Negative
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Gruppe</th>
                <th>Beløb</th>
                <th>Muligt abbonoment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accountStatement->negativeGroups as $groupName => $lines)
                <tr>
                    <td>{{ $loop->index }}</td>
                    <td>{{$groupName}}</td>
                    <td>{{number_format($lines['amount'], 2, ',', '.')}}</td>
                    <td></td>
                </tr>
            @endforeach
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
            @foreach($accountStatement->positiveGroups as $groupName => $groupAmount)
                <tr>
                    <td>{{ $loop->index }}</td>
                    <td>{{$groupName}}</td>
                    <td>{{number_format($groupAmount, 2, ',', '.')}}</td>
                </tr>
            @endforeach
        </tbody>
@endsection