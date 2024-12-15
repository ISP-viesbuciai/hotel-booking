@extends('layouts.app')

@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        .chat-container {
            width: 80%;
            max-width: 800px;
            margin: 50px auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .chat-header {
            background-color: #007BFF;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .chat-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .chat-window {
            padding: 20px;
            max-height: 500px;
            overflow-y: auto;
            background-color: #f9f9f9;
        }

        .message {
            display: flex;
            margin-bottom: 15px;
        }

        .message.support {
            justify-content: flex-start;
        }

        .message.client {
            justify-content: flex-end;
        }

        .message .message-bubble {
            max-width: 60%;
            padding: 10px;
            border-radius: 15px;
            font-size: 14px;
        }

        .message.support .message-bubble {
            background-color: #e1f5fe;
            color: #007BFF;
        }

        .message.client .message-bubble {
            background-color: #dcedc8;
            color: #388e3c;
        }

        .chat-input-container {
            padding: 15px;
            background-color: #f1f1f1;
            border-radius: 0 0 8px 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-input-container input {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 25px;
            font-size: 14px;
        }

        .chat-input-container button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
        }

        .chat-input-container button:hover {
            background-color: #0056b3;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="chat-container">
            <div class="chat-header">
                <h2>Pokalbis su klientu (ID: {{ $pokalbis->id }})</h2>
            </div>
            
            <div class="chat-window" id="chat-window">
                @foreach ($zinutes as $zinute)
                    <div class="message {{ $zinute->siuntejo_id == Auth::id() ? 'client' : 'support' }}">
                        <div class="message-bubble">
                            {{ $zinute->tekstas }}
                        </div>
                    </div>
                @endforeach
            </div>

            <form id="chat-form" method="POST" action="{{ route('chat.message') }}">
                @csrf
                <input type="hidden" name="pokalbio_id" value="{{ $pokalbis->id }}">
                <div class="chat-input-container">
                    <input type="text" name="message" placeholder="Rašykite savo žinutę..." id="chat-input" required>
                    <button type="submit">Siųsti</button>
                </div>
            </form>
        </div>
    </div>
@endsection
