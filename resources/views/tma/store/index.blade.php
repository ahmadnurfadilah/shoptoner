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
    <main class="px-4 pb-4 flex flex-col min-h-screen items-center justify-center">
        <div id="welcome" class="w-full flex items-center justify-center">
            <img src="/assets/img/shopping.webp" alt="Shopping" class="w-2/3 mx-auto" />
            <h1 class="text-center font-bold text-2xl mt-4 mb-8" style="color: var(--tg-theme-text-color)">Connect your wallet<br/>to start shopping</h1>
        </div>
        <div class="shrink-0 flex items-center justify-center w-full">
            <a href="#" id="connect"></a>
        </div>
        <div id="list" class="w-full h-full flex-1 mt-4">
            @livewire('shop.list-product', ['store' => $store])
        </div>
    </main>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <script src="https://unpkg.com/@tonconnect/ui@latest/dist/tonconnect-ui.min.js"></script>
    @livewireScripts
    @stack('scripts')
    <script>
        document.getElementById("welcome").style.display = 'block';
        document.getElementById("list").style.display = 'none';

        const tonConnectUI = new TON_CONNECT_UI.TonConnectUI({
            manifestUrl: 'https://shoptoner.xyz/tonconnect-manifest.json',
            buttonRootId: 'connect'
        });

        tonConnectUI.onStatusChange(
            walletAndwalletInfo => {
                if (walletAndwalletInfo) {
                    document.getElementById("welcome").style.display = 'none';
                    document.getElementById("list").style.display = 'block';
                } else {
                    document.getElementById("welcome").style.display = 'block';
                    document.getElementById("list").style.display = 'none';
                }
            }
        );
    </script>
</body>

</html>
