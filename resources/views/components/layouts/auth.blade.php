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
    <body class="bg-gradient-to-r from-slate-800 via-slate-700 to-slate-800 h-full p-12 text-white" x-data="auth({ csrfToken: '{{ csrf_token() }}' })">
        {{ $main_wrapper }}

        <script>
            const auth = (e) => ({
                async logout() {
                    const response = await fetch(route('post.logout'), {
                        method: 'post',
                        body: null,
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        }
                    })
                    const json = await response.json();
                    return location.reload();
                },
                ...e
            })
        </script>
    </body>
</html>