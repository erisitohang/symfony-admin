<?php


namespace App\Tests;

use App\Document\Transaction;
use Symfony\Component\Form\Test\TypeTestCase as SymfonyTypeTestCase;

class TypeTestCase extends SymfonyTypeTestCase
{
    protected function formData()
    {
        return [
            'currency' => 'SGD',
            'amount' => '150',
            'status' => false,
        ];
    }

    protected function getTransaction()
    {
        $data = $this->formData();
        $transaction = new Transaction();
        $transaction->setCurrency($data['currency']);
        $transaction->setAmount($data['amount']);
        $transaction->setStatus($data['status']);
        return $transaction;
    }
}