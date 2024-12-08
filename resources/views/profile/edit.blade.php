@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Profile</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name', $user->name) }}" required autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email', $user->email) }}" required>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">
            Update Profile
        </button>
    </form>

    <h2 class="mt-5">Payment Information</h2>
    
    @foreach ($user->rezervacijos as $rezervacija)
        @foreach ($rezervacija->mokejimas->paymentInformation as $paymentInfo)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Card Number</th>
                        <th>Card Holder</th>
                        <th>Expiration Date</th>
                        <th>CVV</th>
                        <th>Billing Address</th>
                        <th>Payment ID</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $paymentInfo->MokejimoInformacijos_id }}</td>
                        <td>{{ $paymentInfo->Korteles_nr }}</td>
                        <td>{{ $paymentInfo->Korteles_savininkas }}</td>
                        <td>{{ $paymentInfo->Galiojimo_data }}</td>
                        <td>{{ $paymentInfo->CVV }}</td>
                        <td>{{ $paymentInfo->Atsiskaitymo_adresas }}</td>
                        <td>{{ $paymentInfo->fk_Mokejimas }}</td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    @endforeach

    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCardModal">Add New Card</button>

    <!-- Add Card Modal -->
    <div class="modal fade" id="addCardModal" tabindex="-1" aria-labelledby="addCardModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCardModalLabel">Add New Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('profile.addCard') }}">
                        @csrf
                        <div class="form-group">
                            <label for="Korteles_nr">Card Number</label>
                            <input id="Korteles_nr" type="text" class="form-control" name="Korteles_nr" required>
                        </div>
                        <div class="form-group">
                            <label for="Korteles_savininkas">Card Holder</label>
                            <input id="Korteles_savininkas" type="text" class="form-control" name="Korteles_savininkas"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="Galiojimo_data">Expiration Date</label>
                            <input id="Galiojimo_data" type="date" class="form-control" name="Galiojimo_data" required>
                        </div>
                        <div class="form-group">
                            <label for="CVV">CVV</label>
                            <input id="CVV" type="text" class="form-control" name="CVV" required>
                        </div>
                        <div class="form-group">
                            <label for="Atsiskaitymo_adresas">Billing Address</label>
                            <input id="Atsiskaitymo_adresas" type="text" class="form-control"
                                name="Atsiskaitymo_adresas" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Card</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection