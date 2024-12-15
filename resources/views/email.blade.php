@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Parašykite mums laišką</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('send-email') }}" method="POST">
            @csrf
            <!-- Sender Email -->
            <div class="form-group">
                <label for="siuntejo_el_pastas">Jūsų el. pašto adresas</label>
                <input type="email" name="siuntejo_el_pastas" id="siuntejo_el_pastas" class="form-control" placeholder="Enter your email" required>
            </div>

            <!-- Theme -->
            <div class="form-group">
                <label for="tema">Tema</label>
                <input type="text" name="tema" id="tema" class="form-control" placeholder="Enter the subject" required>
            </div>

            <!-- Message -->
            <div class="form-group">
                <label for="tekstas">Žinutė</label>
                <textarea name="tekstas" id="tekstas" class="form-control" rows="5" placeholder="Write your message here" required></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-3">Siųsti</button>
        </form>
    </div>
@endsection
