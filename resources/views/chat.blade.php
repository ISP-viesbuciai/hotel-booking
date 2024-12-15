@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Support</title>
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
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h2>Pokalbis su darbuotoju</h2>
        </div>
        
        <div class="chat-window">
            <!-- Support and Client messages -->
            <div class="message support">
                <div class="message-bubble">
                    Sveiki! Kuo galiu jums padėti?
                </div>
            </div>
            <div class="message client">
                <div class="message-bubble">
                    Laba diena, turiu klausimą apie rezervaciją.
                </div>
            </div>
            <div class="message support">
                <div class="message-bubble">
                    Žinoma, ko norėtumėte paklausti?
                </div>
            </div>
            <div class="message client">
                <div class="message-bubble">
                    Aš norėčiau pakeisti savo rezervacijos datą.
                </div>
            </div>
        </div>

        <div class="chat-input-container">
            <input type="text" placeholder="Rašykite savo žinutę..." id="chat-input">
            <button id="send-button">Siųsti</button>
        </div>
    </div>

    <script>
        // Simple script to add new messages to the chat window
        document.getElementById("send-button").addEventListener("click", function() {
            var messageInput = document.getElementById("chat-input");
            var messageText = messageInput.value.trim();
            if (messageText !== "") {
                // Create new client message
                var chatWindow = document.querySelector(".chat-window");
                var newMessage = document.createElement("div");
                newMessage.classList.add("message", "client");
                var messageBubble = document.createElement("div");
                messageBubble.classList.add("message-bubble");
                messageBubble.textContent = messageText;
                newMessage.appendChild(messageBubble);
                chatWindow.appendChild(newMessage);

                // Clear input field
                messageInput.value = "";
                chatWindow.scrollTop = chatWindow.scrollHeight; // Scroll to the bottom
            }
        });

        // Allow pressing "Enter" to send a message
        document.getElementById("chat-input").addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                document.getElementById("send-button").click();
            }
        });
    </script>
</body>
@endsection
