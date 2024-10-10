@extends('layouts.app')

@section('content')
    <h1>Details</h1>
    @livewire('budget-items', ['budget' => $budget])
@endsection