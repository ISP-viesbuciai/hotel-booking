@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>Sveiki atvykę į viešbučių rezervacijos puslapį</h1>
        <p>Prašome prisijungti ar užsiregistruoti</p>
        
        <div class="mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary mx-2">Prisijungti</a>
            <a href="{{ route('register') }}" class="btn btn-secondary mx-2">Registruotis</a>
        </div>
    </div>
@endsection