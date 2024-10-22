<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Setup</title>
</head>
<body>
    <h1>Two-Factor Authentication Setup</h1>
    <p>Dear User,</p>
    <p>Your 2FA secret key is: <strong>{{ $secretKey }}</strong></p>
    <p>Scan the QR code below with your authentication app:</p>
    <!-- Render the SVG content directly -->
    {!! $inlineUrl !!}
    <p>Thank you!</p>
</body>
</html>