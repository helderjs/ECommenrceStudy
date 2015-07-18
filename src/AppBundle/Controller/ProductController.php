<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/product/{id}")
     */
    public function indexAction($id)
    {
        $service = $this->get('ProductService');
        $product = $service->getProduct($id);

        return $this->render('product/index.html.twig', ['product' => $product]);
    }
}
