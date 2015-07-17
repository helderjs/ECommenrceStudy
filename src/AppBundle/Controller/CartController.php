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

        return $this->render('cart/index.html.twig', ['products' => $cart]);
    }

    /**
     * @Route("/cart/add/{id}")
     */
    public function addAction($id, Request $request)
    {
        $product = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

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
}
