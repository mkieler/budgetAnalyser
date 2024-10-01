@extends('layouts.app')

@section('content')
    <h1>Result</h1>
    <p>Account Name: {{$accountStatement->name}}</p>
    
    Negative
    <table>
        <thead>
            <tr>
                <th>Gruppe</th>
                <th>Beløb</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accountStatement->negativeGroups as $groupName => $groupAmount)
                <tr>
                    <td>{{$groupName}}</td>
                    <td>{{$groupAmount}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    Positive
    <table>
        <thead>
            <tr>
                <th>Gruppe</th>
                <th>Beløb</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accountStatement->positiveGroups as $groupName => $groupAmount)
                <tr>
                    <td>{{$groupName}}</td>
                    <td>{{$groupAmount}}</td>
                </tr>
            @endforeach
        </tbody>
@endsection