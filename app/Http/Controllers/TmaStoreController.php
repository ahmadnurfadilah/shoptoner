<?php

namespace App\Http\Controllers;

use App\Models\Product\Product;
use App\Models\Store\Store;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;

class TmaStoreController extends Controller
{
    public function index(Store $store)
    {
        return view('tma.store.index', compact('store'));
    }
}
