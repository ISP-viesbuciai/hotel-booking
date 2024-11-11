<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .card-list {
            list-style-type: none;
            padding: 0;
        }
        .card-item {
            background-color: #ffffff;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .edit-button {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <div class="profile-header">
        <h2>John Doe's Profile</h2>
        <p>Email: johndoe@example.com</p>
    </div>

    <!-- User Information Section -->
    <div class="user-info">
        <h5>Personal Information</h5>
        <p><strong>Name:</strong> John Doe</p>
        <p><strong>Email:</strong> johndoe@example.com</p>
        <a href="{{ route('profile.edit') }}" class="btn btn-primary edit-button">Edit Profile</a>
    </div>

    <!-- Bank Cards Section -->
    <div class="bank-cards mt-4">
        <h5>Your Bank Cards</h5>
        <ul class="card-list">
            <li class="card-item">
                <p><strong>Card Number:</strong> **** **** **** 1234</p>
                <p><strong>Expiry:</strong> 12/25</p>
            </li>
            <li class="card-item">
                <p><strong>Card Number:</strong> **** **** **** 5678</p>
                <p><strong>Expiry:</strong> 03/27</p>
            </li>
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
