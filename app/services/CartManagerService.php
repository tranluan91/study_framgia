<?php

namespace Services;

trait CartManagerService
{

    use \Libs\Utility\ModelManagerService;

    public function addCart($product_id)
    {
        $auth = $this->session->get('auth-identity');
        if ($auth) {
            $this->initModel('Carts');
            $this->initModel('Products');
            $product = $this->Products->findFirst($product_id)->toArray();
            if ($product) {
                $product = array_merge(
                    $product,
                    ['created' => date('Y-m-d H:i:s')]
                );
                $this->Carts->create($auth['id'], json_encode($product));
                return true;
            }
        }
        return false;
    }

    public function getProductInCart()
    {
        $auth = $this->session->get('auth-identity');
        $this->initModel('Carts');
        $carts = $this->Carts->get($auth['id']);
        $products = $this->getDataFromCart($carts);
        return $products;
    }

    public function getDataFromCart($carts)
    {
        $products = [];
        if ($carts) {
            foreach($carts as $key => $cart) {
                $product = json_decode($cart, true);
                $auth = $this->session->get('auth-identity');
                $products[$key] = [
                    'user_id' => $auth['id'],
                    'item_id' => $product['id'],
                    'name'    => $product['name'],
                    'price'   => $product['price'],
                    'created' => $product['created']
                ];
            }
            return $products;
        }
        return null;
    }

    public function removeItemOfCart($index)
    {
        $auth = $this->session->get('auth-identity');
        if ($auth) {
            $this->initModel('Carts');
            $carts = $this->Carts->get($auth['id']);
            if ($carts && array_key_exists($index, $carts)) {
                $this->Carts->remove($auth['id'], $index);
                return true;
            }
        }
        return false;
    }
}