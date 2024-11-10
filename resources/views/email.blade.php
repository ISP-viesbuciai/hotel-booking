@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Parašykite mums laišką</h1>

        <!-- Email Input -->
        <div class="form-group">
            <label for="email">Jūsų el. pašto adresas</label>
            <input type="email" id="email" class="form-control" placeholder="Enter your email" >
        </div>

        <!-- Theme (Subject) Input -->
        <div class="form-group">
            <label for="theme">Tema</label>
            <input type="text" id="theme" class="form-control" placeholder="Enter the subject" >
        </div>

        <!-- Email Text Input -->
        <div class="form-group">
            <label for="message">Žinutė</label>
            <textarea id="message" class="form-control" rows="5" placeholder="Write your message here" ></textarea>
        </div>

        <!-- Submit Button -->
        <button class="btn btn-primary mt-3">Siųsti</button>
    </div>
@endsection
