<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ $restaurantName }}</title>
    <style>
        body {
            background-color: #e0f7e0; /* Light green background */
            color: #2e7d32; /* Dark green text */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #2e7d32; /* Dark green heading */
        }
        p {
            color: #2e7d32; /* Dark green for paragraph text */
        }
        strong {
            color: #4caf50; /* Medium green for important highlights */
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff; /* White content block */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #4caf50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hello {{ $firstName }}!</h1>
        <p>Welcome to <strong>{{ $restaurantName }}</strong>!</p>
        <p>Your login credentials are as follows:</p>
        <ul>
            <li><strong>Email:</strong> {{ $email }}</li>
            <li><strong>Temporary Password:</strong> {{ $temporaryPassword }}</li>
        </ul>
        <p>Please log in using these credentials and change your password immediately for security reasons.</p>
        <div class="footer">
            <p>Thank you for joining us!</p>
            <p><strong>The {{ $restaurantName }} Team</strong></p>
        </div>
    </div>
</body>
</html>
