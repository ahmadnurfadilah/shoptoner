<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shoptoner | Empowering Seamless eCommerce in Telegram with Shoptoner</title>
    @vite('resources/css/app.css')
</head>

<body class="antialiased">
    <main class="min-h-screen">
        <div class="w-full aspect-[9/12] md:aspect-[7/3] bg-cover bg-center flex items-center" style="background-image: url('/assets/img/bg.webp')">
            <div class="absolute inset-0 bg-gradient-to-r from-white via-transparent to-white"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-white via-transparent to-white"></div>
            <div class="max-w-3xl mx-auto px-4 relative">
                <img src="/assets/img/shopping.webp" alt="Shopping" class="w-1/2 mx-auto mb-8" />
                <div class="text-center">
                    <h1 class="font-black text-2xl md:text-3xl lg:text-4xl mb-4">Empowering Seamless eCommerce in Telegram with <span class="text-nude">Shoptoner</span></h1>
                    <p class="text-gray-500">Shoptoner provides a no-code solution for building and managing stores within Telegram, enabling users to effortlessly create their eCommerce presence. Users can set up their store, manage products, and accept payments using TON coin, all seamlessly integrated into Telegram.</p>
                </div>
                <div class="flex items-center justify-center gap-4 mt-4">
                    <a href="https://app.shoptoner.xyz" class="flex items-center gap-2 px-5 py-2.5 bg-nude text-white rounded-full font-semibold shadow border border-black/10 hover:shadow-xl transition-all">Start Selling</a>
                    <a href="https://youtu.be/I9yti5SlSiI" target="_blank" class="flex items-center gap-2 px-5 py-2.5 bg-deepblue text-white rounded-full font-semibold shadow border border-black/10 hover:shadow-xl transition-all">Watch Video</a>
                </div>
            </div>
        </div>
        <div class="max-w-3xl mx-auto px-4 relative">
            <div class="grid grid-cols-1 md:grid-cols-3 mt-8 divide-x border">
                <div class="bg-white p-4 text-center flex flex-col items-center">
                    <div class="size-4 bg-nude font-bold text-xl mb-4">1</div>
                    <h2 class="font-bold">Sign Up and Set Up</h2>
                    <p class="text-sm text-gray-500">Register on Shoptoner, create your store, and add products</p>
                </div>
                <div class="bg-white p-4 text-center flex flex-col items-center">
                    <div class="size-4 bg-nude font-bold text-xl mb-4">2</div>
                    <h2 class="font-bold">Integrate with Telegram</h2>
                    <p class="text-sm text-gray-500">Connect your store to Telegram for seamless selling</p>
                </div>
                <div class="bg-white p-4 text-center flex flex-col items-center">
                    <div class="size-4 bg-nude font-bold text-xl mb-4">3</div>
                    <h2 class="font-bold">Start Selling</h2>
                    <p class="text-sm text-gray-500">Share your store link and manage orders easily</p>
                </div>
            </div>
        </div>
    </main>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    @vite('resources/js/app.js')
</body>

</html>
