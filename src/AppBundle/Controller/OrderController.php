<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Item;
use AppBundle\Entity\Order;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Controller
{
    /**
     * @Route("/order")
     */
    public function indexAction(Request $request)
    {
        $orders = $this->getDoctrine()
            ->getRepository('AppBundle:Order')
            ->findBy(['customer' => $this->get('security.token_storage')->getToken()->getUser()]);

        return $this->render('order/index.html.twig', ['orders' => $orders]);
    }

    /**
     * @Route("/order/checkout")
     */
    public function checkoutAction(Request $request)
    {
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        $order = new Order();
        $order->setDate(new \DateTime());
        $order->setStatus(Order::STATUS_PENDING);
        $order->setCustomer($this->get('security.token_storage')->getToken()->getUser());

        $service = $this->get('ProductService');
        $items = new ArrayCollection();
        foreach ($cart as $product) {
            $item = new Item();
            $item->setProduct($service->getProduct($product['id']));
            $item->setQuantity($product['quantity']);

            $items->add($item);
        }

        $order->setItems($items);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($order);
        $em->flush();
        $session->remove('cart');

        return $this->render('order/checkout.html.twig', ['order' => $order]);
    }

    /**
     * @Route("/order/confirm/{id}")
     */
    public function confirmAction($id, Request $request)
    {
        $order = $this->getDoctrine()
            ->getRepository('AppBundle:Order')
            ->find($id);

        $order->setPayment($request->get('payment'));
        $order->setStatus(Order::STATUS_CONFIRMED);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($order);
        $em->flush();

        return $this->render('order/confirm.html.twig', ['order' => $order]);
    }

    /**
     * @Route("/order/open/{id}")
     */
    public function openAction($id, Request $request)
    {
        $order = $this->getDoctrine()
            ->getRepository('AppBundle:Order')
            ->find($id);

        return $this->render('/order/checkout.html.twig', ['order' => $order]);
    }

    /**
     * @Route("/order/{id}")
     */
    public function viewAction($id, Request $request)
    {
        $order = $this->getDoctrine()
            ->getRepository('AppBundle:Order')
            ->find($id);

        return $this->render('order/view.html.twig', ['order' => $order]);
    }
}