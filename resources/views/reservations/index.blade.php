@extends('layouts.app')

@section('content')

    <!-- Display Success or Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <style>
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
    </style>

    <div class="container">
        <h2>Ieškoti Laisvų Kambarių</h2>

        <!-- Date Picker Form -->
        <form method="GET" action="{{ route('reservations.index') }}">
            <div class="mb-3">
                <label for="start_date" class="form-label">Pradžios Data</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">Pabaigos Data</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Ieškoti</button>
        </form>

        @if(isset($availableRooms))
            <h3 class="mt-5">Pasiekiami Kambariai</h3>
            @if($availableRooms->isEmpty())
                <p class="text-danger">Šiuo laikotarpiu nėra laisvų kambarių.</p>
            @else
                <table class="table table-bordered mt-3">
                    <thead>
                    <tr>
                        <th>Kambario Numeris</th>
                        <th>Tipas</th>
                        <th>Talpa</th>
                        <th>Kaina už Nakvynę</th>
                        <th>Veiksmai</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($availableRooms as $room)
                        <tr>
                            <td>{{ $room->kambario_nr }}</td>
                            <td>{{ $room->tipas }}</td>
                            <td>{{ $room->capacity }}</td>
                            <td>{{ number_format($room->kaina_nakciai, 2) }} EUR</td>
                            <td>
                                <!-- Reservation Button -->
                                <form action="{{ route('reservations.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kambario_id" value="{{ $room->kambario_id }}">
                                    <input type="hidden" name="start_date" value="{{ $validated['start_date'] }}">
                                    <input type="hidden" name="end_date" value="{{ $validated['end_date'] }}">
                                    <button type="button" class="btn btn-primary btn-sm"
                                            onclick="openReservationModal({{ $room->kambario_id }}, '{{ $validated['start_date'] }}', '{{ $validated['end_date'] }}')">
                                        Rezervuoti
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $availableRooms->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        @endif
    </div>

    <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="stripePaymentForm" method="POST" action="{{ route('stripe.success') }}">
                @csrf
                    <input type="hidden" name="kambario_id" id="modalKambarioId">
                    <input type="hidden" name="start_date" id="modalStartDate">
                    <input type="hidden" name="end_date" id="modalEndDate">

                    <div class="modal-header">
                        <h5 class="modal-title" id="reservationModalLabel">Užpildykite Rezervacijos Informaciją</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Pilnas Vardas</label>
                            <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Įveskite savo vardą" required>
                        </div>


                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Gimimo Data</label>
                            <input type="date" name="birthdate" id="birthdate" class="form-control" required>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" name="agree_tos" id="agree_tos" class="form-check-input" required>
                            <label class="form-check-label" for="agree_tos">Sutinku su taisyklėmis ir sąlygomis</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Atšaukti</button>
                        <button type="submit" class="btn btn-primary">Pateikti Mokėjimą</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h3>Jūsų Rezervacijos</h3>

        @if($userReservations->isEmpty())
            <p class="text">Neturite užbaigtų rezervacijų.</p>
        @else
            <table class="table table-bordered mt-3">
                <thead>
                <tr>
                    <th>Rezervacijos Numeris</th>
                    <th>Pradžios Data</th>
                    <th>Pabaigos Data</th>
                    <th>Bendra Kaina</th>
                    <th>Kambario Numeris</th>
                    <th>Rezervacijos Statusas</th>
                    <th>Veiksmai</th> <!-- Actions column -->
                </tr>
                </thead>
                <tbody>
                @foreach($userReservations as $reservation)
                    <tr>
                        <td>{{ $reservation->rezervacijos_id }}</td>
                        <td>{{ $reservation->pradzios_data }}</td>
                        <td>{{ $reservation->pabaigos_data }}</td>
                        <td>{{ number_format($reservation->bendra_kaina, 2) }} EUR</td>
                        <td>{{ $reservation->rezervuotu_kambariu_nr }}</td>
                        <td>Patvirtinta</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="{{ route('reservations.edit', $reservation->rezervacijos_id) }}"
                               class="btn btn-warning btn-sm">Redaguoti</a>

                            <!-- Delete Form -->
                            <form action="{{ route('reservations.destroy', $reservation->rezervacijos_id) }}"
                                  method="POST"
                                  style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Ar tikrai norite ištrinti šią rezervaciją?')">Ištrinti</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>



    <script>
        function openReservationModal(kambarioId, startDate, endDate) {
            document.getElementById('modalKambarioId').value = kambarioId;
            document.getElementById('modalStartDate').value = startDate;
            document.getElementById('modalEndDate').value = endDate;

            var reservationModal = new bootstrap.Modal(document.getElementById('reservationModal'));
            reservationModal.show();
        }

        document.getElementById('stripePaymentForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevents the default behavior
            this.submit(); // Submits the form as POST
        });

    </script>

@endsection

