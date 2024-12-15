@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Vartotojų sąrašas</h2>
    <ul class="list-group mt-3">
        @foreach($users as $user)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $user->name }} (ID: {{ $user->id }})
                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-primary">Peržiūrėti</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection