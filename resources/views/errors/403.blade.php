<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('403 - Forbidden') }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #121212; /* Warna hitam */
            color: #ff4c4c; /* Warna merah terang */
        }

        .container {
            text-align: center;
            max-width: 600px;
        }

        .error-code {
            font-size: 10rem;
            font-weight: bold;
            margin: 0;
            color: #ff4c4c;
        }

        .error-message {
            font-size: 2rem;
            margin: 20px 0;
            color: #ffffff;
        }

        .error-description {
            font-size: 1rem;
            margin-bottom: 30px;
            color: #b0b0b0; /* Abu-abu terang */
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #ff4c4c; /* Warna merah */
            color: #ffffff; /* Warna teks putih */
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #d32f2f; /* Merah lebih gelap */
            transform: translateY(-3px); /* Animasi hover */
        }

        .icon {
            font-size: 6rem;
            margin-bottom: 20px;
            color: #ff4c4c;
        }

        footer {
            position: absolute;
            bottom: 10px;
            text-align: center;
            width: 100%;
            color: #b0b0b0;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">⛔</div>
        <h1 class="error-code">403</h1>
        <p class="error-message">{{ __('Forbidden') }}</p>
        <p class="error-description">{{ __('You do not have permission to access this page.') }}</p>
        <a href="{{ url('/') }}" class="btn">{{ __('Return to Home') }}</a>
    </div>
    <footer>
        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. {{ __('All Rights Reserved.') }}
    </footer>
</body>
</html>
