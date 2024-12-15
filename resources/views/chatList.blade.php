<!-- resources/views/chatlist.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Visi pokalbiai</h2>

        @if($pokalbiai->isEmpty())
            <p>Šiuo metu nėra pokalbių.</p>
        @else
            <ul class="list-group">
                @foreach($pokalbiai as $pokalbis)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <!-- Display conversation details -->
                        <span>Pokalbis {{ $pokalbis->id }} - Pradžios laikas: {{ $pokalbis->pradzios_laikas }}</span>
                        
                        <!-- Button to join the conversation -->
                        <a href="{{ route('join.pokalbis', $pokalbis->id) }}" class="btn btn-primary">
                            Prisijungti
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
