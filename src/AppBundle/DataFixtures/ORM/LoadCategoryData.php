<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $category1 = new Category();
        $category1->setName('Masculino');

        $category2 = new Category();
        $category2->setName('Roupas');

        $category3 = new Category();
        $category3->setName('Beleza');

        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);
        $manager->flush();

        $this->addReference('category1', $category1);
        $this->addReference('category2', $category2);
        $this->addReference('category3', $category3);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}