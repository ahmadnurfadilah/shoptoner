<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $store->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>

<body class="antialiased" style="background: var(--tg-theme-bg-color)">
    <main class="p-4">
        @livewire('shop.list-product', ['store' => $store])
    </main>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
