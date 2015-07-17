<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Customer;

class LoadCustomerData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $customer1 = new Customer();
        $customer1->setName('João Silva');
        $customer1->setEmail('joao@email.com');
        $customer1->setUsername('joao');
        $customer1->setSalt(md5(uniqid()));
        $customer1->setAddress($this->getReference('address-customer1'));

        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($customer1)
        ;
        $customer1->setPassword($encoder->encodePassword('123456', $customer1->getSalt()));

        $customer2 = new Customer();
        $customer2->setName('Maria Santos');
        $customer2->setEmail('maria@email.com');
        $customer2->setUsername('maria');
        $customer2->setSalt(md5(uniqid()));
        $customer2->setAddress($this->getReference('address-customer2'));

        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($customer2)
        ;
        $customer2->setPassword($encoder->encodePassword('123456', $customer2->getSalt()));

        $manager->persist($customer1);
        $manager->persist($customer2);
        $manager->flush();

        $this->addReference('customer1', $customer1);
        $this->addReference('customer2', $customer2);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}