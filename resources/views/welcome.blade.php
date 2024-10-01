@extends('layouts.app')

@section('content')
<form method="POST" action="{{route('uploadAccountStatement')}}" enctype="multipart/form-data">
    @csrf
    <input type="text" name="account-name" placeholder="account name">
    <input type="file" name="account-statement">
    <button type="submit">Upload</button>
</form>