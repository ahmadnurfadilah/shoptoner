<div x-data>
    <div class="grid grid-cols-3 gap-4">
        @foreach ($products as $product)
            <div x-on:click="$store.shopping.showProduct({{ $product }}, {{ $product->store }});">
                <div class="relative">
                    <img src="{{ config('app.cdn_url') }}/{{ $product->thumbnail }}" alt={{ $product->name }} class="w-full aspect-square object-cover object-center rounded-lg" />
                    <p class="absolute bottom-1 right-1 pl-2 pr-1 py-1 font-medium rounded-full bg-black/75 text-xs flex items-center gap-1" style="color: var(--tg-theme-text-color)">
                        {{ $product->price }}
                        <svg width="14" height="14" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M28 56C43.464 56 56 43.464 56 28C56 12.536 43.464 0 28 0C12.536 0 0 12.536 0 28C0 43.464 12.536 56 28 56Z" fill="#0098EA"/>
                            <path d="M37.5603 15.6277H18.4386C14.9228 15.6277 12.6944 19.4202 14.4632 22.4861L26.2644 42.9409C27.0345 44.2765 28.9644 44.2765 29.7345 42.9409L41.5381 22.4861C43.3045 19.4251 41.0761 15.6277 37.5627 15.6277H37.5603ZM26.2548 36.8068L23.6847 31.8327L17.4833 20.7414C17.0742 20.0315 17.5795 19.1218 18.4362 19.1218H26.2524V36.8092L26.2548 36.8068ZM38.5108 20.739L32.3118 31.8351L29.7417 36.8068V19.1194H37.5579C38.4146 19.1194 38.9199 20.0291 38.5108 20.739Z" fill="white"/>
                        </svg>
                    </p>
                </div>
                <p class="text-sm font-medium mt-1 line-clamp-1" style="color: var(--tg-theme-text-color)">
                    {{ $product->name }}
                </p>
            </div>
        @endforeach
    </div>

    {{-- Bottom Sheet --}}
    <div class="fixed z-50 inset-0 bg-black/80" x-show="$store.shopping.showSheet"
        x-on:click="$store.shopping.toggleSheet()" x-transition:enter="transition ease-out duration-100 delay-100"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"></div>
    <div class="fixed z-50 bottom-0 inset-x-0 h-[90%] rounded-t-2xl p-4"
        style="background: var(--tg-theme-bg-color); color: var(--tg-theme-text-color)"
        x-transition:enter="transition ease-out duration-300 delay-100"
        x-transition:enter-start="opacity-0 translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-full" x-show="$store.shopping.showSheet">
        <button class="absolute -top-8 right-4 w-6 h-6 rounded-full flex items-center justify-center" style="background: var(--tg-theme-destructive-text-color)" x-on:click="$store.shopping.toggleSheet()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Gallery --}}
        <div class="w-full h-1/2 flex items-center gap-3 relative mb-3 p-3 rounded-lg" style="background: var(--tg-theme-header-bg-color)">
            <div class="flex-1 h-full">
                <img x-bind:src="`{{ config('app.cdn_url') }}/${$store.shopping.currentGallery}`" alt="Gallery" class="h-full w-full object-cover object-center rounded-lg" />
            </div>
            <div class="w-1/5 h-full overflow-y-auto">
                <template x-for="gallery in $store.shopping.selectedProduct.gallery">
                    <button x-on:click="$store.shopping.currentGallery = gallery" class="mb-2">
                        <img x-bind:src="`{{ config('app.cdn_url') }}/${gallery}`" alt="Gallery"
                            class="w-full aspect-[5/4] object-cover object-center rounded-lg transition-all"
                            :class="{ 'border-2 border-white': $store.shopping.currentGallery === gallery }" />
                    </button>
                </template>
            </div>
        </div>

        {{-- Title --}}
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-medium text-lg mb-2 flex-1" x-html="$store.shopping.selectedProduct.name"></h2>
            <div class="pl-2 pr-1 py-1 font-medium rounded-full bg-black/75 text-xs flex items-center gap-1" style="color: var(--tg-theme-text-color)">
                <p x-html="$store.shopping.selectedProduct.price"></p>
                <svg width="14" height="14" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M28 56C43.464 56 56 43.464 56 28C56 12.536 43.464 0 28 0C12.536 0 0 12.536 0 28C0 43.464 12.536 56 28 56Z" fill="#0098EA"/>
                    <path d="M37.5603 15.6277H18.4386C14.9228 15.6277 12.6944 19.4202 14.4632 22.4861L26.2644 42.9409C27.0345 44.2765 28.9644 44.2765 29.7345 42.9409L41.5381 22.4861C43.3045 19.4251 41.0761 15.6277 37.5627 15.6277H37.5603ZM26.2548 36.8068L23.6847 31.8327L17.4833 20.7414C17.0742 20.0315 17.5795 19.1218 18.4362 19.1218H26.2524V36.8092L26.2548 36.8068ZM38.5108 20.739L32.3118 31.8351L29.7417 36.8068V19.1194H37.5579C38.4146 19.1194 38.9199 20.0291 38.5108 20.739Z" fill="white"/>
                </svg>
            </div>
        </div>

        <h4 class="font-medium text-sm">Description</h4>
        <p class="text-sm opacity-80" x-html="$store.shopping.selectedProduct.description"></p>
    </div>

    {{-- Cart --}}
    {{-- <div class="fixed bottom-4 right-4" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-full" x-show="!$store.shopping.showSheet">
        <div class="bg-red-500 absolute rounded-full -top-1 -right-1 size-5 flex items-center justify-center text-xs font-bold" style="background: var(--tg-theme-destructive-text-color); color: var(--tg-theme-button-text-color)">
            {{ Cart::session($user->id ?? 'empty')->getTotalQuantity() }}
        </div>
        <button class="size-12 rounded-full shadow-xl flex items-center justify-center"
            style="background: var(--tg-theme-button-color); color: var(--tg-theme-button-text-color)">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
            </svg>
        </button>
    </div> --}}
