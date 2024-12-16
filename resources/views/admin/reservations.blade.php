@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Reservations</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>User</th>
                <th>Room</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->user->name }}</td>
                    <td>{{ $reservation->room->kambario_nr }}</td>
                    <td>{{ $reservation->pradzios_data }}</td>
                    <td>{{ $reservation->pabaigos_data }}</td>
                    <td>{{ $reservation->bendra_kaina }}</td>
                    <td>Patvirtinta</td>
{{--                    <td>{{ $reservation->status->name }}</td>--}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
