<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="`order`")
 */
class Order
{
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELED = 'canceled';
    const STATUS_COMPLETE = 'complete';

    const PAYMENT_CREDIT_CARD = 'credit-card';
    const PAYMENT_BILLET = 'billet';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", onDelete="set null")
     **/
    private $customer;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('pending', 'confirmed', 'canceled', 'complete')")
     */
    private $status;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('credit-card', 'billet')")
     */
    private $payment;

    /**
     * @ORM\ManyToMany(targetEntity="Item", cascade={"persist"})
     * @ORM\JoinTable(name="orders_items",
     *      joinColumns={@ORM\JoinColumn(name="order_id", referencedColumnName="id", onDelete="cascade")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")}
     *      )
     **/
    private $items;

    /**
     * Configure the entity
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $statusList = [self::STATUS_PENDING, self::STATUS_CONFIRMED, self::STATUS_CANCELED, self::STATUS_COMPLETE];

        if (!in_array($status, $statusList)) {
            throw new \InvalidArgumentException("Invalid status");
        }

        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param string $payment
     */
    public function setPayment($payment)
    {
        if (!in_array($payment, [self::PAYMENT_CREDIT_CARD, self::PAYMENT_BILLET])) {
            throw new \InvalidArgumentException("Invalid status");
        }

        $this->payment = $payment;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param ArrayCollection $items
     */
    public function setItems(ArrayCollection $items)
    {
        $this->items = $items;
    }
}