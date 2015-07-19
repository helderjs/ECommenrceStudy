<?php

namespace AppBundle\Service;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;

class ProductService
{
    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $id
     * @throws \Exception
     * @return Product
     */
    public function getProduct($id)
    {
        $product = $this->em->getRepository('AppBundle:Product')
            ->find($id);

        if (!$product) {
            throw new \Exception(
                'No product found for id '.$id
            );
        }

        return $product;
    }
}