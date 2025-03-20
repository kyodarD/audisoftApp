<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <style>
        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #BBBDC4;
            color: #4a5568;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .error-container {
            text-align: center;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #0A40DC;
            animation: pulse 1.5s ease-in-out infinite alternate;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #000;
        }

        a {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: #fff;
            font-size: 1.2rem;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.05);
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>@yield('code')</h1>
        <p>@yield('message')</p>
		<a href="{{ url('/home') }}">Ir a la página de inicio</a>
    </div>
</body>
</html>
