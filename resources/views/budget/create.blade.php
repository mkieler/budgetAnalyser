@extends('layouts.app')

@section('content')
    <h1>Opret</h1>

    <form action="{{route('budget.store')}}" method="post">
        @csrf
        <label for="name">Navn</label>
        <input type="text" name="name" id="name">
        <button type="submit">Opret</button>
    </form>
@endsection