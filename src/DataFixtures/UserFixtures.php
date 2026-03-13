<?php

namespace App\DataFixtures;

use App\Entity\Accountant;
use App\Entity\Civility;
use App\Entity\Company;
use App\Entity\Individual;
use App\Entity\Technician;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $u = (new User())
            ->setUsername('admin')
            ->setEmail('admin@gmail.com')
            ->setPassword('$2y$13$KxH9ONFNvdook3MyNVqOJ.S6NML.r5nBvdFM6W0xkexhbGwCJvraO');//613670
        $manager->persist($u);

        $a = (new Accountant())
            ->setUsername('accountant')
            ->setEmail('accountant@gmail.com')
            ->setFirstName('Rachel')
            ->setLastName('Prime')
            ->setPassword('$2y$13$KxH9ONFNvdook3MyNVqOJ.S6NML.r5nBvdFM6W0xkexhbGwCJvraO');//613670
        $this->addReference('accountant', $a);
        $manager->persist($a);

        $t = (new Technician())
            ->setUsername('technician')
            ->setEmail('technician@gmail.com')
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setPassword('$2y$13$KxH9ONFNvdook3MyNVqOJ.S6NML.r5nBvdFM6W0xkexhbGwCJvraO');//613670
        $this->addReference('technician', $t);
        $manager->persist($t);

        $i = (new Individual())
            ->setUsername('Jane')
            ->setEmail('jane@gmail.com')
            ->setFirstName('Jane')
            ->setLastName('Doe')
            ->setBirthDate(new \DateTime('1990-01-01'))
            ->setCivility($this->getReference('f', Civility::class))
            ->setPassword('$2y$13$KxH9ONFNvdook3MyNVqOJ.S6NML.r5nBvdFM6W0xkexhbGwCJvraO');//613670
        $this->addReference('jane', $i);
        $manager->persist($i);

        $c = (new Company())
            ->setUsername('Google')
            ->setEmail('google@gmail.com')
            ->setName('Google')
            ->setCreation(new \DateTime('1998-09-04'))
            ->setCompanyRegister('44306184100047')
            ->setPassword('$2y$13$KxH9ONFNvdook3MyNVqOJ.S6NML.r5nBvdFM6W0xkexhbGwCJvraO');//613670
        $this->addReference('google', $c);
        $manager->persist($c);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CivilityFixtures::class];

    }
}
