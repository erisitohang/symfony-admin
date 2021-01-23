<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Company
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument=User::class, inversedBy="company")
     */
    protected $user;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $tax_number;

    /**
     * @MongoDB\EmbedOne(targetDocument=Address::class)
     */
    protected $address;

    /**
     * @MongoDB\ReferenceMany(targetDocument=Transaction::class, mappedBy="company")
     */
    private $transactions;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getTaxNumber()
    {
        return $this->tax_number;
    }

    /**
     * @param mixed $tax_number
     */
    public function setTaxNumber($tax_number): void
    {
        $this->tax_number = $tax_number;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param mixed $transactions
     */
    public function setTransactions($transactions): void
    {
        $this->transactions = $transactions;
    }
}
