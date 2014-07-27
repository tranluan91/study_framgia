<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    /**
     * @var session cart
     */
    public $cart = null;

    public function initialize()
    {
        if ($this->session->has('cart')) {
            $cart = $this->session->get('cart');
            $cartItemCount = count($cart);
        }
        $this->view->cart = $cart;

        $cartItemCount = ($cartItemCount && $cartItemCount > 0) ? $cartItemCount : 0;
        $this->view->cartItemCount = $cartItemCount;
    }
}
