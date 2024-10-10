@extends('layouts.app')

@section('content')
    <h1>Category</h1>
    @livewire('budget-item-line-category', ['category' => $category, 'budget' => $budget])
@endsection