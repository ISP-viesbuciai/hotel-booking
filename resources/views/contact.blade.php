@extends('layouts.app')

@section('content')
    <div class="container">
        <div id="faq-chat" class="chat-container">
            <div class="chat-header">
                <h2>Dažniausiai Užduodami Klausimai (Spauskite ant klausimo) </h2>
            </div>

            <!-- Admin's FAQ messages -->
            <div class="chat-window">
                @foreach($faqs as $index => $faq)
                    <div class="message support" data-question="{{ $faq->question }}" data-answer="{{ $faq->answer }}">
                        <div class="message-bubble">
                            <strong>{{ $index + 1 }}. {{ $faq->question }}</strong>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="faq-message mt-5">
            <h3>Neradote atsakymo į norimą klausimą? Susisiekite su darbuotoju.</h3>
            <a href="{{ url('/chat') }}" class="btn btn-primary mt-2">Pradėti pokalbį su darbuotoju</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const faqItems = document.querySelectorAll('.message.support');

            faqItems.forEach(item => {
                item.addEventListener('click', () => {
                    const question = item.dataset.question;
                    const answer = item.dataset.answer;

                    // Add to chat window
                    const chatWindow = document.querySelector('.chat-window');

                    // User question
                    const userMessage = document.createElement('div');
                    userMessage.classList.add('message', 'support');
                    userMessage.innerHTML = `<div class="message-bubble">${question}</div>`;
                    chatWindow.appendChild(userMessage);

                    // Admin response
                    const adminMessage = document.createElement('div');
                    adminMessage.classList.add('message', 'client');
                    adminMessage.innerHTML = `<div class="message-bubble">${answer}</div>`;
                    chatWindow.appendChild(adminMessage);

                    chatWindow.scrollTop = chatWindow.scrollHeight;

                    // Save to the database
                    fetch('{{ route('faq.chat') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ question, answer }),
                    }).then(response => {
                        if (!response.ok) {
                            console.error('Failed to save chat messages.');
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        });
    </script>
@endsection

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

        .faq-message {
            text-align: center;
        }

        .faq-message h3 {
            margin-top: 30px;
        }

        .btn-primary {
            background-color: #007BFF;
            border: none;
            padding: 10px 15px;
            border-radius: 25px;
            color: white;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
@endsection
