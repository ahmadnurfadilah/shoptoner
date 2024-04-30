<?php

namespace App\Livewire\Shop;

use App\Models\Payment\Payment;
use App\Models\Payment\PaymentItem;
use App\Models\Product\Product;
use App\Models\Product\ProductUser;
use App\Models\User;
use Darryldecode\Cart\Facades\CartFacade;
use Livewire\Component;

class ListProduct extends Component
{
    public $user;
    public $products;
    public $ownedProducts;
    public $carts;

    public function mount($store)
    {
        $this->products = Product::with('store')->where('store_id', $store->id)->published()->get();
    }

    public function initData($data)
    {
        $user = User::firstOrNew(['telegram_id' => $data['id']]);
        $user->first_name = $data['first_name'] ?? '?';
        $user->last_name = $data['last_name'] ?? null;
        $user->username = $data['username'] ?? null;
        $user->save();

        $this->user = $user;
        // $this->carts = CartFacade::session($user->id)->getContent();
        $this->ownedProducts = ProductUser::where('user_id', $user->id)->get();
    }

    public function initPay($trxId, $selectedProductId)
    {
        $product = Product::findOrFail($selectedProductId);
        $pay = Payment::create([
            'trx_id' => $trxId,
            'user_id' => $this->user->id,
            'amount' => $product->price,
            'total_amount' => $product->price,
            'due_at' => now()->addDay(),
        ]);

        PaymentItem::create([
            'payment_id' => $pay->id,
            'payable_type' => 'product',
            'payable_id' => $product->id,
            'user_id' => $this->user->id,
            'price' => $product->price,
        ]);
    }

    public function setBoc($trxId, $boc)
    {
        $pay = Payment::where('trx_id', $trxId)->firstOrFail();
        $pay->boc = $boc;
        $pay->save();
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
