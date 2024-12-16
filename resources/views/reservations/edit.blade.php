@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Redaguoti Rezervaciją</h3>

        <form action="{{ route('reservations.update', $reservation->rezervacijos_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="pradzios_data" class="form-label">Pradžios Data</label>
                <input type="date" name="pradzios_data" id="pradzios_data" class="form-control"
                       value="{{ $reservation->pradzios_data }}" required>
            </div>

            <div class="mb-3">
                <label for="pabaigos_data" class="form-label">Pabaigos Data</label>
                <input type="date" name="pabaigos_data" id="pabaigos_data" class="form-control"
                       value="{{ $reservation->pabaigos_data }}" required>
            </div>

            <div class="mb-3">
                <label for="kiek_zmoniu" class="form-label">Žmonių Skaičius</label>
                <input type="number" name="kiek_zmoniu" id="kiek_zmoniu" class="form-control"
                       value="{{ $reservation->kiek_zmoniu }}" required>
            </div>

            <button type="submit" class="btn btn-success">Išsaugoti</button>
            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Atšaukti</a>
        </form>
    </div>
@endsection
