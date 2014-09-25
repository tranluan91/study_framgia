<?php

class IndexController extends ControllerBase
{

    use \Services\CartManagerService;

    public function indexAction($option = null)
    {
        $this->initModel('Products');
        $this->view->products = $this->Products->find();
        if (!$this->session->has('auth-identity')) {
            return $this->response->redirect('index');
        }

        $product_id = $this->request->get('product');
        if ($option === 'add' && $product_id) {
            if ($this->addCart($product_id)) {
                $this->flash->success('Item was added to cart!');
                return $this->response->redirect('index');
            }
        }
    }

    public function cartAction($option = null)
    {
        $product_id = $this->request->get('product');
        if ($option === 'remove' && isset($product_id)) {
            if ($this->removeItemOfCart($product_id)) {
                $this->flash->success('Item was remove from cart!');
                return $this->response->redirect('index/cart');
            }
        }
        $products = $this->getProductInCart();
        if ($products) {
            $this->view->products = $products;
        }
    }
}
