<!DOCTYPE html>
<html lang="en" class="h-screen">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Card Pilot - Dashboard</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @routes
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-r from-[#E6E6E6] via-pink-100 to-[#E6E6E6] h-full p-12 text-slate-800">
        {{ $main_wrapper }}
    </body>
</html>