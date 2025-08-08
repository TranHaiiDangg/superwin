<?php

namespace App\Http\ViewComposers;

use App\Services\CartService;
use Illuminate\View\View;

class CartComposer
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $cartData = $this->cartService->getCartData();

        $view->with([
            'globalCartCount' => $cartData['count'],
            'globalCartTotal' => $cartData['total'],
            'globalCartItems' => $cartData['items']
        ]);
    }
}
