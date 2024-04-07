<?php

namespace App\Livewire\Shop;

use App\Models\Product\Product;
use App\Models\User;
use Darryldecode\Cart\Facades\CartFacade;
use Livewire\Component;

class ListProduct extends Component
{
    public $user;
    public $products;
    public $carts;

    public function mount($store)
    {
        $this->products = Product::where('store_id', $store->id)->published()->get();
    }

    public function initData($data)
    {
        $user = User::firstOrNew(['telegram_id' => $data['id']]);
        $user->first_name = $data['first_name'] ?? '?';
        $user->last_name = $data['last_name'] ?? null;
        $user->username = $data['username'] ?? null;
        $user->save();

        $this->user = $user;
        $this->carts = CartFacade::session($user->id)->getContent();
    }

    public function addToCart($productId) {
        $product = Product::findOrFail($productId);
        CartFacade::session($this->user->id);
        CartFacade::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => [],
            'associatedModel' => $product
        ]);
    }

    public function render()
    {
        return view('livewire.shop.list-product');
    }
}
