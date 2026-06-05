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
        $mdp = '$2y$13$16OpOQBpMTzTIuDyXk61/OB1ksNcf5deJnjsk5hA5r4UPGv8Uooz6';//Not24get
        $u = (new User())
            ->setUsername('admin')
            ->setEmail('admin@gmail.com')
            ->setPassword($mdp);
        $manager->persist($u);

        $t = (new Technician())
            ->setUsername('Doe John')
            ->setEmail('technicien@gmail.com')
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setCivility($this->getReference('h', Civility::class))
            ->setPassword($mdp);
        $this->addReference('technician', $t);
        $manager->persist($t);

        $a = (new Accountant())
            ->setUsername('Dupond Jeanne')
            ->setEmail('comptable@gmail.com')
            ->setFirstName('Jeanne')
            ->setLastName('Dupond')
            ->setCivility($this->getReference('f', Civility::class))
            ->setPassword($mdp);
        $this->addReference('accountant', $a);
        $manager->persist($a);

        $i = (new Individual())
            ->setUsername('Vigile')
            ->setEmail('virgile@gmail.com')
            ->setFirstName('Virgile')
            ->setLastName('Martinier')
            ->setBirthDate(new \DateTime('2006-05-04'))
            ->setCivility($this->getReference('h', Civility::class))
            ->setPassword($mdp);
        $this->addReference('v', $i);
        $manager->persist($i);

        $i = (new Individual())
            ->setUsername('Jane')
            ->setEmail('jane@gmail.com')
            ->setFirstName('Jane')
            ->setLastName('Doe')
            ->setBirthDate(new \DateTime('2001-09-18'))
            ->setCivility($this->getReference('f', Civility::class))
            ->setPassword($mdp);
        $this->addReference('j', $i);
        $manager->persist($i);

        $c = (new Company())
            ->setUsername('Lactalis')
            ->setEmail('lactalis@gmail.com')
            ->setName('Lactalis')
            ->setCreation(new \DateTime('1933-10-19'))
            ->setCompanyRegister('44306184100047')
            ->setPassword($mdp);
        $this->addReference('l', $c);
        $manager->persist($c);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CivilityFixtures::class];

    }
}
