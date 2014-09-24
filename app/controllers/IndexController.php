<?php

class IndexController extends ControllerBase
{

    use \Libs\Utility\ModelManagerService;

    public function indexAction()
    {
        $this->initModel('Products');
        $this->view->products = $this->Products->find();

        // to prevent undefined index notice
        $action = $this->request->get('action');
        $name = $this->request->get('name');
        if ($action) {
            $this->view->action = $action;
        }
        if (!$name) {
            $name = '';
        }
        $this->view->name = $name;
    }

    public function cartAction()
    {
        if (!$this->session->has('auth-identity')) {
            return $this->response->redirect('index');
        }
        if ($this->session->has('cart')) {
            $cart = $this->session->get('cart');
        }

        if ($cart) {
            $products = new Products();
            $your_cart = [];
            foreach($cart as $id) {
                array_push($your_cart, $products->findFirst($id));
            }
            $this->view->your_cart = $your_cart;
        }
        // to prevent undefined index notice
        $action = $this->request->get('action');
        $name = $this->request->get('name');
        if ($action) {
            $this->view->action = $action;
        }
        if (!$name) {
            $name = '';
        }
        $this->view->name = $name;
    }

    public function cartaddAction()
    {
        $id = $this->request->get('id');
        $name = $this->request->get('name');
        if (!$this->session->has('cart')) {
            $this->session->set('cart', []);
        }
        $cart = $this->session->get('cart');
        if (in_array($id, $cart)) {
            header('Location: index?action=exists&id=' . $id . '&name=' . $name);
        } else {
            array_push($cart, $id);
            $this->session->set('cart', $cart);
            header('Location: index?action=add&id=' . $id . '&name=' . $name);
        }
        $this->view->disable();
    }

    public function cartremoveAction()
    {
        $id = $this->request->get('id');
        $name = $this->request->get('name');
        if ($this->session->has('cart')) {
            $cart = $this->session->get('cart');
            $item_id = array_search($id, $cart);
            if ($item_id !== false && $item_id >= 0) {
                if ($item_id === 0) {
                    array_shift($cart);
                } else {
                    unset($cart[$item_id]);
                }
                $this->session->set('cart', $cart);
                header('Location: cart?action=remove&id=' . $id . '&name=' . $name);
            } else {
                header('Location: cart?action=notexists&id=' . $id . '&name=' . $name);
            }
        }
        $this->view->disable();
    }
}
