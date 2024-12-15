@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administratoriaus pokalbiai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        .chat-container {
            width: 80%;
            max-width: 900px;
            margin: 50px auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
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

        .chat-section {
            margin-top: 30px;
        }

        .chat-section h3 {
            font-size: 20px;
            color: #333;
        }

        .chat-list {
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }

        .chat-item {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
            cursor: pointer;
            align-items: center; /* Ensure vertical centering */
        }

        .chat-item .client-name {
            text-align: left;
            width: 150px; 
        }

        .chat-item .chat-status {
            text-align: center; /* Ensure the status is centered */
            width: 100px; /* Set a fixed width for status to prevent shifting */
            margin: 0 auto; /* Center the status in the available space */
        }

        .chat-item .chat-status {
            color: #007BFF;
        }

        .chat-item .join-button {
            background-color: #007BFF;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
        }

        .chat-item .join-button:hover {
            background-color: #0056b3;
        }

        .finished-chat-item {
            color: #888;
        }

        .view-button {
            background-color: #28a745;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
        }

        .view-button:hover {
            background-color: #218838;
        }

        .chat-box-container {
            width: 80%;
            max-width: 900px;
            margin: 50px auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            padding: 20px;
            display: none;
        }

        .chat-box-header {
            background-color: #007BFF;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .chat-window {
            padding: 20px;
            max-height: 300px;
            overflow-y: auto;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }

        .message {
            display: flex;
            margin-bottom: 15px;
        }

        .message.support {
            justify-content: flex-end;
        }

        .message.client {
            justify-content: flex-start;
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
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h2>Pokalbiai su klientais</h2>
        </div>
        
        <!-- Active Chats Section -->
        <div class="chat-section">
            <h3>Aktyvūs pokalbiai</h3>
            <ul class="chat-list">
                <li class="chat-item" onclick="openChat('Jonas Petraitis')">
                    <span class="client-name">Jonas Petraitis </span>
                    <span class="chat-status"> Aktyvus</span>
                    <button class="join-button">Prisijungti</button>
                </li>
                <li class="chat-item" onclick="openChat('Rūta Žukauskaitė')">
                    <span class="client-name">Rūta Žukauskaitė</span>
                    <span class="chat-status">Aktyvus</span>
                    <button class="join-button">Prisijungti</button>
                </li>
                <li class="chat-item" onclick="openChat('Petras Kalniukas')">
                    <span class="client-name">Petras Kalniukas</span>
                    <span class="chat-status">Aktyvus</span>
                    <button class="join-button">Prisijungti</button>
                </li>
            </ul>
        </div>

        <!-- Finished Chats Section -->
        <div class="chat-section">
            <h3>Užbaigti pokalbiai</h3>
            <ul class="chat-list">
                <li class="chat-item finished-chat-item">
                    <span class="client-name">Dainius Tamošaitis</span>
                    <span class="chat-status">Baigtas</span>
                    <button class="view-button" onclick="viewChat('Dainius Tamošaitis')">Peržiūrėti</button>
                </li>
                <li class="chat-item finished-chat-item">
                    <span class="client-name">Eglė Jonaitė   </span>
                    <span class="chat-status">Baigtas</span>
                    <button class="view-button" onclick="viewChat('Eglė Jonaitė')">Peržiūrėti</button>
                </li>
                <li class="chat-item finished-chat-item">
                    <span class="client-name">Marius Girdvainis</span>
                    <span class="chat-status">Baigtas</span>
                    <button class="view-button" onclick="viewChat('Marius Girdvainis')">Peržiūrėti</button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Chat Box (Active) -->
    <div id="chat-box" class="chat-box-container">
        <div class="chat-box-header">
            <h2>Pokalbis su <span id="chat-client-name"></span></h2>
        </div>

        <div id="chat-window" class="chat-window">
            <!-- Dynamic messages will appear here -->
        </div>

        <div id="chat-input-container" class="chat-input-container">
            <input type="text" placeholder="Įrašykite žinutę..." id="chat-input">
            <button id="send-button" onclick="sendMessage()">Siųsti</button>
        </div>
    </div>

    <script>
        function openChat(clientName) {
            document.getElementById('chat-client-name').innerText = clientName;
            document.getElementById('chat-box').style.display = 'block';
            document.getElementById('send-button').style.display = 'inline-block'; // Show send button
            document.getElementById('chat-input-container').style.display = 'flex'; // Show input field
            
            // Clear previous chat messages
            document.getElementById('chat-window').innerHTML = `
                <div class="message support">
                    <div class="message-bubble">Sveiki, kaip galiu jums padėti?</div>
                </div>
                <div class="message client">
                    <div class="message-bubble">Sveiki, turiu klausimą apie rezervaciją.</div>
                </div>
            `;
        }

        function viewChat(clientName) {
            document.getElementById('chat-client-name').innerText = clientName;
            document.getElementById('chat-box').style.display = 'block';
            document.getElementById('send-button').style.display = 'none'; // Hide send button
            document.getElementById('chat-input-container').style.display = 'none'; // Hide input field

            // Display finished chat messages
            document.getElementById('chat-window').innerHTML = `
                <div class="message support">
                    <div class="message-bubble">Atsiprašome už laukimą. Kuo galime jums padėti?</div>
                </div>
                <div class="message client">
                    <div class="message-bubble">Aš noriu pakeisti savo rezervaciją.</div>
                </div>
                <div class="message support">
                    <div class="message-bubble">Atsiprašome už nepatogumus. Pakeitimas buvo atliktas.</div>
                </div>
                <div class="message client">
                    <div class="message-bubble">Dėkoju už pagalbą!</div>
                </div>
            `;
        }

        function sendMessage() {
            var messageInput = document.getElementById('chat-input').value;
            if (messageInput.trim() === '') return;

            var messageBubble = document.createElement('div');
            messageBubble.classList.add('message', 'client');
            messageBubble.innerHTML = `
                <div class="message-bubble">${messageInput}</div>
            `;
            document.getElementById('chat-window').appendChild(messageBubble);
            document.getElementById('chat-input').value = ''; // Clear input
        }
    </script>
</body>
@endsection
