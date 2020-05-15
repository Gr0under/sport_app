<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User; 

class UserFixtures extends BaseFixture
{
	private $encoder;

	private static $profilePicture = [
		'/img/profilePicture/profile_picture_1.jpg',
		'/img/profilePicture/profile_picture_2.jpg',
		'/img/profilePicture/profile_picture_3.jpg',
		'/img/profilePicture/profile_picture_4.jpg',
		'/img/profilePicture/profile_picture_5.jpg',
		'/img/profilePicture/profile_picture_6.jpg',
	];

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
	             ->setRoles([])
	             ->setPicture($this->faker->randomElement(self::$profilePicture)) 
	             ;

    	});
    	
        $manager->flush();
    }
}
