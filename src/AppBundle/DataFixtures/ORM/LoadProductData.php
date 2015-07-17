<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Product;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $product1 = new Product();
        $product1->setName('Calça Jeans');
        $product1->setDescription('Calça Jeans masculina confeccionada em algodão, poliéster e
        elastano, que proporcionam toque macio sobre o corpo. Fechamento por botão e zíper.');
        $product1->setImage('calca_jeans.jpg');
        $product1->setPrice(150.49);

        $categories1 = new ArrayCollection();
        $categories1->add($this->getReference('category1'));
        $categories1->add($this->getReference('category2'));
        $product1->setCategories($categories1);

        $product2 = new Product();
        $product2->setName('Shampoo');
        $product2->setDescription('Shampoo anti-caspa para cabelos secos.');
        $product2->setImage('shampoo.jpg');
        $product2->setPrice(9.99);

        $categories2 = new ArrayCollection();
        $categories2->add($this->getReference('category3'));
        $product2->setCategories($categories2);

        $manager->persist($product1);
        $manager->persist($product2);
        $manager->flush();

        $this->addReference('product1', $product1);
        $this->addReference('product2', $product2);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4;
    }
}