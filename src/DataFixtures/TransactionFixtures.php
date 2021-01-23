<?php

namespace App\DataFixtures;

use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Document\Transaction;

class TransactionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 2; $i++) {
            $transaction = new Transaction();
            $transaction->setCurrency($faker->currencyCode);
            $transaction->setAmount($faker->randomFloat(2, 100, 1000));
            $transaction->setStatus($faker->boolean);
            $manager->persist($transaction);
        }
        $manager->flush();
    }
}
