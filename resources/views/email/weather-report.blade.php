<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            color: #555;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Hello, {{ $subscriber->email }}!</p>
        <p>The current weather in {{ $data['location']['name'] }}, {{ $data['location']['country'] }} is
            @foreach ($data['current']['weather_descriptions'] as $desc)
                <span> {{ $desc }}</span>
            @endforeach
            with:
        </p>

        <ul>
            <li>temperature: {{ $data['current']['temperature'] }}&deg;C</li>
            <li>wind speed: {{ $data['current']['wind_speed'] }} km/h</li>
            <li>precipitation: {{ $data['current']['precip'] }} mm</li>
        </ul>

        <p>
            @foreach ($data['current']['weather_icons'] as $icon)
                <img src="{{ $icon }}" alt="todo"></img>
            @endforeach
        </p>

        <p>If you wish to unsubscribe click this link <a href="{{ route('unsubscribe') }}?email={{ $subscriber->email }}">{{ route('unsubscribe') }}?email={{ $subscriber->email }}</a></p>
        <p>Best Regards,</p>
        <p><strong>{{ config('app.name') }}</strong></p>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
