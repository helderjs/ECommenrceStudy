<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Address;

class LoadAddressData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $address1 = new Address();
        $address1->setState('Bahia');
        $address1->setCity('Salvador');
        $address1->setNeighborhood('Barra');
        $address1->setStreet('Rua das Flores');
        $address1->setNumber('1000');
        $address1->setPostalCode('41000-000');

        $address2 = new Address();
        $address2->setState('São Paulo');
        $address2->setCity('São Paulo');
        $address2->setNeighborhood('Pinheiros');
        $address2->setStreet('Rua das Rosas');
        $address2->setNumber('1100');
        $address2->setPostalCode('40000-000');

        $manager->persist($address1);
        $manager->persist($address2);
        $manager->flush();

        $this->addReference('address-customer1', $address1);
        $this->addReference('address-customer2', $address2);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}