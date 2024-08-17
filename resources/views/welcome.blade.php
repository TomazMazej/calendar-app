<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar App</title>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
</head>
<body>
    <div class="container">
        <h1>Welcome to Calendar App!</h1>
        <p>Please sign in using your Google account.</p>
        <a href="{{ route('google.redirect') }}" class="refresh-button">Sign in with Google</a>
    </div>
</body>
</html>