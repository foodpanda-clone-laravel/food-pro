<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hi {{ $name }}</title>
    <style>
        body {
            background-color: #e8f5e9; /* Light green background */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff; /* White content block */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        h1 {
            color: #2e7d32; /* Dark green for heading */
            text-align: center;
        }
        p {
            color: #4e4e4e; /* Dark gray for text */
            line-height: 1.6;
        }
        strong {
            color: #2e7d32; /* Dark green for highlighted text */
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #555;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hi {{ $name }}, Your Request Has Been Received!</h1>
        <p>Your request has been received. You will get a response within <strong>24 hours</strong>.</p>
        <p>Thank you for reaching out to us!</p>
        <div class="footer">
            <p>Best regards,</p>
            <p><strong>The Support Team</strong></p>
        </div>
    </div>
</body>
</html>
