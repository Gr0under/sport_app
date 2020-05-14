<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User; 

class UserFixtures extends BaseFixture
{
	private $encoder;

	public function __construct(UserPasswordEncoderInterface $encoder)
	{
		$this->encoder = $encoder; 
	}
    protected function loadData(ObjectManager $manager)
    {
    	$this->createMany(User::class, 15, function(User $user, $count){

			$user->setEmail("paul.juquelier".$count."@gmail.com")
	    		 ->setPassword($this->encoder->encodePassword($user, "engage"))
	    		 ->setFullName($this->faker->firstName()." ".$this->faker->name())
	             ->setPseudo($this->faker->firstName())
	             ->setBirthdate($this->faker->dateTimeBetween('-50 years' , '-18 years'))
	             ->setAddress(95800)
	             ->setGender("male")
	             ->setRoles([]); 

    	});
    	
        $manager->flush();
    }
}
