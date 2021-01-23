<?php

namespace App\DataFixtures;

use App\Document\{Company, Address};
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\en_SG\Address($faker));
        $faker->addProvider(new \Faker\Provider\at_AT\Payment($faker));
        for ($i = 0; $i < 2; $i++) {
            $transaction = new Company();
            $transaction->setName($faker->name);
            $address = new Address();
            $address->setStreet($faker->streetAddress);
            $address->setPostcode($faker->postcode);
            $transaction->setTaxNumber($faker->vat(false));
            $transaction->setAddress($address);
            $manager->persist($transaction);
        }
        $manager->flush();
    }
}
