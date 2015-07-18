<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    /**
     * @Route("/cart", name="cart")
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        $total = 0;
        foreach ($cart as $product) {
            $total += ($product['quantity'] * $product['price']);
        }

        return $this->render('cart/index.html.twig', ['products' => $cart, 'total' => $total]);
    }

    protected function isProductValid($id)
    {}

    /**
     * @Route("/cart/add/{id}")
     */
    public function addAction($id, Request $request)
    {
        $service = $this->get('ProductService');
        $product = $service->getProduct($id);

        $session = $request->getSession();
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = ['id' => $id, 'name' => $product->getName(), 'quantity' => 1, 'price' => $product->getPrice()];
        }

        $session->set('cart', $cart);

        return $this->redirect('/cart');
    }

    /**
     * @Route("/cart/remove/{id}")
     */
    public function removeAction($id, Request $request)
    {
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        if (isset ($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirect('/cart');
    }

    /**
     * @Route("/cart/update/{id}")
     */
    public function updateAction($id, Request $request)
    {
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        if ($request->get('quantity', 0) == 0) {
            return $this->removeAction($id, $request);
        }

        if (!empty ($cart[$id])) {
            $cart[$id]['quantity'] = $request->get('quantity');
        }

        $session->set('cart', $cart);

        return $this->redirect('/cart');
    }
}
