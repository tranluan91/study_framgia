<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public $auth;

    public function initialize()
    {
        if ($this->session->has('auth-identity')) {
            $auth = $this->session->get('auth-identity');
            $this->view->auth = $auth;
            $this->initModel('Carts');
            $cartItemCount = $this->Carts->count($auth['id']);
            $cartItemCount = ($cartItemCount > 0) ? $cartItemCount : 0;
            $this->view->cartItemCount = $cartItemCount;
        }
    }
}
