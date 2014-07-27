<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $products = new Products();
        $results = $products->find();
        $this->view->products = $results;

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

    }

    public function cartaddAction()
    {
        $response = new \Phalcon\Http\Response();
        $id = $this->request->get('id');
        $name = $this->request->get('name');
        if (!$this->session->has('cart')) {
            $this->session->set('cart', []);
        }
        $cart = $this->session->get('cart');
        if (in_array($id, $cart)) {
            header('Location: index?action=exists&id' . $id . '&name=' . $name);
        } else {
            array_push($cart, $id);
            $this->session->set('cart', $cart);
            header('Location: index?action=add&id' . $id . '&name=' . $name);
        }
        $this->view->disable();
    }
}
