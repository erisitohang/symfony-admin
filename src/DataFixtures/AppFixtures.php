<?php

namespace App\DataFixtures;

use App\Document\Address;
use App\Document\Company;
use App\Document\User;
use App\Document\Transaction;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var Generator
     */
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $faker = new Generator();
        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\en_SG\Address($faker));
        $faker->addProvider(new \Faker\Provider\at_AT\Payment($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));
        $faker->addProvider(new \Faker\Provider\Miscellaneous($faker));
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 2; $i++) {
            $user = $this->user($i);
            $address = $this->address();
            $company = $this->company($user, $address);
            $transaction1 = $this->transaction($company);
            $transaction2 = $this->transaction($company);
            $manager->persist($user);
            $manager->persist($company);
            $manager->persist($transaction1);
            $manager->persist($transaction2);
        }
        $manager->flush();
    }

    private function company($user, $address): Company
    {
        $company = new Company();
        $company->setName($this->faker->name);
        $company->setTaxNumber($this->faker->vat(false));
        $company->setAddress($address);
        $company->setUser($user);

        return $company;
    }

    /**
     * @return Address
     */
    private function address(): Address
    {
        $address = new Address();
        $address->setStreet($this->faker->streetAddress);
        $address->setPostcode($this->faker->postcode);
        return $address;
    }

    /**
     * @param int $index
     * @return User
     */
    private function user(int $index): User
    {
        $email = $index === 0 ? 'user@example.com' : $this->faker->email;
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $user->setEmail($email);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'password123'
        ));
        return $user;
    }

    /**
     * @param Company $company
     * @return Transaction
     */
    private function transaction(Company $company): Transaction
    {
        $transaction = new Transaction();
        $transaction->setCompany($company);
        $transaction->setCurrency($this->faker->currencyCode);
        $transaction->setAmount($this->faker->randomFloat(2, 100, 1000));
        $transaction->setStatus($this->faker->boolean);
        return $transaction;
    }
}