</div>

@script
    <script>
        Alpine.store('shopping', {
            showSheet: false,
            selectedProduct: '',
            selectedStore: '',
            currentGallery: '',
            user: {},
            init() {
                // get user data
                const initData = window.Telegram.WebApp.initData;
                const urlParams = new URLSearchParams(initData);
                this.user = JSON.parse(urlParams.get('user'));
                $wire.initData(this.user);

                // handle onClick mainButton
                const mainButton = window.Telegram.WebApp.MainButton;
                mainButton.onClick(async () => {
                    if (mainButton.text === 'Buy now') {
                        const trxId = Math.floor(Math.random() * 999999999999999);

                        $wire.initPay(trxId, this.selectedProduct.id);

                        const body = beginCell()
                            .storeUint(0, 32)
                            .storeStringTail("INVOICE:" + trxId)
                            .endCell();

                        const transaction = {
                            validUntil: Math.floor(Date.now() / 1000) + 60,
                            messages: [
                                {
                                    address: this.selectedStore.wallet_address,
                                    // address: "UQD43HTgmvEcHzcCa2svarWPikzb74d5AKPhf1h2PhFfEJdx",
                                    amount: (parseFloat(this.selectedProduct.price) * 10**9),
                                    payload: body.toBoc().toString("base64"),
                                },
                            ]
                        }

                        try {
                            const result = await tonConnectUI.sendTransaction(transaction);
                            $wire.setBoc(trxId, result.boc);
                        } catch (e) {
                            alert("Error occured");
                        }

                        // $wire.addToCart(this.selectedProduct.id);
                        this.showSheet = false;
                        mainButton.hide();
                    }
                });
            },
            toggleSheet() {
                this.showSheet = !this.showSheet
                if (!this.showSheet) {
                    window.Telegram.WebApp.MainButton.isVisible = false;
                }
            },
            showProduct(product, store) {
                this.showSheet = true;
                this.selectedProduct = product;
                this.selectedStore = store;
                this.currentGallery = product.thumbnail;
                setTimeout(() => {
                    window.Telegram.WebApp.MainButton.show().setText('Buy now');
                }, 100);
            }
        });
    </script>
@endscript
