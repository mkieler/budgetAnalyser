@extends('layouts.app')

@section('content')
    <h1>Result</h1>
    <p>Account Name: {{$accountStatement->name}}</p>

    @livewire('analyser-tabel', ['accountStatementID' => $accountStatementID])
@endsection